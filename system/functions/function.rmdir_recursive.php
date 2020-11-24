<?php defined('Imperial') or die('No direct script access.');
/**
 * Функция рекурсивного удаления папки
 * @param $dir
 */
function rmdir_recursive($dir) { 
     $files = glob($dir . '/*', GLOB_MARK); 
     
     foreach($files AS $file){ 
         (substr($file, -1) == '/') ? rmdir_recursive($file) : unlink($file);
     } 
     
     if (is_dir($dir))
     	rmdir($dir); 
}