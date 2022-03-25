<?php

class Category
{
    private int $id;
    private string $name;
    private string $description;
    private string $urlPicture;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
}
