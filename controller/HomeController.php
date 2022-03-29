<?php

require_once './repository/ProductRepository.php';
require_once './controller/AbstractController.php';

class HomeController extends AbstractController {


    /** 
     * @Route ("index.php?url=home")
     */
    public function displayHome()
    {
        $productRepository = new ProductRepository();
        $products = $productRepository->fetchNewProducts();
        
        $this->displayTwig('home', [
                'products' => $products]);
    }
    
    
    /** 
     * @Route ("index.php?url=error404")
     * @Route par défault
     */
    public function displayError404()
    {
        $this->displayTwig('error404');
    }
    
    /** 
     * @Route ("index.php?url=search")
     */
    public function search()
    {
        $query = $_GET['q'] ?? "";
        
        $productRepository = new ProductRepository();
        $datas = $productRepository->fetchQuery($query);
        echo json_encode($datas);
    }
    
}