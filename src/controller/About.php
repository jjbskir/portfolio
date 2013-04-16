<?php

namespace controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Silex\Provider\TwigServiceProvider;

/*
 * About page controller
 */
class About implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $home = $app['controllers_factory'];

        $home->get('/', function() use ($app)  {
             
            $about    = $app['Admin']->getAbout();
            
            return $app['twig']->render('about.view.php', array(  
                'about'   => $about,             
            ));               
        })
        ->bind('about');
        return $home;
    }
}

?>
