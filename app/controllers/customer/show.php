<?php

use App\DatabaseFactory;

require __DIR__.'/../../../vendor/autoload.php';

$db = DatabaseFactory::Get();
$customer= $db->getCustomerById(2);
var_dump($customer);

