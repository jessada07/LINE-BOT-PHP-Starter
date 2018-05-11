<?php
	$get_data = $_GET['data'];
    $access_token = 'W+X36trYjmT3J3MwxGH0eVwYFEiJIN/MUhRKS4NkOAVjMjS1iy43ja//nWUu3/sVjyDheG3kYnZS23ZGunisgNyCs86RynE/NclW0ibHkFoiIJKrnqrIL4ean0c7rvDYAWx+JzG5yv/cvfuzze0G6QdB04t89/1O/w1cDnyilFU=';
    if($get_data = 1){
    	$url = "http://api.thingspeak.com/channels/482888/feeds/last.json?api_key=5AZJRVINNBDSF7B7";
        $curl_handle = curl_init();
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt( $curl_handle, CURLOPT_URL, $url );
        curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
        $text = curl_exec( $curl_handle );
        curl_close( $curl_handle ); 
        $obj = json_decode($text);
        $mes = $obj->{'field1'};             
		    // Build message to reply back
		    $messages = [
					    'type' => 'text',
				        'text' => 'ขณะนี้แบตเตอรี่ '.mes.'%'
					    ];
    }
      // Make a POST Request to Messaging API to reply to sender
	    $url = 'https://api.line.me/v2/bot/message/push';
	    $data = [
		          'to' => 'U1afc8417a53546990d662f7319e981e6',
			      'messages' => [$messages]
			    ];
	  	$post = json_encode($data);
		$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		url_close($ch);
		echo $result . "\r\n";		 
?>