<?php

namespace controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/*
 * Admin project controller
 */
class AdminProjectPannel implements ControllerProviderInterface 
{
    
    /* @var type, project object. */
    private $project;
    /* name of the project without white spaces. */
    private $name;
    /* success/failure message for forms */
    private $message;


    public function connect(Application $app)
    {
        $home = $app['controllers_factory'];

        $home->match('/', function(Request $request, $project) use ($app)  {
            
            $project            = $app->escape($project); 
            $admin              = new AdminProjectPannel();
            
            if ($app['Projects']->projectExists($project)) {      
                $admin->setProject($app['Projects']->getProject($project));
                $admin->setName($admin->getProject()->getName());
                $imagesDelete = $admin->imagesToDelete($app);                
            }
            else {
                return $app->abort(404);
            }
                        
            $formAddImage = $app['form.factory']->createBuilder('form')
               ->add('caption', 'textarea', array (
                ))
               ->add('FileUpload', 'file', array(
                    'constraints' => array(new Assert\Image())
                ))
               ->getForm();
            
            $formUpdateThumbnail = $app['form.factory']->createBuilder('form')
               ->add('FileUpload', 'file', array(
                    'constraints' => array(new Assert\Image())
                ))
               ->getForm();
            
            $formDeleteImages = $app['form.factory']->createBuilder('form')
               ->add('images', 'choice', array(
                    'choices'   => $imagesDelete,
                    'multiple'  => true,
                    'constraints' => array(new Assert\NotBlank())
                ))
               ->getForm();
            
            $formUpdateDescription = $app['form.factory']->createBuilder('form')
               ->add('description', 'textarea', array(
                    'constraints' => array(new Assert\NotBlank())
                ))
               ->getForm();
            
            $formUpdateExternalLocation = $app['form.factory']->createBuilder('form')
               ->add('externalLocation', 'textarea', array())
               ->getForm();
            
            
            if ($app['request']->isMethod('POST')) try {
                if (isset($_POST['submitAddImage'])) {
                    $admin->addImage($app, $formAddImage);
                }
                else if (isset($_POST['submitChangeThumbnail']))
                    $admin->updateThumbnail($app, $formUpdateThumbnail);
                else if (isset($_POST['submitDeleteImages'])) 
                    $admin->deleteImagesUpdate($app, $formDeleteImages);
                else if (isset($_POST['submitUpdateDescription'])) 
                    $admin->updateDescription($app, $formUpdateDescription);
                else if (isset($_POST['submitUpdateExternalLocation']))
                    $admin->updateExternalLocation($app, $formUpdateExternalLocation);
                else 
                    throw new \Exception('Forms not sumbitted properly.');
            }
            catch (\Exception $e) {
                $admin->setMessage($e->getMessage());
            } 
            
            return $app['twig']->render('AdminProjectPannel.view.php', array(  
                        'projectName'           => $admin->getProject()->getName(),
                        'message'               => $admin->getMessage(),
                        'formAddImage'          => $formAddImage->createView(),
                        'formUpdateThumbnail'   => $formUpdateThumbnail->createView(),
                        'formDeleteImages'      => $formDeleteImages->createView(),
                        'formUpdateDescription' => $formUpdateDescription->createView(),
                        'formUpdateExternalLocation' => $formUpdateExternalLocation->createView(),
                     ));   
        })
        ->bind('adminProject');
        return $home;
    } 

    /** main functions for $_POST. to work with form data. **/

    /**
     * Updates a project from a form.
     */
    public function addImage($_app, $_form) {
        $_form->bind($_app['request']);
        if ($_form->isValid()) {

            $data = $_form->getData(); 
            $imageLocation = $_app['ImageManagment']->getDirectoryLocal() . $this->getName();            
            
            // file uploads both gives the file name and uploads the file.
            $data['imageName']  = $this->fileUpload($imageLocation, $_app, $_form);
            $data['imageId'] = null;
            $data['id'] = $this->getProject()->getId(); 
            $_app['dbPortfolio']->storeCaption($data);
            $this->setMessage('Image Added Successfuly');
            
        }
        else {
            throw new \Exception('Not valid form.');
        }
    }
    
