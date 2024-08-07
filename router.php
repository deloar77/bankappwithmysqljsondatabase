<?php

$uri=parse_url($_SERVER['REQUEST_URI'])['path'];
$routes= require "routes.php";


function route_to_controller($uri,$routes){
 if(array_key_exists($uri,$routes)){
    require $routes[$uri];
 } 
 
 else{
    require $routes['/NotFound'];
 }

}

route_to_controller($uri,$routes);