<?php

namespace controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

/*
 * Admin controller
 */
class Login implements ControllerProviderInterface 
{
    
    public function connect(Application $app)
    {
        $home = $app['controllers_factory'];

        $home->get('/', function(Request $request) use ($app)  {
                        
            $token = $app['security']->getToken(); 
            
            if (null !== $token) {
                $user = $token->getUser();
                echo $user;
            }
            
            return $app['twig']->render('login.view.php', array(
                 'error'         => $app['security.last_error']($request),
                 'last_username' => $app['session']->get('_security.last_username'),
            ));

                
        })
        ->bind('login');

        return $home;
    }
    
}
?>
