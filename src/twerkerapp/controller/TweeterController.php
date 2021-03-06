<?php

namespace twerkerapp\controller;

/* Classe TweeterController :
 *
 * Réalise les algorithmes des fonctionnalitÃé suivantes:
 *
 *  - afficher la liste des Tweets
 *  - afficher un Tweet
 *  - afficher les tweet d'un utilisateur
 *  - afficher la le formulaire pour poster un Tweet
 *  - afficher la liste des utilisateurs suivis
 *  - Ã©valuer un Tweet
 *  - suivre un utilisateur
 *
 */

use bfforever\auth\Authentication;
use bfforever\controller\AbstractController;
use bfforever\router\Router;
use Illuminate\Support\Facades\Auth;
use twerkerapp\auth\TweeterAuthentication;
use twerkerapp\model\Follow;
use twerkerapp\model\Like;
use twerkerapp\model\Tweet;
use twerkerapp\model\User;
use twerkerapp\view\TweeterView;

class TweeterController extends AbstractController {

    public function __construct(){
        parent::__construct();

        TweeterView::addStyleSheet('assets/css/default.css');
        TweeterView::setAppTitle('Twerker');
    }

    public function viewHome(){
        $tweets = Tweet::with('user')->orderBy('created_at', 'DESC')->get();
        $tweeterView = new TweeterView($tweets);
        $tweeterView->render('home');
    }

    public function viewTweet(){

        /* Algorithme :
         *
         *  1 L'identifiant du Tweet en question est passé en paramètre (id)
         *      d'une requête GET
         *  2 Récupérer le Tweet depuis le modèle Tweet
         *  3 Afficher toutes les informations du tweet
         *      (text, auteur, date, score)
         *  4 Retourner un block HTML qui met en forme le Tweet
         *
         *  Erreurs possibles : (*** à implanter ultérieurement ***)
         *    - pas de paramètre dans la requête
         *    - le paramètre passé ne correspond pas a un identifiant existant
         *    - le paramètre passé n'est pas un entier
         *
         */

        $tweetId = $this->request->get['id'];

        $tweet = Tweet::with('user')->find($tweetId);
        if(!empty($tweet)){
            $tweeterView = new TweeterView($tweet);
            $tweeterView->render('tweet');
        } else {
            $this->forward('ErrorController', 'notFound');
        }
    }

    public function viewUserTweets(){
        /*
         *
         *  1 L'identifiant de l'utilisateur en question est passé en
         *      paramètre (id) d'une requête GET
         *  2 Récupérer l'utilisateur et ses Tweets depuis le modèle
         *      Tweet et User
         *  3 Afficher les informations de l'utilisateur
         *      (non, login, nombre de suiveurs)
         *  4 Afficher ses Tweets (text, auteur, date)
         *  5 Retourner un block HTML qui met en forme la liste
         *
         *  Erreurs possibles : (*** à implanter ultérieurement ***)
         *    - pas de paramètre dans la requête
         *    - le paramètre passé ne correspond pas a un identifiant existant
         *    - le paramètre passé n'est pas un entier
         *
         */

        $userId = $this->request->get['id'];

        $tweets = Tweet::where('author', $userId)->with('user')->get();

        $userFollowersCount = Follow::where('followee', $userId)->count();

        $data = [];
        $data['tweets'] = $tweets;
        $data['followers_count'] = $userFollowersCount;

        $tweeterView = new TweeterView($data);
        $tweeterView->render('userTweets');
    }

    public function viewPostTweet(){
        $tweeterView = new TweeterView();
        $tweeterView->render('postTweet');
    }

    public function viewMe(){
        $authentication = new TweeterAuthentication();

        $userId = User::where('username', $authentication->user_login)->first()->id;
        $userTweets = Tweet::where('author', $userId)->with('user')->orderBy('created_at', 'DESC')->get();

        $userFollowersCount = Follow::where('followee', $userId)->count();

        $data = [];
        $data['tweets'] = $userTweets;
        $data['followers_count'] = $userFollowersCount;
        $tweeterView = new TweeterView($data);
        $tweeterView->render('userTweets');
    }

    public function sendTweet(){
        $authentication = new Authentication();
        $userId = User::where('username', $authentication->user_login)->first()->id;

        $tweet = new Tweet();
        $tweet->author = $userId;
        $tweet->text = htmlspecialchars($this->request->post['tweet']);
        $tweet->save();

        $tweets = Tweet::orderBy('created_at', 'DESC')->get();
        $tweeterView = new TweeterView($tweets);
        $tweeterView->render('home');
    }

    public function likeTweet(){
        $router = new Router();
        $auth = new TweeterAuthentication();

        $referer = $_SERVER['HTTP_REFERER'];
        $tweet_id = $this->request->get['id'];

        $user = User::where('username', $auth->user_login)->first();
        if(empty(Like::where('user_id', $user->id)->where('tweet_id', $tweet_id)->first())){
            $like = new Like();
            $like->user_id = $user->id;
            $like->tweet_id = $tweet_id;
            $like->save();


            $tweet = Tweet::find($tweet_id);
            $tweet->score += 1;
            $tweet->update();
        }
        if(!empty($referer)){
            header('Location: ' . $referer);
        } else {
            header('Location: ' . $router->urlFor('home'));
        }
    }

    public function dislikeTweet(){
        $router = new Router();
        $auth = new TweeterAuthentication();

        $referer = $_SERVER['HTTP_REFERER'];
        $tweet_id = $this->request->get['id'];

        $user = User::where('username', $auth->user_login)->first();
        if(empty(Like::where('user_id', $user->id)->where('tweet_id', $tweet_id)->first())){
            $like = new Like();
            $like->user_id = $user->id;
            $like->tweet_id = $tweet_id;
            $like->save();


            $tweet = Tweet::find($tweet_id);
            $tweet->score -= 1;
            $tweet->update();
        }
        if(!empty($referer)){
            header('Location: ' . $referer);
        } else {
            header('Location: ' . $router->urlFor('home'));
        }

    }

    public function phpInfo(){
        phpinfo();
    }
}
