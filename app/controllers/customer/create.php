<?php
namespace App\Controllers\Customer;

use App\DatabaseFactory;

 require __DIR__.'/../../../vendor/autoload.php';

 $db = DatabaseFactory::Get();
 $customer=[
    'name'=>'alam',
    'email'=>'alam@gmail.com',
    'password'=>123
 ];
 $db->registerCustomer($customer);












 