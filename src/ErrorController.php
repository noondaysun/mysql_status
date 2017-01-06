<?php
namespace Mysql_Status;

class ErrorController
{
    public function __construct(\Twig_Environment $twig, int $http_response_code)
    {
        if (in_array($http_response_code, array_keys($this->acceptableResponseCodes())) === false) {
            throw new \ErrorException('Bad Request');
        }
        $first = substr($http_response_code, 0, 1);
        switch ($first) {
            case 4:
                echo $twig->render('400.html.twig');
                break;
            case 5:
                echo $twig->render('500.html.twig');
                break;
        }
    }
    
    public function __destruct()
    {
        unset($this);
    }
    
    protected final function acceptableResponseCodes() :array
    {
        return (array) [
            400=>'Bad request',
            403=>'Forbidden',
            404=>'Not found',
            405=>'Method not found',
            500=>'Internal server error'
        ];
    }
}