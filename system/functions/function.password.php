<?php defined('Imperial') or die('No direct script access.');
/**
 * Функция генерации пароля
 * @param int $lenght
 * @return false|string
 */
function password($lenght = 6) {
  	return substr(str_shuffle('aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789'), 0, $lenght);
}