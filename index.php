<?php

session_start();

require_once './controller/HomeController.php';
require_once './controller/SecurityController.php';
require_once './controller/UserController.php';
require_once './controller/ProductController.php';
require_once './controller/CategoryController.php';
require_once './controller/AdminController.php';

$url = $_GET['url'] ?? "home";

switch($url) {
    
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
    
    case "account/update" : 
        $userController = new UserController();
        $userController->displayUpdateMyAccount();
        break;
        
    /** 
     * CATEGORY
     */
    case "categories" : 
        $categoryController = new CategoryController();
        $categoryController->displayCategories();
        break;
        
    case "admin/category/create" : 
        $categoryController = new CategoryController();
        $categoryController->displayAddCategoryForm();
        break;
    
    case "admin/category/update" : 
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
    
    case "products/new":
        $productController = new ProductController();
        $productController->displayNewProducts();
        break;
        
    case "product/create" : 
        $productController = new ProductController();
        $productController->displayAddProductForm();
        break;
        
    case "product/update" :
        $productController = new ProductController();
        $productController->displayUpdateProductForm();
        break;
    
    /** 
     * ADMIN
     */    
    case "admin/users" : 
        $adminController = new AdminController();
        $adminController->displayAdmin();
        break;
            
    case "admin/user/update" :
        $adminController = new AdminController();
        $adminController->displayUpdateUser();
        break;
        
    case "admin/categories" : 
        $adminController = new AdminController();
        $adminController->displayAdminCategories();
        break;
        
    case "admin/products" : 
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
        
    case "account/delete" : 
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
    
    case "admin/category/delete":
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
    
    case "admin/account/delete" : 
        $adminController = new AdminController();
        $adminController->deleteAccount();
        break;
        
    // -------------------------- DEBUG / TEST ---------------------------------
    
    case "debug":
        $securityController = new SecurityController();
        $securityController->debug();
        break;
        
    case "search":
        $homeController = new HomeController();
        $homeController->search();
        break;
    
    
    // ------------------------- PAGE ERROR 404 --------------------------------
    
    default:
        $homeController = new HomeController();
        $homeController->displayError404();
       break;
       
}

