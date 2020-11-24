<?php defined('Imperial') or die('No direct script access.');

class Callibri {
	
	public static function curl_get_contents($url) {
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_URL, $url);
        
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.99 Safari/537.22');

		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data;
	}

    /**
     * @param $name
     * @param array $params
     * @param $site
     * @return mixed
     */
    public static function api($name, array $params, $site) {
		
		$content = self::curl_get_contents('https://api.callibri.ru/'.$name.'?user_email=it@kontinent-crimea.com&user_token=&site_id='.$site.'&'.str_replace('&amp;', '&', http_build_query($params)));
        return json_decode($content);
	}
}