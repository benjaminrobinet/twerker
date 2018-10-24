<?php

namespace twerkerapp\view;

use bfforever\router\Router;
use bfforever\utils\HttpRequest;
use twerkerapp\model\Tweet;
use Rymanalu\TwitterTimeAgo\TwitterTimeAgo;

class TweeterView extends \bfforever\view\AbstractView {

    public function __construct($data = null){
        parent::__construct($data);
    }

    private function renderHeader(){
        $router = new Router();
        $html = <<<EOF
<header>
    <h1><a href="{$router->urlFor('default')}">{$this::$app_title}</a></h1>
    <nav><a href="{$router->urlFor('home')}">Home</a><a href="{$router->urlFor('login')}">Login</a><a href="{$router->urlFor('signup')}">Sign-up</a></nav>
</header>
EOF;

        return $html;
    }

    private function renderFooter(){
        return '<footer>La super app créée en Licence Pro &copy;2018</footer>';
    }
    public function renderHome(){
        $router = new Router();
        $timeAgo = new TwitterTimeAgo();
        $html = '';
        foreach ($this->data as $tweet){
            $tweetTemplate = <<<EOF
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
            $html .= $tweetTemplate;
        }
        return $html;
    }

    private function renderUserTweets(){
        $router = new Router();
        $timeAgo = new TwitterTimeAgo();
        $html = '';
        foreach ($this->data as $tweet){
            $tweetTemplate = <<<EOF
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
            $html .= $tweetTemplate;
        }
        return $html;
    }

    private function renderTweet(){

        $router = new Router();
        $timeAgo = new TwitterTimeAgo();
        $tweet = $this->data;
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

    private function renderPostTweet(){
        $router = new Router();

        $html = <<<EOF
<section class="form">
    <form action="{$router->urlFor('send')}" method="post">
        <textarea name="tweet"></textarea>
        <button type="submt">Envoyer</button>
    </form>
</section>
EOF;
        return $html;
    }

    protected function renderBody($selector=null){
        $renderMethod = 'render'.ucfirst($selector);

        $header = $this->renderHeader();
        $content = $this->{$renderMethod}();
        $footer = $this->renderFooter();

        $html = <<<EOF
{$header}
<main>
    {$content}
</main>
{$footer}
EOF;
        return $html;
    }











    
}
