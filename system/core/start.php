<?php defined('Imperial') or die ('No direct script access.');
/**
 * PHP version >= 5.2.1
 *
 */

/**
* Системные константы
*/
define ('MT', microtime(TRUE));
define ('TIME', time());
define ('ACTION', isset($_GET['action']) ? $_GET['action'] : '', true);
define ('ROOT', str_replace('system/core', '', str_replace(DIRECTORY_SEPARATOR, '/', dirname(__FILE__))));
define ('CACHE_DIR', ROOT . 'cache');


/**
* Основные конфигурации системы
*/
ini_set ('error_reporting', -1);  								// Включаем полное отображение ошибок
ini_set ('xhtml_errors', TRUE);   								// Включаем полное отображение ошибок xHTML разметки
ini_set ('arg_separator.output', '&amp;');      				// Включаем переобразование & в &amp;
ini_set ('display_errors', FALSE); 								// Выключаем вывод ошибок на экран
ini_set ('ignore_repeated_errors', TRUE);       				// Выключаем повторый показ ошибок
ini_set ('session.use_trans_sid', FALSE);       				// Выключаем подстановку PHPSESSID в ссылки
ini_set ('magic_quotes_gpc', FALSE);                            // Выключаем экранирование кавычек
ini_set ('magic_quotes_runtime', FALSE);                        // Выключаем экранирование кавычек
ini_set ('magic_quotes_sybase', FALSE);                         // Выключаем экранирование кавычек
ini_set ('register_globals', FALSE);                            // Выключаем глобальные переменные

/**
* Загрузка настроек и проверка системы
*/
$set = parse_ini_file (ROOT . 'system/config/config.ini', TRUE);
version_compare (phpversion(), '5.2.1', '>=') or die ('Требуется PHP >= 5.2.1');

define ('LANG', 'ru');
define ('STYLE', 'default');
define ('TPLDIR', ROOT . 'template/' . STYLE . '/' . LANG . '/');

session_start (); // Устанавливаем сессии

mb_internal_encoding ('UTF-8'); 								// Устанавливаем кодировку UTF-8
setlocale(LC_ALL, 'ru_RU.utf-8');								// Устанавливаем локализацию

/**
* Автозагрузка классов
*/

spl_autoload_register(function ($name) {
    require_once ROOT . 'system/classes/' . $name . '.class.php';
});

$function = new Functions;
$tpl = new Template;
$var = new Security;

/**
* Подключение к базе данных MySQL
*/
$mysqli = @ new DB($set['db']['host'], $set['db']['user'], $set['db']['password'], $set['db']['db'], $set['db']['port']);
if (mysqli_connect_errno())
	exit ('Fatal error! ' . mysqli_connect_error());

$mysqli -> set_charset('UTF8');

/**
* Установка параметров
*/
$id = (isset($_GET['id'])) ? $var -> int($_GET['id']) : false;
$sPage = (!isset($_GET['page']) or !is_numeric($_GET['page']) or $_GET['page'] == 0) ? 1 : $var -> int($_GET['page']);
$sLimit = $sPage * 10 - 10;
$tpl -> assign(array(
	'function' => $function,
    'var'      => $var,
	'set'	   => $set,
	'id'	   => $id,
	'sPage'	   => $sPage,
	'mysqli'   => $mysqli));