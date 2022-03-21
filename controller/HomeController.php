<?php

require_once './repository/ProductRepository.php';
require_once './controller/AbstractController.php';

class HomeController extends AbstractController {


    public function displayHome()
    {
        $productRepository = new ProductRepository();
        $products = $productRepository->fetchNewProducts();
        
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('home', [
                'products' => $products]);
            
        } else {
            $this->displayTwig('home', [
                'session' => unserialize($_SESSION['user']),
                'products' => $products]);
        }

    }
    
    public function displayError404()
    {
        $this->displayTwig('error404');
    }
}