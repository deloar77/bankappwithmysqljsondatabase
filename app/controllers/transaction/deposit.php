<?php
namespace App\Controllers\Transaction;

use App\DatabaseFactory;

 require __DIR__.'/../../../vendor/autoload.php';
 if(isset($_POST['amount']) && isset($_POST['customer_id'])){
    $amount=$_POST['amount'];
    $customer_id=$_POST['customer_id'];
 }

 $db= DatabaseFactory::Get();
 $res= $db->deposit($customer_id,$amount);
 header("Location: /customer/deposit_page");