<?php 

require_once './service/AbstractRepository.php';

class CategoryRepository extends AbstractRepository {
    
    private const TABLE = "category";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
        
    public function fetchCategories() {
        
        $query = $this->connexion->prepare("SELECT * from category");
        $data = null;
        try {
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $data = $query->fetchAll();
            
        } catch (Exception $e) {
            $data = $e;
        }
        
        return $data;
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
        
}
