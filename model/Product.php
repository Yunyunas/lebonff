<?php

require_once "User.php";
require_once "Category.php";

class Product
{
    private int $id;
    private User $user;
    private Category $category;
    private string $name;
    private string $description;
    private string $urlPicture;
    private int $price;
    private $createdAt;
    private $updatedAt;


    public function __construct($id = 0, User $user = NULL, Category $category = NULL, $name = "", $description = "", $urlPicture = "",
     $price = 0, $createdAt = NULL, $updatedAt = NULL)
    {
        $this->id = $id;
        //$this->user = $user;
        //$this->category = $category;
        $this->name = $name;
        $this->description = $description;
        $this->urlPicture = $urlPicture;
        $this->price = $price;
        $this->createdAt = new DateTime($createdAt);
        $this->updatedAt = new DateTime($updatedAt);
    }

    public function __toString()
    {
        return $this->name;
    }

    // GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }
    
    public function getCategory(): Category
    {
        return $this->category;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function getUrlPicture(): string
    {
        return $this->urlPicture;
    }
    
    public function getPrice(): int
    {
        return $this->price;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    // SETTERS
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
    
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }
    
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    
    public function setUrlPicture(string $urlPicture): void
    {
        $this->urlPicture = $urlPicture;
    }
    
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }
    
        public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
        public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}
