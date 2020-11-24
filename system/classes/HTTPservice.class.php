<?php defined('Imperial') or die('No direct script access.');
 
class HTTPservice {
	
	public static function curl_get_contents($url) {
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_GET, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_URL, $url);
        
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.99 Safari/537.22');

		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data;
	}
	
	public static function api($method, $params) {
		
		$content = self::curl_get_contents('http://192.168.10.1/1Hotel/hs/rest_api/'.$method.'/'.$params.'');
		$result  = json_decode(json_encode(json_decode(($content))), True);

		return $result;
	}
}