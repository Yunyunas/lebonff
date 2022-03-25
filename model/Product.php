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
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     * @return string
     */
    public function getUrlPicture(): string
    {
        return $this->urlPicture;
    }
    
    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }
    
    /**
     * @return date
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * @return date
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }
    
    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    
    /**
     * @param string $urlPicture
     */
    public function setUrlPicture(string $urlPicture): void
    {
        $this->urlPicture = $urlPicture;
    }
    
    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }
    
    /**
     * @param date $createdAt
     */
        public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * @param date $updatedAt
     */
        public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}
