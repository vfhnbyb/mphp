<?php defined('Imperial') or die('No direct script access.');
/**
 * Функция перевода HTML в смайлы
 * @param $string
 * @return string|string[]|null
 */

function HTML2smiles($string) {
  	return preg_replace('#<img src="' . $GLOBALS['set']['http'] . 'content/smiles/(.*?).gif" alt="(.*?)" />#',':\1', $string);
}