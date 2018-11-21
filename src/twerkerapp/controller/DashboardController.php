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

class DashboardController extends AbstractController
{
    public function __construct(){
        parent::__construct();

        TweeterView::addStyleSheet('assets/css/default.css');
        TweeterView::setAppTitle('Twerker');
    }

    public function viewSphere(){
        $userId = 2;

        $search = true;
    }
}