<?php
$access_token = 'W+X36trYjmT3J3MwxGH0eVwYFEiJIN/MUhRKS4NkOAVjMjS1iy43ja//nWUu3/sVjyDheG3kYnZS23ZGunisgNyCs86RynE/NclW0ibHkFoiIJKrnqrIL4ean0c7rvDYAWx+JzG5yv/cvfuzze0G6QdB04t89/1O/w1cDnyilFU=';

$to ='U1afc8417a53546990d662f7319e981e6';

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
					'text' => 'Please select',
					'actions' => array(
              array(
							'type' => 'postback',
							'label' => 'Order',
              'data' => 'order'
              ),
						  array(
							'type' => 'message',
							'label' => 'Help',
              'text' => ' Help : คุณสามารถจองคิวได้เฉพาะหน้าร้านเท่านั้นโดยกดคำว่า Order'
						  )
					 )
				 )
			);

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/push';
			$data = [
				'to' => $to,
				'messages' => [$messages],
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
			curl_close($ch);

			echo $result . "\r\n";
      echo "OK";
?>