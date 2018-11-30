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

    public function viewHome(){
        return $this->viewUsersByFollowers();
    }

    public function viewUsersBySphere(){
        $users = User::all();
        $data = [];
        foreach ($users as $user){
           $data[] = ['user' => $user,
               'sphere' => $this->countSphere($user->id)];
        }

        usort($data, 'self::sortBySphere');

        $dashboardView = new DashboardView($data);
        $dashboardView->render('userSphereCount');
    }

    private static function sortBySphere($a, $b){
        $a = $a['sphere'];
        $b = $b['sphere'];

        if ($a == $b) return 0;
        return ($a < $b) ? 1 : -1;
    }

    public function viewUsersByFollowers(){
        $users = User::with('followedBy')->orderBy('followers', 'DESC')->get();

        $dashboardView = new DashboardView($users);
        $dashboardView->render('userFollowersCount');
    }

    public function viewUserFollowers(){
        $userId = $this->request->get['id'];
        if(!empty($userId)){
            $user = User::with('followedBy')->where('id', $userId)->first();

            $dashboardView = new DashboardView($user);
            $dashboardView->render('userFollowers');
        }
    }

    protected function countSphere($user_id, $done = [], $count = 0){
        if(!in_array($user_id, $done)){
            $done[] = $user_id;
            $followed = Follow::where('followee', $user_id)->get();
            if($followed->count() !== 0){
                $count += $followed->count();
                foreach ($followed as $line){
                    return $this->countSphere($line->follower, $done, $count);
                }
            }
        }

        return $count;
    }
}