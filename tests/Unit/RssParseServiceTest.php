<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\RssParseService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use File;

class RssParseServiceTest extends TestCase
{
    /**
     * @var RssParseService
     */
    protected $rssParserService;

    public function setUp()
    {
        parent::setUp();

        $this->rssParserService = app('App\Services\RssParseService');
    }
    /** @test */
    public function parse()
    {
        $xmlTest = File::get(resource_path('tests/test.xml'));

        ['mainLink' => $mainLink, 'links' => $links] = $this->rssParserService->parse($xmlTest);

        $this->assertEquals('http://www.technologijos.lt', $mainLink);
        $this->assertCount(15, $links);

        ['title' => $title, 'link' => $link, 'description' => $description] = array_first($links);

        $this->assertNotEmpty($title, 'Title empty');
        $this->assertNotEmpty($link, 'Link empty');
        $this->assertNotEmpty($description, 'Description empty');

    }
}
