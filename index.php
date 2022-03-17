<?php

session_start();

require_once './controller/HomeController.php';
require_once './controller/SecurityController.php';
require_once './controller/UserController.php';
require_once './controller/ProductController.php';
require_once './controller/CategoryController.php';

$url = $_GET['url'] ?? "home";

switch($url){
    
    case "home" : 
        $homeController = new HomeController();
        $homeController->displayHome();
        break;
       
    case "login" : 
        $securityController = new SecurityController();
        $securityController->displayLogin();
        break;
        
    case "register" : 
        $securityController = new SecurityController();
        $securityController->displayRegister();
        break;
        
    case "account" : 
        $userController = new UserController();
        $userController->displayAccount();
        break;
        
    case "categories" : 
        $categoryController = new CategoryController();
        $categoryController->displayCategories();
        break;
        
    case "addCategory" : 
        $categoryController = new CategoryController();
        $categoryController->displayAddCategoryForm();
        break;
        
    case "products" : 
        $productController = new ProductController();
        $productController->displayProducts();
        break;
        
        
    //----------------------- ROUTES FONCTIONNELLES ----------------------------
    
    case "securityRegister":
        $securityController = new SecurityController();
        $securityController->securityRegister();
        break;
    
    case "securityLogin":
        $securityController = new SecurityController();
        $securityController->securityLogin();
        break;
        
    case "logout":
        $securityController = new SecurityController();
        $securityController->logout();
        break;
        
    case "insertCategory":
        $categoryController = new CategoryController();
        $categoryController->insertCategory();
        break;
        
        
    // -------------------------- DEBUG / TEST ---------------------------------
    
    case "debug":
        $securityController = new SecurityController();
        $securityController->debug();
        break;
        
    case "debugCat":
        $categoryController = new CategoryController();
        $categoryController->testCat();
        break;
        
    default:
        $homeController = new HomeController();
        $homeController->displayError404();
       break;
}

