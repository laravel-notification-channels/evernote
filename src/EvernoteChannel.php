<?php

namespace NotificationChannels\Evernote;

use Evernote\Client;
use Evernote\Model\HtmlNoteContent;
use Evernote\Model\Note;
use Evernote\Model\PlainTextNoteContent;
use Exception;
use Illuminate\Support\Arr;
use NotificationChannels\Evernote\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class EvernoteChannel
{
    /** @var Client */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Evernote\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $token = $notifiable->routeNotificationFor('Evernote')) {
            return;
        }

        $this->client->setToken($token);

        $message = $notification->toEvernote($notifiable)->toArray();

        $this->client->setSandbox(Arr::get($message, 'sandbox', false));

        $note = new Note();
        $note->setTitle($message['title']);

        if (! is_null($message['content'])) {
            if (Arr::get($message, 'content.type') === EvernoteContent::TYPE_HTML) {
                $content = new HtmlNoteContent(Arr::get($message, 'content.content'));
            } else {
                $content = new PlainTextNoteContent(Arr::get($message, 'content.content'));
            }
            $note->setContent($content);
        }
        $note->setTagNames($message['tags']);

        if ($message['done'] === true) {
            $note->setAsDone();
        }

        if (! is_null(Arr::get($message, 'reminder'))) {
            $note->setReminder($message['reminder']);
        }

        try {
            $this->client->uploadNote($note);
        } catch (Exception $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        }
    }
}
