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
            $API_KEY = 'FIV2UGQG1OAR6K65';
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
            $API_KEY = 'FIV2UGQG1OAR6K65';
            $url = "http://api.thingspeak.com/update?key=".$API_KEY."&field1=".$request;
            $curl_handle = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt( $curl_handle, CURLOPT_URL, $url );
            curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_exec( $curl_handle );
            curl_close( $curl_handle ); 
				    break;
            
        case 'อัตโนมัติ':
				    // Build message to reply back
				    $messages = [
							     'type' => 'text',
							     'text' => 'เปิดการใช้งานอัตโนมัติ'			
							    ];  
            $request = '2'; 
            $API_KEY = 'FIV2UGQG1OAR6K65';
            $url = "http://api.thingspeak.com/update?key=".$API_KEY."&field1=".$request;
            $curl_handle = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt( $curl_handle, CURLOPT_URL, $url );
            curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_exec( $curl_handle );
            curl_close( $curl_handle ); 
				    break;
            
				case 'อุณหภูมิ': 
            $url = "http://api.thingspeak.com/channels/202503/feeds/last.json?api_key=0QJTN9QPAXWCI68I";
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
							     'text' => "ขณะนี้อุณหภูมิ  $mes  C"
							    ];
            
				    break;
         case 'สถานะ': 
            $url = "http://api.thingspeak.com/channels/202506/feeds/last.json?api_key=FIV2UGQG1OAR6K65";
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
            }elseif($mes == "0"){
               $mes = "พัดลมไม่ได้ทำงาน...";
            }else{
               $mes = "อัตโนมัติ";
            }
            
				    // Build message to reply back
				    $messages = [
							     'type' => 'text',
							     'text' => $mes
							    ];
            
				    break;
           case 'หาร้านอาหาร': 
            $url = "https://maps.googleapis.com/maps/api/place/radarsearch/json?opennow&language=th&location=13.8081935,100.0536584&radius=500&type=restaurant&key=AIzaSyBEA0UcZj9m-fYvwGTx0aoITGJxyWLdGm4";
            $curl_handle = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt( $curl_handle, CURLOPT_URL, $url );
            curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
            $text = curl_exec( $curl_handle );
            curl_close( $curl_handle ); 
            $obj = json_decode($text, TRUE);
            for ($x = 0; $x <= 10; $x++) {
               $mes = $obj['results'][$x]['place_id']; 
               $url = "https://maps.googleapis.com/maps/api/place/details/json?placeid=$mes&key=AIzaSyBEA0UcZj9m-fYvwGTx0aoITGJxyWLdGm4";
               $curl_handle = curl_init();
               curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
               curl_setopt( $curl_handle, CURLOPT_URL, $url );
               curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true);
               $text = curl_exec( $curl_handle );
               curl_close( $curl_handle ); 
               $object = json_decode($text, TRUE);
               $name = $object['result']['name']; 
               $number = $object['result']['formatted_phone_number'];
               $address = $object['result']['formatted_address'];
               $addname .= "->>".$name."\n".$number."\n".$address."\n\n";
            }            
				    // Build message to reply back
				    $messages = [
							     'type' => 'text',
							     'text' => "$addname"
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