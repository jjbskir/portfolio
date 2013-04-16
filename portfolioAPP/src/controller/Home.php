<?php

namespace controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Silex\Provider\TwigServiceProvider;

/*
 * Home page controller
 */
class Home implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $home = $app['controllers_factory'];

        $home->get('/', function() use ($app)  {
             
            $adminShortAbout    = $app['Admin']->getShortAbout();
             
            $projects = $app['Projects']->getTopProjects(12);           
            
            $images = $app['ImageManagment']->loadThumbnailImages($projects);
            
            if (!isset($projects) && !isset($adminFirstName)) {
                return $app->abort(404);
            }
            
            return $app['twig']->render('home.view.php', array(  
                        'adminShortAbout'   => $adminShortAbout,     
                        'projects'          => $projects,
                        'images'            => $images,
                     ));               
        })
        ->bind('home');

        return $home;
    }
}

?>
