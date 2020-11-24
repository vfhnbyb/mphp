<?php defined('Imperial') or die('No direct script access.');
/**
 * Функция BB кодов
 * @param $text
 * @return string|string[]|null
 */
function BBcode($text) {
	$bbcode = array(
		'/\[br]/isU' 											          =>'<br />',
		'/\[i\](.+)\[\/i\]/isU'                                           =>'<i>$1</i>',
 		'/\[b\](.+)\[\/b\]/isU'                                           =>'<strong>$1</strong>',
		'/\[del\](.+)\[\/del\]/isU'                                       =>'<span style="text-decoration: line-through">$1</span>',
		'/\[u\](.+)\[\/u\]/isU'                                           =>'<span style="text-decoration:underline">$1</span>',
		'/\[big\](.+)\[\/big\]/isU'                                       =>'<big>$1</big>',
		'/\[small\](.+)\[\/small\]/isU'                                   =>'<small>$1</small>',
		'/\[color=(.+)\](.+)\[\/color\]/isU'                              =>'<span style="color:#$1">$2</span>',
		'/\[red\](.+)\[\/red\]/isU'                                       =>'<span style="color:#ff0000">$1</span>',
		'/\[yellow\](.+)\[\/yellow\]/isU'                                 =>'<span style="color:#ffff22">$1</span>',
		'/\[green\](.+)\[\/green\]/isU'                                   =>'<span style="color:#00bb00">$1</span>',
		'/\[blue\](.+)\[\/blue\]/isU'                                     =>'<span style="color:#0000bb">$1</span>');

 	return preg_replace(array_keys($bbcode), array_values($bbcode), $text);
}