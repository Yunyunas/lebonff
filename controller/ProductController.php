<?php

require_once './model/User.php';

require_once './model/Product.php';
require_once './repository/ProductRepository.php';

require_once './model/Category.php';
require_once './repository/CategoryRepository.php';
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
        $category = new Category();
        $category->setId($_GET['id']);
        
        $products = $this->repository->fetchByCategory($category);

        $catRepo = new CategoryRepository();
        $categories = $catRepo->fetchAll();
        
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('products', [
                'products' => $products,
                'categories' => $categories,
                'paramName' => $_GET['paramName']]);
            
        } else {
            $this->displayTwig('products', [
                'session' => unserialize($_SESSION['user']),
                'products' => $products,
                'categories' => $categories,
                'paramName' => $_GET['paramName']]);
        }
    }
    
    public function displayNewProducts()
    {
        $products = $this->repository->fetchNewProducts();

        $catRepo = new CategoryRepository();
        $categories = $catRepo->fetchAll();
        
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('products', [
                'products' => $products,
                'categories' => $categories,
                'paramName' => $_GET['paramName']]);
            
        } else {
            $this->displayTwig('products', [
                'session' => unserialize($_SESSION['user']),
                'products' => $products,
                'categories' => $categories,
                'paramName' => $_GET['paramName']]);
        }
    }
    
    public function displayProductDetail()
    {
        $catRepo = new CategoryRepository();
        $categories = $catRepo->fetchAll();
        
        $product = new Product();
        $product->setId($_GET['id']);
        $data = $this->repository->fetchProduct($product);
        $paramName = $data->getCategory()->getName();


        
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('productDetail', [
                'product' => $data,
                'categories' => $categories,
                'paramName' => $paramName]);
            
        } else {
            $this->displayTwig('productDetail', [
                'session' => unserialize($_SESSION['user']),
                'product' => $data,
                'categories' => $categories,
                'paramName' => $paramName]);
        }
    }
    
        
    public function displayAddProductForm()
    {
        $catRepo = new CategoryRepository();
        $categories = $catRepo->fetchAll();
        
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('login');
            
        } else {
            $this->displayTwig('addProductForm', [
                'session' => unserialize($_SESSION['user']),
                'categories' => $categories]);
        }
    }
    
    public function displayUpdateProductForm()
    {
        $catRepo = new CategoryRepository();
        $categories = $catRepo->fetchAll();
        
        $product = new Product();
        $product->setId($_GET['id']);
        
        $data = $this->repository->fetchProduct($product);
        
        if (!isset($_SESSION['user'])) {
            $this->displayTwig('login');
            
        } else {
            $this->displayTwig('updateProductForm', [
                'session' => unserialize($_SESSION['user']),
                'categories' => $categories,
                'product' => $data]);
        }
    }
    
    
    public function insertProduct()
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
            move_uploaded_file($tmpName, './public/img/products/'.$name);
        }
        else{
            $message = "La taille du fichier ou l'extension est incorrect.";
        }
        
        $currentUser = unserialize($_SESSION['user']);
        $user = new User();
        $user->setId($currentUser->getId());
        //var_dump($user->getId());
        //die();
        $category = new Category();
        $category->setId($_POST['category']);
        
        $product = new Product();
        
        $product->setCategory($category);
        $product->setUser($user);
        $product->setName(htmlspecialchars($_POST['name']));
        $product->setDescription(htmlspecialchars($_POST['description']));
        $product->setPrice(htmlspecialchars($_POST['price']));
        $product->setUrlPicture($name);
        
        $this->repository->insert($product);

        header('location: ./index.php?url=account');
        exit();
    }
    
    
    public function updateProduct()
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
            move_uploaded_file($tmpName, './public/img/products/'.$name);
        }
        else{
            $message = "La taille du fichier ou l'extension est incorrect.";
        }
        
        $currentUser = unserialize($_SESSION['user']);
        $user = new User();
        $user->setId($currentUser->getId());
        //var_dump($user->getId());
        //die();
        $category = new Category();
        $category->setId($_POST['category']);
        
        $product = new Product();
        
        $product->setId($_GET['id']);
        $product->setCategory($category);
        $product->setUser($user);
        $product->setName(htmlspecialchars($_POST['name']));
        $product->setDescription(htmlspecialchars($_POST['description']));
        $product->setPrice(htmlspecialchars($_POST['price']));
        $product->setUrlPicture($name);
        
        $data = $this->repository->update($product);
        if ($data == true) {
            header('location: ./index.php?url=account');
            exit();
        }

    }
    
    
    public function deleteProduct()
    {
        $product = new Product();
        $product->setId($_GET['id']);
        
        $data = $this->repository->delete($product);
        
        header('location: ./index.php?url=account');
        exit();
    }
}