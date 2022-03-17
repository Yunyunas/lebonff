<?php

require_once './model/Product.php';
require_once './repository/ProductRepository.php';
require_once './controller/AbstractController.php';

class ProductController extends AbstractController
{
    
    private $repository;
    
    public function __construct()
    {
        $this->repository = new ProductRepository();
    }
    
    public function displayProducts()
    {
        $datas = $this->repository->fetchAll();
        
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('products');
            
        } else {
            $this->displayTwig('products', [
                'session' => unserialize($_SESSION['user']),
                'products' => $datas]);
        }
    }
}