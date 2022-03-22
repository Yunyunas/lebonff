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
    
    case "updateAccount" : 
        $userController = new UserController();
        $userController->displayUpdateAccount();
        break;
        
    case "categories" : 
        $categoryController = new CategoryController();
        $categoryController->displayCategories();
        break;
        
    case "addCategory" : 
        $categoryController = new CategoryController();
        $categoryController->displayAddCategoryForm();
        break;
    
    case "updateCategoryForm" : 
        $categoryController = new CategoryController();
        $categoryController->displayUpdateCategoryForm();
        break;
        
    case "products" : 
        $productController = new ProductController();
        $productController->displayProducts();
        break;
        
    case "product" : 
        $productController = new ProductController();
        $productController->displayProductDetail();
        break;
    
    case "newProducts":
        $productController = new ProductController();
        $productController->displayNewProducts();
        break;
        
    case "addProduct" : 
        $productController = new ProductController();
        $productController->displayAddProductForm();
        break;
        
    case "updateProductForm" :
        $productController = new ProductController();
        $productController->displayUpdateProductForm();
        break;
        
        
    //----------------------- ROUTES FONCTIONNELLES ----------------------------
    
    /** 
     * SECURITY
     */
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
    
    /** 
     * USER
     */
    case "updateProfil" : 
        $userController = new UserController();
        $userController->updateProfil();
        break;
    
    case "updatePassword" : 
        $userController = new UserController();
        $userController->updatePassword();
        break;
        
    case "deleteAccount" : 
        $userController = new UserController();
        $userController->deleteAccount();
        break;
        
    /** 
     * CATEGORY
     */
    case "insertCategory":
        $categoryController = new CategoryController();
        $categoryController->insertCategory();
        break;
    
    case "updateCategory":
        $categoryController = new CategoryController();
        $categoryController->updateCategory();
        break;
    
    case "deleteCategory":
        $categoryController = new CategoryController();
        $categoryController->deleteCategory();
        break;
    
    /** 
     * PRODUCT
     */
    case "insertProduct" : 
        $productController = new ProductController();
        $productController->insertProduct();
        break;
    
    case "updateProduct" : 
        $productController = new ProductController();
        $productController->updateProduct();
        break;
        
    case "deleteProduct" : 
        $productController = new ProductController();
        $productController->deleteProduct();
        break;
        
    // -------------------------- DEBUG / TEST ---------------------------------
    
    case "debug":
        $securityController = new SecurityController();
        $securityController->debug();
        break;
        
    default:
        $homeController = new HomeController();
        $homeController->displayError404();
       break;
}

