<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator AS v;

class AuthController extends Controller
{
    
    //RENDER SIGNIP>TWIG VIEW
    public function getSignIn($request, $response)
    {
        return $this->view->render($response, 'auth/signin.twig');
    }
    
    //WHATS GOING TO HAPPEN WHEN WE SUBMIT THE FORM (POST SIGN IN)
    public function postSignIn($request, $response)
    {
        
        //PARAMS NEEDED $REQUST FROM SLIM AND THE ARRAY OF RULES
        $validation = $this->validator->validate($request, array(
            //KEY IS DEPENDED ON THE NAME VALUES FROM THE FORM
          'identification' => v::notEmpty(),
          'password'       => v::noWhitespace()->notEmpty()->stringType()->length(6, null)
        ));
        
        //CHECK IF VALIDATION PASSES
        if ($validation->failed()) {
            
            return $response->withRedirect($this->router->pathFor('auth.signin'));
            
        }
        
        //ATTEMPTS TO AUTHENTICATE THE USER
        $auth = $this->auth->attempt(
          $request->getParam('identification'),
          $request->getParam('password')
        
        );
        
        //FAILES AUTHENTICATION
        if (!$auth) {
            $this->flash->addMessage('error', 'Please try again could not sign in.');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }
        
        //SUCCESS LOGIN
        $this->flash->addMessage('success', 'You are now signed in.');
        return $response->withRedirect($this->router->pathFor('home'));
        
    }
    
    //RENDER SIGNUP>TWIG VIEW
    public function getSignUp($request, $response)
    {
        return $this->view->render($response, 'auth/signup.twig');
    }
    
    //WHATS GOING TO HAPPEN WHEN WE SUBMIT THE FORM (POST SIGN UP)
    
    /**
     * @param $request
     * @param $response
     * @return mixed
     */
    public function postSignUp($request, $response)
    {
        
        //PARAMS NEEDED $REQUST FROM SLIM AND THE ARRAY OF RULES
        $validation = $this->validator->validate($request, array(
            //KEY IS ORDER DEPENDED ON THE NAME VALUES FROM THE FORM
          'first_name'         => v::alpha(),
          'surname'            => v::alpha(),
          'email'              => v::email()->noWhitespace()->notEmpty()->EmailAvailable(),
          'username'           => v::notEmpty()->noWhitespace()->alnum()->UsernameAvailable(),
          'password'           => v::noWhitespace()->notEmpty()->stringType()->length(6, null),
          'confirmed_password' => v::equals($request->getParam('password'))->notEmpty()
        
        ));
        
        //CHECK IF IT PASSES VALIDATION
        if ($validation->failed()) {
            
            return $response->withRedirect($this->router->pathFor('auth.signup'));
            
        }
        
        //SECURITY KEY SALT
        $identifier = $this->randomlib->generateString(128,
          '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        
        
        //CREATES THE USER
        $user = User::create(array(
            //getParams RETURNS WHOLE POST ARRAY getParam RETURNS ENTITY
          'username'    => $request->getParam('username'),
          'first_name'  => $request->getParam('first_name'),
          'last_name'   => $request->getParam('surname'),
          'email'       => $request->getParam('email'),
          'password'    => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
          'active_hash' => $identifier
        ));
        
        
        //SENDS ACTIVATION EMAIL
        $this->mailer->send('email/registered.twig', array('user' => $user, 'identifier' => $identifier),
          function ($message) use ($user) {
              $message->to($user->email);
              $message->subject('Activate Your Account');
              $message->from('No-Reply@frostweb.co.za');
              
          });
        
        //REDIRECT TO HOME
        //this->router WE ACCESS THE CONTAINER PASSED IN THE APP SECTION "home" is the setName GIVEN IN ROUTES FILE
        return $response->withRedirect($this->router->pathFor('home'));
        
    }
    
    //SIGNS THE USER OUT
    public function getLogout($request, $response)
    {
        
        $this->auth->logout();
        
        return $response->withRedirect($this->router->pathFor('home'));
        
    }
    
    //ACTIVATE THE ACCOUNT
    public function getActivateAccount($request, $response)
    {
        //GET THE PARAMETERS
        $email = $request->getParam('email');
        $identifier = $request->getParam('identifier');
        
        
        $successActivation = $this->auth->activate($email, $identifier);
        
        
        if ($successActivation != true) {
            $this->flash->addMessage('error',
              'Please contact general support as we failed to activiate you at this time.');
            return $response->withRedirect($this->router->pathFor('contact'));
        }
        
        $this->flash->addMessage('success', 'Your Account is now activated you can now login.');
        return $response->withRedirect($this->router->pathFor('home'));
        
    }
    
}