<?php

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
    }
    
    
    /** 
     * @Route ("index.php?url=admin/users")
     */
    public function displayAdmin() 
    {
        $users = $this->repository->fetchAll();
        
                
        $user = unserialize($_SESSION['user']);
        if ($user->getRole() !== 'admin') {
            $this->displayTwig('login');
        } else {
            $this->displayTwig('adminUsers', [
            'session' => unserialize($_SESSION['user']),
            'users' => $users]);
        }
    }
    
    
    /** 
     * @Route ("index.php?url=admin/categories")
     */
    public function displayAdminCategories() 
    {
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('login');
            
        } else {
            $this->displayTwig('adminCategories', [
            'session' => unserialize($_SESSION['user'])]);
        }
    }
    
    
    /** 
     * @Route ("index.php?url=admin/products")
     */
    public function displayAdminProducts() 
    {
        $productRepository = new ProductRepository();
        $products = $productRepository->fetchAll();

        if (!isset($_SESSION['user'])) {
            $this->displayTwig('login');
            
        } else {
            $this->displayTwig('adminProducts', [
            'session' => unserialize($_SESSION['user']),
            'products' => $products]);
        }
    }
    
    
    /** 
     * @Route ("index.php?url=admin/user/update")
     */
    public function displayUpdateUser(): void
    {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $user = $this->repository->fetchById($_GET['id']);
        
        $this->displayTwig('updateAccountAdmin', [
            'user' => $user,
            'csrf' => $_SESSION['csrf']]);
    }
    
    
    /** 
     * @Route ("index.php?url=updateAccount")
     */
    public function updateAccount()
    {
        
        if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
            header('location: ./index.php?url=admin/account/update');
            exit();
        }
        
        if($_POST['firstName'] || $_POST['lastName'] || $_POST['email']) {
            
            $user = new User();
            $user->setId($_GET['id']);
            $user->setLastName(htmlspecialchars($_POST['lastName']));
            $user->setFirstName(htmlspecialchars($_POST['firstName']));
            $user->setEmail(htmlspecialchars($_POST['email']));
            
            $this->repository->updateProfil($user);
            
            header('location: ./index.php?url=admin/users');
            exit();
        }
    }
    
    
    /** 
     * @Route ("index.php?url=admin/account/delete")
     */
    public function deleteAccount()
    {
        $user = new User();
        $user->setId($_GET['id']);
        
        $data = $this->repository->deleteAccount($user);
            
        header('location: ./index.php?url=admin/users');
        exit();
    }
}