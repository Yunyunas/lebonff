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
            $this->displayTwig('categories', [
                'categories' => $datas]);
            
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
    
    
        public function displayUpdateCategoryForm()
    {
        
        $data = $this->repository->fetchCategory($_GET['id']);
        
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('updateCategoryForm');
            
        } else {
            $this->displayTwig('updateCategoryForm', [
                'session' => unserialize($_SESSION['user']),
                'category' => $data]);
        }
    }
    
    
    public function insertCategory() 
    {
        if (isset($_FILES['image'])) {
            $tmpName = $_FILES['image']['tmp_name'];
            $name = $_FILES['image']['name'];
            $size = $_FILES['image']['size'];
            $error = $_FILES['image']['error'];
        }
        
        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));
        
        $extensions = ['jpg', 'png', 'jpeg'];
        $maxSize = 4000000;
        
        if(in_array($extension, $extensions) && $size <= $maxSize){
            move_uploaded_file($tmpName, './public/img/categories/'.$name);
        }
        else{
            echo "Mauvaise extension ou taille trop grande";
        }
        
        if (isset($_POST['name']) && $_POST['description']) {    
        $category = new Category();
        
        $category->setName(htmlspecialchars($_POST['name']));
        $category->setDescription(htmlspecialchars($_POST['description']));
        $category->setUrlPicture($name);
        
        $this->repository->insert($category);

        header('location: ./index.php?url=categories');
        exit();
        }
    }
    
    public function updateCategory()
    {
       
        if (isset($_FILES['image'])) {
            $tmpName = $_FILES['image']['tmp_name'];
            $name = $_FILES['image']['name'];
            $size = $_FILES['image']['size'];
            $error = $_FILES['image']['error'];
        }
        
        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));
        
        $extensions = ['jpg', 'png', 'jpeg'];
        $maxSize = 4000000;
        
        if(in_array($extension, $extensions) && $size <= $maxSize){
            move_uploaded_file($tmpName, './public/image/'.$name);
        }
        else{
            echo "Mauvaise extension ou taille trop grande";
        }
        
        if($_POST['name'] || $_POST['description']) {

        $category = new Category();
        
        $category->setId($_GET['id']);
        $category->setName(htmlspecialchars($_POST['name']));
        $category->setDescription(htmlspecialchars($_POST['description']));
        $category->setUrlPicture($name);

        $data = $this->repository->update($category);
        
        header('location: ./index.php?url=categories');
        exit();
        }
    }
    
    
    public function deleteCategory()
    {
        $category = new Category();
        $category->setId($_GET['id']);
        
        $data = $this->repository->delete($category);
        
        header('location: ./index.php?url=categories');
        exit();
    }
}