<?php 

require_once './service/AbstractRepository.php';

class CategoryRepository extends AbstractRepository {
    
    private const TABLE = "category";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }

    public function fetchCategory($id) {
        
        $data = null;
        try {
            $query = $this->connexion->prepare("SELECT * from category WHERE id = :id");
            if ($query) {
                $query->bindParam(":id", $id);
                $query->execute();
                $data = $query->fetch(PDO::FETCH_ASSOC);
            
            }
        } catch (Exception $e) {
            $data = $e;
        }

        return $data;
    }
    
    
    public function  insert(Category $category): bool
    {
        try {
            $query = $this->connexion->prepare("INSERT INTO category(name, description, url_picture) 
                                            VALUES (:name, :description, :url_picture)");
           
            $query->bindValue(':name', $category->getName());
            $query->bindValue(':description', $category->getDescription());
            $query->bindValue(':url_picture', $category->getUrlPicture());
            $query->execute();
            $category = $query->fetchObject("category");
            
            return $category;
            
        } catch (Exception $e) {
            $data = $e;
        }
    }
    
    
    public function  update(Category $category)
    {
        try {

            $query = $this->connexion->prepare("UPDATE category SET name = :name, 
            description = :description, url_picture = :url_picture WHERE id = :id");
            
            $query->bindValue(':id', $category->getId());
            $query->bindValue(':name', $category->getName());
            $query->bindValue(':description', $category->getDescription());
            $query->bindValue(':url_picture', $category->getUrlPicture());
            $query->execute();

            return $category;
            
        } catch (Exception $e) {
            $data = $e;
        }
    }
    
    
    public function  delete(Category $category)
    {
        try {
            $query = $this->connexion->prepare("DELETE FROM category WHERE id = :id");
            
            $query->bindValue(':id', $category->getId());
            $query->execute();
            
        } catch (Exception $e) {
            $data = $e;
        }
    }
    
}
