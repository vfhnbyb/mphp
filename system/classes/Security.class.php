<?php defined('Imperial') or die('No direct script access.');

class Security {
	/**
     * clean
     *
     * @param string	$var
     * @return string
     */
	function clean($var) {
		return str_replace('&ndash;', '–', trim(htmlentities($var, ENT_QUOTES, 'UTF-8')));
        //return mysqli_real_escape_string($var);
        //return trim(mysqli_real_escape_string(htmlentities($var, ENT_QUOTES, 'UTF-8')));
	}


	/**
     * int
     *
     * @param string	$var
     * @return int
     */
	function int($var) {
		return abs((int)$var);
	}


	/**
     * get
     *
     * @param string	$key
     * @return string
     */
    function get($key) {
    	return $this -> clean($_GET[$key]);
    }


	/**
     * pos
     *
     * @param string	$key
     * @return string
     */
    function post($key) {
    	return $this -> clean($_POST[$key]);
    }

	/**
     * cookie
     *
     * @param string	$key
     * @return string
     */
    function cookie($key) {
    	return $this -> clean($_COOKIE[$key]);
    }
}