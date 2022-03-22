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
    
    public function displayAccount() 
    {
        $productRepository = new ProductRepository();
        $user = unserialize($_SESSION['user']);
        $products = $productRepository->fetchByUser($user);

        
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('login');
            
        } else {
            $this->displayTwig('account', [
            'session' => unserialize($_SESSION['user']),
            'products' => $products]);
        }
    }
    
    // Affichage de la page modification profil
    public function displayUpdateAccount(): void
    {
        $this->displayTwig('updateAccountForm', [
            'session' => unserialize($_SESSION['user'])]);
    }
    
    public function updateProfil(): void
    {
        // Dans l'idée ou je ne veux modifier qu'un champs, soit je fais des
        // if pour chaque $_POST, soit je mets des "value" dans mon html
        // qui reprendrait les infos de la BDD
        // Donc un str_replace value {%lastname%} et avant ça une fonction repo
        if($_POST['firstName'] || $_POST['lastName'] || $_POST['email']) {
        
            $currentUser = unserialize($_SESSION['user']);
            
            $user = new User();
            $user->setId($currentUser->getId());
            $user->setLastName(htmlspecialchars($_POST['lastName']));
            $user->setFirstName(htmlspecialchars($_POST['firstName']));
            $user->setEmail(htmlspecialchars($_POST['email']));
            
            $this->repository->updateProfil($user);
            
            // J'instancie les informations modifiées de mon user dans la SESSION
            $_SESSION['user'] = [
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'email' => $user->getEmail(),
                ];
            
            $_SESSION['user'] = serialize($user);
            
            header('location: ./index.php?url=account');
            exit();
        }
    }
    
    
    public function updatePassword(): void
    {
        $passwordOld = htmlspecialchars($_POST['passwordOld']);
        
        $user = unserialize($_SESSION['user']);
        $email = $user->getEmail();

        $data = $this->repository->fetchLogin($email);

        if($data){
            if(password_verify ($passwordOld, $data['password']) && $_POST['passwordNew']) {
            
                $passwordObscure = password_hash($_POST['passwordNew'], PASSWORD_DEFAULT);
                
                $user->setPassword(htmlspecialchars($passwordObscure));

                $this->repository->updatePassword($user);
                
                $_SESSION['user'] = serialize($user);
                
                header('location: ./index.php?url=account');
                exit();
            }
        } else {
            header('location: ./index.php?url=error404');
            exit();
        }   
    }
    
    public function deleteAccount(): void 
    {
        // Fonction pour supprimer le compte et donc le user
        // Demande confirmation du mot de passe pour valider la suppression
        // Faire ça avec un pop ou un nouveau formulaire (?)
        // Ou pas de demande de mdp mais juste un pop de confirmation (?)
        $user = unserialize($_SESSION['user']);
        
        $data = $this->repository->deleteAccount($user);
        if ($data == true) {
            session_destroy();
            header('location: ./index.php?url=home');
            exit();
        } else {
            header('location: ./index.php?url=account');
            exit();
        }

        
    }
}