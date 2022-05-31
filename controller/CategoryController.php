<?php

require_once './model/Category.php';
require_once './service/AdminAuthenticator.php';
require_once './service/Picture.php';
require_once './repository/CategoryRepository.php';
require_once './controller/AbstractController.php';

class CategoryController extends AbstractController
{
    
    private $repository;
    private $picture;
    private $role;
    
    const FOLDER = 'categories';
    
    public function __construct()
    {
        $this->repository = new CategoryRepository();
        $this->picture = new Picture();
        $this->role = new AdminAuthenticator();
    }
    
    
    /** 
     * Route ("index.php?url=categories")
     * Afficher la page "categories"
     */
    public function displayCategories(): void
    {
        $this->displayTwig('categories');
    }
    
    
    /** 
     * Route ("index.php?url=admin/category/create")
     * Afficher la page "addCategoryForm"
     */
    public function displayAddCategoryForm(): void
    {
       
        if ($this->role->isAdmin()) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
            
            $this->displayTwig('admin/addCategoryForm', [
                'csrf' => $_SESSION['csrf']]);

        } else {
            header('location: ./index.php?url=error&code=403');
            exit();
        }        
    }
    
    
    /** 
     * Route ("index.php?url=admin/category/update")
     * Afficher la page "updateCategoryForm"
     */
    public function displayUpdateCategoryForm(): void
    {
        if ($this->role->isAdmin()) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
            $data = $this->repository->fetchCategory($_GET['id']);
            
            $this->displayTwig('admin/updateCategoryForm', [
                'category' => $data,
                'csrf' => $_SESSION['csrf']]);
        } else {
            header('location: ./index.php?url=home');
            exit();
        }        
    }
    
    
    /** 
     * Route ("index.php?url=insertCategory")
     * Ajouter une catégorie par l'admin
     */
    public function insertCategory(): void 
    {
        if ($this->role->isAdmin()) {
            if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
                header('location: ./index.php?url=admin/category/create');
                exit();
            }
            
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
            
            $category = new Category();
            $category->setName(htmlspecialchars($_POST['name']));
            $category->setDescription(htmlspecialchars($_POST['description']));
            
            if (isset($_FILES['image'])) {
                
                $result = $this->picture->addPicture($_FILES['image'], self::FOLDER);
                
                if ($result) {
                    $category->setUrlPicture($result);
            
                    $this->repository->insert($category);
                    
                    $successMessage = "La catégorie a bien été créée";
                    $this->displayTwig('admin/adminCategories', [
                                'message' => $successMessage]);
                } else {
                    header('location: ./index.php?url=admin/category/create&code=400&customCode=pictureError');
                    exit();
                }
            }
            
        } else {
            header('location: ./index.php?url=home');
            exit();
        }        
    }
    
    
    /** 
     * Route ("index.php?url=updateCategory")
     * Modifier une catégorie par l'admin
     */
    public function updateCategory(): void
    {
        $id = $_GET['id'];
        
        if ($this->role->isAdmin()) {
            if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
                header('location: ./index.php?url=admin/category/update');
                exit();
            }
            
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
            
            $img = $_GET['img'];
           
            $category = new Category();
            $category->setId($id);
            $category->setName(htmlspecialchars($_POST['name']));
            $category->setDescription(htmlspecialchars($_POST['description']));
    
            if (!empty($_FILES['image']['tmp_name'])) {
                
                $result = $this->picture->addPicture($_FILES['image'], self::FOLDER);
                
                if ($result) {
                    
                    $category->setUrlPicture($result);
            
                    $data = $this->repository->update($category);
                    
                    if ($data) {
                        $this->picture->deletePicture($img, self::FOLDER);
                    }
                    
                    $successMessage = "La modification de la catégorie est validée.";
                        $this->displayTwig('admin/adminCategories', [
                        'message' => $successMessage]);
                        
                } else {
                    header('location: ./index.php?url=admin/category/update&code=400&customCode=pictureError&id='.$id);
                    exit();
                }
                
            } else {
                $category->setUrlPicture($img);
                
                $data = $this->repository->update($category);
                
                header('location: ./index.php?url=admin/categories');
                exit();
            } 
                
        } else {
            header('location: ./index.php?url=home');
            exit();
        }        
        
    }
    
    
    /** 
     * Route ("index.php?url=admin/category/delete")
     * Supprimer une catégorie par l'admin
     */
    public function deleteCategory(): void
    {
        if ($this->role->isAdmin()) {
            $category = new Category();
            $category->setId($_GET['id']);
            $img = $_GET['img'];
            
            $data = $this->repository->delete($category);
            
            if($data) {
                $this->picture->deletePicture($img, self::FOLDER);
                
                $successMessage = "La catégorie a bien été supprimée.";
                $this->displayTwig('admin/adminCategories', [
                        'message' => $successMessage]);
                        
            } else {
                header('location: ./index.php?url=admin/categories&code=400&customCode=adminCategoryDelete');
                exit();
            }
            
        } else {
            header('location: ./index.php?url=home');
            exit();
        }        
    }
    
}