<?php


class Settings{
    private $host;
    private $port;
    private $name;
    private $username;
    private $password;
    private $charset;
    public $settings;

    function __construct()
    {
        $this->host='127.0.0.1';
        $this->port='8889';
        $this->name='phil';
        $this->username='root';
        $this->password='';
        $this->charset='utf8';
        $this->settings=[
            'host' => $this->host,
            'port' => $this->port,
            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
            'charset' => $this->charset
        ];
        $this->getSettings();
    }
    function getSettings(){
        return $this->settings;
    }
}
