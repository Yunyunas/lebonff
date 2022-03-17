<?php 

require_once './service/AbstractRepository.php';

class ProductRepository extends AbstractRepository {
    
    private const TABLE = "product";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
        
    public function fetchProducts() {
        
        $query = $this->connexion->prepare("SELECT * from product");
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
    
    public function fetchProduct($id) {
        
        $data = null;
        try {
            $query = $this->connexion->prepare("SELECT * from product WHERE id = :id");
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
