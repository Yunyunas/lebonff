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

    public function __construct($id = 0, $lastName = "", $firstName = "", $email = "", $password = "", 
    $address = "", $postalCode = 0, $city = "", $role = "user")
    {
        $this->id = $id;
        $this->lastName = $lastName;
        $this->firstName= $firstName;
        $this->email = $email;
        $this->password = $password;
        $this->address = $address;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->role = $role;
    }

    public function __toString()
    {
        return $this->email;
    }

    // GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
    
        public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    
    public function getAddress(): string
    {
        return $this->address;
    }
    
    public function getPostalCode(): int
    {
        return $this->postalCode;
    }
    
    
    public function getCity(): string
    {
        return $this->city;
    }
    
    public function getRole(): string
    {
        return $this->role;
    }

    // SETTERS
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
    
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
    
    public function setPostalCode(int $postalCode): void
    {
        $this->postalCode = $postalCode;
    }
    
    public function setCity(string $city): void
    {
        $this->city = $city;
    }
    
    public function setRole(string $role): void
    {
        $this->role = $role;
    }
}
