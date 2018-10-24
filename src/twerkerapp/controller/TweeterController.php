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

use bfforever\controller\AbstractController;
use twerkerapp\model\Tweet;
use twerkerapp\view\TweeterView;

class TweeterController extends AbstractController {

    public function __construct(){
        parent::__construct();

        TweeterView::addStyleSheet('assets/css/default.css');
        TweeterView::setAppTitle('Twerker');
    }

    public function viewHome(){
        $tweets = Tweet::orderBy('created_at', 'DESC')->get();
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

        $tweet = Tweet::find($tweetId);
        $tweeterView = new TweeterView($tweet);
        $tweeterView->render('tweet');
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

        $tweets = Tweet::where('author', $userId)->get();
        $tweeterView = new TweeterView($tweets);
        $tweeterView->render('userTweets');
    }

    public function viewPostTweet(){
        $tweeterView = new TweeterView();
        $tweeterView->render('postTweet');
    }

    public function sendTweet(){
        $tweet = new Tweet();
        $tweet->author = 1;
        $tweet->text = $this->request->post['tweet'];
        $tweet->save();

        $tweets = Tweet::orderBy('created_at', 'DESC')->get();
        $tweeterView = new TweeterView($tweets);
        $tweeterView->render('home');
    }

    public function phpInfo(){
        phpinfo();
    }
}
