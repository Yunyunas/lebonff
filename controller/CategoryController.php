<?php

require_once './model/Category.php';
require_once './repository/CategoryRepository.php';
require_once './controller/AbstractController.php';

class CategoryController extends AbstractController
{
    
    private $repository;
    
    public function __construct()
    {
        $this->repository = new CategoryRepository();
    }
    
    public function displayCategories()
    {
        $datas = $this->repository->fetchAll();
        
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('categories');
            
        } else {
            $this->displayTwig('categories', [
                'session' => unserialize($_SESSION['user']),
                'categories' => $datas]);
        }
    }
    
    public function displayAddCategoryForm()
    {
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('addCategoryForm');
            
        } else {
            $this->displayTwig('addCategoryForm', [
                'session' => unserialize($_SESSION['user'])]);
        }
    }
    
    public function insertCategory() 
    {
        $category = new Category();
        
        $category->setName(htmlspecialchars($_POST['name']));
        $category->setDescription(htmlspecialchars($_POST['description']));
        $category->setUrlPicture(htmlspecialchars($_POST['image']));
        
        $this->repository->insert($category);

        header('location: ./index.php?url=addCategory');
        exit();
    }
    
    
    // ------------------------- DEBUG / TEST ----------------------------------
    
    public function testCat() 
    {
        $datas = $this->repository->fetchAll();
        
        var_dump($datas);
        die();
        
    }
}