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
        $this->role = new Admin();
    }
    
    
    /** 
     * @Route ("index.php?url=categories")
     */
    public function displayCategories()
    {
        $this->displayTwig('categories');
    }
    
    
    /** 
     * @Route ("index.php?url=admin/category/create")
     */
    public function displayAddCategoryForm()
    {
        if ($this->role->isAdmin()) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
            $this->displayTwig('admin/addCategoryForm', [
                'csrf' => $_SESSION['csrf']]);
        } else {
            $this->displayTwig('home');
        }        
    }
    
    
    /** 
     * @Route ("index.php?url=admin/category/update")
     */
    public function displayUpdateCategoryForm()
    {
        if ($this->role->isAdmin()) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
            $data = $this->repository->fetchCategory($_GET['id']);
            
            $this->displayTwig('admin/updateCategoryForm', [
                'category' => $data,
                'csrf' => $_SESSION['csrf']]);
        } else {
            $this->displayTwig('home');
        }        
    }
    
    
    /** 
     * @Route ("index.php?url=insertCategory")
     */
    public function insertCategory() 
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
                    $errorMessage = "La taille de l'image est trop grande ou son extension n'est pas valide.";
                    $this->displayTwig('admin/addCategoryForm', [
                        'message' => $errorMessage,
                        'csrf' => $_SESSION['csrf']]);
                }
            }
            
        } else {
            $this->displayTwig('home');
        }        
    }
    
    
    /** 
     * @Route ("index.php?url=updateCategory")
     */
    public function updateCategory()
    {
        
        if ($this->role->isAdmin()) {
            if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
                header('location: ./index.php?url=admin/category/update');
                exit();
            }
            
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
            
            $img = $_GET['img'];
           
            $category = new Category();
            $category->setId($_GET['id']);
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
                    $errorMessage = "La taille de l'image est trop grande ou son extension n'est pas valide.";
                    $data = $this->repository->fetchCategory($_GET['id']);
                    
                    $this->displayTwig('admin/updateCategoryForm', [
                        'category' => $data,
                        'message' => $errorMessage,
                        'csrf' => $_SESSION['csrf']]);
                }
                
            } else {
                $category->setUrlPicture($img);
                
                $data = $this->repository->update($category);
            } 
                
        } else {
            $this->displayTwig('home');
        }        
        
    }
    
    
    /** 
     * Route ("index.php?url=admin/category/delete")
     */
    public function deleteCategory()
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
                $errorMessage = "Une erreur est survenue lors de la suppression de la catégorie. Avez-vous vérifié que la catégorie 
                                ne possédait pas d'annonces avant de la supprimer ?";
                                
                $this->displayTwig('admin/adminCategories', [
                        'message' => $errorMessage]);
            }
            
        } else {
            $this->displayTwig('home');
        }        
    }
    
}