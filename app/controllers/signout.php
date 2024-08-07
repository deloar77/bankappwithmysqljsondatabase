<?php
session_start();
use App\DatabaseFactory;



        // Unset all session variables
        $_SESSION = [];

        // Destroy the session
        session_destroy();

        // Redirect to the login page or home page
       
   
 require __DIR__.'/../views/customer/login_page.php';
