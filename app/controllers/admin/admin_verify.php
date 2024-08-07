<?php
session_start();
use App\DatabaseFactory;

require __DIR__.'/../../../vendor/autoload.php';
if(isset($_POST['email']) && isset($_POST['password'])){
   
    $email=$_POST['email'];
    $password=$_POST['password'];
}



$db = DatabaseFactory::Get();
$user = $db->authenticateadmin($email,$password);

if($user){
    $_SESSION['id']=$user['id'];
    $_SESSION['name']=$user['name'];
    $_SESSION['email']=$user['email'];
   $customers= $db->getAllCustomers();
   
 require __DIR__.'/../../views/admin/dashboard.php';
  

}
