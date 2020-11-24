<?php defined('Imperial') or die('No direct script access.');

final class DB extends MySQLi {
    /**
     * query
     *
     * @param $q
     * @return string
     */
    public function query($q){
    	$q = str_replace('#__', $GLOBALS['set']['db']['prefix'], $q);
        if ($this -> real_query($q)) {
            return new MySQLi_Result($this);
        } else {
            return false;
        }
    }
    
    public function mquery($q){
        return $this -> multi_query(str_replace('#__', $GLOBALS['set']['db']['prefix'], $q));
    }


    /**
     * result
     *
     * @param string $query
     * @return string OR int
     */
	static public function result($query) {
		if ($query != FALSE) {
			$arr = $query -> fetch_row();
			return $arr[0];
		} else {
			return FALSE;
		}
	}


	/**
     * cycle
     *
     * @param string $query
     * @return array
     */
	static public function cycle($query) {   		
   		if ($query != FALSE) {
   			$out = array();

			if($query -> num_rows > 0) {
    			while ($row = $query -> fetch_assoc()) {
        			$out[] = $row;
    			}

    			return $out;
    		}
    	} else {
    		return FALSE;
    	}
	}
}