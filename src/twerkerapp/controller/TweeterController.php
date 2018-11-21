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
use Illuminate\Support\Facades\Auth;
use twerkerapp\auth\TweeterAuthentication;
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
        $tweeterView = new TweeterView($tweets);
        $tweeterView->render('userTweets');
    }

    public function viewPostTweet(){
        $tweeterView = new TweeterView();
        $tweeterView->render('postTweet');
    }

    public function viewMe(){
        $authentication = new TweeterAuthentication();
//        $userTweets = Tweet::with('tweets')->where('username', '=', $authentication->user_login)->first();
//        var_dump($userTweets); die();

        $userId = User::where('username', $authentication->user_login)->first()->id;
        $userTweets = Tweet::where('author', $userId)->with('user')->orderBy('created_at', 'DESC')->get();
        $tweeterView = new TweeterView($userTweets);
        $tweeterView->render('me');
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

    public function phpInfo(){
        phpinfo();
    }
}
