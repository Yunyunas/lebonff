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
     * @Route ("index.php?url=admin")
     */
    public function displayAdmin() 
    {
        $users = $this->repository->fetchAll();

        if (!isset($_SESSION['user'])) {
            $this->displayTwig('login');
            
        } else {
            $this->displayTwig('adminUsers', [
            'session' => unserialize($_SESSION['user']),
            'users' => $users]);
        }
    }
    
    
    /** 
     * @Route ("index.php?url=adminCategories")
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
     * @Route ("index.php?url=adminProducts")
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
     * @Route ("index.php?url=updateAccountAdmin")
     */
    public function displayUpdateAccount(): void
    {
        $user = $this->repository->fetchById($_GET['id']);
        
        $this->displayTwig('updateAccountAdmin', [
            'user' => $user]);
    }
    
    
    /** 
     * @Route ("index.php?url=updateAccount")
     */
    public function updateAccount()
    {
        if($_POST['firstName'] || $_POST['lastName'] || $_POST['email']) {
            
            $user = new User();
            $user->setId($_GET['id']);
            $user->setLastName(htmlspecialchars($_POST['lastName']));
            $user->setFirstName(htmlspecialchars($_POST['firstName']));
            $user->setEmail(htmlspecialchars($_POST['email']));
            
            $this->repository->updateProfil($user);
            
            header('location: ./index.php?url=admin');
            exit();
        }
    }
    
    
    /** 
     * @Route ("index.php?url=deleteAccount")
     */
    public function deleteAccount()
    {
        $user = new User();
        $user->setId($_GET['id']);
        
        $data = $this->repository->deleteAccount($user);
            
        header('location: ./index.php?url=admin');
        exit();
    }
}