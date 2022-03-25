<?php

session_start();

require_once './controller/HomeController.php';
require_once './controller/SecurityController.php';
require_once './controller/UserController.php';
require_once './controller/ProductController.php';
require_once './controller/CategoryController.php';
require_once './controller/AdminController.php';

$url = $_GET['url'] ?? "home";

switch($url){
    
    
    /** 
     * HOME
     */
    case "home" : 
        $homeController = new HomeController();
        $homeController->displayHome();
        break;
    
    /** 
     * SECURITY
     */   
    case "login" : 
        $securityController = new SecurityController();
        $securityController->displayLogin();
        break;
        
    case "register" : 
        $securityController = new SecurityController();
        $securityController->displayRegister();
        break;
    
    
    /** 
     * USER
     */
    case "account" : 
        $userController = new UserController();
        $userController->displayAccount();
        break;
    
    case "updateMyAccount" : 
        $userController = new UserController();
        $userController->displayUpdateMyAccount();
        break;
        
    case "updateAccountAdmin" :
        $adminController = new AdminController();
        $adminController->displayUpdateAccount();
        break;
        
    /** 
     * CATEGORY
     */
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
    
    /** 
     * PRODUCT
     */    
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
    
    /** 
     * ADMIN
     */    
    case "admin" : 
        $adminController = new AdminController();
        $adminController->displayAdmin();
        break;
        
    case "adminCategories" : 
        $adminController = new AdminController();
        $adminController->displayAdminCategories();
        break;
        
    case "adminProducts" : 
        $adminController = new AdminController();
        $adminController->displayAdminProducts();
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
        
    case "deleteMyAccount" : 
        $userController = new UserController();
        $userController->deleteMyAccount();
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
        
    /**
     * ADMIN
     */
    case "updateAccount" : 
        $adminController = new AdminController();
        $adminController->updateAccount();
        break;
    
    case "deleteAccount" : 
        $adminController = new AdminController();
        $adminController->deleteAccount();
        break;
        
    // -------------------------- DEBUG / TEST ---------------------------------
    
    case "debug":
        $securityController = new SecurityController();
        $securityController->debug();
        break;
        
    case "test":
        $homeController = new HomeController();
        $homeController->test();
        break;
        
    case "test2":
        $homeController = new HomeController();
        $homeController->test2();
        break;
    
    
    // ------------------------- PAGE ERROR 404 --------------------------------
    
    default:
        $homeController = new HomeController();
        $homeController->displayError404();
       break;
}

