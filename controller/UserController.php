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
     * @Route ("index.php?url=account")
     */
    public function displayAccount() 
    {
        if ($_SESSION['user']) {
            $productRepository = new ProductRepository();
            $user = unserialize($_SESSION['user']);
            $products = $productRepository->fetchByUser($user);
            
            $this->displayTwig('account', [
                'products' => $products]);
        } else {
            header('location: ./index.php?url=login');
            exit();
        }
    }
    
    
    /** 
     * @Route ("index.php?url=updateMyAccount")
     */
    public function displayUpdateMyAccount(): void
    {
        if ($_SESSION['user']) {
        $this->displayTwig('updateAccountForm', [
            'session' => unserialize($_SESSION['user'])]);
        } else {
                header('location: ./index.php?url=login');
                exit();
        }
    }
    
    /*/
    /** 
     * @Route ("index.php?url=updateProfil")
     */
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
            $user->setPhone(htmlspecialchars($_POST['phone']));
            $user->setEmail(htmlspecialchars($_POST['email']));
            $user->setRole($currentUser->getRole());
            
            $this->repository->updateProfil($user);
            
            // J'instancie les informations modifiées de mon user dans la SESSION
            $_SESSION['user'] = [
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'phone' => $user->getPhone(),
                'email' => $user->getEmail(),
                'role' => $user->getRole(),
                ];
            
            $_SESSION['user'] = serialize($user);
            
            header('location: ./index.php?url=account');
            exit();
        }
    }
    
    
    /** 
     * @Route ("index.php?url=updatePassword")
     */
    public function updatePassword(): void
    {
        $passwordOld = htmlspecialchars($_POST['passwordOld']);
        
        $user = unserialize($_SESSION['user']);

        $data = $this->repository->fetchById($user->getId());

        if($data){
            if(password_verify ($passwordOld, $data->getPassword()) && $_POST['passwordNew']) {
            
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
    
    
    /** 
     * @Route ("index.php?url=deleteMyAccount")
     */
    public function deleteMyAccount(): void 
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