<?php defined('Imperial') or die('No direct script access.');
/**
 * Функция удаленного подсчета размера файла
 * @param $url
 * @return mixed
 */

function getSizeFile($url) {
        $x = array_change_key_case(get_headers($url, 1), CASE_LOWER);
        return (strcasecmp($x[0], 'HTTP/1.1 200 OK') != 0) ? $x['content-length'][1] : $x['content-length'];
}