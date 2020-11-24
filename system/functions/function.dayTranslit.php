<?php defined('Imperial') or die('No direct script access.');
/**
 * Функция склонения числительных
 * @param $number
 * @param $n
 */
function dayTranslit($number, $n) {
  $after = (!$n) ? array('День', 'Дня', 'Дней') : array('Сутки', 'Суток', 'Суток');
  $cases = array (2, 0, 1, 1, 1, 2);
  echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}