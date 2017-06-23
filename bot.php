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
		    echo "<script>console.log( test );</script>";
		    $url = "http://api.thingspeak.com/channels/266142/feeds/last.json?api_key=UJ9398YTW67RQ2KN";
			$curl_handle = curl_init();
			curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt( $curl_handle, CURLOPT_URL, $url );
			curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
			$text = curl_exec( $curl_handle );
			curl_close( $curl_handle ); 
			$object = json_decode($text);
			$messager = $object->{'field1'};

			// Get text sent
			$text = $event['message']['text'];      
			// Get replyToken
	        $replyToken = $event['replyToken'];      
			// Build message to reply back
			$messages = array(
				'type' => 'template',
				'altText' => 'This is a buttons template',
				'template' => array(
					'type' => 'confirm',
					'text' => 'ระบบจองคิว',
					'actions' => array(
						  array(
							'type' => 'postback',
							'label'=> 'Booking',
							'data' => $messager
						  ),
						  array(
							'type' => 'message',
							'label'=> 'Help',
							'text' => 'สามารถจองคิวได้โดยกดคำว่า Booking โดยมีอายุการใช้งาน 1 วัน'
						  )
					 )
				 )
			);
		}			
/*    if ($event['type'] == 'postback' && $event['postback']['data'] == '2' ||  $event['postback']['data'] == '4' || $event['postback']['data'] == '8' || $event['postback']['data'] == '10') {
		// Get replyToken
		$user_id = $event['source']['userId'];
		$replyToken = $event['replyToken'];
		$url = "http://api.thingspeak.com/channels/202503/feeds/last.json?api_key=0QJTN9QPAXWCI68I";
		$curl_handle = curl_init();
		curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt( $curl_handle, CURLOPT_URL, $url );
		curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
		$text = curl_exec( $curl_handle );
		curl_close( $curl_handle ); 
		$obj = json_decode($text);
		$mes = $obj->{'field4'}; 
		$mes = $mes + 1;
      	$url = 'https://api.thingspeak.com/update?api_key=0QJTN9QPAXWCI68I&field1='.$mes.'&field2=booking&field3='.$user_id.'&field4='.$mes.'&field5='.$event['postback']['data'];
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
    }*/

    if ($event['type'] == 'postback' && $event['postback']['data'] == 'cancel') {
		  // Get replyToken
		  $url = "http://api.thingspeak.com/channels/202503/feeds/last.json?api_key=0QJTN9QPAXWCI68I";
		  $curl_handle = curl_init();
		  curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
		  curl_setopt( $curl_handle, CURLOPT_URL, $url );
		  curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
		  $text = curl_exec( $curl_handle );
		  curl_close( $curl_handle ); 
		  $obj = json_decode($text);
		  $last = $obj->{'field4'}; 
      
		  $user_id = $event['source']['userId'];
		  $replyToken = $event['replyToken'];
		  $url = "http://api.thingspeak.com/channels/202506/feeds/last.json?api_key=5WBJKUX2CGYQ04N2";
		  $curl_handle = curl_init();
		  curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
		  curl_setopt( $curl_handle, CURLOPT_URL, $url );
		  curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
		  $text = curl_exec( $curl_handle );
		  curl_close( $curl_handle ); 
		  $obj = json_decode($text);
		  $mes = $obj->{'field1'}; 
      
		  $url = 'https://api.thingspeak.com/update?api_key=0QJTN9QPAXWCI68I&field1='.$mes.'&field2=cancel&field3='.$user_id.'&field4='.$last;
		  $curl_handle = curl_init();
		  curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
		  curl_setopt( $curl_handle, CURLOPT_URL, $url );
		  curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
		  curl_exec( $curl_handle );
		  curl_close( $curl_handle );
		  $messages = [
			  'type' => 'text',
			  'text' => 'ยกเลิก Queue เรียบร้อย'
		  ];
    }

	if ($event['type'] == 'postback' && $event['postback']['data'] != 'cancel') {		
		 if ($event['postback']['data'] == '2' ||  $event['postback']['data'] == '4' || $event['postback']['data'] == '8' || $event['postback']['data'] == '10') {
			// Get replyToken
			$user_id = $event['source']['userId'];
			$replyToken = $event['replyToken'];
			$url = "http://api.thingspeak.com/channels/202503/feeds/last.json?api_key=0QJTN9QPAXWCI68I";
			$curl_handle = curl_init();
			curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt( $curl_handle, CURLOPT_URL, $url );
			curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
			$text = curl_exec( $curl_handle );
			curl_close( $curl_handle ); 
			$obj = json_decode($text);
			$mes = $obj->{'field4'}; 
			$mes = $mes + 1;
      		$url = 'https://api.thingspeak.com/update?api_key=0QJTN9QPAXWCI68I&field1='.$mes.'&field2=booking&field3='.$user_id.'&field4='.$mes.'&field5='.$event['postback']['data'];
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
        }else{
			$code = $event['postback']['data'];
			$url = "http://api.thingspeak.com/channels/266142/feeds/last.json?api_key=UJ9398YTW67RQ2KN";
			$curl_handle = curl_init();
			curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt( $curl_handle, CURLOPT_URL, $url );
			curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
			$text = curl_exec( $curl_handle );
			curl_close( $curl_handle ); 
			$object = json_decode($text);
			$messager = $object->{'field1'}; 

			if($messager == $code){
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
						'text' => 'จำนวนที่นั่ง',
						'actions' => array(
							  array(
								'type' => 'postback',
								'label'=> '1-2 ที่นั่ง',
								'data' => '2'
							  ),array(
								'type' => 'postback',
								'label'=> '3-4 ที่นั่ง',
								'data' => '4'
							  ),array(
								'type' => 'postback',
								'label'=> '5-8 ที่นั่ง',
								'data' => '8'
							  ),array(
								'type' => 'postback',
								'label'=> '10 ที่นั่งขึ้นไป',
								'data' => '10'
							  )
						 )
					 )
				);    
			}else {
				$replyToken = $event['replyToken'];
				$messages = [
					'type' => 'text',
					'text' => 'ขออภัยหมดเวลาในการจอง'
				];		
			}
		}	    
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
