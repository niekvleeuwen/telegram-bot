# Telegram bot
Simple telegram bot written in PHP
## Usage

Create a [bot](https://core.telegram.org/bots#6-botfather) and set `bot.php` as [webhook](https://core.telegram.org/bots/webhooks)

Create the file `credentials.php` and fill in the fields

```php
<?php
    $bot_key = "";
    $user_id = ; //telegram user id to verify that the request is coming from you
    $api_url = ""; 
    $api_key = "";
?>
```