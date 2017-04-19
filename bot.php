<?php
$access_token = 'W+X36trYjmT3J3MwxGH0eVwYFEiJIN/MUhRKS4NkOAVjMjS1iy43ja//nWUu3/sVjyDheG3kYnZS23ZGunisgNyCs86RynE/NclW0ibHkFoiIJKrnqrIL4ean0c7rvDYAWx+JzG5yv/cvfuzze0G6QdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'beacon' && $event['beacon']['type'] == 'enter') {
			// Get text sent
			$text = $event['message']['text'];      
			// Get replyToken
	        $replyToken = $event['replyToken'];      
			// Build message to reply back
			$messages = array(
				'type' => 'template',
				'altText' => 'This is a buttons template',
				'template' => array(
					'type' => 'buttons',
					'text' => 'ระบบจองคิว',
					'actions' => array(
              array(
							'type' => 'postback',
							'label' => 'Order',
              'data' => 'order'
              ),
						  array(
							'type' => 'message',
							'label' => 'Help',
              'text' => 'คุณสามารถจองคิวได้เฉพาะหน้าร้านเท่านั้นโดยกดคำว่า Order'
						  )
					 )
				 )
			);
		}			
    if ($event['type'] == 'postback' && $event['postback']['data'] == 'order') {
      // Get replyToken
      //$status = $event['beacon']['type']; 
      $user_id = $event['source']['userId']
	    $replyToken = $event['replyToken'];
      $url = "http://api.thingspeak.com/channels/202503/feeds/last.json?api_key=0QJTN9QPAXWCI68I";
      $curl_handle = curl_init();
      curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt( $curl_handle, CURLOPT_URL, $url );
      curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
      $text = curl_exec( $curl_handle );
      curl_close( $curl_handle ); 
      $obj = json_decode($text);
      $mes = $obj->{'field1'}; 
      $mes = $mes + 1;
      
      $url = 'https://api.thingspeak.com/update?api_key=0QJTN9QPAXWCI68I&field1='.$mes.'&field2=booking&field3='.$user_id;
      $curl_handle = curl_init();
      curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt( $curl_handle, CURLOPT_URL, $url );
      curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
      curl_exec( $curl_handle );
      curl_close( $curl_handle );
      $messages = [
          'type' => 'text',
          'text' => 'Queue ของคุณคือ   '.$mes
      ];
    }
    
		// Make a POST Request to Messaging API to reply to sender
	    $url = 'https://api.line.me/v2/bot/message/reply';
	    $data = [
		        'replyToken' => $replyToken,
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
	}
}
?>