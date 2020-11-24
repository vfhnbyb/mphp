<?php defined('Imperial') or die('No direct script access.');
/**
 * Функция устранения дублей в масиве
 * @param $array
 * @param $key
 * @return array
 */
function uniqueMultidimArray($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}