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
use twerkerapp\view\TweeterView;

class DashboardController extends AbstractController
{
    protected $sphere = 0;

    public function __construct(){
        parent::__construct();

        TweeterView::addStyleSheet('assets/css/default.css');
        TweeterView::setAppTitle('Twerker');
    }

    public function viewSphere(){
        $userId = 2;

        $this->countSphere($userId);
        echo '<pre>';
        var_dump($this->sphere);
        echo '</pre>';
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