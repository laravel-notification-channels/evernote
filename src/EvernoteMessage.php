<?php

namespace NotificationChannels\Evernote;

use DateTime;
use DateTimeZone;
use NotificationChannels\Evernote\Exceptions\CouldNotCreateMessage;

class EvernoteMessage
{
    /** @var string */
    protected $title;

    /** @var EvernoteContent */
    protected $content;

    /** @var array */
    protected $tags = [];

    /** @var bool */
    protected $done = false;

    /** @var bool */
    protected $sandbox = false;

    /** @var int|null */
    protected $reminder;

    /**
     * @param string $title
     *
     * @return static
     */
    public static function create($title)
    {
        return new static($title);
    }

    /**
     * @param string $title
     */
    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * Set the ticket title.
     *
     * @param string $title
     *
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the ticket content.
     *
     * @param EvernoteContent $content
     *
     * @return $this
     */
    public function content(EvernoteContent $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the ticket tags.
     *
     * @param array $tags
     *
     * @return $this
     */
    public function tags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Set the ticket as done.
     *
     * @return $this
     */
    public function done()
    {
        $this->done = true;

        return $this;
    }

    /**
     * Enable sandbox mode.
     *
     * @return $this
     */
    public function sandbox()
    {
        $this->sandbox = true;

        return $this;
    }

    /**
     * Set the ticket reminder date.
     *
     * @param string|DateTime $reminder
     *
     * @return $this
     */
    public function reminder($reminder)
    {
        if (! $reminder instanceof DateTime) {
            $reminder = new DateTime($reminder);
        }

        $this->reminder = $reminder->getTimestamp();

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content ? $this->content->toArray() : null,
            'reminder' => $this->reminder,
            'sandbox' => $this->sandbox,
            'done' => $this->done,
            'tags' => $this->tags,
        ];
    }
}
