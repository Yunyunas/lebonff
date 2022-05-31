<?php 

require_once './service/AbstractRepository.php';

class FavouriteRepository extends AbstractRepository {
    
    private const TABLE = "favourite";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
    
    public function fetchOne(Favourite $favourite)
    {
        $query = $this->connexion->prepare("SELECT id FROM favourite WHERE user_id = :user_id AND product_id = :product_id");
        $data = null;
        $userId = $favourite->getUser()->getId();
        $productId = $favourite->getProduct()->getId();
        
        try {
            $query->bindParam(':user_id', $userId);
            $query->bindParam(':product_id', $productId);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);
                    
            return $data;
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }  
            
    }


    public function fetchByUser(User $user): array
    {
        $query = $this->connexion->prepare("SELECT * FROM favourite INNER JOIN user 
                                            ON user.id = favourite.user_id INNER JOIN product
                                            ON product.id = favourite.product_id WHERE user.id = :user_id");
        $data = null;
        try {
            $query->bindValue(':user_id', $user->getId());
            $query->setFetchMode(PDO::FETCH_NAMED);
            $query->execute();
            $datas = $query->fetchAll();

            $favourites = [];
            
            foreach ($datas as $data) {
                $user = new User();
                    $user->setId($data['id'][1]);
                    $user->setLastName($data['last_name']);
                    $user->setFirstName($data['first_name']);
                    $user->setPhone($data['phone']);
                    $user->setEmail($data['email']);
                    $user->setRole($data['role']);
                
                $category = new Category();
                    $category->setId($data['category_id']);
 
                $product = new Product();
                $products[] = $product;
                    $product->setId($data['id'][2]);
                    $product->setUser($user);
                    $product->setCategory($category);
                    $product->setName($data['name']);
                    $product->setDescription($data['description']);
                    $product->setUrlPicture($data['url_picture']);
                    $product->setPrice($data['price']);
                    $product->setCreatedAt($data['created_at']);
                    
                $favourite = new Favourite();
                $favourites[] = $favourite;
                    $favourite->setId($data['id'][0]);
                    $favourite->setUser($user);
                    $favourite->setProduct($product);
            }
            
            return $favourites;
            
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
        
    public function insert(Favourite $favourite): bool 
    {
        try {
            $query = $this->connexion->prepare("INSERT INTO favourite(user_id, product_id)
                                                VALUES (:user_id, :product_id)");

            $query->bindValue(':user_id', $favourite->getUser()->getId());
            $query->bindValue(':product_id', $favourite->getProduct()->getId());

            return $query->execute();

        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
    
    // DANS LE CAS OU UN USER VEUT JUSTE SUPPRIMER UN PRODUIT PRESENT DANS SES COUPS DE COEUR
    public function delete(Favourite $favourite): bool
    {
        try {
            $query = $this->connexion->prepare("DELETE FROM favourite WHERE id = :id");
            
            $query->bindValue(':id', $favourite->getId());
            
            $result = $query->execute();
            return $result;
            
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
    
    
    // VERIFIER SI NECESSAIRE --------------------------------------------------
    // DANS LE CAS OU UN USER SUPPRIME SON COMPTE ALORS SUPPRIMER TOUS LES COUPS DE COEURS LIES A LUI
    public function deleteAllByUser(Favourite $favourite): bool
    {
        try {
            $query = $this->connexion->prepare("DELETE FROM favourite WHERE user_id = :user_id");
            
            $query->bindValue(':user_id', $favourite->getUser()->getId());
            
            $result = $query->execute();
            return $result;
            
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
    
    // DANS LE CAS OU UN PRODUIT EST SUPPRIME ALORS IL FAUT LE SUPPRIMER DE TOUS LES COUPS DE COEUR OU IL AVAIT PU ETRE ADD
    public function deleteAllByProducts(Favourite $favourite): bool
    {
        try {
            $query = $this->connexion->prepare("DELETE FROM favourite WHERE product_id = :product_id");
            
            $query->bindValue(':user_id', $favourite->getUser()->getId());
            
            $result = $query->execute();
            return $result;
            
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
}
