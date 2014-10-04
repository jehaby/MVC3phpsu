<?php


class Router
{
    private $routes;

    function __construct()
    {
        $this->_load_defaults();
    }

    function getURI()
    {
        $uri=$this->_getURI();
        $webRoot=Config_Handler::getInstance()->getWebpath();

        return ltrim(preg_replace('#^'.$webRoot.'#i', '', $uri), '/');
    }
    //

    function run()
    {
        $uri = $this->getURI();
        foreach($this->routes as $route=>$destination)
        {
            if(preg_match($route, $uri))
            {
                $internalRoute = preg_replace($route, $destination, $uri);
                $segments = explode('/', $internalRoute);
                $controller = 'Controller_'.ucfirst(array_shift($segments));
                $method = array_shift($segments).'Action';
                $parameters = $segments;
                //launch controller:
                if(class_exists($controller))
                {
                    $obj    = new $controller;
                    if(method_exists($obj, $method))
                    {
                        call_user_func_array(array($obj, $method), $parameters);
                        return;
                    }
                    else
                    {
                        $this->_default_error();
                    }
                }
                else
                {
                    $this->_default_error();
                }
            }
        }
        return;
    }

    protected function _default_error()
    {
        header("HTTP/1.0 404 Not Found");
        exit("<table style='width:100%; height: 100%'><tr><td align='center' valign='center'><h1>404 Not Found</h1></td></tr></table>");
    }

    protected function _load_defaults()
    {
        $this->routes = array(
            '#([-_a-z0-9]+)/([-_a-z0-9]+)/([-_a-z0-9]+)[\?]?(.*)#'   => '$1/$2/$3/$4',
            '#([-_a-z0-9]+)/([-_a-z0-9]+)[\?]?(.*)#'                 => '$1/$2/$3',
            '#([-_a-z0-9]+)[\?]?(.*)#'                               => '$1/$2',
        );
        return true;
    }

    protected function _getURI()
    {
        if(!empty($_SERVER['REQUEST_URI']))
        {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        if(!empty($_SERVER['PATH_INFO']))
        {
            return trim($_SERVER['PATH_INFO'], '/');
        }
        if(!empty($_SERVER['QUERY_STRING']))
        {
            return trim($_SERVER['QUERY_STRING'], '/');
        }
    }
}