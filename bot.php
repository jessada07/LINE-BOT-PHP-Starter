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
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
	        $replyToken = $event['replyToken'];
    
			switch($text){
				case 'เปิดพัดลม':
				    // Build message to reply back           
				    $messages = [
							     'type' => 'text',
							     'text' => 'เปิดการใช้งานพัดลม'			
							    ];  
            $request = '1'; 
            $API_KEY = 'A636EPHK6T4XEIVP';
            $url = "http://api.thingspeak.com/update?key=".$API_KEY."&field1=".$request;
            $curl_handle = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt( $curl_handle, CURLOPT_URL, $url );
            curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_exec( $curl_handle );
            curl_close( $curl_handle ); 
				    break;
				case 'ปิดพัดลม':
				    // Build message to reply back
				    $messages = [
							     'type' => 'text',
							     'text' => 'ปิดการใช้งานพัดลม'			
							    ];  
            $request = '0'; 
            $API_KEY = 'A636EPHK6T4XEIVP';
            $url = "http://api.thingspeak.com/update?key=".$API_KEY."&field1=".$request;
            $curl_handle = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt( $curl_handle, CURLOPT_URL, $url );
            curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_exec( $curl_handle );
            curl_close( $curl_handle ); 
				    break;
				case 'อุณหภูมิ':
 
            $url = "http://api.thingspeak.com/channels/181033/feeds/last.json?api_key=L17TKCWDYRHVIRZR";
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
							     'text' => $mes
							    ];
            
				    break;
         case 'สถานะ': 
            $url = "http://api.thingspeak.com/channels/178792/feeds/last.json?api_key=A636EPHK6T4XEIVP";
            $curl_handle = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt( $curl_handle, CURLOPT_URL, $url );
            curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
            $text = curl_exec( $curl_handle );
            curl_close( $curl_handle ); 
            $obj = json_decode($text);
            $mes = $obj->{'field1'};
            if($mes == "1"){
               $mes = "พัดลมกำลังทำงาน...";
            }else{
               $mes = "พัดลมไม่ได้ทำงาน...";
            }
            
				    // Build message to reply back
				    $messages = [
							     'type' => 'text',
							     'text' => $mes
							    ];
            
				    break;
  			  default:
					$messages = [
							     'type' => 'text',
							     'text' => $text		
							    ];
					break;
			}
		}
		if ($event['type'] == 'message' && $event['message']['type'] == 'sticker'){
			// Get text sent
			$text = $event['message']['sticker'];
			// Get replyToken
	        $replyToken = $event['replyToken'];
			$random = rand(407,430);
			$messages = [
						 'type' => 'sticker',
                         'packageId' => '1',
                         'stickerId' => $random
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