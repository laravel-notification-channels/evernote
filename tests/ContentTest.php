<?php

namespace NotificationChannels\Evernote\Test;

use Illuminate\Support\Arr;
use NotificationChannels\Evernote\EvernoteContent;

class ContentTest extends \PHPUnit_Framework_TestCase
{
    /** @var \NotificationChannels\Evernote\EvernoteContent */
    protected $content;

    public function setUp()
    {
        parent::setUp();

        $this->content = new EvernoteContent('');
    }

    /** @test */
    public function it_accepts_a_content_when_constructing_a_message()
    {
        $content = new EvernoteContent('Content');

        $this->assertEquals('Content', Arr::get($content->toArray(), 'content'));
    }

    /** @test */
    public function it_provides_a_create_method()
    {
        $content = EvernoteContent::create('Content');

        $this->assertEquals('Content', Arr::get($content->toArray(), 'content'));
    }

    /** @test */
    public function it_can_set_the_type_to_html()
    {
        $this->content->html();

        $this->assertEquals('html', Arr::get($this->content->toArray(), 'type'));
    }

    /** @test */
    public function it_can_set_the_type_to_plain()
    {
        $this->content->plain();

        $this->assertEquals('plain', Arr::get($this->content->toArray(), 'type'));
    }

    /** @test */
    public function it_has_default_type_of_plaintext()
    {
        $this->assertEquals('plain', Arr::get($this->content->toArray(), 'type'));
    }

}
