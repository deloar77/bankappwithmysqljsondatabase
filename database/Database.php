<?php





class Database{
    public $mysqli;
    public $mysqlcon;

    public function __construct()
    {
        $config= require __DIR__.'/../config/config.php';
        $this->mysqli= new mysqli($config['host'],$config['username'],$config['password']);
         if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }

        $this->checkAndCreateDatabase($config['dbname']);
        $this->mysqli->select_db($config['dbname']);
    }

      public function getConnection()
    {
         $config= require __DIR__.'/../config/config.php';
        $this->mysqlcon= new mysqli($config['host'],$config['username'],$config['password'],$config['dbname']);
        return $this->mysqlcon;
    }

  
    private function checkAndCreateDatabase($dbName)
    {
        $result = $this->mysqli->query("SHOW DATABASES LIKE '$dbName'");
        if ($result->num_rows === 0) {
            // Database does not exist, create it
            if ($this->mysqli->query("CREATE DATABASE $dbName") === TRUE) {
                echo "Database $dbName created successfully.\n";
            } else {
                die("Error creating database: " . $this->mysqli->error . "\n");
            }
        } else {
            echo "Database $dbName already exists.\n";
        }
    }


 

}


var_dump(new Database());