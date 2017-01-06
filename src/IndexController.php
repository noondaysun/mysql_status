<?php
namespace Mysql_Status;

class IndexController extends MysqlStatus
{
    public function __construct(\Twig_Environment $twig)
    {
    
    }
    
    public function __destruct()
    {
        unset($this);
    }
}