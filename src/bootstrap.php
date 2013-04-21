<?php

/*
 * bootstrap app with all of its classes.
 * change image managment for production
 */

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\FormServiceProvider;
use model\dbPortfolio;
use model\EntitiesData;
use model\entities\Admin;
use model\entities\Projects;
use model\entities\Types;
use model\entities\SkillTypes;
use model\entities\Skills;
use classes\ImageManagment;
use classes\UserProvider;
use classes\AssetManagment;

$app = new Silex\Application();

$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallback'           => 'en'
));

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->register(new DoctrineServiceProvider(), array(
    'db.options' => require_once __DIR__.'/../config/db.php',
));

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/development.log',
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new FormServiceProvider());

$app->register(new SecurityServiceProvider());
$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/admin',
        'form' => array('login_path' => '/login', 
                        'check_path' => '/admin/login_check'),
        'logout' => array('logout_path' => '/admin/logout'),
        'users' => $app->share(function () use ($app) {
            return new UserProvider($app['Admin']);
        }),
    ),
);

$app['dbPortfolio'] = $app->share(function() use ($app) {
    return new dbPortfolio($app['db']);
});

$app['EntitiesData'] = $app->share(function() use ($app) {
    return new EntitiesData($app['db']);
});

$app['Admin'] = $app->share(function() use ($app) {
    return new Admin( $app['EntitiesData']->getAdmin() );
});

$app['Projects'] = $app->share(function() use ($app) {
    return new Projects( $app['EntitiesData']->getProjects() );
});

$app['Types'] = $app->share(function() use ($app) {
    return new Types( $app['EntitiesData']->getTypes() );
});

$app['SkillTypes'] = $app->share(function() use ($app) {
    return new SkillTypes( $app['EntitiesData']->getSkillTypes() );
});

$app['Skills'] = $app->share(function() use ($app) {
    return new Skills( $app['EntitiesData']->getSkills(), $app['SkillTypes'] );
});

$app['AssetManagment'] = $app->share(function() use ($app) {
    return new AssetManagment();
});

/*
 * need to change $dir for production site.
 */
$app['ImageManagment'] = $app->share(function() use ($app) {
    # local directory on computer where images are.
    $dirLocal = preg_replace('/src/', 'public_html', __DIR__);
    $dirWeb = $_SERVER['PHP_SELF'];
    return new ImageManagment($dirWeb, $dirLocal, $app['EntitiesData']->getCaptions());
});

return $app;

?>
