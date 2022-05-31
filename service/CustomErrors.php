<?php

class CustomErrors {
    
    private int $code;
    
    private string $customCode;
    
    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }
    
     /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }
    
    /**
     * @return string
     */
    public function getCustomCode(): string
    {
        return $this->customCode;
    }
    
     /**
     * @param string $customCode
     */
    public function setCustomCode(string $customCode): void
    {
        $this->customCode = $customCode;
    }
    
    /**
     * @return string
     */
    public function customMessage(): string
    {
        switch ($this->customCode) {
            case "pictureError":
                $message = "La taille de l'image est trop grande ou son extension n'est pas valide.";
                break;
            
            case "formRequiredError":
                $message = "Veuillez remplir tous les champs du formulaire.";
                break;
                
            case "adminCategoryDelete":
                $message = "Une erreur est survenue lors de la suppression de la catégorie. Avez-vous vérifié que la catégorie 
                                ne possédait pas d'annonces avant de la supprimer ?";
                break;
            
            case "favouriteError":
                $message = "Cette annonce est déjà dans vos coups de coeur.";
                break;
                
            case "loginError":
                $message = "Adresse email ou mot de passe incorrect.";
                break;
            
                            
            case "passwordError":
                $message = "Le mot de passe doit comporter 6 caractères minimum.";
                break;
            
            case "deleteAccountError":
                $message = "Une erreur est survenue lors de la suppression du compte.";
                break;
            
            default:
                $message = "Une erreur est survenue, veuillez contacter l'assistance.";
                break;
        }
        
        return $message;
    }
    
    /**
     * @return string
     */
    public function createMessage(): string
    {
        
        switch($this->code) {
            
            case "200":
                // $message = $this->customMessage();
                $message = "Requête traitée avec succès. La réponse dépendra de la méthode de requête utilisée. ";
                break;
            
            case "201":
                $message = "Created : requête traitée avec succès et création d’un document. ";
                break;
                
            case "400":
                $message = $this->customMessage();
                break;
            
            case "401":
                $message = "Veuillez vous connecter pour accéder à votre compte.";
                break;
            
            case "403":
                $message = "Vous n'avez pas les droits pour accéder à cette page.";
                break;
            
            case "404":
                $message = "La page que vous avez demandé est introuvable";
                break;

            default:
                $message = "Une erreur est survenue, veuillez contacter l'assistance.";
                break;
        }
        
        return $message;
    }
}