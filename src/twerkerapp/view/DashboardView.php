<?php

namespace twerkerapp\view;

use bfforever\auth\Authentication;
use bfforever\router\Router;
use bfforever\utils\HttpRequest;
use phpDocumentor\Reflection\TypeResolver;
use twerkerapp\model\Tweet;
use Rymanalu\TwitterTimeAgo\TwitterTimeAgo;

class DashboardView extends \bfforever\view\AbstractView {

    public function __construct($data = null){
        parent::__construct($data);
    }

    public function renderHome(){
        $html = '<table id="user_followers">';
        $html .= '<thead>';
        $html .= '<tr>
            <th>User</th>
            <th>Followers (count)</th>
        </tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($this->data as $user){
            $html .= '<tr>
                <td>' . $user->username . ' ('. $user->fullname .')</td>
                <td>' . $user->followers . '</td>
            </tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }

    public function renderLogin(){
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

    public function renderSignup(){
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

    public function renderHeader(){
        $authentication = new Authentication();
        $router = new Router();
        $logged_in = $authentication->logged_in;

        $part_login = '<a href="' . $router->urlFor($logged_in ? 'logout' : 'login') . '">'. ($logged_in ? "Logout" : "Login") .'</a>';
        $part_signup = '<a href="' . $router->urlFor($logged_in ? 'me' : 'signup') . '">'. ($logged_in ? "Me" : "Sign-up") .'</a>';

        $router = new Router();
        $html = <<<EOF
<header>
    <h1><a href="{$router->urlFor('dashboard')}">{$this::$app_title}</a></h1>
    <nav><a href="{$router->urlFor('home')}">Home</a>{$part_login}{$part_signup}</nav>
</header>
EOF;

        return $html;
    }

    /*
     * Render Footer, should not be modified
     */
    public function renderFooter(){
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
</main>
{$footer}
EOF;
        return $html;
    }

}
