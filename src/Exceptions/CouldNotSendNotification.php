<?php

namespace NotificationChannels\Evernote\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($error)
    {
        return new static('Evernote responded with an error: `'.$error.'`');
    }
}
