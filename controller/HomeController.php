<?php

require_once './controller/AbstractController.php';

class HomeController extends AbstractController {

    
    public function __construct() {
        
    }
    
    public function displayHome()
    {
        $this->displayTwig('home');
    }
    
    public function displayError404()
    {
        $this->displayTwig('error404');
    }
}