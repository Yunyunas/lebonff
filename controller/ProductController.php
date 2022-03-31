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
    
    
    /** 
     * @Route ("index.php?url=products")
     */
    public function displayProducts()
    {
        $category = new Category();
        $category->setId($_GET['id']);
        
        $products = $this->repository->fetchByCategory($category);
        
        
        $this->displayTwig('products', [
                'products' => $products,
                'paramName' => $_GET['paramName']]);
    }
    
    
    /** 
     * @Route ("index.php?url=products/new")
     */
    public function displayNewProducts()
    {
        $products = $this->repository->fetchNewProducts();
      
        $this->displayTwig('products', [
            'products' => $products,
            'paramName' => $_GET['paramName']]);
    }
    
    
    /** 
     * @Route ("index.php?url=productDetail")
     */
    public function displayProductDetail()
    {
        $product = new Product();
        $product->setId($_GET['id']);
        
        $data = $this->repository->fetchProduct($product);
        
        $paramName = $data->getCategory()->getName();

        $this->displayTwig('productDetail', [
            'product' => $data,
            'user' => $data->getUser(),
            'paramName' => $paramName]);
    }
    
    
    /** 
     * @Route ("index.php?url=product/create")
     */    
    public function displayAddProductForm()
    {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $this->displayTwig('addProductForm', [
            'csrf' => $_SESSION['csrf']]);
    }
    
    
    /** 
     * @Route ("index.php?url=product/update")
     */
    public function displayUpdateProductForm()
    {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $product = new Product();
        $product->setId($_GET['id']);
        
        $data = $this->repository->fetchProduct($product);
       
        $this->displayTwig('updateProductForm', [
            'product' => $data,
            'csrf' => $_SESSION['csrf']]);

    }
    
    
    /** 
     * @Route ("index.php?url=insertProduct")
     */
    public function insertProduct()
    {
        if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
            header('location: ./index.php?url=product/create');
            exit();
        }
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $currentUser = unserialize($_SESSION['user']);
        $user = new User();
        $user->setId($currentUser->getId());

        $category = new Category();
        $category->setId($_POST['category']);
        
        $product = new Product();
        
        $product->setCategory($category);
        $product->setUser($user);
        $product->setName(htmlspecialchars($_POST['name']));
        $product->setDescription(htmlspecialchars($_POST['description']));
        $product->setPrice(htmlspecialchars($_POST['price']));

        if (isset($_FILES['image'])) {
            $tmpName = $_FILES['image']['tmp_name'];
            $name = $_FILES['image']['name'];
            $size = $_FILES['image']['size'];
            $error = $_FILES['image']['error'];
        
            $tabExtension = explode('.', $name);
            $extension = strtolower(end($tabExtension));
            
            $extensions = ['jpg', 'png', 'jpeg'];
            $maxSize = 4000000;
            
            if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
                $uniqueName = uniqid('', true);
                $file = $uniqueName.".".$extension;
                
                move_uploaded_file($tmpName, './public/img/products/'.$file);
                
                $product->setUrlPicture($file);
            
                $this->repository->insert($product);
                
                header('location: ./index.php?url=account');
                exit();
            }
            else{
                $errorMessage = "La taille de l'image est trop grande ou son extension n'est pas valide.";
                $this->displayTwig('addProductForm', [
                    'message' => $errorMessage,
                    'csrf' => $_SESSION['csrf']]);
            }
        }
    }
    
    
    /** 
     * @Route ("index.php?url=updateProduct")
     */
    public function updateProduct()
    {
        
        if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
            header('location: ./index.php?url=product/update');
            exit();
        }
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $img = $_GET['img'];
        
        $currentUser = unserialize($_SESSION['user']);
        $user = new User();
        $user->setId($currentUser->getId());

        $category = new Category();
        $category->setId($_POST['category']);
        
        $product = new Product();
        
        $product->setId($_GET['id']);
        $product->setCategory($category);
        $product->setUser($user);
        $product->setName(htmlspecialchars($_POST['name']));
        $product->setDescription(htmlspecialchars($_POST['description']));
        $product->setPrice(htmlspecialchars($_POST['price']));
        
        if (!empty($_FILES['image']['tmp_name'])) {
            $tmpName = $_FILES['image']['tmp_name'];
            $name = $_FILES['image']['name'];
            $size = $_FILES['image']['size'];
            $error = $_FILES['image']['error'];
        
        
            $tabExtension = explode('.', $name);
            $extension = strtolower(end($tabExtension));
            
            $extensions = ['jpg', 'png', 'jpeg'];
            $maxSize = 4000000;
            
            if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
                $uniqueName = uniqid('', true);
                $file = $uniqueName.".".$extension;
                
                move_uploaded_file($tmpName, './public/img/products/'.$file);
                
                $product->setUrlPicture($file);
        
                $data = $this->repository->update($product);
                
                if ($data && file_exists('./public/img/products/'.$img)) {
                    unlink("./public/img/products/" . $img);
                }
                
            }
            else {
                $errorMessage = "La taille de l'image est trop grande ou son extension n'est pas valide.";
                $data = $this->repository->fetchProduct($product);
               
                $this->displayTwig('updateProductForm', [
                    'product' => $data,
                    'message' => $errorMessage,
                    'csrf' => $_SESSION['csrf']]);
            } 
            
        } else {
            $product->setUrlPicture($img);
            
            $data = $this->repository->update($product);
        }
        
        header('location: ./index.php?url=account');
        exit();
    }
    
    
    /** 
     * @Route ("index.php?url=deleteProduct")
     */
    public function deleteProduct()
    {
        $product = new Product();
        $product->setId($_GET['id']);
        $img = $_GET['img'];
        
        $data = $this->repository->delete($product);
        
        if($data) {
            unlink("./public/img/products/" . $img);
            header('location: ./index.php?url=account');
            exit();
        } else {
            header('location: ./index.php?url=account');
            exit();
        }
    }
}