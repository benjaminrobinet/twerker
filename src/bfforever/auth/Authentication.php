<?php
/**
 * Created by PhpStorm.
 * User: benjaminrobinet
 * Date: 10/10/2018
 * Time: 11:00
 */

namespace bfforever\auth;


class Authentication extends AbstractAuthentication
{
    /**
     * Authentication constructor.
     */
    public function __construct()
    {
        if(isset($_SESSION['user_login'])){
            $this->user_login = $_SESSION['user_login'];
            if(isset($_SESSION['access_level'])){
                $this->access_level = $_SESSION['access_level'];
                $this->logged_in = true;
            } else {
                $this->logout();
                return;
            }
        } else {
            $this->user_login = null;
            $this->access_level = self::ACCESS_LEVEL_NONE;
            $this->logged_in = false;
        }
    }

    protected function updateSession($username, $level)
    {
        $this->user_login = $_SESSION['user_login'] = $username;
        $this->access_level = $_SESSION['access_level'] = $level;
        $this->logged_in = true;
    }

    public function logout()
    {
        $this->user_login = $_SESSION['user_login'] = null;
        $_SESSION['access_level'] = null;
        $this->access_level = self::ACCESS_LEVEL_NONE;
        $this->logged_in = false;
    }

    public function checkAccessRight($requested)
    {
        return $requested > $this->access_level ? false : true;
    }

    /**
     * @param $username
     * @param $db_pass
     * @param $given_pass
     * @param $level
     * @throws AuthenticationException
     */
    public function login($username, $db_pass, $given_pass, $level)
    {
        if(!$this->verifyPassword($given_pass, $db_pass)){
            throw new AuthenticationException('Password invalid');
        } else {
            $this->updateSession($username, $level);
        }
    }

    protected function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    protected function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}