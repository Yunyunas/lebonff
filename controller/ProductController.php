<?php

require_once './service/Picture.php';

require_once './model/User.php';
require_once './repository/UserRepository.php';

require_once './model/Product.php';
require_once './repository/ProductRepository.php';

require_once './model/Category.php';
require_once './repository/CategoryRepository.php';
require_once './controller/AbstractController.php';

class ProductController extends AbstractController
{
    
    private $repository;
    
    const FOLDER = 'products';
    
    public function __construct()
    {
        $this->repository = new ProductRepository();
        $this->picture = new Picture();
    }
    
    
    /** 
     * Route ("index.php?url=products")
     * Afficher la page "products"
     */
    public function displayProducts(): void
    {
        $category = new Category();
        $category->setId($_GET['id']);
        
        $products = $this->repository->fetchByCategory($category);
            
        
        $this->displayTwig('products', [
            'products' => $products,
            'paramName' => $_GET['paramName']]);
    }
    
    
    /** 
     * Route ("index.php?url=products/new")
     * Afficher la page "products" nouveautés
     */
    public function displayNewProducts(): void
    {
        $products = $this->repository->fetchNewProducts();
      
        $this->displayTwig('products', [
            'products' => $products,
            'paramName' => $_GET['paramName']]);
    }
    
    
    /** 
     * Route ("index.php?url=productDetail")
     * Afficher la page "productDetail"
     */
    public function displayProductDetail(): void
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
     * Route ("index.php?url=products/user")
     * Afficher la page "productsByUser"
     */
    public function displayProductsByUser(): void
    {
        $user = new User();
        $user->setId($_GET['id']);
        
        $products = $this->repository->fetchByUser($user);
        
        if ($products) {
            
            $user = $products[0]->getUser();
            
            $this->displayTwig('productsByUser', [
                'products' => $products,
                'user' => $user]);
        } else {
            header('location: ./index.php?url=home');
            exit();
        }

    }
    
    /** 
     * Route ("index.php?url=product/create")
     * Afficher la page "addProductForm"
     */    
    public function displayAddProductForm(): void
    {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $this->displayTwig('addProductForm', [
            'csrf' => $_SESSION['csrf']]);
    }
    
    
    /** 
     * Route ("index.php?url=product/update")
     * Afficher la page "updateProductForm"
     */
    public function displayUpdateProductForm(): void
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
     * Route ("index.php?url=insertProduct")
     * Ajouter une annonce
     */
    public function insertProduct(): void
    {
        if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
            header('location: ./index.php?url=product/create');
            exit();
        }
        
        $user = unserialize($_SESSION['user']);

        $category = new Category();
        $category->setId($_POST['category']);
        
        $product = new Product();
        
        $product->setCategory($category);
        $product->setUser($user);
        $product->setName(htmlspecialchars($_POST['name']));
        $product->setDescription(htmlspecialchars($_POST['description']));
        $product->setPrice(htmlspecialchars($_POST['price']));

        if (isset($_FILES['image'])) {
            
            $result = $this->picture->addPicture($_FILES['image'], 'products');
            
            if ($result) {
                $product->setUrlPicture($result);
            
                $this->repository->insert($product);
                                
                header('location: ./index.php?url=account');
                exit();
                
            } else {
                header('location: ./index.php?url=product/create&code=400&customCode=pictureError');
                exit();
            }
            
        } else {
            header('location: ./index.php?url=product/create&code=400&customCode=formRequiredError');
            exit();
        }
    }
    
    
    /** 
     * Route ("index.php?url=updateProduct")
     * Modifier une annonce
     */
    public function updateProduct(): void
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
            
            $result = $this->picture->addPicture($_FILES['image'], self::FOLDER);
            
            if ($result) {
                
                $product->setUrlPicture($result);
        
                $data = $this->repository->update($product);
                
                if ($data) {
                    $this->picture->deletePicture($img, self::FOLDER);
                }
                
            } else {
                header('location: ./index.php?url=product/update&code=400&customCode=pictureError');
                exit();
            } 
            
        } else {
            $product->setUrlPicture($img);
            
            $data = $this->repository->update($product);
        }
        
        header('location: ./index.php?url=account');
        exit();
    }
    
    
    /** 
     * Route ("index.php?url=deleteProduct")
     * Supprimer une annonce
     */
    public function deleteProduct(): void
    {
        $product = new Product();
        $product->setId($_GET['id']);
        $img = $_GET['img'];
        
        $data = $this->repository->delete($product);
        
        if($data) {
            $this->picture->deletePicture($img, self::FOLDER);
            header('location: ./index.php?url=account');
            exit();
        } else {
            header('location: ./index.php?url=account');
            exit();
        }
    }
}