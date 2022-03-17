<?php

class Category
{
    private int $id;
    private string $name;
    private string $description;
    private string $urlPicture;


    public function __construct($id = 0, $name = "", $description = "", $urlPicture = "")
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->urlPicture = $urlPicture;
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

    // SETTERS
    public function setId(int $id): void
    {
        $this->id = $id;
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
}
