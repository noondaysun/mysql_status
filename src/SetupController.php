<?php
namespace Mysql_Status;

class SetupController extends MysqlStatus
{
    public function __construct(\Twig_Environment $twig)
    {
        $conn = $this->connectMe();
        if ($conn) {
            $this->getTableStructure($conn);
        }
        echo $twig->render('setup.html.twig');
    }
    
    public function __destruct()
    {
        unset($this);
    }
    
    protected function getTableStructure($conn) :bool
    {
        try {
            $statement = $conn->prepare('SHOW TABLES');
            $statement->execute();
            $tables = $statement->fetchAll();
            if ($tables) {
                print '<pre>';
                print_r($tables);
            }
        } catch (\Exception $e) {
            syslog(LOG_CRIT, 'Cannot query database. Exiting. Error: ' . $e->getMessage());
            exit;
        }
        $variables = (string)'CREATE TABLE variables (';
        $variables .= 'id INT PRIMARY KEY AUTOINCREMENT,';
        $variables .= 'name TEXT,';
        $variables .= 'query TEXT';
        $variables .= ') ENGINE=INNODB DEFAULT CHARSET=utf8';
        $hosts = (string) 'CREATE TABLE hosts (';
        $hosts .= 'id INT PRIMARY KEY AUTOINCREMENT,';
        $hosts .= 'host TEXT,';
        $hosts .= 'user TEXT,';
        $hosts .= 'pass TEXT';
        $hosts .= ') ENGINE=INNODB DEFAULT CHARSET=utf8';
        $host_keys = (string) 'CREATE TABLE host_keys (';
        $host_keys .= 'id INT PRIMARY KEY AUTOINCREMENT,';
        $host_keys .= 'host_id INT,';
        $host_keys .= 'key TEXT,';
        $host_keys .= 'INDEX host_ind (host_id),';
        $host_keys .= 'FOREIGN KEY (host_id) REFERENCES hosts(id) ON DELETE CASCADE';
        $host_keys .= ') ENGINE=INNODB DEFAULT CHARSET=utf8';
        $run = (string)'CREATE TABLE run (';
        $run .= 'id INT PRIMARY KEY AUTOINCREMENT,';
        $run .= '';
        $run .= ') ENGINE=INNODB DEFAULT CHARSET=utf8';
        
        return true;
    }
}