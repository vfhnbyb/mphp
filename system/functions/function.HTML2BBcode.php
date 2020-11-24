<?php defined('Imperial') or die('No direct script access.');
/**
 * Функция перевода xHTML в BBкоды
 * @param $text
 * @return string|string[]|null
 */
function HTML2BBcode($text) {
   	$bbcode = array(
      	'/<a href="(.+)">(.+)<\/a>/isU'                                   => '[url]$1[/url]',
      	'/<a href="(.+)">(.+)<\/a>/isU'                                   => '[url=$1]$2[/url]',
      	'/<br \/>/isU'                                                    => '[br]',
      	'/<i>(.+)<\/i>/isU'                                               => '[i]$1[/i]',
      	'/<strong\>(.+)<\/strong>/isU'                                    => '[b]$1[/b]',
      	'/<span style="text-decoration: line-through">(.+)<\/span>/isU'   => '[del]$1[/del]',
      	'/<span style="text-decoration:underline">(.+)<\/span>/isU'       => '[u]$1[/u]',
      	'/<big>(.+)<\/big>/isU'                                           => '[big]$1[/big]',
      	'/<small>(.+)<\/small>/isU'                                       => '[small]$1[/small]',
      	'/<span style="color:#(.+)">(.+)<\/span>/isU'                     => '[color=$1]$2[/color]',
      	'/<span style="color:#ff0000">(.+)<\/span>/isU'                   => '[red]$1[/red\]',
      	'/<span style="color:#ffff22">(.+)<\/span>/isU'                   => '[yellow]$1[/red\]',
      	'/<span style="color:#00bb00">(.+)<\/span>/isU'                   => '[green]$1[/red\]',
      	'/<span style="color:#0000bb">(.+)<\/span>/isU'                   => '[blue]$1[/red\]');

 	return preg_replace(array_keys($bbcode), array_values($bbcode), $text);
}