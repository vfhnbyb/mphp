<?php defined('Imperial') or die('No direct script access.');
/**
 * Функция вывода размера файлов
 * @param $size
 * @return string
 */
function size($size) {
	if($size >= 1073741824) {
		$size = round($size/1073741824*100) / 100 . ' Гб';
	} elseif($size >= 1048576) {
		$size = round($size/1048576*100) / 100 . ' Мб';
	} elseif($size >= 1024) {
		$size = round($size/1024*100) / 100 . ' Кб';
	} else {
		$size = round($size) . ' б';
	}

	return $size;
}