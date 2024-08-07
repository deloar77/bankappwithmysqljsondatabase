<?php
namespace App\Controllers\Transaction;

use App\DatabaseFactory;

require __DIR__.'/../../../vendor/autoload.php';

if(isset($_POST['fromId']) && isset($_POST['toEmail']) && isset($_POST['amount'])){
    $fromId=$_POST['fromId'];
    $toEmail=$_POST['toEmail'];
    $amount=$_POST['amount'];
    
 }




$db = DatabaseFactory::Get();
$db->addTransaction($fromId,$toEmail,$amount);
header("Location:/customer/transfer_page");