<?php


/*
 * Załadowanie bibliotek oraz start aplikacji
 *
 * Zend -> do obsługi bazy danych
 * Smarty -> do łatwiejszego pisanie kodu PHP w HTMLu
 * App -> moja własna 'biblioteka' jądro aplikacji
 *
 *
 * Dodatkowo z bibliotek użytwane są jeszcze
 * JQuery
 * Bootstrap
 * font-awesome
 *
 * Ale one są po stronie przeglądarki a nie serwera
 */


require __DIR__.'/../vendor/autoload.php';
require __DIR__ . '/../library/Pig/App.php';

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) .'/..'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/library'),
    get_include_path(),
)));

$pigFramework = new App();
$pigFramework->run();