<?php

include('settings.php');

class DBConn{

    private $settings;
    private $pdo;

    function __construct()
    {
        $this->settings=new Settings();
        $this->connect_db();
    }
    function getInstance(){
        return $this->pdo;
    }
    function connect_db(){
        $this->pdo = new PDO(sprintf(
            'mysql:host=%s;dbname=%s;port=%s;charset=%s',
            $this->settings->settings['host'],
            $this->settings->settings['name'],
            $this->settings->settings['port'],
            $this->settings->settings['charset']
        ),
            $this->settings->settings['username'],
            $this->settings->settings['password']
        );
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
}


