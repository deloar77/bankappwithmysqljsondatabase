<?php

use App\DatabaseFactory;
use App\models\MySQLDatabase;

 require __DIR__.'/../../../vendor/autoload.php';
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
}
  $customer=[
    'name'=>$name,
    'email'=>$email,
    'password'=>$password
 ];

 $db = DatabaseFactory::Get();
 $db->registerCustomer($customer);

  header("Location: /customer/login_page");
