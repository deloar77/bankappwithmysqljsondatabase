<?php

use App\DatabaseFactory;

session_start();
require __DIR__.'/../../../vendor/autoload.php';
if (!isset($_SESSION['email'])) {
    header("Location: /admin/login_page");
    exit;
}

$db= DatabaseFactory::Get();
$transactions=$db->getAllTransactions();
require __DIR__.'/../../views/admin/transactions.php';