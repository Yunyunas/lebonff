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
     * @Route ("index.php?url=newProducts")
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
     * @Route ("index.php?url=addProduct")
     */    
    public function displayAddProductForm()
    {
        $this->displayTwig('addProductForm');
    }
    
    
    /** 
     * @Route ("index.php?url=updateProductForm")
     */
    public function displayUpdateProductForm()
    {
        $product = new Product();
        $product->setId($_GET['id']);
        
        $data = $this->repository->fetchProduct($product);
       
        $this->displayTwig('updateProductForm', [
            'product' => $data]);

    }
    
    
    /** 
     * @Route ("index.php?url=insertProduct")
     */
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
        
        if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
            $uniqueName = uniqid('', true);
            $file = $uniqueName.".".$extension;
            
            move_uploaded_file($tmpName, './public/img/products/'.$file);
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
        $product->setUrlPicture($file);
        
        $this->repository->insert($product);

        header('location: ./index.php?url=account');
        exit();
    }
    
    
    /** 
     * @Route ("index.php?url=updateProduct")
     */
    public function updateProduct()
    {
        // Retirer le "required" du file et donc si $_FILES -> setUrlPicture else => le reste
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
        
        if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
            $uniqueName = uniqid('', true);
            $file = $uniqueName.".".$extension;
            
            move_uploaded_file($tmpName, './public/img/products/'.$file);
        }
        else{
            $message = "La taille du fichier ou l'extension est incorrect.";
        }
        
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
        $product->setUrlPicture($file);
        
        $data = $this->repository->update($product);
        
        if ($data == true) {
            $img = $_GET['img'];
            unlink("./public/img/products/" . $img);
            header('location: ./index.php?url=account');
            exit();
        } else {
            header('location: ./index.php?url=account');
            exit();
        }

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
        
        if($data === true) {
            unlink("./public/img/products/" . $img);
            header('location: ./index.php?url=account');
            exit();
        } else {
            header('location: ./index.php?url=account');
            exit();
        }
    }
}