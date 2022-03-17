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
    
    public function displayRegister() 
    {
         if (!isset($_SESSION['user'])) {
            $this->displayTwig('register');
            
        } else {
            header('location: ./index.php?url=account');
            exit();
        }
        
    }
    
    public function displayLogin() 
    {
         if (!isset($_SESSION['user'])) {
            $this->displayTwig('login');
            
        } else {
            header('location: ./index.php?url=account');
            exit();
        }

    }
    
    
    public function securityRegister(): void
    {
        
        $passwordObscure = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
        
        $user = new User();
        
        $user->setLastName(htmlspecialchars($_POST['lastName']));
        $user->setFirstName(htmlspecialchars($_POST['firstName']));
        $user->setEmail(htmlspecialchars($_POST['email']));
        $user->setPassword(htmlspecialchars($passwordObscure));
        $user->setAddress("adresse par defaut");
        $user->setPostalCode(56000);
        $user->setCity("ville");
        $user->setRole('user');
        
        $this->repository->insert($user);
        
        // J'instancie les informations de mon user actuel dans la SESSION
        $_SESSION['user'] = [
                'id' => $user->getId(),
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'email' => $user->getEmail(),
                'role' => $user->getRole()
                ];

        $_SESSION['user'] = serialize($user);
        
        header('location: ./index.php?url=account');
        exit();
    }
    
    public function securityLogin(): void
    {
        if(!isset($_POST['email'], $_POST['password'])){
            header('location: ./index.php?url=login');
            exit();
        }
        
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $data = $this->repository->fetchLogin($email);
        
        if($data){
            if(password_verify ($password, $data['password'])) {
            
            $user = new User();

            $user->setId($data['id']);
            $user->setLastName($data['last_name']);
            $user->setFirstName($data['first_name']);
            $user->setEmail($data['email']);
            //$user->setPassword($data['password']);
            $user->setRole($data['role']);
            
            // J'instancie les informations de mon user actuel dans la SESSION
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
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
    
    
    // ---------------------------------------------------------------------------------------
    
    
    
    /**
     * @Route("/login", name="security_login")
     */
    /*public function login(AuthenticationUtils $utils)
    {
        $form = $this->createForm(LoginType::class, ['email' => $utils->getLastUsername()]);

        return $this->render('security/login.html.twig', [
            'formView' => $form->createView(),
            'error' => $utils->getLastAuthenticationError()
        ]);
    }
    
    
    // -------------------------------------------------------------------------------------
    
        // Connexion
    case 'identifierUtilisateur':
        $user = identifierUtilisateur();

        if ($user) { // si $user n'est pas false

            setSession($user->getMail());
            afficherAnnoncesParUtilisateur();
        
            echo $twig->render('compteUtilisateur.html.twig', [
                'rubrique'=>afficherRubriques(),
                'annonce'=>afficherAnnoncesParUtilisateur(),
                'session'=> $_SESSION
                ]);

        } else {

            echo $twig->render('connexion.html.twig', [
                'message' => 'Adresse mail ou mot de passe incorrect',
                'rubrique'=>afficherRubriques(),
                'session'=> $_SESSION
                ]);
        }

    break;
    */
}