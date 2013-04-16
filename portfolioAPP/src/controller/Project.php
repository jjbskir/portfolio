<?php

namespace controller;

use Silex\Application;
use Silex\ControllerProviderInterface;

/*
 * project controller
 */
class Project implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];

        $controller->get('/', function($project) use($app) {
            
            $project            = $app->escape($project);
           
            if ($app['Projects']->projectExists($project)) {                
                $projectObject      = $app['Projects']->getProject($project);               
                $imageCaptions      = $app['ImageManagment']->loadImagesCaptions(
                        $projectObject->getImageLocation(), $projectObject->getId());
            }
            else {
                return $app->abort(404);
            }                      
            
            return $app['twig']->render('project.view.php', array(
                    'project'           => $projectObject,
                    'images'            => $imageCaptions,
                 ));
        })
        ->bind('project');

        return $controller;
    }
}

?>
