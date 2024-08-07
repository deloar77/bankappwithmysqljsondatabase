<?php
use App\DatabaseFactory;
session_start();
require __DIR__.'/../../../vendor/autoload.php';
if (!isset($_SESSION['email'])) {
    header("Location: /customer/login_page");
    exit;
}

if($_SESSION['id']){
    $db = DatabaseFactory::Get();
    $user=$db->getCustomerById($_SESSION['id']);

}

require __DIR__ . "/../../views/customer/withdraw_page.php";