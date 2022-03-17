<?php

require_once './controller/AbstractController.php';

class UserController extends AbstractController
{
    
    public function displayAccount() 
    {
        $this->displayTwig('account');
    }
}