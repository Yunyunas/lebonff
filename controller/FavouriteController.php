<?php

require_once './repository/ProductRepository.php';
require_once './repository/UserRepository.php';
require_once './repository/FavouriteRepository.php';
require_once './model/Favourite.php';
require_once './model/User.php';
require_once './controller/AbstractController.php';

class FavouriteController extends AbstractController
{
    private $repository;
    
    public function __construct()
    {
        $this->repository = new FavouriteRepository();
    }
    
    
    /** 
     * @Route ("index.php?url=favourites")
     */
    public function displayFavourites() 
    {
        if ($_SESSION['user']) {
            $productRepository = new ProductRepository();
            $user = unserialize($_SESSION['user']);
            $datas = $this->repository->fetchByUser($user);
            
            for ($i = 0; $i < count($datas); $i ++) {
                $favourites[] = $datas[$i];
            }
            
            $this->displayTwig('favourites', [
                'favourites' => $favourites]);
                
        } else {
            header('location: ./index.php?url=login');
            exit();
        }
    }
    
    /** 
     * @Route ("index.php?url=addFavourite")
     */
    public function addFavourite() 
    {
        $user = unserialize($_SESSION['user']);
        $product = new Product();
        $product->setId($_GET['id']);
        
        $favourite = new Favourite();
        $favourite->setUser($user);
        $favourite->setProduct($product);
        
        $data = $this->repository->fetchOne($favourite);
        
        // A MODIFIER ET A RENDRE + DYNAMIQUE
        if ($data) {
            echo ("Ce produit est déjà dans vos coups de coeur.");
        } else {
            $this->repository->insert($favourite);
            echo ("Ce produit a bien été ajouté à vos coups de coeur.");
        }
    }
    
    /** 
     * @Route ("index.php?url=deleteFavourite")
     */
    public function deleteFavourite() 
    {
        $favourite = new Favourite();
        $favourite->setId($_GET['id']);
        
        $data = $this->repository->delete($favourite);
        
        header('location: ./index.php?url=favourites');
        exit();
    }
    
    
}