<?php

require_once __DIR__.'/../Database.php';

class CreateCustomersTable{

    public static function up(){

        $db=(new Database())->getConnection();

        $sql="CREATE TABLE IF NOT EXISTS customers(
          id INT AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(255) NOT NULL,
          email VARCHAR(255) UNIQUE NOT NULL,
          is_Admin BOOLEAN DEFAULT FALSE,
          password VARCHAR(255) NOT NULL,
          balance INT DEFAULT 0,
          is_approved BOOLEAN DEFAULT FALSE
          

        )";
        if($db->query($sql)=== TRUE){
            echo "customers table created successfully";
        } else {
            echo "table creation failed:".$db->error."\n";
        }
        $db->close();
    }
}
CreateCustomersTable::up();
?>