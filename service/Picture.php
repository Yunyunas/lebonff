<?php

class Picture {
    
    const MAXSIZE = 4000000;
    
    const EXTENSIONS = ['jpg', 'png', 'jpeg'];

    public function addPicture($files, $folder) 
    {
        $tabExtension = explode('.', $files['name']);
        $extension = strtolower(end($tabExtension));
        
        if(in_array($extension, self::EXTENSIONS) && $files['size'] <= self::MAXSIZE && $files['error'] == 0){
            $uniqueName = uniqid('', true);
            $file = $uniqueName.".".$extension;
            
            move_uploaded_file($files['tmp_name'], './public/img/'.$folder.'/'.$file);
            
            return $file;

        } else {
            return false;
        }
    }
    
    
    public function deletePicture($currentPicture, $folder): bool 
    {
        if (file_exists('./public/img/'.$folder.'/'.$currentPicture)) {
            unlink('./public/img/'.$folder.'/' . $currentPicture);
            return true;
        } else {
                return false;
        }   
    }
    
}