<?php
session_start();
require __DIR__.'/../../../vendor/autoload.php';
if (!isset($_SESSION['email'])) {
    header("Location: /customer/login_page");
    exit;
}


require __DIR__ . "/../../views/customer/dashboard_page.php";