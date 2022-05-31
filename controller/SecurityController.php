<?php

require_once './controller/AbstractController.php';
require_once './repository/UserRepository.php';
require_once './model/User.php';


class SecurityController extends AbstractController {

    private $repository;
    

    public function __construct()
    {
        $this->repository = new UserRepository();
    }
    
    
    /** 
     * Route ("index.php?url=register")
     * Afficher la page "register"
     */
    public function displayRegister(): void 
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
     * Afficher la page "login"
     */
    public function displayLogin(): void 
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
        
        if(strlen($_POST['password']) < 6){
            header('location: ./index.php?url=register&code=400&customCode=passwordError');
            exit();
        } 
        
        
        if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
            header('location: ./index.php?url=register');
            exit();
        }
        
        $passwordObscure = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
        
        $user = new User();
        
        $user->setLastName(htmlspecialchars($_POST['lastName']));
        $user->setFirstName(htmlspecialchars($_POST['firstName']));
        $user->setPhone(htmlspecialchars($_POST['phone']));
        $user->setEmail(htmlspecialchars($_POST['email']));
        $user->setPassword(htmlspecialchars($passwordObscure));
        $user->setRole('user');
        
        $data = $this->repository->insert($user);
        
        if($data) {
            $currentData = $this->repository->fetchLogin($user->getEmail());

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
        $email = $_POST['email'];
        
        if(!isset($email, $_POST['password'])){
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
                header('location: ./index.php?url=login&code=400&customCode=loginError');
                exit();
            }
        } else {
            header('location: ./index.php?url=login&code=400&customCode=loginError');
            exit();
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
    
}