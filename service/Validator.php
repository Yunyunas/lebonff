<?php

class Validator {
    
    
    public function __construct(){
        // Pour l'instant R 
    }
    
    public function validateEmail($data)
    {
        $filter = filter_var(htmlspecialchars($data), FILTER_VALIDATE_EMAIL);
        if(!$filter)
            throw new Error('There is an error with this rating.');
            
        return $filter;
    }
    
    public function validateInt($data): bool 
    {
        $filter = filter_var(htmlspecialchars($data), FILTER_VALIDATE_INT);
        if(!$filter)
            throw new Error('There is an error with this rating.');
            
        return $filter;
    }
    
}