<?php

namespace twerkerapp\view;

use bfforever\auth\Authentication;
use bfforever\router\Router;
use bfforever\utils\HttpRequest;
use phpDocumentor\Reflection\TypeResolver;
use twerkerapp\model\Tweet;
use Rymanalu\TwitterTimeAgo\TwitterTimeAgo;

class TweeterView extends \bfforever\view\AbstractView {

    public function __construct($data = null){
        parent::__construct($data);
    }

    private function renderHome(){
        return $this->makeTweets($this->data);
    }

    private function renderUserTweets(){
        return $this->makeTweets($this->data);
    }

    private function renderTweet(){
        return $this->makeTweet($this->data);
    }

    private function renderPostTweet(){
        $router = new Router();

        $html = <<<EOF
<section id="create">
    <form action="{$router->urlFor('send')}" method="post">
        <textarea name="tweet"></textarea>
        <button type="submt">Envoyer</button>
    </form>
</section>
EOF;
        return $html;
    }

    private function renderLogin(){
        $router = new Router();

        $html = <<<EOF
<section id="create">
    <form action="{$router->urlFor('login_check')}" method="post">
        <input type="text" name="username">
        <input type="password" name="password">
        <button type="submt">Se connecter</button>
    </form>
</section>
EOF;
        if(!empty($this->data['errors'])){
            foreach ($this->data['errors'] as $error){
                $html .= '<p class="alert-error">' . $error . '</p>';
            }
        }
        return $html;
    }

    private function renderSignup(){
        $router = new Router();

        $html = <<<EOF
<section id="create">
    <form action="{$router->urlFor('signup_check')}" method="post">
        <div><label for="">Fullname</label> <input type="text" name="fullname"></div>
        <div><label for="">Username</label> <input type="text" name="username"></div>
        <div><label for="">Password</label> <input type="password" name="password"></div>
        <div><label for="">Password Confirmation</label> <input type="password" name="password_confirm"></div>
        <button type="submt">Register</button>
    </form>
</section>
EOF;
        if(!empty($this->data['errors'])){
            foreach ($this->data['errors'] as $error){
                $html .= '<p class="alert-error">' . $error . '</p>';
            }
        }
        return $html;
    }

    private function renderMe(){
        return $this->makeTweets($this->data);
    }

    private function renderHeader(){
        $authentication = new Authentication();
        $router = new Router();
        $logged_in = $authentication->logged_in;

        $part_login = '<a href="' . $router->urlFor($logged_in ? 'logout' : 'login') . '">'. ($logged_in ? "Logout" : "Login") .'</a>';
        $part_signup = '<a href="' . $router->urlFor($logged_in ? 'me' : 'signup') . '">'. ($logged_in ? "Me" : "Sign-up") .'</a>';

        $router = new Router();
        $html = <<<EOF
<header>
    <h1><a href="{$router->urlFor('default')}">{$this::$app_title}</a></h1>
    <nav><a href="{$router->urlFor('home')}">Home</a>{$part_login}{$part_signup}</nav>
</header>
EOF;

        return $html;
    }

    /*
     * Render Footer, should not be modified
     */
    private function renderFooter(){
        return '<footer>La super app créée en Licence Pro &copy;2018</footer>';
    }

    /*
     * Render body, should not be modified
     * */
    protected function renderBody($selector=null){
        $renderMethod = 'render'.ucfirst($selector);
        $router = new Router();

        $header = $this->renderHeader();
        $content = $this->{$renderMethod}();
        $footer = $this->renderFooter();

        $html = <<<EOF
{$header}
<main>
    {$content}
    <a href="{$router->urlFor('post')}" id="create">+</a>
</main>
{$footer}
EOF;
        return $html;
    }

    protected function makeTweets($tweets){
        $router = new Router();
        $timeAgo = new TwitterTimeAgo();

        $html = '';
        foreach ($tweets as $tweet){
            $html .= <<<EOF
<article>
    <section class="informations">
        <a href="{$router->urlFor('user', [['id', $tweet->user->id]])}">
            <div class="name">{$tweet->user->fullname}</div>
            <div class="username">@{$tweet->user->username}</div>
        </a>
        <div class="date">{$timeAgo->parse($tweet->created_at)}</div>
    </section>
    <section class="content">
        <a href="{$router->urlFor('tweet', [['id', $tweet->id]])}">{$tweet->text}</a>
    </section>
    <section class="actions">
        <a href="">+</a>
        <a href="">-</a>
        <div class="score">{$tweet->score}</div>
    </section>
</article>
EOF;
        };
        return $html;
    }
    protected function makeTweet($tweet){
        $router = new Router();
        $timeAgo = new TwitterTimeAgo();

        $html = <<<EOF
<article>
    <section class="informations">
        <a href="{$router->urlFor('user', [['id', $tweet->user->id]])}">
            <div class="name">{$tweet->user->fullname}</div>
            <div class="username">@{$tweet->user->username}</div>
        </a>
        <div class="date">{$timeAgo->parse($tweet->created_at)}</div>
    </section>
    <section class="content">
        <a href="{$router->urlFor('tweet', [['id', $tweet->id]])}">{$tweet->text}</a>
    </section>
    <section class="actions">
        <a href="">+</a>
        <a href="">-</a>
        <div class="score">{$tweet->score}</div>
    </section>
</article>
EOF;
        return $html;
    }

}
