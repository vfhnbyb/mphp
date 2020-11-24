<?php defined('Imperial') or die('No direct script access.');

class Functions {
    /**
     * __call
     *
     * @param string $name
     * @param $key
     * @return string OR array
     */
    public function __call(string $name, $key) {
     	require_once(ROOT . '/system/functions/function.' . $name . '.php');
     	return call_user_func_array($name, $key);
    }
}