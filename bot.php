<?php
    require "credentials.php";

    //get json
    $data = file_get_contents('php://input');
    // parse de JSON
    $json = json_decode($data);

    if (!$json) {
        // received non valid request
        exit();
    }

    $incoming_text = htmlspecialchars($json->{'message'}->{'text'});
    $incoming_userid = htmlspecialchars($json->{'message'}->{'chat'}->{'id'});

    //validate user
    if($incoming_userid != $user_id){
        exit;
    }

    //get the response from the api
    $url = $api_url;
    $data = array(
        'apikey'      => $api_key,
        'request'      => $incoming_text
      );

    $options = array(
        'http' => array(
          'method'  => 'POST',
          'content' => json_encode( $data ),
          'header'=>  "Content-Type: application/json\r\n" .
                      "Accept: application/json\r\n"
          )
      );
      
    $context  = stream_context_create( $options );
    $result = file_get_contents( $url, false, $context );
    $response = json_decode( $result );

    //check if request is succesful
    if($response->{'status'} == 200){
        $outgoing_text = $response->{'response'};
        //if the text contains multipe messages send them separated
        if(is_array($outgoing_text)){
            foreach($outgoing_text as $msg){
                send_message($msg, $user_id, $bot_key);
            }
        }else{
            send_message($outgoing_text, $user_id, $bot_key);
        }
    }else{
        send_message("Something went wrong Sir, my apologies", $user_id, $bot_key);
    }

    function send_message($msg, $user_id, $bot_key){
        $request_params = [
            'chat_id' => $user_id,
            'text' => $msg
        ];
    
        $request_url = 'https://api.telegram.org/bot' . $bot_key . '/sendMessage?' . http_build_query($request_params);
        file_get_contents($request_url);
    }
?>