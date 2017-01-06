<?php
namespace Mysql_Status\Tests;

// : Defines
defined('BASE')||
define('BASE', substr(dirname(realpath(__FILE__)), 0, strrpos(dirname(realpath(__FILE__)), 'mysql_status')));
// : End

class IndexTest extends \PHPUnit_Framework_TestCase
{
    //: Can we write to the file system?
    /**
    *
    */
    public function testBase()
    {
        $this->assertEquals(gettype(BASE), 'string');
        $this->assertEquals(is_dir(BASE), true);
        $this->assertEquals(is_readable(BASE), true);
        $this->assertEquals(is_writable(BASE), true);
    }
    
    //: Does our database exist?
    /**
     * 
     */
    public function testForDatabase()
    {
        $database = (string) BASE . DIRECTORY_SEPARATOR . 'mysql_status' . DIRECTORY_SEPARATOR . 'mysqlstatus.db';
        $this->assertEquals(is_readable($database), true);
        $this->assertEquals(is_writable($database), true);
    }
}