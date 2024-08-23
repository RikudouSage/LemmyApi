# Lemmy API

Lemmy is all the rage now! This package allows you to communicate with Lemmy from PHP which opens up great possibilities
for writing bots!

All methods are fully typed so your IDE should help you a lot.

Note that this is an alpha version and while everything should work, the public api will probably change as I 
find better names and/or locations for various methods.

## Installation

Requires PHP 8.2.

`composer require rikudou/lemmy-api`

You also need to install a compatible [PSR http client](https://packagist.org/providers/psr/http-client-implementation)
and [PSR http request factory](https://packagist.org/providers/psr/http-factory-implementation):

`composer require rikudou/lemmy-api guzzlehttp/guzzle`

or 

`composer require rikudou/lemmy-api symfony/http-client nyholm/psr7`

or any other implementation you like.

## Usage

```php
<?php

use Rikudou\LemmyApi\DefaultLemmyApi;
use Rikudou\LemmyApi\Enum\LemmyApiVersion;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Exception\LemmyApiException;

$api = new DefaultLemmyApi(
    instanceUrl: 'https://my-lemmy-instance.world', 
    version: LemmyApiVersion::Version3, // this is currently the only supported version
    httpClient: new Psr18Client(), // assuming you use Symfony, otherwise provide any other implementation
    requestFactory: new Psr17Factory(), // assuming you use Nyholm, otherwise provide any other implementation,
);

// before calling anything else, you must login

$response = $api->login('my_username_or_email', 'myPassword');

// now you can call any other methods, you don't even have to store the $response result, you are logged in automatically

try {
    $community = $api->community()->get('some_cool_community');
    $result = $api->post()->create($community, 'Post Name', body: 'Some content', language: Language::English);
} catch (LemmyApiException $e) {
    // todo handle exception - all exceptions implement the LemmyApiException interface
}
```

## Non-strict mode

By default, the library works in a strict mode - when Lemmy returns a property in the response that the library
does not expect in the mapped DTO, it throws an exception. That can happen when the library is not updated to work
with the latest version and Lemmy adds new parameters to responses.

To mitigate this you can switch to non-strict mode by providing it as a parameter:

```php
<?php

use Rikudou\LemmyApi\DefaultLemmyApi;
use Rikudou\LemmyApi\Enum\LemmyApiVersion;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Exception\LemmyApiException;

$api = new DefaultLemmyApi(
    instanceUrl: 'https://my-lemmy-instance.world', 
    version: LemmyApiVersion::Version3,
    httpClient: new Psr18Client(),
    requestFactory: new Psr17Factory(),
    strictDeserialization: false, // here you disable the strict mode
);
```

> Currently, the latest fully supported version is **0.19.3**, if you use this library to connect to a newer
> version, it might be wise to turn off the strict mode.

## Notes

There are many, many api methods, most of them have no documentation in the upstream so I tried my best to guess
at what they do and tried to sort them into different classes, I'm not entirely sure if I managed to do so correctly.

Due to the same reason it would also be hard to list them all and provide documentation, it would easily take me more
time than writing the code.
If someone feels up to the task, I'll gladly accept PRs with documentation!

To get you started at least a little, check the various interfaces to see the names and arguments of methods:

- [LemmyApi](src/LemmyApi.php) - the main class, contains links to other modules and two api methods on its own, `login()`
and `register()`
- [AdminEndpoint](src/Endpoint/AdminEndpoint.php) - contains methods that only instance admins can use
- [CommentEndpoint](src/Endpoint/CommentEndpoint.php) - contains stuff relating to comments, like posting, editing, deleting and so on
- [CommunityEndpoint](src/Endpoint/CommunityEndpoint.php) - contains stuff relating to communities, creating, deleting, listing etc.
- [CurrentUserEndpoint](src/Endpoint/CurrentUserEndpoint.php) - contains stuff relating to the currently logged in user
- [MiscellaneousEndpoint](src/Endpoint/MiscellaneousEndpoint.php) - stuff that doesn't belong in any other category
- [ModeratorEndpoint](src/Endpoint/ModeratorEndpoint.php) - stuff that only moderators can do
- [PostEndpoint](src/Endpoint/PostEndpoint.php) - methods relating to posts
- [SiteEndpoint](src/Endpoint/SiteEndpoint.php) - methods relating to the instance itself
- [UserEndpoint](src/Endpoint/UserEndpoint.php) - methods relating to users in general

Currently even api calls that don't need a logged in user require login in this package, meaning this package
doesn't allow anonymous access at all.
This will be looked into in the future.

There are no tests currently, I plan them in the future but now I don't want to see anything Lemmy api related for
a while.

## Example

A very primitive remind me bot:

```php
<?php

use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Exception\LemmyApiException;
use Rikudou\LemmyApi\LemmyApi;

final readonly class RemindMeBot
{
    public function __construct(
        private LemmyApi $api,
        // how long to sleep between each loop
        private int $sleepFor,
        private string $username,
        #[SensitiveParameter] private string $password,
    ) {
    }

    public function loop(): void
    {
        $this->login();
        while (true) {
            try {
                $unreadMentions = $this->api->currentUser()->getMentions(
                    unreadOnly: true,
                );

                foreach ($unreadMentions as $mention) {
                    $author = $mention->creator->id;
                    $message = $mention->comment->content;
                    $dateTime = $this->getDateFromMessage($message);

                    $this->storeReminderInDatabase($author, $dateTime);
                    $this->api->currentUser()->markMentionAsRead($mention->personMention);

                    $this->api->comment()->create(
                        post: $mention->post,
                        content: "Sure, I'll let you know!",
                        language: Language::English,
                        parent: $mention->comment,
                    );
                }
            } catch (LemmyApiException $e) {
                $this->logException($e);
            }

            sleep($this->sleepFor);
        }
    }

    private function login(): void
    {
        $this->api->login($this->username, $this->password);
    }

    private function getDateFromMessage(string $message): DateTimeInterface
    {
        // todo implement this yourself
    }

    private function storeReminderInDatabase(int $userId, DateTimeInterface $dateTime): void
    {
        // todo implement this yourself
    }

    private function logException(LemmyApiException $e): void
    {
        // todo implement this yourself
    }
}
```
