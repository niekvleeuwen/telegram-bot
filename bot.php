<?php
    require "credentials.php";
    $msg = "Welcome back Sir";

    $request_params = [
        'chat_id' => $user_id,
        'text' => $msg
    ];

    $reqeust_url = 'https://api.telegram.org/bot' . $bot_key . '/sendMessage?' . http_build_query($request_params);

    file_get_contents($reqeust_url);
?>