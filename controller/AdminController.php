<?php

require_once './service/AdminAuthenticator.php';
require_once './repository/ProductRepository.php';
require_once './repository/UserRepository.php';
require_once './model/User.php';
require_once './controller/AbstractController.php';

class AdminController extends AbstractController
{
    
    private $repository;
    
    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->role = new Admin();
    }
    
    
    /** 
     * Route ("index.php?url=admin/users")
     * Afficher la page "adminUsers"
     */
    public function displayAdmin(): void 
    {
        if ($this->role->isAdmin()) {
            $users = $this->repository->fetchAll();
            
            $this->displayTwig('admin/adminUsers', [
                'session' => unserialize($_SESSION['user']),
                'users' => $users]);
        } else {
            header('location: ./index.php?url=error&code=403');
            exit();
        }        
    }
    
    
    /** 
     * Route ("index.php?url=admin/categories")
     */
    public function displayAdminCategories(): void 
    {
        if ($this->role->isAdmin()) {
            $this->displayTwig('admin/adminCategories', [
                'session' => unserialize($_SESSION['user'])]);
        } else {
            header('location: ./index.php?url=error&code=403');
            exit();
        }        
    }
    
    
    /** 
     * Route ("index.php?url=admin/products")
     * Afficher la page "adminProducts"
     */
    public function displayAdminProducts(): void 
    {
        if ($this->role->isAdmin()) {
            $productRepository = new ProductRepository();
            $products = $productRepository->fetchAll();
            
            
            $this->displayTwig('admin/adminProducts', [
                'session' => unserialize($_SESSION['user']),
                'products' => $products]);
        } else {
            header('location: ./index.php?url=error&code=403');
            exit();
        }        
    }
    
    
    /** 
     * Route ("index.php?url=admin/user/update")
     * Afficher la page "updateAccountAdmin"
     */
    public function displayUpdateUser(): void
    {
        if ($this->role->isAdmin()) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
            $user = $this->repository->fetchById($_GET['id']);
            
            $this->displayTwig('admin/updateAccountAdmin', [
                'user' => $user,
                'csrf' => $_SESSION['csrf']]);
        } else {
            header('location: ./index.php?url=error&code=403');
            exit();
        }        
    }
    
    
    /** 
     * Route ("index.php?url=updateAccount")
     * Modifier le compte d'un user par l'admin
     */
    public function updateAccount(): void
    {
        if ($this->role->isAdmin()) {
            if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
            header('location: ./index.php?url=admin/account/update');
            exit();
            }
            
            if($_POST['firstName'] || $_POST['lastName'] || $_POST['email'] || $_POST['phone']) {
                
                $user = new User();
                $user->setId($_GET['id']);
                $user->setLastName(htmlspecialchars($_POST['lastName']));
                $user->setFirstName(htmlspecialchars($_POST['firstName']));
                $user->setPhone(htmlspecialchars($_POST['phone']));
                $user->setEmail(htmlspecialchars($_POST['email']));
                
                $this->repository->updateProfil($user);
                
                header('location: ./index.php?url=admin/users');
                exit();
            } 
            
        } else {
            header('location: ./index.php?url=error&code=403');
            exit();
        }
    }
    
    
    /** 
     * Route ("index.php?url=admin/account/delete")
     * Supprimer le compte d'un user par l'admin
     */
    public function deleteAccount(): void
    { 
        if ($this->role->isAdmin()) {
            $user = new User();
            $user->setId($_GET['id']);
            
            $data = $this->repository->deleteAccount($user);
                
            header('location: ./index.php?url=admin/users');
            exit();
            
        } else {
            header('location: ./index.php?url=error&code=403');
            exit();
        }        
    }
    
}