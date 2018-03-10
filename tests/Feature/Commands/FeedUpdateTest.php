<?php

namespace Tests\Feature\Commands;


use App\Feed;
use App\Post;
use Tests\TestCase;
use App\Console\Commands\FeedUpdate;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Tester\CommandTester;


class FeedUpdateTest extends TestCase
{
    use DatabaseMigrations;

    protected $command;
    /**
     * @var CommandTester
     */
    protected $commandTester;

    /**
     * @var Feed
     */
    protected $feed;

    public function setUp()
    {
        parent::setUp();

        $application = new ConsoleApplication();

        $testedCommand = $this->app->make(FeedUpdate::class);
        $testedCommand->setLaravel(app());
        $application->add($testedCommand);

        $this->command = $application->find('feed:update');
        $this->commandTester = new CommandTester($this->command);

        $this->feed = factory(Feed::class)->create();
    }

    /** @test */
    public function feedUpdate()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName()
        ]);

        $posts = Post::all();

        $this->assertNotEmpty($posts);

        $this->feed->refresh();

        $this->assertNotNull($this->feed->provider_url);

    }
}
