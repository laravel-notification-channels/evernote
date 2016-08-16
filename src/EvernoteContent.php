<?php

namespace NotificationChannels\Evernote;

use DateTime;
use DateTimeZone;
use NotificationChannels\Evernote\Exceptions\CouldNotCreateMessage;

class EvernoteContent
{
    const TYPE_HTML = 'html';
    const TYPE_PLAIN = 'plain';

    /** @var string */
    protected $content;

    /** @var array */
    protected $type = self::TYPE_PLAIN;


    /**
     * @param string $content
     *
     * @return static
     */
    public static function create($content)
    {
        return new static($content);
    }

    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Set the content type to HTML.
     *
     * @return $this
     */
    public function html()
    {
        $this->type = self::TYPE_HTML;

        return $this;
    }

    /**
     * Set the content type to plaintext.
     *
     * @return $this
     */
    public function plain()
    {
        $this->type = self::TYPE_PLAIN;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'content' => $this->content,
            'type' => $this->type,
        ];
    }
}
