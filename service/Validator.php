<?php

class Validator {
    

    public function validateEmail($data): bool
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
    
    
    // Modifier la class Validator voir la supprimer ? En parler comme idée mais ne pas l'utiliser (?)
    // Sinon faire comme pour la class picture, à ma manière
}