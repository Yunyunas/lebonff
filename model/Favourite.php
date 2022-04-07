<?php

require_once "User.php";
require_once "Product.php";

class Favourite
{
    private int $id;
    private User $user;
    private Product $product;
    
    
     /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
    
    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }
    
    
     /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
    
    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
    
}