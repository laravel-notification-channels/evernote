<?php

namespace NotificationChannels\Evernote\Test;

use Evernote\Client;
use Illuminate\Notifications\Notification;
use Mockery;
use NotificationChannels\Evernote\EvernoteContent;
use NotificationChannels\Evernote\Exceptions\CouldNotSendNotification;
use NotificationChannels\Evernote\EvernoteChannel;
use NotificationChannels\Evernote\EvernoteMessage;
use Orchestra\Testbench\TestCase;

class ChannelTest extends TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('setToken')
            ->once()
            ->with('NotifiableToken');

        $client->shouldReceive('setSandbox')
            ->once()
            ->with(false);

        $client->shouldReceive('uploadNote')
            ->once()
            ->with(Mockery::any());

        $channel = new EvernoteChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_throws_an_exception_when_it_could_not_send_the_notification()
    {
        $this->setExpectedException(CouldNotSendNotification::class);

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('setToken')
            ->once()
            ->with('NotifiableToken');

        $client->shouldReceive('setSandbox')
            ->once()
            ->with(false);

        $client->shouldReceive('uploadNote')
            ->once()
            ->with(Mockery::any())
            ->andThrow(\Exception::class);

        $channel = new EvernoteChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }
}

class TestNotifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return int
     */
    public function routeNotificationForEvernote()
    {
        return 'NotifiableToken';
    }
}


class TestNotification extends Notification
{
    public function toEvernote($notifiable)
    {
        return EvernoteMessage::create('EvernoteMessage')
            ->content(EvernoteContent::create('EvernoteContent'))
            ->done()
            ->reminder('tomorrow');
    }
}
