<?php

use App\DatabaseFactory;

require __DIR__.'/../../../vendor/autoload.php';

$db= DatabaseFactory::Get();
if(isset($_POST['customer_id'])){
    $customer_id=$_POST['customer_id'];
   
}

$db->approveCustomer($customer_id);
header("Location:/admin/dashboard_page");
