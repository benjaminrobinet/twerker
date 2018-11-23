<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 21/11/2018
 * Time: 12:11
 */

namespace twerkerapp\controller;


use bfforever\controller\AbstractController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use twerkerapp\model\Follow;
use twerkerapp\model\User;
use twerkerapp\view\DashboardView;
use twerkerapp\view\TweeterView;

class DashboardController extends AbstractController
{
    protected $sphere = 0;

    public function __construct(){
        parent::__construct();

        TweeterView::addStyleSheet('assets/css/default.css');
        TweeterView::setAppTitle('Twerker - Dashboard');
    }

    public function viewSphere(){
        $userId = 2;
        $this->countSphere($userId);

        $dashboardView = new DashboardView();
        $dashboardView->render('sphere');
    }

    public function viewUsersByFollowers(){
        $users = User::with('followedBy')->orderBy('followers', 'DESC')->get();

        $dashboardView = new DashboardView($users);
        $dashboardView->render('home');
    }

    protected function countSphere($user_id, $done = []){
        if(!in_array($user_id, $done)){
            $done[] = $user_id;
            $followed = Follow::where('followee', $user_id)->get();
            if($followed->count() !== 0){
                $this->sphere += $followed->count();
                foreach ($followed as $line){
                    return $this->countSphere($line->follower, $done);
                }
            }
        }
    }
}