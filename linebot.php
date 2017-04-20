<?php
    $access_token = 'W+X36trYjmT3J3MwxGH0eVwYFEiJIN/MUhRKS4NkOAVjMjS1iy43ja//nWUu3/sVjyDheG3kYnZS23ZGunisgNyCs86RynE/NclW0ibHkFoiIJKrnqrIL4ean0c7rvDYAWx+JzG5yv/cvfuzze0G6QdB04t89/1O/w1cDnyilFU=';
    
    // Get POST body content
    $content = file_get_contents('php://input');

    $url = "http://api.thingspeak.com/channels/202506/feeds/last.json?api_key=5WBJKUX2CGYQ04N2";
    $curl_handle = curl_init();
    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt( $curl_handle, CURLOPT_URL, $url );
    curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
    $text = curl_exec( $curl_handle );
    curl_close( $curl_handle ); 
    $obj = json_decode($text);
    $to = $obj->{'field2'}; 
    
    // Build message to reply back
			$messages = array(
				'type' => 'template',
				'altText' => 'This is a buttons template',
				'template' => array(
					'type' => 'buttons',
					'text' => 'ถึงคิวของคุณ',
					'actions' => array(
              array(
							'type' => 'postback',
							'label' => 'Cancel',
              'data' => 'Cancel My Queue'
              )
					 )
				 )
			);
      // Make a POST Request to Messaging API to reply to sender
	    $url = 'https://api.line.me/v2/bot/message/push';
	    $data = [
		        'to' => $to,
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