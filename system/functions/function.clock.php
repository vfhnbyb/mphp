<?php defined('Imperial') or die('No direct script access.');
/**
 * Функция вывода времени
 * @param $time
 * @return false|string
 */
function clock($time) {
	global $user;
	
	$arrM = array(
		'01' => 'Января',
		'02' => 'Февраля',
		'03' => 'Марта',
		'04' => 'Апреля',
		'05' => 'Мая',
		'06' => 'Июня',
		'07' => 'Июля',
		'08' => 'Августа',
		'09' => 'Сентября',
		'10' => 'Октября',
		'11' => 'Ноября',
		'12' => 'Декабря'
	);
	
	$time = (!$user) ? $time + ($GLOBALS['set']['timezone'] * 3600) : $time + ($user['timezone'] * 3600);

	$labelTime = date('j.m.Y', $time);

	if ($labelTime == date('j.m.Y', TIME + $GLOBALS['set']['timezone'] * 3600)) :
		return 'Сегодня в '.date('H:i', $time);
	elseif ($labelTime == (date('j', TIME + $GLOBALS['set']['timezone'] * 3600) - 1).'.'.date('m.Y', TIME + $GLOBALS['set']['timezone'])) :
		return 'Вчера в '.date('H:i', $time);
	else :
		return date('j '.$arrM[date('m', $time)].' Y в H:i', $time);
	endif;
}