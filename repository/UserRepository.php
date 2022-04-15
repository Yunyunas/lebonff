<?php 

require_once './service/AbstractRepository.php';

class UserRepository extends AbstractRepository {
    
    private const TABLE = "user";
    
    public function __construct(){
        parent::__construct(self::TABLE);
    }
    
    
    public function fetchLogin($email)
    {
        $data = null;

        try {
            $query = $this->connexion->prepare("SELECT * FROM user WHERE email = :email");
            
            if ($query) {
                $query->bindParam(":email", $email);
                $query->execute();
                $data = $query->fetch(PDO::FETCH_ASSOC);

                if ($data) {
                    $user = new User();
                    $user->setId($data['id']);
                    $user->setLastName($data['last_name']);
                    $user->setFirstName($data['first_name']);
                    $user->setPhone($data['phone']);
                    $user->setEmail($data['email']);
                    $user->setPassword($data['password']);
                    $user->setRole($data['role']);
                
                    return $user;
                }
            }
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
    
    public function fetchById($id)
    {
        $data = null;

        try {
            $query = $this->connexion->prepare("SELECT * FROM user WHERE id = :id");
            
            if ($query) {
                $query->bindParam(":id", $id);
                $query->execute();
                $data = $query->fetch(PDO::FETCH_ASSOC);
                
                if ($data) {
                    $user = new User();
                    $user->setId($data['id']);
                    $user->setLastName($data['last_name']);
                    $user->setFirstName($data['first_name']);
                    $user->setPhone($data['phone']);
                    $user->setEmail($data['email']);
                    $user->setPassword($data['password']);
                    $user->setRole($data['role']);

                    return $user;
                }
            }
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
    
    
    public function  insert(User $user)
    {
        try {
            $query = $this->connexion->prepare("INSERT INTO user(last_name, first_name, phone, email, password, role) 
                                            VALUES (:lastName, :firstName, :phone, :email, :password, :role)");
           
            $query->bindValue(':lastName', $user->getLastName());
            $query->bindValue(':firstName', $user->getFirstName());
            $query->bindValue(':phone', $user->getPhone());
            $query->bindValue(':email', $user->getEmail());
            $query->bindValue(':password', $user->getPassword());
            $query->bindValue(':role', $user->getRole());
            return $query->execute();
            
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
    
    
    public function  updateProfil(User $user): bool 
    {
        try {
            $query = $this->connexion->prepare("UPDATE user SET last_name = :lastName, 
            first_name = :firstName, phone = :phone, email = :email WHERE id = :id");
            
            $query->bindValue(':id', $user->getId());
            $query->bindValue(':lastName', $user->getLastName());
            $query->bindValue(':firstName', $user->getFirstName());
            $query->bindValue(':phone', $user->getPhone());
            $query->bindValue(':email', $user->getEmail());
            
            return $query->execute();
            
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
    
    
    public function  updatePassword(User $user): bool 
    {
        try {
            $query = $this->connexion->prepare("UPDATE user SET password = :password WHERE id = :id");
            
            $query->bindValue(':id', $user->getId());
            $query->bindValue(':password', $user->getPassword());
            
            return $query->execute();

        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
    
    
    public function  deleteAccount(User $user): bool 
    {
        try {
            $query = $this->connexion->prepare("DELETE FROM user WHERE id = :id");
            
            $query->bindValue(':id', $user->getId());
            
            return $query->execute();
            
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
    
    public function fetchQuery($data) 
    {
        $name = '%'.$data.'%';
        try {
            $query = $this->connexion->prepare("SELECT * FROM user WHERE name LIKE :name");
            
            $query->bindParam(':name', $name);
            $query->setFetchMode(PDO::FETCH_NAMED);
            $query->execute();
            $datas = $query->fetchAll();

            return $datas;
            
        } catch(Exception $e) {
            $data = ['error' => $e->getMessage()];
        }
    }
}