<?php

namespace twerkerapp\view;

use bfforever\auth\Authentication;
use bfforever\router\Router;

class DashboardView extends \bfforever\view\AbstractView {

    public function __construct($data = null){
        parent::__construct($data);
    }

    private function renderHome(){
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

    private function renderUserFollowersCount(){
        $router = new Router();
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
                <td><a href="' . $router->urlFor('dashboard_user_followers') . '?id=' . $user->id . '">' . $user->username . ' ('. $user->fullname .')</a></td>
                <td>' . $user->followers . '</td>
            </tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }

    private function renderUserSphereCount(){
        $router = new Router();
        $html = '<table id="user_followers">';
        $html .= '<thead>';
        $html .= '<tr>
            <th>User</th>
            <th>Sphere (count)</th>
        </tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($this->data as $row){
            $html .= '<tr>
                <td><a href="' . $router->urlFor('dashboard_user_followers') . '?id=' . $row['user']->id . '">' . $row['user']->username . ' ('. $row['user']->fullname .')</a></td>
                <td>' . $row['sphere'] . '</td>
            </tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }

    private function renderUserFollowers(){
        $user = $this->data;
        $html = '<ul>
            <li>' . $user->fullname . '<ul>';
        foreach ($user->followedBy as $follower){
            $html .= '<li>' . $follower->fullname . '</li>';
        }
        $html .= '</ul></ul></li>';

        return $html;
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
    <h1><a href="{$router->urlFor('dashboard')}">{$this::$app_title}</a></h1>
    <nav><a href="{$router->urlFor('home')}">Home</a>{$part_login}{$part_signup}</nav>
</header>
EOF;

        return $html;
    }

    private function renderNav()
    {
        $router = new Router();

        $data = '<div class="order_by">
            <div class="title">Trier par: </div>
            <nav>
                <ul>
                    <li><a href="' . $router->urlFor('dashboard_followers_count') . '">Nombre d\'abonnés</a></li>
                    <li><a href="' . $router->urlFor('dashboard_sphere_count') . '">Taille de la sphère de suiveurs</a></li>
                </ul>
            </nav>
        </div>';

        return $data;
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
        $nav = $this->renderNav();
        $content = $this->{$renderMethod}();
        $footer = $this->renderFooter();

        $html = <<<EOF
{$header}
{$nav}
<main>
    {$content}
</main>
{$footer}
EOF;
        return $html;
    }

}
