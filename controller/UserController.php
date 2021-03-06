<?php

require_once './repository/ProductRepository.php';
require_once './repository/UserRepository.php';
require_once './model/User.php';
require_once './controller/AbstractController.php';

class UserController extends AbstractController
{
    private $repository;
    
    public function __construct()
    {
        $this->repository = new UserRepository();
    }
    
    
    /** 
     * Route ("index.php?url=account")
     * Afficher la page "account"
     */
    public function displayAccount(): void 
    {
        if ($_SESSION['user']) {
            $productRepository = new ProductRepository();
            $user = unserialize($_SESSION['user']);
            $products = $productRepository->fetchByUser($user);
            
            $this->displayTwig('account', [
                'products' => $products]);
        } else {
            header('location: ./index.php?url=error&code=401');
            exit();
        }
    }
    
    
    /** 
     * Route ("index.php?url=account/update")
     * Afficher la page "updateAccountForm"
     */
    public function displayUpdateMyAccount(): void
    {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        if ($_SESSION['user']) {
            $this->displayTwig('updateAccountForm', [
                'session' => unserialize($_SESSION['user']),
                'csrf' => $_SESSION['csrf']]);
        } else {
            header('location: ./index.php?url=error&code=401');
            exit();
        }
    }
    
    
    /** 
     * Route ("index.php?url=updateProfil")
     * Modifier les informations personnelles
     */
    public function updateProfil(): void
    {
        if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
            header('location: ./index.php?url=account/update');
            exit();
        }
        
        $currentUser = unserialize($_SESSION['user']);
        
        $user = new User();
        $user->setId($currentUser->getId());
        $user->setLastName(htmlspecialchars($_POST['lastName']));
        $user->setFirstName(htmlspecialchars($_POST['firstName']));
        $user->setPhone(htmlspecialchars($_POST['phone']));
        $user->setEmail(htmlspecialchars($_POST['email']));
        $user->setRole($currentUser->getRole());
        
        $this->repository->updateProfil($user);
        
        $_SESSION['user'] = serialize($user);
        
        header('location: ./index.php?url=account');
        exit();
    }
    
    
    /** 
     * Route ("index.php?url=updatePassword")
     * Modifier le mot de passe
     */
    public function updatePassword(): void
    {
        
        if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
            header('location: ./index.php?url=account/update');
            exit();
        }
        
        $passwordOld = htmlspecialchars($_POST['passwordOld']);
        
        $user = unserialize($_SESSION['user']);

        $data = $this->repository->fetchById($user->getId());

        if($data){
            if(password_verify ($passwordOld, $data->getPassword()) && $_POST['passwordNew']) {
            
                $passwordObscure = password_hash($_POST['passwordNew'], PASSWORD_DEFAULT);
                
                $user->setPassword(htmlspecialchars($passwordObscure));

                $this->repository->updatePassword($user);
                
                header('location: ./index.php?url=account');
                exit();
                
            } else {
                header('location: ./index.php?url=account/update');
                exit();
            }
            
        } else {
            header('location: ./index.php?url=error&code=401');
            exit();
        }   
    }
    
    
    /** 
     * Route ("index.php?url=account/delete")
     * Supprimer son compte
     */
    public function deleteMyAccount(): void 
    {
        $user = unserialize($_SESSION['user']);
        
        $productRepository = new ProductRepository();
        $products = $productRepository->fetchByUser($user);
        
        $data = $this->repository->deleteAccount($user);

        if ($data) {
            if ($products) {
                for ($i = 0; $i < count($products); $i++) {
                    $img = $products[$i]->getUrlPicture();
                
                    if (file_exists('./public/img/products/'.$img)) {
                        unlink("./public/img/products/" . $img);
                    }
                }
            }
            
            session_destroy();
            $successMessage = "Votre compte a bien ??t?? supprim??.";
            
            $this->displayTwig('login', [
                'message' => $successMessage]);

        } else {
            header('location: ./index.php?url=account&code=deleteAccountError');
            exit();
        }
    }
    
}