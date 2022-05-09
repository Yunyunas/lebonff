<?php 

require_once './service/AbstractRepository.php';

class CategoryRepository extends AbstractRepository {
    
    private const TABLE = "category";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }

    public function fetchCategory($id): array 
    {
        $data = null;
        try {
            $query = $this->connexion->prepare("SELECT * from category WHERE id = :id");
            if ($query) {
                $query->bindParam(":id", $id);
                $query->execute();
                $data = $query->fetch(PDO::FETCH_ASSOC);
                
                return $data;
            }
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
    
    
    public function  insert(Category $category): bool
    {
        try {
            $query = $this->connexion->prepare("INSERT INTO category(name, description, url_picture) 
                                            VALUES (:name, :description, :url_picture)");
           
            $query->bindValue(':name', $category->getName());
            $query->bindValue(':description', $category->getDescription());
            $query->bindValue(':url_picture', $category->getUrlPicture());
            
            $result = $query->execute();
            
            return $result;
            
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
    
    
    public function update(Category $category): bool
    {
        try {
            $query = $this->connexion->prepare("UPDATE category SET name = :name, 
            description = :description, url_picture = :url_picture WHERE id = :id");
            
            $query->bindValue(':id', $category->getId());
            $query->bindValue(':name', $category->getName());
            $query->bindValue(':description', $category->getDescription());
            $query->bindValue(':url_picture', $category->getUrlPicture());
            
            $result = $query->execute();
            
            return $result;
            
        } catch (Exception $e) {
            return false;
        }
    }
    
    
    public function delete(Category $category): bool
    {
        try {
            $query = $this->connexion->prepare("DELETE FROM category WHERE id = :id");
            
            $query->bindValue(':id', $category->getId());
            
            $result = $query->execute();
            
            return $result;
            
        } catch (Exception $e) {
            return false;
        }
    }
    
}
