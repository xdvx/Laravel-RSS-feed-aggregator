<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp;
use GuzzleHttp\Psr7\Stream;
use App\Feed;
use App\Post;
use Facades\App\Services\RssParseService;



class FeedUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates feeds';

    /**
     * @var GuzzleHttp\Client
     */
    private $http;

    /**
     * FeedUpdate constructor.
     * @param GuzzleHttp\Client $http
     */
    public function __construct(GuzzleHttp\Client $http)
    {
        parent::__construct();

        $this->http = $http;
    }

    /**
     * Fetches content from URL
     *
     * @param $url
     * @return bool|\Psr\Http\Message\StreamInterface|string
     */
    private function fetchContent($url)
    {
        try {
            $response = $this->http->request('GET', $url);
        } catch (GuzzleHttp\Exception\RequestException $e) {
            $this->error($e->getMessage());
            return false;
        }

        $data = $response->getBody();

        if ($data instanceof Stream) {
            $data = $data->getContents();
        }

        return $data;
    }

    public function importLinks(Feed $feed, array $rssData)
    {
        foreach ($rssData as $row) {
            ['title' => $title, 'link' => $link, 'description' => $description] = $row;

            $urlCRC32 = crc32($link);

            $exists = Post::where([
                'feed_id' => $feed->id,
                'url_crc32' => $urlCRC32,
                'url' => $link
            ])->exists();



            if (! $exists) {
                $this->info("Inserting {$link}");

                Post::create([
                    'title' => $title,
                    'feed_id' => $feed->id,
                    'url' => $link,
                    'url_crc32' => $urlCRC32,
                    'text' => $description
                ]);
            } else {
                $this->warn("Already exists {$link}");
            }
        }
    }

    /**
     * Fetch Feeds
     */
    public function fetchFeeds()
    {
        $feeds = Feed::all();
        foreach ($feeds as $feed) {
            $this->info("Fetching {$feed->url}");
            $data = $this->fetchContent($feed->url);
            $parsed = RssParseService::parse($data);

            if (! $parsed) {
                $this->error("Failed to parse");
                continue;
            }
            ['mainLink' => $mainLink, 'links' => $rssLinks] = $parsed;

            if (! $feed->provider_url) {
                $feed->provider_url = $mainLink;
                $feed->save();
            }

            $this->importLinks($feed, $rssLinks);
        }
    }



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->fetchFeeds();
    }
}
