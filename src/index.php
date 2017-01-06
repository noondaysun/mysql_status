<?php
namespace Mysql_Status;

// : Defines
defined('BASE')||
define('BASE', substr(dirname(realpath(__FILE__)), 0, strrpos(dirname(realpath(__FILE__)), 'mysql_status')));
// : End
require_once BASE . 'mysql_status' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require_once BASE . 'mysql_status' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'MysqlStatus.php';
require_once BASE . 'mysql_status' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'IndexController.php';
require_once BASE . 'mysql_status' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'SetupController.php';
require_once BASE . 'mysql_status' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'ErrorController.php';

$database = (string) 'mysqlstatus';

try {
    $loader = new \Twig_Loader_Filesystem(
        BASE . 'mysql_status' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'views'
        );
    try {
        $twig = new \Twig_Environment($loader, array(
            'cache' => BASE . 'mysql_status' . DIRECTORY_SEPARATOR . 'cache',
        ));
        if (array_key_exists('setup', $_GET)) {
            new SetupController($twig);
        } else {
            new IndexController($twig);
        }
    } catch (\Exception $e) {
        syslog(LOG_ERR, 'Cannot load Twig. Exiting. Line: ' . __LINE__);
        print('Can\'t load templating engine. Exiting. Error returned: ' . $e->getMessage());
        exit;
    }
} catch (\Twig_Error_Loader $e) {
    syslog(LOG_ERR, 'Cannot load Twig. Exiting. Line: ' . __LINE__);
    print('Can\'t load templating engine. Exiting. Error returned: ' . $e->getMessage());
    exit;
}