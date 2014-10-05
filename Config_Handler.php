<?php


class Config_Handler {
    static protected $rInstance = null;
    protected $section='main';

    protected $rgIni;

    public static function getInstance()
    {
        if(!self::$rInstance)
        {
            self::$rInstance    = new Config_Handler();
        }
        return self::$rInstance;
    }

    function  __construct($path=null)
    {
        if(!$path)
        {
            $path=realpath(dirname(__FILE__)).'/../../Config/application.ini';
        }

        $this->rgIni=parse_ini_file($path, $this->section);
    }
    public function getDb()
    {
        return $this->rgIni[$this->section]['dbtype'];
    }
    public function getCredentials()
    {
        return array(
            'host'      => $this->rgIni[$this->section]['dbhost'],
            'port'      => $this->rgIni[$this->section]['dbport'],
            'user'      => $this->rgIni[$this->section]['dbuser'],
            'password'  => $this->rgIni[$this->section]['dbpassword'],
            'database'  => $this->rgIni[$this->section]['dbname']
        );
    }

    public function getWebpath()
    {
        $webRoot    = preg_replace('#^http\:\/\/#i', '', $this->rgIni[$this->section]['web_root']);
        $webRoot    = preg_replace('#^'.$_SERVER['HTTP_HOST'].'#i', '', $webRoot);
        $webRoot    = ltrim($webRoot, '/');
        return $webRoot;
    }

    public function getWebRoot()
    {
        return $this->rgIni[$this->section]['web_root'];
    }
} 