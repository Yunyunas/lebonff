<?php 
//require_once './model/User.php';
//require_once './model/Category.php';
require_once './service/AbstractRepository.php';

class ProductRepository extends AbstractRepository {
    
    private const TABLE = "product";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
        
    public function fetchNewProducts(): array
    {
        $query = $this->connexion->prepare("SELECT * from product INNER JOIN user 
                                            ON user.id = product.id_user INNER JOIN category
                                            ON category.id = product.id_category ORDER BY created_at DESC LIMIT 9");
        $data = null;
        try {
            $query->setFetchMode(PDO::FETCH_NAMED);
            $query->execute();
            $datas = $query->fetchAll();

            $products = [];
            foreach ($datas as $data) {
                $user = new User();
                    $user->setId($data['id'][1]);
                    $user->setLastName($data['last_name']);
                    $user->setFirstName($data['first_name']);
                    $user->setPhone($data['phone']);
                    $user->setEmail($data['email']);
                    $user->setRole($data['role']);
                    
                $category = new Category();
                    $category->setId($data['id'][2]);
                    $category->setName($data['name'][1]);
                    $category->setDescription($data['description'][1]);
                    $category->setUrlPicture($data['url_picture'][1]);
 
                $product = new Product();
                $products[] = $product;
                    $product->setId($data['id'][0]);
                    $product->setUser($user);
                    $product->setCategory($category);
                    $product->setName($data['name'][0]);
                    $product->setDescription($data['description'][0]);
                    $product->setUrlPicture($data['url_picture'][0]);
                    $product->setPrice($data['price']);
                    $product->setCreatedAt($data['created_at']);
            }
            
            return $products;
            
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function fetchProduct(Product $product)
    {
        $data = null;
        try {
            $query = $this->connexion->prepare("SELECT * from product 
                                                INNER JOIN user ON user.id = product.id_user
                                                INNER JOIN category ON category.id = product.id_category
                                                WHERE product.id = :id");
            if ($query) {
                $query->bindValue(":id", $product->getId());
                $query->execute();
                $data = $query->fetch(PDO::FETCH_NAMED);
                
                $user = new User();
                    $user->setId($data['id'][1]);
                    $user->setLastName($data['last_name']);
                    $user->setFirstName($data['first_name']);
                    $user->setPhone($data['phone']);
                    $user->setEmail($data['email']);
                    $user->setRole($data['role']);
                        
                $category = new Category();
                    $category->setId($data['id'][2]);
                    $category->setName($data['name'][1]);
                    $category->setDescription($data['description'][1]);
                    $category->setUrlPicture($data['url_picture'][1]);

                $product = new Product();
                    $product->setId($data['id'][0]);
                    $product->setUser($user);
                    $product->setCategory($category);
                    $product->setName($data['name'][0]);
                    $product->setDescription($data['description'][0]);
                    $product->setUrlPicture($data['url_picture'][0]);
                    $product->setPrice($data['price']);
                    $product->setCreatedAt($data['created_at']);

                return $product;
            }
        } catch (Exception $e) {
            return $e;
        }

        
    }
    
    public function fetchByCategory(Category $category): array 
    {
        $query = $this->connexion->prepare("SELECT * from product INNER JOIN user 
                                            ON user.id = product.id_user INNER JOIN category
                                            ON category.id = product.id_category WHERE category.id = :id_category");
        $data = null;
        try {
            $query->bindValue(':id_category', $category->getId());
            $query->setFetchMode(PDO::FETCH_NAMED);
            $query->execute();
            $datas = $query->fetchAll();

            $products = [];
            foreach ($datas as $data) {
                
                $user = new User();
                    $user->setId($data['id'][1]);
                    $user->setLastName($data['last_name']);
                    $user->setFirstName($data['first_name']);
                    $user->setPhone($data['phone']);
                    $user->setEmail($data['email']);
                    $user->setRole($data['role']);
                    
                $category = new Category();
                    $category->setId($data['id'][2]);
                    $category->setName($data['name'][1]);
                    $category->setDescription($data['description'][1]);
                    $category->setUrlPicture($data['url_picture'][1]);
 
                $product = new Product();
                $products[] = $product;
                    $product->setId($data['id'][0]);
                    $product->setUser($user);
                    $product->setCategory($category);
                    $product->setName($data['name'][0]);
                    $product->setDescription($data['description'][0]);
                    $product->setUrlPicture($data['url_picture'][0]);
                    $product->setPrice($data['price']);
                    $product->setCreatedAt($data['created_at']);
            }
            
            return $products;
            
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function fetchByUser(User $user): array
    {
        $query = $this->connexion->prepare("SELECT * from product INNER JOIN user 
                                            ON user.id = product.id_user INNER JOIN category
                                            ON category.id = product.id_category WHERE user.id = :id_user");
        $data = null;
        try {
            $query->bindValue(':id_user', $user->getId());
            $query->setFetchMode(PDO::FETCH_NAMED);
            $query->execute();
            $datas = $query->fetchAll();

            $products = [];
            foreach ($datas as $data) {
                $user = new User();
                    $user->setId($data['id'][1]);
                    $user->setLastName($data['last_name']);
                    $user->setFirstName($data['first_name']);
                    $user->setPhone($data['phone']);
                    $user->setEmail($data['email']);
                    $user->setRole($data['role']);
                    
                $category = new Category();
                    $category->setId($data['id'][2]);
                    $category->setName($data['name'][1]);
                    $category->setDescription($data['description'][1]);
                    $category->setUrlPicture($data['url_picture'][1]);
 
                $product = new Product();
                $products[] = $product;
                    $product->setId($data['id'][0]);
                    $product->setUser($user);
                    $product->setCategory($category);
                    $product->setName($data['name'][0]);
                    $product->setDescription($data['description'][0]);
                    $product->setUrlPicture($data['url_picture'][0]);
                    $product->setPrice($data['price']);
                    $product->setCreatedAt($data['created_at']);
            }
            
            return $products;
            
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function insert(Product $product): bool 
    {
        try {
            $query = $this->connexion->prepare("INSERT INTO product(id_user, id_category, name, description, url_picture, price, created_at)
                                                VALUES (:id_user, :id_category, :name, :description, :url_picture, :price, NOW())");

            $query->bindValue(':id_user', $product->getUser()->getId());
            $query->bindValue(':id_category', $product->getCategory()->getId());
            $query->bindValue(':name', $product->getName());
            $query->bindValue(':description', $product->getDescription());
            $query->bindValue(':url_picture', $product->getUrlPicture());
            $query->bindValue(':price', $product->getPrice());
            
            return $query->execute();

        } catch (Exception $e) {
            $data = $e;
        }
    }
    
    
    public function update(Product $product): bool
    {
        try {

            $query = $this->connexion->prepare("UPDATE product SET id_category = :id_category, name = :name, 
            description = :description, url_picture = :url_picture, price = :price, updated_at = NOW() WHERE product.id = :id");
            
            $query->bindValue(':id', $product->getId());
            $query->bindValue(':id_category', $product->getCategory()->getId());
            $query->bindValue(':name', $product->getName());
            $query->bindValue(':description', $product->getDescription());
            $query->bindValue(':url_picture', $product->getUrlPicture());
            $query->bindValue(':price', $product->getPrice());
            $result = $query->execute();
            
            return $result;
            
        } catch (Exception $e) {
            return false;
        }
    }
    
    
    public function delete(Product $product):bool
    {
        try {
            $query = $this->connexion->prepare("DELETE FROM product WHERE id = :id");
            
            $query->bindValue(':id', $product->getId());
            
            $result = $query->execute();
            return $result;
            
        } catch (Exception $e) {
            return false;
        }
    }
    
    
    public function fetchQuery($data) 
    {
        $data = null;
        try {
            $query = $this->connexion->prepare("SELECT * FROM product WHERE name LIKE :name");
            
            $query->bindParam(':name', '%'.$data.'%');
            $query->setFetchMode(PDO::FETCH_NAMED);
            $query->execute();
            $datas = $query->fetchAll();
            
            if ($datas) {
                $products = [];
            
                foreach ($datas as $data) {
                    $user = new User();
                        $user->setId($data['id'][1]);
                        $user->setLastName($data['last_name']);
                        $user->setFirstName($data['first_name']);
                        $user->setPhone($data['phone']);
                        $user->setEmail($data['email']);
                        $user->setRole($data['role']);
                        
                    $category = new Category();
                        $category->setId($data['id'][2]);
                        $category->setName($data['name'][1]);
                        $category->setDescription($data['description'][1]);
                        $category->setUrlPicture($data['url_picture'][1]);
     
                    $product = new Product();
                    $products[] = $product;
                        $product->setId($data['id'][0]);
                        $product->setUser($user);
                        $product->setCategory($category);
                        $product->setName($data['name'][0]);
                        $product->setDescription($data['description'][0]);
                        $product->setUrlPicture($data['url_picture'][0]);
                        $product->setPrice($data['price']);
                        $product->setCreatedAt($data['created_at']);
                }
                
                return $products;
            }
            
        } catch(Exception $e) {
            return false;
        }
    }
    
    
    
    
    
}
