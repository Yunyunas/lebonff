<?php 

use Twig\Environment;

require_once './vendor/autoload.php';

abstract class AbstractController
{
    private $page;
    private $loader;
    private $twig;

    public function __construct()
    {
        // Voir si devra être complété
    }
    
    
    public function displayTwig($page) 
    {
        $this->constructTwig();
        echo $this->twig->render($page . '.twig');
    }
    
    public function constructTwig() {
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


    
