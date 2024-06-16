## Installation

Set up `.env` file (database, etc)

```shell
composer install
php artisan migrate
```

### Add bot

```shell
php artisan telegraph:new-bot
```

Provide the bot's token, name. Set up a webhook.

Run the following command to update bot description, register commands.

```shell
php artisan bot:init
```
