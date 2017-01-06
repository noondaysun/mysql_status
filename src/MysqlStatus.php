<?php
namespace Mysql_Status;

class MysqlStatus
{
    public function __construct()
    {
        //: Do nothing
    }
    
    public function __destruct()
    {
        unset($this);
    }
    
    /**
     * Connects to a mysql database
     * @return mixed
     * Exits on failure else DoctrineDriverManager instance
     */
    public function connectMe()
    {
        $config_file = (string) BASE . 'mysql_status' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
        $config_file .= 'config' . DIRECTORY_SEPARATOR . 'config.php';
        if (file_exists($config_file) === false) {
            syslog(LOG_CRIT, 'Doctrine config file missing.');
            exit;
        }
        if (is_readable($config_file) === false) {
            syslog(LOG_CRIT, 'Doctrine config file not readable.');
            exit;
        }
        include_once $config_file;
        try {
            $config = new \Doctrine\DBAL\Configuration();
            try {
                $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
                return $conn;
            } catch (\Exception $e) {
                syslog(LOG_CRIT, 'Cannot start Doctrine. Error: ' . $e->getMessage());
                exit;
            }
        } catch (\Exception $e) {
            syslog(LOG_CRIT, 'Cannot start Doctrine. Error: ' . $e->getMessage());
            exit;
        }
    }
}