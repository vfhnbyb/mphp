<?php defined('Imperial') or die('No direct script access.');

class Evotor {

    public static function curl_get($url) {
    		$ch = curl_init($url);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            //curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json', 
                'X-Authorization: ',
                'Content-Type: application/json'));
    		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.99 Safari/537.22');
    
    		$data = curl_exec($ch);
    		curl_close($ch);
    		
    		return json_decode($data);
    	}
    
    public static function curl_post($url, array $params = array()) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'X-Authorization: ',
                'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            
            $data = curl_exec($ch);
            curl_close($ch);
            
            return $data;
      }
}