<?php
$host = "localhost";    
$user = "mydata";    
$pass = "1234";    
$db = "testmydata";    
mysql_connect($host, $user, $pass) or die("Could not connect to database"); 
mysql_select_db($db) or die("Could not connect to database"); 
mysql_query("SET NAMES utf8")
    
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
				case 'เปิดไฟ':
				    // Build message to reply back           
				    $messages = [
							     'type' => 'text',
							     'text' => 'เรียบร้อย'			
							    ];  
            $sql = "UPDATE temp SET temp = '1' WHERE id =1";
            $query = mysql_query($sql);

				    break;
				case 'ปิดไฟ':
				    // Build message to reply back
				    $messages = [
							     'type' => 'text',
							     'text' => 'เรียบร้อย'			
							    ];            
				    break;
				case 'อุณหภูมิ':
				    // Build message to reply back
				    $messages = [
							     'type' => 'text',
							     'text' => 'ขณะนี้อุณหภูมิ'			
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