    /**
     * Updates a project from a form.
     */
    public function updateThumbnail($_app, $_form) {
        $_form->bind($_app['request']);
        if ($_form->isValid()) {
            
            $imageLocation = $_app['ImageManagment']->getDirectoryLocal() . $this->getName() 
                    . $_app['ImageManagment']->getThumbnailLocation(); 

            $images = $_app['ImageManagment']->getImagesFromDir($imageLocation);
            $this->deleteImages($images);
            
            $this->fileUpload($imageLocation, $_app, $_form); 
            $this->setMessage('Thumbnail Updated');
            
        }
        else {
            throw new \Exception('Not valid form.');
        }
    }
    
    /**
     * Delete images. 
     */
    public function deleteImagesUpdate($_app, $_form) {
        $_form->bind($_app['request']);
        if ($_form->isValid()) {
            $data = $_form->getData(); 
            
            foreach ($data['images'] as $image) {
                $name = $_app['ImageManagment']->extractImageName($image);
                //if the images have the same name then delete in db
                $_app['dbPortfolio']->removeCaption($name);
            }
            $this->deleteImages($data['images']);
            $this->setMessage('Images Deleted');
        } 
        else {
            throw new \Exception('Not valid form.');
        }
    }
    
    /**
     * Change the description.
     */
    public function updateDescription($_app, $_form) {
        $_form->bind($_app['request']);
        if ($_form->isValid()) {
            $data = $_form->getData(); 
            $data['id'] = $this->getProject()->getId();
            $_app['dbPortfolio']->updateDescription($data);     
            $this->setMessage('Description Uploaded');
        }
        else {
            throw new \Exception('Not valid form.');
        }
    }
    
    /**
     * change the url external location for a project.
     */
    public function updateExternalLocation($_app, $_form) {
        $_form->bind($_app['request']);
        if ($_form->isValid()) {
            $data = $_form->getData(); 
            $data['externalLocation'] = $this->checkExternalLocation($data['externalLocation']);
            $data['id'] = $this->getProject()->getId();
            $_app['dbPortfolio']->updateExternalLocation($data);     
            $this->setMessage('Description Uploaded');
        }
        else {
            throw new \Exception('Not valid form.');
        }
    }


    /**  Helper functions  **/
    
    /**
     * given a url location, do checks on it. 
     * returns corrected url address.
     */
    public function checkExternalLocation($location) {
        // if they did not submit an adress, give a predefined one.
        if (!isset($location)) {
            return '#';  
        }
        // check the address entered has http at start. if it doesn't add it to the start pf the address.
        else if (!parse_url($location, PHP_URL_SCHEME)) {
            $location = 'http://' . $location;
        }     
        // check the address is a valid url.
        if (!filter_var($location, FILTER_VALIDATE_URL)) {
            throw new \Exception('Not valid URL.');
        }
        return $location;
    }
    
    /**
     * uploads a file to file $location.
     */
    public function fileUpload($location, $_app, $_form) {
            $files = $_app['request']->files->get($_form->getName());
            $filename = $files['FileUpload']->getClientOriginalName();
            $files['FileUpload']->move($location, $filename);
            return $filename;
    }
    
    /**
     * @param type $images, array of images with their full paths.
     * Deletes all of the images.
     */
    public function deleteImages($images) {
        assert('is_array($images)');
        if (count($images) > 0) foreach ($images as $image) {
            if (!unlink($image)) {
                throw new \Exception('Could not delete previous thumbnail');
            }
        }
    }
    
    /**
     * @return type, returns a array mapping image name => image location.
     * used for knowing which images are to be deleted in form.
     */
    public function imagesToDelete($_app) {
        $imagesForForm = array();
        $imageLocation = $_app['ImageManagment']->getDirectoryLocal() . $this->getName();
        $images = $_app['ImageManagment']->getImagesFromDir($imageLocation);
        foreach ($images as $image) {
            $name = $_app['ImageManagment']->extractImageName($image);
            $imagesForForm[$image] = $name;
        }
        return $imagesForForm;
    }

    /**
     * @param $string, string to get rid of spaces.
     * get rid of all the white spaces.
     */
    public function stripWhiteSpaces($string) {                   
        $stringFinal = preg_replace('/\s+/', '', $string);
        return $stringFinal;
    }
    
    /** setters and getters **/
    
    /**
     * @param type $object, to set project with.
     */
    public function setProject($object) {
        assert('is_object($object)');
        $this->project = $object;
    }
    
    public function getProject() {
        return $this->project;
    }
    
    public function setName($name) {
        assert('is_string($name)');
        $this->name = $this->stripWhiteSpaces($name);
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setMessage($msg) {
        assert('is_string($msg)');
        $this->message = $msg;
    }
    
    public function getMessage() {
        return $this->message;
    }


}

?>
