<?php

require_once './controller/AbstractController.php';
require_once './repository/UserRepository.php';
require_once './model/User.php';
//require_once './service/Validator.php';


class SecurityController extends AbstractController {

    private $repository;
    

    public function __construct()
    {
        $this->repository = new UserRepository();
    }
    
    
    /** 
     * Route ("index.php?url=register")
     */
    public function displayRegister() 
    {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('register', [
                'csrf' => $_SESSION['csrf']]);
            
        } else {
            header('location: ./index.php?url=account');
            exit();
        }
    }
    
    
    /** 
     * Route ("index.php?url=login")
     */
    public function displayLogin() 
    {
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('login', [
                'csrf' => $_SESSION['csrf']]);
            
        } else {
            header('location: ./index.php?url=account');
            exit();
        }
    }
    
    
    /** 
     * Route ("index.php?url=securityRegister")
     */
    public function securityRegister(): void
    {
        /*
        if(strlen($_POST['password']) < 6){
            header('location: ./index.php?url=register');
            exit();
        } else {
        */
        
        if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
            header('location: ./index.php?url=register');
            exit();
        }
        
        //$validator = new Validator();
        
        $passwordObscure = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
        
        $user = new User();
        
        $user->setLastName(htmlspecialchars($_POST['lastName']));
        $user->setFirstName(htmlspecialchars($_POST['firstName']));
        $user->setPhone(htmlspecialchars($_POST['phone']));
        $user->setEmail(htmlspecialchars($_POST['email']));
        $user->setPassword(htmlspecialchars($passwordObscure));
        $user->setRole('user');
        
        // Retourne la data ou retourne false si le filtre échoue (gérer l'erreur si false => class Validator)
        
        /*$test = $validator->validateEmail($_POST['email']);
        var_dump($test); die();*/
        
        $data = $this->repository->insert($user);
        
        if($data) {
            $currentData = $this->repository->fetchLogin($user->getEmail());
            
            // Je fais ça juste pour éviter que le password soit dans la session !
            // SELECT SCOPE_IDENTITY() en SQL possible suite au INSERT mais peut potentiellement
            // causer des pb si plusieurs user s'inscrivent en même temps
            // ou ajouter une requête SQL au insert (même SELECT que pour fetch LOGIN)
            if ($currentData) {
                $currentUser = new User();
                $currentUser->setId($currentData->getId());
                $currentUser->setLastName($currentData->getLastName());
                $currentUser->setFirstName($currentData->getFirstName());
                $currentUser->setPhone($currentData->getPhone());
                $currentUser->setEmail($currentData->getEmail());
                $currentUser->setRole($currentData->getRole());
        
                $_SESSION['user'] = serialize($currentUser);
                
                header('location: ./index.php?url=account');
                exit();
            }
        } else {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
            $errorMessage = "Une erreur est survenue.";
            $this->displayTwig('register', [
                'message' => $errorMessage,
                'csrf' => $_SESSION['csrf']]);
        }
    }
    
    
    /** 
     * Route ("index.php?url=securityLogin")
     */
    public function securityLogin(): void
    {
        if(!isset($_POST['email'], $_POST['password'])){
            header('location: ./index.php?url=login');
            exit();
        }
 
        if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
            header('location: ./index.php?url=login');
            exit();
        }
        
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $user = $this->repository->fetchLogin($email);

        if($user){
            if(password_verify ($password, $user->getPassword())) {
            
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'phone' => $user->getPhone(),
                'email' => $user->getEmail(),
                'role' => $user->getRole()
                ];
            
            $_SESSION['user'] = serialize($user);
            
            header('location: ./index.php?url=account');
            exit();
            
            } else {
                $this->displayTwig('login', [
                    'message' => 'Adresse mail ou mot de passe incorrect']);
            }
        } else {
            $this->displayTwig('login', [
                'message' => 'Adresse mail ou mot de passe incorrect']);
        }
    }
    
    
    /** 
     * Route ("index.php?url=logout")
     */
    public function logout(): void
    {
        session_destroy();
        header('location: ./index.php');
        exit();
    }
    
    
    public function debug() {
        echo ("Infos de la session : ");
        var_dump ($_SESSION);
        
        echo("Infos Session[user]");
        var_dump ($_SESSION['user']);

        // Fonctionnerait écrit comme ça : var_dump(unserialize($_SESSION['user']);
        echo("Infos Session[user] unserialize");
        unserialize($_SESSION['user']);
        var_dump ($_SESSION['user']);

        echo("Infos user après unserialize");
        $currentUser = unserialize($_SESSION['user']);
        var_dump($currentUser);
        
        var_dump($user->getId());
    } 
}