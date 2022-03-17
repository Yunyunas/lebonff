<?php

require_once './controller/AbstractController.php';

class HomeController extends AbstractController {


    public function displayHome()
    {
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('home');
            
        } else {
            $this->displayTwig('home', [
                'session' => unserialize($_SESSION['user'])]);
        }

    }
    
    public function displayError404()
    {
        $this->displayTwig('error404');
    }
}