<?php

namespace classes;

class AssetManagment {
    
    public function __construct() {  
    } 
    
    public function getAssetsLocation() {
        
    	/* List of assets that are easy to find without weird url's. */
     	$assetsEasy = array(
            'about', 'admin', 'contact', 'login', 'portfolio', 'index.php'
     	);
     	
        /* last part of url after final / */
        $urlEnding = basename($_SERVER['REQUEST_URI']); 
        $assetLocation = NULL;
		
	if ($urlEnding == '') $assetLocation = 'index.php';
        else if (!in_array($urlEnding, $assetsEasy) && !strstr($_SERVER['PHP_SELF'], 'admin')) $assetLocation = 'project';
        else if (!in_array($urlEnding, $assetsEasy) && strstr($_SERVER['PHP_SELF'], 'admin')) $assetLocation = 'adminProject';  
        else $assetLocation = $urlEnding;
        
        return $assetLocation;
    }
    
}

?>
