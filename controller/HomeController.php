<?php

require_once './repository/ProductRepository.php';
require_once './controller/AbstractController.php';

class HomeController extends AbstractController {


    /** 
     * Route ("index.php?url=home")
     * Afficher la page "home"
     */
    public function displayHome(): void
    {
        $productRepository = new ProductRepository();
        $products = $productRepository->fetchNewProducts();
        
        $this->displayTwig('home', [
                'products' => $products]);
    }
    
    
    /** 
     * Route ("index.php?url=error404")
     * Afficher la page "error404"
     */
    public function displayError404(): void
    {
        $message = "La page que vous avez demand√© est introuvable";

        $this->displayTwig('error', [
                'message' => $message]);
    }
    
    
    /** 
     * Route ("index.php?url=error")
     * Afficher la page error avec un message personnalis√©
     */
    public function displayError(): void
    {
        $this->displayTwig('error');
    }
    
    
    /** 
     * Route ("index.php?url=search")
     * Barre de recherche
     */
    public function search()
    {
        $query = $_GET['q'];
        
        $productRepository = new ProductRepository();
        $datas = $productRepository->fetchQuery($query);
        
        echo json_encode($datas);

    }
    
}