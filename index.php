<?php

session_start();

require_once './controller/HomeController.php';
require_once './controller/SecurityController.php';
require_once './controller/UserController.php';
require_once './controller/ProductController.php';
require_once './controller/CategoryController.php';

$url = $_GET['url'] ?? "home";

$homeController = new HomeController();
$securityController = new SecurityController();
$userController = new UserController();
$productController = new ProductController();
$categoryController = new CategoryController();

switch($url){
    
    case "home" : 
        $homeController->displayHome();
        break;
       
    case "login" : 
        $securityController->displayLogin();
        break;
        
    case "register" : 
        $securityController->displayRegister();
        break;
        
    case "account" : 
        $userController->displayAccount();
        break;
        
        
    //----------------------- ROUTES FONCTIONNELLES ----------------------------
    case "securityRegister":
        $securityController->securityRegister();
        break;
    
    case "securityLogin":
        $securityController->securityLogin();
        break;
        
    case "logout":
        $securityController->logout();
        break;
        
    case "debug":
        $securityController->debug();
        break;
        
    default:
       $homeController->displayError404();
       break;
}

