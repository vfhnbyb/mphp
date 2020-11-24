<?php defined('Imperial') or die('No direct script access.');
 
class Bitrix {

    /**
     * @param $url
     * @param $dataArray
     * @return bool|string
     */
    public static function curl_get_contents($url, $dataArray) {
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataArray);
        
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.99 Safari/537.22');

		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data;
	}

    /**
     * @param $name
     * @param array $params
     * @param $key
     * @param $uid
     * @return mixed
     */
    public static function api($name, array $params, $key, $uid) {
		$key = ($key) ? $key : 'key';
        $uid = ($uid) ? $uid : '1';
		$content = self::curl_get_contents('https://127.0.0.1/rest/'.$uid.'/'.$key.'/'.$name.'.json', str_replace('&amp;', '&', http_build_query($params)));
        return json_decode($content);
	}

    /**
     * @param $msg
     * @param $id
     * @param int $type
     * @return mixed
     */
    public static function Livemsg($msg, $id, $type = 2) {
        return self::api('crm.livefeedmessage.add', array(
                      "fields" => array(
                         "POST_TITLE" => "Информация",
                         "MESSAGE" => $msg,
                         "ENTITYTYPEID" => $type,
                         "ENTITYID" => $id,
                         )), false, false);
    }
     public static function dealUpdateStage($stage, $id) {
        $result = self::api('crm.deal.update', array("ID" => $id, "fields" => array("STAGE_ID" => $stage)), false, false);
        return $result;
    }
}