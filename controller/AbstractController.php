<?php 

use Twig\Environment;

require_once './repository/ProductRepository.php';
require_once './repository/CategoryRepository.php';
require_once './vendor/autoload.php';
require_once './service/CustomErrors.php';

abstract class AbstractController
{
    private $page;
    private $loader;
    private $twig;
    private array $params;

    public function displayTwig($page, $params = []) 
    {
        $this->constructTwig();
        
        $catRepo = new CategoryRepository();
        $categories = $catRepo->fetchAll();
        $categories = ['categories' => $categories];

        if(isset($_GET['code'])) {
                $code = new CustomErrors();
                $code->setCode($_GET['code']);
                
                if(isset($_GET['customCode'])) {
                    $code->setCustomCode($_GET['customCode']);
                }
                
                $message = $code->createMessage();
                
                $paramMessage = ['message' => $message];
                $tabs = array_merge($params, $categories, $paramMessage);
        } else {
            $tabs = array_merge($params, $categories);
        }
        
        if (!isset($_SESSION['user'])) {
            echo $this->twig->render($page . '.twig', $tabs);
        } else {
            $session = ['session' => unserialize($_SESSION['user'])];
            $tabsSession = array_merge($tabs, $session);
            echo $this->twig->render($page . '.twig', $tabsSession);
        }
    }
    
    public function constructTwig() 
    {
        try {
            $this->loader = new Twig\Loader\FilesystemLoader('template');
            $this->twig = new Environment($this->loader, [
                    'cache' => false,
                    ]);
                    
        } catch (Exception $e) {
            die('Erreur');
        }
    }
}


    
