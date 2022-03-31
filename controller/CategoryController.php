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
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $this->displayTwig('addCategoryForm', [
            'csrf' => $_SESSION['csrf']]);
    }
    
    
    /** 
     * @Route ("index.php?url=admin/category/update")
     */
    public function displayUpdateCategoryForm()
    {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $data = $this->repository->fetchCategory($_GET['id']);
        $this->displayTwig('updateCategoryForm', [
            'category' => $data,
            'csrf' => $_SESSION['csrf']]);
    }
    
    
    /** 
     * @Route ("index.php?url=insertCategory")
     */
    public function insertCategory() 
    {
        if(!$_SESSION['csrf'] || $_SESSION['csrf'] !== $_POST['csrf_token']){
            header('location: ./index.php?url=admin/category/create');
            exit();
        }
        
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        
        $category = new Category();
        $category->setName(htmlspecialchars($_POST['name']));
        $category->setDescription(htmlspecialchars($_POST['description']));

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
                
                move_uploaded_file($tmpName, './public/img/categories/'.$file);
                
                $category->setUrlPicture($file);
        
                $this->repository->insert($category);
                
                $successMessage = "La catégorie a bien été créée";
                $this->displayTwig('adminCategories', [
                            'message' => $successMessage]);
                
            } else{
                $errorMessage = "La taille de l'image est trop grande ou son extension n'est pas valide.";
                $this->displayTwig('addCategoryForm', [
                    'message' => $errorMessage,
                    'csrf' => $_SESSION['csrf']]);
            }
        }
    }
    
    
    /** 
     * @Route ("index.php?url=updateCategory")
     */
    public function updateCategory()
    {
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
                
                move_uploaded_file($tmpName, './public/img/categories/'.$file);
                
                $category->setUrlPicture($file);
                
                $data = $this->repository->update($category);
                
                if ($data && file_exists('./public/img/categories/'.$img)) {
                    unlink("./public/img/categories/" . $img);
                }
                
            } else {
                $errorMessage = "La taille de l'image est trop grande ou son extension n'est pas valide.";
                $data = $this->repository->fetchCategory($_GET['id']);
                
                $this->displayTwig('updateCategoryForm', [
                    'category' => $data,
                    'message' => $errorMessage,
                    'csrf' => $_SESSION['csrf']]);
            }
            
        } else {
            $category->setUrlPicture($img);
            
            $data = $this->repository->update($category);
        } 
        
        $successMessage = "La modification de la catégorie est validée.";
        $this->displayTwig('adminCategories', [
                    'message' => $successMessage]);
    }
    
    
    /** 
     * @Route ("index.php?url=admin/category/delete")
     */
    public function deleteCategory()
    {
        $category = new Category();
        $category->setId($_GET['id']);
        $img = $_GET['img'];
        
        $data = $this->repository->delete($category);
        
        if($data) {
            unlink("./public/img/categories/" . $img);
            
            $successMessage = "La catégorie a bien été supprimée.";
            $this->displayTwig('adminCategories', [
                    'message' => $successMessage]);
                    
        } else {
            $errorMessage = "Une erreur est survenue lors de la suppression de la catégorie. Avez-vous vérifié que la catégorie ne possédait pas d'annonces avant de la supprimer ?";
            $this->displayTwig('adminCategories', [
                    'message' => $errorMessage]);
        }
    }
    
}