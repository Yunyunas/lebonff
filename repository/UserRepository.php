<?php 

require_once './service/AbstractRepository.php';

class UserRepository extends AbstractRepository {
    
    private const TABLE = "user";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
    
    
    public function fetchLogin($email) {
        $data = null;

        try {
            $query = $this->connexion->prepare("SELECT * FROM user WHERE email = :email");
            
            if ($query) {
                $query->bindParam(":email", $email);
                $query->execute();
                $data = $query->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $data = $e;
        }

        return $data;
    }
    
    
    public function  insert(User $user): bool
    {
        try {
            $query = $this->connexion->prepare("INSERT INTO user(last_name, first_name, email, password, address, postal_code, city, role) 
                                            VALUES (:lastName, :firstName, :email, :password, :address, :postal_code, :city, :role)");
           
            $query->bindValue(':lastName', $user->getLastName());
            $query->bindValue(':firstName', $user->getFirstName());
            $query->bindValue(':email', $user->getEmail());
            $query->bindValue(':password', $user->getPassword());
            $query->bindValue(':address', $user->getAddress());
            $query->bindValue(':postal_code', $user->getPostalCode());
            $query->bindValue(':city', $user->getCity());
            $query->bindValue(':role', $user->getRole());
            $query->execute();
            $user = $query->fetchObject("user");
            
            return $user;
            
        } catch (Exception $e) {
            $data = $e;
        }
    }
    
    
    public function  updateProfil(User $user) 
    {
        try {
            $query = $this->connexion->prepare("UPDATE user SET last_name = :lastName, 
            first_name = :firstName, email = :email WHERE id = :id");
            
            $query->bindValue(':id', $user->getId());
            $query->bindValue(':lastName', $user->getLastName());
            $query->bindValue(':firstName', $user->getFirstName());
            $query->bindValue(':email', $user->getEmail());
            $query->execute();
            //var_dump($user);
            //die();
            return $user;
            
        } catch (Exception $e) {
            $data = $e;
        }
    }
    
    
    public function  updatePassword(User $user) 
    {
        try {
            //var_dump($user);
            //die();
            $query = $this->connexion->prepare("UPDATE user SET password = :password WHERE id = :id");
            
            $query->bindValue(':id', $user->getId());
            $query->bindValue(':password', $user->getPassword());
            $query->execute();

            return $user;
            
        } catch (Exception $e) {
            $data = $e;
        }
    }
    
    
    public function  deleteAccount(User $user) 
    {
        try {
            //var_dump($user);
            //die();
            $query = $this->connexion->prepare("DELETE FROM user WHERE id = :id");
            
            $query->bindValue(':id', $user->getId());
            $query->execute();
            
            //return $user;
            
        } catch (Exception $e) {
            $data = $e;
        }
    }
}