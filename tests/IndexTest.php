<?php
namespace Mysql_StatusTests;

class IndexTest extends \PHPUnit_Framework_TestCase
{
    //: Can we write to the file system?
    /**
    *
    */
    public function testBase()
    {
        if (defined('BASE') === false) {
            define('BASE', substr(dirname(realpath(__FILE__)), 0, strrpos(dirname(realpath(__FILE__)), 'mysql_status')));
        }
        $this->assertEquals(gettype(BASE), 'string');
    }

    //: Can we connect to the specified hosts?
}