<?php 
//require_once './model/User.php';
//require_once './model/Category.php';
require_once './service/AbstractRepository.php';

class ProductRepository extends AbstractRepository {
    
    private const TABLE = "product";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
        
    public function fetchNewProducts() {
        
        $query = $this->connexion->prepare("SELECT * from product INNER JOIN user 
                                            ON user.id = product.id_user INNER JOIN category
                                            ON category.id = product.id_category ORDER BY created_at DESC LIMIT 9");
        $data = null;
        try {
            $query->setFetchMode(PDO::FETCH_NAMED);
            $query->execute();
            $datas = $query->fetchAll();
            //var_dump($datas);
            //die();
            $products = [];
            foreach ($datas as $data) {
                $user = new User(
                    $data['id'][1],
                    $data['last_name'],
                    $data['first_name'],
                    $data['email'],
                    $data['role'],
                    );
                    
                $category = new Category(
                    $data['id'][2],
                    $data['name'][1],
                    $data['description'][1],
                    $data['url_picture'][1]
                    );
 
                $products[] = new Product(
                    $data['id'][0],
                    $user,
                    $category,
                    $data['name'][0],
                    $data['description'][0],
                    $data['url_picture'][0],
                    $data['price'],
                    $data['created_at']
                    );
            }
            
            return $products;
            
        } catch (Exception $e) {
            $data = $e;
        }
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
    
    public function fetchByCategory() 
    {
        
    }
    
    
    public function fetchByUser()
    {
        
    }
    
    public function insert(Product $product) 
    {
        try {
            $query = $this->connexion->prepare("INSERT INTO product(id_user, id_category, name, description, url_picture, price)
                                                VALUES (:id_user, :id_category, :name, :description, :url_picture, :price)");

            $query->bindValue(':id_user', $product->getUser()->getId());
            $query->bindValue(':id_category', $product->getCategory()->getId());
            $query->bindValue(':name', $product->getName());
            $query->bindValue(':description', $product->getDescription());
            $query->bindValue(':url_picture', $product->getUrlPicture());
            $query->bindValue(':price', $product->getPrice());
            $query->execute();
            
            $annonce = $query->fetchObject("product");
            
            return $product;
            
        } catch (Exception $e) {
            $data = $e;
        }
    }
    
    public function delete(Product $product)
    {
        try {
            $query = $this->connexion->prepare("DELETE FROM product WHERE id = :id");
            
            $query->bindValue(':id', $product->getId());
            $query->execute();
            
        } catch (Exception $e) {
            $data = $e;
        }
    }
    
    
    
    
    
    
    
    
}
