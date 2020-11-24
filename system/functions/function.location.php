<?php defined('Imperial') or die('No direct script access.');
/**
 * Функция перенаправления
 * @param $url
 * @param bool $host
 */
function location($url, $host = false) {
	if(!$host)
		$host = $GLOBALS['set']['http'];
                                       
	  header('Location: ' . $host . $url);
   exit();
}