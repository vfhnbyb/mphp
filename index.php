<?php
define('Imperial', true);
require_once 'system/core/start.php';

switch(ACTION) {
	default:
	    echo ROOT . "system/core/start.php";

	    $iQuery = $mysqli -> query("SELECT * FROM `#__user` WHERE `id` = '" . $var -> get('id') . "'") -> fetch_array();

        $tpl -> assign(array("fff" => "ooo"));
        $tpl -> display('index');
        break;
}