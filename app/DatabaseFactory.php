<?php

namespace App;

use App\models\JSONDatabase;
use App\models\MySQLDatabase;
use Exception;

require_once __DIR__.'/../vendor/autoload.php';

class DatabaseFactory{
    public static function Get(){
        $config= require __DIR__.'/../config/config.php';
        switch($config['db_type']){
            case 'mysql':
                $db= new MySQLDatabase();
                break;
             case 'json':
                $db= new JSONDatabase();
                break;
             default:
                throw new Exception("Unsupported database type: " . $config['db_type']);      
        }

            $db->connect();
           return $db;
    }

}

?>