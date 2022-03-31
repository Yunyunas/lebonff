<?php 

use Twig\Environment;

require_once './repository/CategoryRepository.php';
require_once './vendor/autoload.php';

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

        $tabs = array_merge($params, $categories);
        
        if (!isset($_SESSION['user'])) {
            echo $this->twig->render($page . '.twig', $tabs);
        } else {
            $session = ['session' => unserialize($_SESSION['user'])];
            $tabs = array_merge($params, $categories, $session);
            echo $this->twig->render($page . '.twig', $tabs);
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


    
