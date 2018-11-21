<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 21/11/2018
 * Time: 12:11
 */

namespace twerkerapp\controller;


use bfforever\auth\Authentication;
use bfforever\auth\AuthenticationException;
use bfforever\controller\AbstractController;
use bfforever\router\Router;
use bfforever\utils\HttpRequest;
use twerkerapp\auth\TweeterAuthentication;
use twerkerapp\view\TweeterView;

class TweeterAdminController extends AbstractController
{
    public function __construct(){
        parent::__construct();

        TweeterView::addStyleSheet('assets/css/default.css');
        TweeterView::setAppTitle('Twerker');
    }

    public function viewLogin(){
        $tweeterView = new TweeterView();
        $tweeterView->render('login');
    }

    public function viewSignup(){
        $tweeterView = new TweeterView();
        $tweeterView->render('signup');
    }

    public function checkSignup(){
        $request = new HttpRequest();
        $post = $request->post;

        $authentication = new TweeterAuthentication();
        $errors = [];

        if(!empty($post['username']) && !empty($post['password']) && !empty($post['fullname']) && !empty($post['password_confirm'])){
            try {
                if($post['password'] === $post['password_confirm']){
                    $authentication->createUser($post['username'], $post['password'], $post['fullname']);
                    $authentication->loginUser($post['username'], $post['password']);
                    $router = new Router();
                    header('Location: ' . $router->urlFor('home'));
                } else {
                    $errors[] = 'Passwords mismatch';
                }
            } catch (AuthenticationException $e) {
                $errors[] = $e->getMessage();
            }
        } else {
            $errors[] = 'Verifiez le formulaire.';
        }
        if(!empty($errors)){
            $tweeterView = new TweeterView(['errors' => $errors]);
            $tweeterView->render('signup');
        }
    }

    public function makeLogout(){
        $authentication = new TweeterAuthentication();

        $router = new Router();

        $authentication->logout();
        header('Location: ' . $router->urlFor('home'));
    }

    public function checkLogin(){
        $request = new HttpRequest();
        $post = $request->post;

        $authentication = new TweeterAuthentication();
        $errors = [];

        if(!empty($post['username']) && !empty($post['password'])){
            try {
                $authentication->loginUser($post['username'], $post['password']);
                $router = new Router();
                header('Location: ' . $router->urlFor('me'));
            } catch (AuthenticationException $e) {
                $errors[] = $e->getMessage();
            }
        } else {
            $errors[] = 'Verifiez le formulaire.';
        }
        if(!empty($errors)){
            $tweeterView = new TweeterView(['errors' => $errors]);
            $tweeterView->render('login');
        }
    }
}