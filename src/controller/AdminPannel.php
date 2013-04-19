<?php

namespace controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use model\entities\Project;

/*
 * Admin controller
 */
class AdminPannel implements ControllerProviderInterface 
{
    /* success/failure message for forms */
    private $message;

    public function connect(Application $app)
    {
        $home = $app['controllers_factory'];

        $home->match('/', function(Request $request) use ($app)  {
            
            $projects           = $app['Projects']->getProjects();
            $AdminPannel        = new AdminPannel();
            $types              = $app['Types']->getMapIdType();
            $typesKey           = $app['Types']->getTypesKey();           
            
            $form = $app['form.factory']->createBuilder('form')
               ->add('name', 'text', array(
                    'constraints' => array(new Assert\NotBlank())
                ))
               ->add('type', 'choice', array(
                    'choices' => $types,
                    'constraints' => new Assert\Choice($typesKey),
                ))
			   ->add('externalLocation', 'text', array())
               ->add('description', 'textarea', array(
                    'constraints' => array(new Assert\NotBlank())
                ))
               ->getForm();
            
            $formDeleteProjects = $app['form.factory']->createBuilder('form')
                ->add('projects', 'choice', array(
                    'choices' => $app['Projects']->getNameNameMap(),
                    'multiple'  => true,
                    'constraints' => new Assert\NotBlank(),
                ))
                ->getForm();               
                    
            $formType = $app['form.factory']->createBuilder('form')
               ->add('type', 'text', array(
                    'constraints' => array(new Assert\NotBlank())
                ))
               ->getForm();
            
            $formUpdateShortAbout = $app['form.factory']->createBuilder('form')
               ->add('about', 'textarea', array(
                    'constraints' => array(new Assert\NotBlank())
                ))
               ->getForm();
               
            if ($request->isMethod('POST')) try {
                if (isset($_POST['submitProject'])) {
                    $AdminPannel->formPostProject($app, $form);
                    return $app->redirect($request->getRequestUri());
                }
                else if (isset($_POST['submitProjectType'])) {
                    $AdminPannel->formPostProjectType($app, $formType);
                    return $app->redirect($request->getRequestUri());
                }
                else if (isset($_POST['submitDeleteProjects'])) {
                    $AdminPannel->deleteProjects($app, $formDeleteProjects);
                    return $app->redirect($request->getRequestUri());
                }
                else if (isset($_POST['submitUpdateShortAbout'])) {
                    $AdminPannel->updateShortAbout($app, $formUpdateShortAbout);
                }
                else {
                    throw new \Exception('Form not sumbitted properly.');
                }
            }
            catch (\Exception $e) {
                $AdminPannel->setMessage($e->getMessage());
            } 
               
            
            return $app['twig']->render('AdminPannel.view.php', array(  
                        'projects'          => $projects,
                        'message'           => $AdminPannel->getMessage(),
                        'form'              => $form->createView(),
                        'formDeleteProjects'=> $formDeleteProjects->createView(),
                        'formUpdateShortAbout' => $formUpdateShortAbout->createView(),
                        'formType'          => $formType->createView(),
                     ));          
        })
        ->bind('admin');

        return $home;
    }
    
    /** main functions for $_POST. to work with form data. **/
    
    /**
     * creates a new project from form data.
     */
    public function formPostProject($_app, $_form) {  
        $_form->bind($_app['request']);
        if ($_form->isValid()) {
            $data = $_form->getData(); 
            $name = $this->stripWhiteSpaces($data['name']);
            
            $imageLocation = $_app['ImageManagment']->getDirectoryLocal() . $name;
            $imageThumbnailLocation = $imageLocation . '/' . $_app['ImageManagment']->getThumbnailLocation();
            $this->makeDirectory($imageLocation);
            $this->makeDirectory($imageThumbnailLocation);
            
            $data['id'] = NULL;
            $data['dateCreated'] = '2012-11-20 00:00:00';
            $data['imageLocation'] = $_app['ImageManagment']->getImagesLocation() . $name;
            $data['externalLocation'] = $this->checkExternalLocation($data['externalLocation']);
            $project = new Project($data);
            $project->storeProject($_app['dbPortfolio']);
            $this->setMessage('Field Updated');
        }
        else {
            throw new \Exception('Not valid form.');
        }
    }
    
    /**
     * Creates a new project type category from a form.
     */
    public function formPostProjectType($_app, $_form) {  
        $_form->bind($_app['request']);
        if ($_form->isValid()) {
            $data = $_form->getData(); 
            $data['id'] = NULL;
            $_app['dbPortfolio']->storeType($data);
            $this->setMessage('Field Updated');
        }
        else {
            throw new \Exception('Not valid form.');
        }  
    }
    
    /**
     * deltes projects.
     */
    public function deleteProjects($_app, $_form) {
        $_form->bind($_app['request']);
        if ($_form->isValid()) {
            $data = $_form->getData();
            foreach ($data['projects'] as $projectName) {
                $project = $_app['Projects']->getProject($projectName);
                $id = $project->getId();
                
                $imageLocation = $_app['ImageManagment']->getDirectoryLocal() . $this->stripWhiteSpaces($project->getName());
                $this->deleteDir($imageLocation);
                
                $_app['dbPortfolio']->deleteProject($id);
                $this->setMessage('Field Updated');
            }
        }
        else {
            throw new \Exception('Not valid form.');
        }
    }
    
    public function updateShortAbout($_app, $_form) {
        $_form->bind($_app['request']);
        if ($_form->isValid()) {
            $data = $_form->getData();
            $data['id'] = $_app['Admin']->getId();
            $_app['dbPortfolio']->updateShortAbout($data);
            $this->setMessage('Field Updated');
        }
        else {
            throw new \Exception('Not valid form.');
        }
    }


    /** helper functions **/
    
    
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
     * makes a directory with given location.
     * Change chmod() for production code so not everyone can access.
     */
    public function makeDirectory($location) {
        if (is_dir($location)) {
            throw new \Exception('Directory allready exists.');
        }
        else if (!mkdir($location, 0777)) {
            throw new \Exception('Could not make directory.');
        }
        chmod($location, 0777);
    }
    
    /**
     * delete directory at given location and all of its content.
     */
    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new \Exception('Directory does not exist.');
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
    
    
    /**
     * @param $string, string to get rid of spaces.
     * get rid of all the white spaces.
     */
    public function stripWhiteSpaces($string) {                   
        $stringFinal = preg_replace('/\s+/', '', $string);
        return $stringFinal;
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
