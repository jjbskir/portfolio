<?php

namespace classes;

/*
 * manages all of the images for the website.
 */
class ImageManagment {
    
    /* root directory for images on local machine. to check if file exists */
    private $directoryLocal;
    
    /* root directory of images on the web. what gets sent to the browser. */
    private $directoryWeb;
    
    /* directory for thumbnails. */
    private $thumbnailLocation = '/thumbnail/';
    
    /* directory of all the images. */
    private $images = '/images/';
    
    /**
     * info on images from db. 
     * for captions. Bridge between directory of images and db of info on images.
     */
    private $imageDb;

    /**
     * constructor
     * @param type $dir, local directory for images in app.
     */
    public function __construct($dir, $dirLocal, $captions) {
        $this->directoryLocal      = $dirLocal;
        $this->directoryWeb        = $this->collectDirectoryWeb($dir);
        $this->imageDb             = $captions;
    }
    
    /**
     * Changes the given directory from bootstrap to a usable
     * web address where the images are located. 
     */
    public function collectDirectoryWeb($_dir) {
        
        $dir = NULL;
        $dirArray = explode('/', $_dir);
        $state = 0;
        
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            foreach($dirArray as $dirValue) {
                if (!empty($dirValue)) {
                    $dir .= '/' . $dirValue; 
                    if ($dirValue == 'public_html') return $dir;
                }
            } 
        }
        // server code.
        else {
    		foreach($dirArray as $dirValue) {
    			if ($state <= 1 && !empty($dirValue)) {
            		$dir .= '/' . $dirValue;
            		$state++;
            	}
    		}
        }
        return $dir;
    }
    
    /**
     * load an array of image descriptions:
     * images => image => location, caption.
     * Takes as input image location and project id.
     */
    public function loadImagesCaptions($imgLocation, $projectId) {
        $imagesCaptions = array();
        $directory = $this->directoryLocal . $imgLocation;
        if (is_dir($directory)) {
            $images = $this->getImagesFromDir($directory);
            foreach ($images as $image) {
                
                $imageDesc = array(); 
                $name = $this->extractImageName($image);
                
                $imageDesc['location'] = $this->directoryWeb . $imgLocation . '/' . $name;
                $imageDesc['caption'] = $this->loadCaption($projectId, $name);
                array_push($imagesCaptions, $imageDesc); 
            }
        }
        return $imagesCaptions; 
    }
    
    /**
     * @param type $projectId, id of project.
     * @param type $name, name of project.
     * @return caption 
     */
    public function loadCaption($projectId, $name) {
        $caption = null;
        foreach ($this->imageDb as $image) {
            if ($image['id'] == $projectId && $image['imageName'] == $name) {
                $caption = $image['caption'];
            }
        }
        return $caption;
    }
    
    
    /**
     * @param type $projects, loads thumbnail images for a list of projects.
     * @return array, an array of all of the images loaded.
     */
    public function loadThumbnailImages($projects) {
        $thumbnails = array();
        foreach ($projects as $project) {
            // get rid of all the white spaces.
            $name = preg_replace('/\s+/', '', $project->getName());
            
            $imageLocal = $this->directoryLocal . $project->getImageLocation() .
                    $this->thumbnailLocation;
            
            $images = $this->getImagesFromDir($imageLocal);
            
            if (count($images) > 0) {
                
                $imageName = $this->extractImageName($images[0]);
                
                $imageWeb = $this->directoryWeb . $project->getImageLocation() . 
                     $this->thumbnailLocation . $imageName;
                
                $thumbnails[$name] = $imageWeb;
            }
            // if the file doesnt exist, give them the default thumbnail.
            else {
                $thumbnails[$name] = $this->directoryWeb . $this->images . 
                        $this->getThumbnailLocation() . 'thumbnail.png';
            }
        }  
        return $thumbnails;
    }
    
    /**
     * Takes the location of an image, and extracts just the image name.
     */
    public function extractImageName($imageLocation) {
        assert('is_string($imageLocation)');
        $imageArray = explode('/', $imageLocation);
        $imageName = end($imageArray);
        assert('is_string($imageName)');
        return $imageName;
    }
    
    public function getImagesFromDir($imageLocation) {
        assert('is_string($imageLocation)');
        $images = glob($imageLocation.'/*.{jpg,gif,png,jpeg,tif,JPG,GIF,PNG,JPEG,TIF}', GLOB_BRACE);
        assert('is_array($images)');
        return $images;
    }
    
    public function getDirectoryWeb() {
        return $this->directoryWeb;
    }

    public function getDirectoryLocal() {
        return $this->directoryLocal . $this->images;
    }
    
    public function getThumbnailLocation() {
        return $this->thumbnailLocation;
    }
    
    public function getImagesLocation() {
        return $this->images;
    }
    
    public function getImageDb() {
        return $this->imageDb;
    }


}

?>
