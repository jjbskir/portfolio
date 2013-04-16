<?php

namespace controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

/*
 * project controller
 */
class Portfolio implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $portfolio = $app['controllers_factory'];
        
        $portfolio->get('/', function() use($app) {
            
            $projects            = $app['Projects']->getProjectsByType();
            $projectNames        = $app['Projects']->getProjects();
            
            $images              = $app['ImageManagment']->loadThumbnailImages($projectNames);
            
            if (!isset($projects) && !isset($adminFirstName)) {
                return $app->abort(404);
            }
            
            return $app['twig']->render('portfolio.view.php', array(
                        'projects'          => $projects,
                        'images'            => $images
            )); 
            
        })
        ->bind('portfolio');

        return $portfolio;
    }
}

?>
