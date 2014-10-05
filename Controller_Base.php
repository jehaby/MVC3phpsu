<?php


class Controller_Base {
    protected $view;
    protected $dbInstance;
    protected $currentUser;

    function __construct()
    {
        session_start();
        $rDb    = new Db_Controller();
        $this->view = new View_Base();
        $this->dbInstance   = $rDb->getAdapter();
        /* handle possible auth, for example:
        if(isset($_SESSION['login']))
        {
            $this->currentUser=$_SESSION['login'];
        }
        */
    }

    function redirect($url)
    {
        if($url[0]!='/')
        {
            $url[0]='/';
        }
        header('Location: '.Config_Handler::getInstance()->getWebroot().$url);
        exit();
    }

    function getParam($param)
    {
        $mValue = $this->_get_param($param, $_GET);
        if(!$mValue)
        {
            $mValue = $this->_get_param($param, $_POST);
        }
        return $mValue;
    }

    function loginUser($rgUser)
    {
        /* here we are saving login of user, for example:
        $_SESSION['login']=$rgUser['login'];
        */
    }

    function logoutUser()
    {
        /* here we are doing logout of user, for example:
        unset($_SESSION['login']);
        */
    }

    protected function _get_param($param, $array)
    {
        if(!array_key_exists($param, $array))
        {
            return null;
        }
        return $array[$param];
    }
} 