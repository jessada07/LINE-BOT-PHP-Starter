<?php
require __DIR__  . '/vendor/autoload.php';
$access_token = 'W+X36trYjmT3J3MwxGH0eVwYFEiJIN/MUhRKS4NkOAVjMjS1iy43ja//nWUu3/sVjyDheG3kYnZS23ZGunisgNyCs86RynE/NclW0ibHkFoiIJKrnqrIL4ean0c7rvDYAWx+JzG5yv/cvfuzze0G6QdB04t89/1O/w1cDnyilFU=';
$secret ='3b44899e97cacf93240d4112b87ac873';
$to ='U1afc8417a53546990d662f7319e981e6';


$profile = get_user($to);

function get_user(&$user_id){
	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $secret]);
	$response = $bot->getProfile($user_id);
	if ($response->isSucceeded()) {
		$profile = $response->getJSONDecodedBody();
		echo $profile['displayName'];
		echo $profile['pictureUrl'];
		echo $profile['statusMessage'];
	}
	return $profile;
}

?>