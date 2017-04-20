<?php
    require __DIR__  . '/vendor/autoload.php';
    $access_token = 'W+X36trYjmT3J3MwxGH0eVwYFEiJIN/MUhRKS4NkOAVjMjS1iy43ja//nWUu3/sVjyDheG3kYnZS23ZGunisgNyCs86RynE/NclW0ibHkFoiIJKrnqrIL4ean0c7rvDYAWx+JzG5yv/cvfuzze0G6QdB04t89/1O/w1cDnyilFU=';
    $secret ='3b44899e97cacf93240d4112b87ac873';

    $url = "http://api.thingspeak.com/channels/202506/feeds/last.json?api_key=5WBJKUX2CGYQ04N2";
    $curl_handle = curl_init();
    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt( $curl_handle, CURLOPT_URL, $url );
    curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
    $text = curl_exec( $curl_handle );
    curl_close( $curl_handle ); 
    $obj = json_decode($text);
    $to = $obj->{'field2'}; 

    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('$access_token');
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '$secret']);

    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
    $response = $bot->pushMessage('$to', $textMessageBuilder);

    echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
?>