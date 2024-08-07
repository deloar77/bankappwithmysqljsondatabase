<?php

 require __DIR__.'/../../../vendor/autoload.php';
 use App\DatabaseFactory;

  $db =  DatabaseFactory::Get();
  $customers= $db->getAllCustomers();
  var_dump($customers);

  
