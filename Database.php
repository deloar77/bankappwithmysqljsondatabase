<?php

$config=require "config.php";
$config=$config['database'];



class Database{
    public $mysqli;

    public function __construct($config)
    {
        $this->mysqli= new mysqli($config['host'],$config['username'],$config['password'],$config['dbname']);
    }

    public function checkconnection(){
        if($this->mysqli->connect_errno){
            printf("connection failed: %s\n",$this->mysqli->connect_errno);
            exit();
        } else {
          echo "server connection is going okay\n";
        }

        if($this->mysqli->ping()){
            printf("db connection is okay");
        } else {
            printf("DB connection error: %s\n",$this->mysqli->error);
        }
    }

}

$mysqli= new Database($config);
$mysqli->checkconnection();