# Evernote notifications channel for Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/evernote.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/evernote)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/evernote/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/evernote)
[![StyleCI](https://styleci.io/repos/65765910/shield)](https://styleci.io/repos/65765910)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/262c4806-f5de-473a-99ca-8d86a96dcfba.svg?style=flat-square)](https://insight.sensiolabs.com/projects/262c4806-f5de-473a-99ca-8d86a96dcfba)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/evernote.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/evernote)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/evernote/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/evernote/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/evernote.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/evernote)

This package makes it easy to create [Evernote notes](https://dev.evernote.com/doc/) with Laravel 5.3.

## Contents

- [Installation](#installation)
    - [Setting up the Evernote service](#setting-up-the-evernote-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
	- [Available Content methods](#available-content-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

``` bash
composer require laravel-notification-channels/evernote
```

### Setting up the Evernote service

In order to add tickets to Evernote users, you need to obtain their access token.

Create a sandbox [Evernote API key](https://dev.evernote.com/doc/) to get started.

To simplify development, you can also generate your [personal development access token](https://sandbox.evernote.com/api/DeveloperToken.action).

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\Evernote\EvernoteChannel;
use NotificationChannels\Evernote\EvernoteContent;
use NotificationChannels\Evernote\EvernoteMessage;
use Illuminate\Notifications\Notification;

class ProjectCreated extends Notification
{
    public function via($notifiable)
    {
        return [EvernoteChannel::class];
    }

    public function toEvernote($notifiable)
    {
        return EvernoteMessage::create('Evernote message title')
                    ->sandbox()
                    ->content(EvernoteContent::create('Evernote content is here'))
                    ->tags(['Laravel','Notifications'])
                    ->reminder('tomorrow');
    }
}
```

In order to let your Notification know which Evernote user you are targeting, add the `routeNotificationForEvernote` method to your Notifiable model.

This method needs to return the access token of the authorized Evernote user.

```php
public function routeNotificationForEvernote()
{
    return 'NotifiableAccessToken';
}
```

### Available Message methods

- `title('')`: Accepts a string for the Evernote ticket title.
- `content(EvernoteContent)`: Accepts an EvernoteContent object.
- `sandbox()`: Enables the Evernote sandbox mode (default `false`).
- `done()`: Marks the Evernote ticket as done.
- `tags('')`: Accepts an array with tags to add to the Evernote ticket.
- `reminder('')`: Accepts a string or DateTime object for the Evernote ticket reminder.

### Available Content methods

- `content('')`: Accepts a string value for the Evernote ticket content.
- `html()`: Sets the content type to HTML.
- `plain()`: Sets the content type to Plaintext (default).


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email m.pociot@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Marcel Pociot](https://github.com/mpociot)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
