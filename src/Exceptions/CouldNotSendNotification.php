<?php

namespace NotificationChannels\Evernote\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * @param string $errorMessage
     *
     * @return static
     */
    public static function serviceRespondedWithAnError($errorMessage)
    {
        return new static("Evernote responded with an error: `{$errorMessage}`");
    }
}
