<?php

class User
{
    private int $id;
    private string $lastName;
    private string $firstName;
    private string $email;
    private string $password;
    private string $address;
    private int $postalCode;
    private string $city;
    private string $role;

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
    public function getLastName(): string
    {
        return $this->lastName;
    }
    
    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */    
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return int
     */    
    public function getPostalCode(): int
    {
        return $this->postalCode;
    }
    
    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */    
    public function getRole(): string
    {
        return $this->role;
    }


    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $lastName
     */    
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    
    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
    
    /**
     * @param int $postalCode
     */    
    public function setPostalCode(int $postalCode): void
    {
        $this->postalCode = $postalCode;
    }
    
    /**
     * @param string $city
     */    
    public function setCity(string $city): void
    {
        $this->city = $city;
    }
    
    /**
     * @param string $role
     */    
    public function setRole(string $role): void
    {
        $this->role = $role;
    }
}
