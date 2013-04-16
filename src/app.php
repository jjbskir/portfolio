<?php

use Symfony\Component\HttpFoundation\Response;

/*
 * app
 */
$app = require_once __DIR__.'/bootstrap.php';


/*
 * turn on debugging.
 * turn off for production though.
 */
$app['debug'] = true;


/*
 * declare global variables to be used in twig templates.
 */
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $twig->addGlobal('assets', $app['AssetManagment']->getAssetsLocation() );
    $twig->addGlobal('name', $app['Admin']->getFirstName() . ' ' . $app['Admin']->getLastName());
    return $twig;
}));


/*
 * controllers.
 */
$app->mount('/', new controller\Home());

$app->mount('/login', new controller\Login());

$app->mount('/admin', new controller\AdminPannel());

$app->mount('/admin/personal', new controller\AdminPersonal());

$app->mount('/admin/{project}', new controller\AdminProjectPannel());

$app->mount('/portfolio', new controller\Portfolio());

$app->mount('/portfolio/{project}', new controller\Project());

$app->mount('/about', new controller\About());

$app->mount('/contact', new controller\Contact());


/*
 * error handling.
 */
$app->error(function (\Exception $e, $code) {
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found ' . $code . $e;
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.' . $code . $e;
    }

    return new Response($message);
});


return $app;

?>
