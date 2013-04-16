<?php

namespace controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class AdminPersonal implements ControllerProviderInterface 
{
    /* success/failure message for forms */
    private $message;

    public function connect(Application $app)
    {
        $home = $app['controllers_factory'];

        $home->match('/', function(Request $request) use ($app)  {
            
            $Admin = new AdminPersonal();
            
            /*
             * add hidden field info for description of form.
             */
            $formUpdateAbout = $app['form.factory']->createBuilder('form')
               ->add('hidden', 'hidden', array(
                    'data' => 'update about',
               ))
               ->add('description', 'textarea', array(
                    'constraints' => array(new Assert\NotBlank())
                ))
               ->getForm();
            
            $formUpdateName = $app['form.factory']->createBuilder('form')
               ->add('hidden', 'hidden', array(
                    'data' => 'update name',
               ))
               ->add('firstName', 'text', array(
                    'constraints' => array(new Assert\NotBlank())
                ))
               ->add('lastName', 'text', array(
                    'constraints' => array(new Assert\NotBlank())
                ))
               ->getForm();
            
            $formUpdateUsername = $app['form.factory']->createBuilder('form')
               ->add('hidden', 'hidden', array(
                    'data' => 'update username',
               ))
               ->add('username', 'text', array(
                    'constraints' => array(new Assert\NotBlank())
                ))
               ->getForm();
            
            $formUpdatePassword = $app['form.factory']->createBuilder('form')
               ->add('hidden', 'hidden', array(
                    'data' => 'update password',
               ))
               ->add('password', 'text', array(
                    'constraints' => array(new Assert\NotBlank())
                ))
               ->getForm();
                        
            $formUpdateContact = $app['form.factory']->createBuilder('form')
               ->add('hidden', 'hidden', array(
                    'data' => 'update contact',
               ))
               ->add('email', 'email', array(
                    'constraints' => array(new Assert\Email())
                ))
               ->add('phoneNumber', 'text', array(
                    'constraints' => array(new Assert\NotBlank())
                ))
               ->add('address', 'text', array(
                    'constraints' => array(new Assert\NotBlank())
                ))               
               ->getForm();
            
            
           if ($app['request']->isMethod('POST')) try {
                if (isset($_POST['submitUpdateAbout']))     
                    $Admin->formUpdate($app, $formUpdateAbout);
                else if (isset($_POST['submitUpdateName'])) 
                    $Admin->formUpdate($app, $formUpdateName);
                else if (isset($_POST['submitUpdateContact'])) 
                    $Admin->formUpdate($app, $formUpdateContact);
                else if (isset($_POST['submitUpdateUsername']))
                    $Admin->formUpdate($app, $formUpdateUsername);
                else if (isset($_POST['submitUpdatePassword']))
                    $Admin->formUpdate($app, $formUpdatePassword);
                else                                        
                    throw new \Exception('Forms not sumbitted properly.');
            }
            catch (\Exception $e) {
                $Admin->setMessage($e->getMessage());
            } 
            
            return $app['twig']->render('AdminPersonal.view.php', array( 
                'message'               => $Admin->getMessage(),
                'formUpdateAbout'       => $formUpdateAbout->createView(),
                'formUpdateName'        => $formUpdateName->createView(),
                'formUpdateContact'     => $formUpdateContact->createView(),
                'formUpdateUsername'    => $formUpdateUsername->createView(),
                'formUpdatePassword'    => $formUpdatePassword->createView(),
            ));   
        })
        ->bind('adminPersonal');
        return $home;
    } 
    
    /**
     * Updates form for variable specified in the form. 
     */
    public function formUpdate($_app, $_form) {
        $_form->bind($_app['request']);
        if ($_form->isValid()) {
            $data = $_form->getData();
            $data['id'] = $_app['Admin']->getId();
            $funcName = $this->creatFunctionName($data['hidden']);
            if (method_exists($this, $funcName)) {
                    $data = call_user_func(array($this, $funcName), $data, $_app);
            }
            call_user_func(array($_app['dbPortfolio'], $funcName), $data);
            $this->setMessage($data['hidden']);
        }
        else {
            throw new \Exception('Not valid form.');
        }
    }
    
    /**
     * Takes the hidden variable $data['hidden'] from the form and changes
     * it to a useable function name to be used in the database update.
     */
    public function creatFunctionName($name) {
        assert('is_string($name)');
        $nameArray = explode(' ', $name);
        $nameFunc = '';
        $counter = 0;
        foreach ($nameArray as $word) {
            if ($counter > 0) {
                $word = trim($word);
                $word = ucfirst($word);
                $nameFunc .= $word;
            }
            else $nameFunc .= $word;
        }
        return $nameFunc;
    }
    
    public function updatePassword($arrayValues, $_app) { 
        $arrayValues['password'] = $_app['security.encoder.digest']->encodePassword($arrayValues['password'], '');
        return $arrayValues;
    }

    public function setMessage($message) {
        assert('is_string($message)');
        $this->message = $message;
    }
    
    public function getMessage() {
        return $this->message;
    }

}
        
?>
