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
     * Route ("index.php?url=favourites")
     * Afficher la page "favourites"
     */
    public function displayFavourites(): void 
    {
        if ($_SESSION['user']) {
            $productRepository = new ProductRepository();
            $user = unserialize($_SESSION['user']);
            $datas = $this->repository->fetchByUser($user);
            
            if ($datas) {
                for ($i = 0; $i < count($datas); $i ++) {
                $favourites[] = $datas[$i];
                }
                
                $this->displayTwig('favourites', [
                    'favourites' => $favourites]);
            } else {
                $this->displayTwig('favourites');
            }
                
        } else {
            header('location: ./index.php?url=login');
            exit();
        }
    }
    
    /** 
     * Route ("index.php?url=addFavourite")
     * Ajouter un favoris
     */
    public function addFavourite(): void 
    {
        if (!empty($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            $product = new Product();
            $product->setId($_GET['id']);
            
            $favourite = new Favourite();
            $favourite->setUser($user);
            $favourite->setProduct($product);
            
            $data = $this->repository->fetchOne($favourite);
            
            if ($data) {
                echo ("Ce produit est déjà dans vos coups de coeur.");
            } else {
                $this->repository->insert($favourite);
                header('location: ./index.php?url=favourites');
                exit();
            }
        } else {
            header('location: ./index.php?url=home');
            exit();
        }
        
    }
    
    /** 
     * Route ("index.php?url=deleteFavourite")
     * Supprimer un favoris
     */
    public function deleteFavourite(): void 
    {
        $favourite = new Favourite();
        $favourite->setId($_GET['id']);
        
        $data = $this->repository->delete($favourite);
        
        header('location: ./index.php?url=favourites');
        exit();
    }
    
    
}