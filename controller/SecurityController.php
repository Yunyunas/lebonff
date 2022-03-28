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
     * @Route ("index.php?url=register")
     */
    public function displayRegister() 
    {
         if (!isset($_SESSION['user'])) {
            $this->displayTwig('register');
            
        } else {
            header('location: ./index.php?url=account');
            exit();
        }
    }
    
    
    /** 
     * @Route ("index.php?url=login")
     */
    public function displayLogin() 
    {
         if (!isset($_SESSION['user'])) {
            $this->displayTwig('login');
            
        } else {
            header('location: ./index.php?url=account');
            exit();
        }
    }
    
    
    /** 
     * @Route ("index.php?url=securityRegister")
     */
    public function securityRegister(): void
    {
        
        $passwordObscure = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
        
        $user = new User();
        
        $user->setLastName(htmlspecialchars($_POST['lastName']));
        $user->setFirstName(htmlspecialchars($_POST['firstName']));
        $user->setPhone(htmlspecialchars($_POST['phone']));
        $user->setEmail(htmlspecialchars($_POST['email']));
        $user->setPassword(htmlspecialchars($passwordObscure));
        $user->setRole('user');
        
        $this->repository->insert($user);
        
        // A MODIFIER ABSOLUMENT CAR ACTUELLEMENT REGISTER AVEC UN EMAIL DEJA EN BDD = LOGIN SANS MDP
        $user = $this->repository->fetchLogin($user->getEmail());

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
    }
    
    
    /** 
     * @Route ("index.php?url=securityLogin")
     */
    public function securityLogin(): void
    {
        if(!isset($_POST['email'], $_POST['password'])){
            header('location: ./index.php?url=login');
            exit();
        }
        
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $user = $this->repository->fetchLogin($email);
        
        if($user){
            if(password_verify ($password, $user->getPassword())) {
            
           // J'instancie les informations de mon user actuel dans la SESSION
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'phone' => $user->getPhone(),
                'email' => $user->getEmail(),
                'role' => $user->getRole()
                ];
            
            //var_dump($_SESSION['user']);
            $_SESSION['user'] = serialize($user);
            
            header('location: ./index.php?url=account');
            exit();
            // voir pour un $this->twig->redirectToRoute
            // voir si télécharger le component a une +value
            
            } else {
                $this->displayTwig('login', [
                    'message' => 'Adresse mail ou mot de passe incorrect']);
            }
        } else {
            header('location: ./index.php?url=error404');
            exit();
        }
    }
    
    
    /** 
     * @Route ("index.php?url=logout")
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
        var_dump($user);
        
        var_dump($user->getId());
    } 
}