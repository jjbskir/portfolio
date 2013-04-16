<?php

namespace controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Silex\Provider\TwigServiceProvider;

/*
 * About page controller
 */
class Contact implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $home = $app['controllers_factory'];

        $home->get('/', function() use ($app)  {
             
            $email      = $app['Admin']->getEmail();
            $phone      = $app['Admin']->getPhoneNumber();
            $address    = $app['Admin']->getAddress();
            
            return $app['twig']->render('contact.view.php', array(  
                'email'     => $email,
                'phone'     => $phone,
                'address'   => $address,   
            ));               
        })
        ->bind('contact');

        return $home;
    }
}

?>
