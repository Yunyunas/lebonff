<?php 

class Admin {
    
    public function isAdmin() 
    {
        if (!empty($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            if ($user->getRole() === 'admin') {
                return true;
            } 
        }
        
        return false;
    }
}