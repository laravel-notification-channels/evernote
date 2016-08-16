<?php

namespace NotificationChannels\Evernote\Test;

use DateTime;
use Illuminate\Support\Arr;
use NotificationChannels\Evernote\EvernoteContent;
use NotificationChannels\Evernote\Exceptions\CouldNotCreateMessage;
use NotificationChannels\Evernote\EvernoteMessage;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    /** @var \NotificationChannels\Evernote\EvernoteMessage */
    protected $message;

    public function setUp()
    {
        parent::setUp();

        $this->message = new EvernoteMessage('');
    }

    /** @test */
    public function it_accepts_a_title_when_constructing_a_message()
    {
        $message = new EvernoteMessage('Title');

        $this->assertEquals('Title', Arr::get($message->toArray(), 'title'));
    }

    /** @test */
    public function it_provides_a_create_method()
    {
        $message = EvernoteMessage::create('Title');

        $this->assertEquals('Title', Arr::get($message->toArray(), 'title'));
    }

    /** @test */
    public function it_can_set_the_title()
    {
        $this->message->title('TicketTitle');

        $this->assertEquals('TicketTitle', Arr::get($this->message->toArray(), 'title'));
    }

    /** @test */
    public function it_can_set_the_content()
    {
        $this->message->content(EvernoteContent::create('TicketContent'));

        $this->assertEquals('TicketContent', Arr::get($this->message->toArray(), 'content.content'));
    }

    /** @test */
    public function it_can_set_a_reminder_from_string()
    {
        $date = new DateTime('tomorrow');
        $this->message->reminder('tomorrow');

        $this->assertEquals($date->getTimestamp(), Arr::get($this->message->toArray(), 'reminder'));
    }

    /** @test */
    public function it_can_set_a_reminder_from_datetime()
    {
        $date = new DateTime('tomorrow');
        $this->message->reminder($date);

        $this->assertEquals($date->getTimestamp(), Arr::get($this->message->toArray(), 'reminder'));
    }

    /** @test */
    public function it_can_set_the_ticket_as_done()
    {
        $this->message->done();

        $this->assertEquals(true, Arr::get($this->message->toArray(), 'done'));
    }

    /** @test */
    public function it_has_default_messages_not_done()
    {
        $this->assertEquals(false, Arr::get($this->message->toArray(), 'done'));
    }

    /** @test */
    public function it_can_enable_sandbox_mode()
    {
        $this->message->sandbox();

        $this->assertEquals(true, Arr::get($this->message->toArray(), 'sandbox'));
    }

    /** @test */
    public function it_has_default_sandbox_disabled()
    {
        $this->assertEquals(false, Arr::get($this->message->toArray(), 'sandbox'));
    }
}
