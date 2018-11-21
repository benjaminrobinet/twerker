<?php

namespace twerkerapp\auth;

use bfforever\auth\AuthenticationException;
use twerkerapp\model\User;

class TweeterAuthentication extends \bfforever\auth\Authentication {

    /*
     * Classe TweeterAuthentification qui définie les méthodes qui dépendent
     * de l'application (liée à la manipulation du modèle User) 
     *
     */

    /* niveaux d'accès de TweeterApp 
     *
     * Le niveau USER correspond a un utilisateur inscrit avec un compte
     * Le niveau ADMIN est un plus haut niveau (non utilisé ici)
     * 
     * Ne pas oublier le niveau NONE un utilisateur non inscrit est hérité 
     * depuis AbstractAuthentification 
     */
    const ACCESS_LEVEL_USER  = 100;   
    const ACCESS_LEVEL_PARTNER = 150;
    const ACCESS_LEVEL_ADMIN = 200;

    /* constructeur */
    public function __construct(){
        parent::__construct();
    }

    public function createUser($username, $pass, $fullname, $level = self::ACCESS_LEVEL_USER) {
        $userExists = User::where('username', $username)->first();
        if(!$userExists){
            $user = new User();
            $user->username = $username;
            $user->fullname = $fullname;
            $user->password = $this->hashPassword($pass);
            $user->level = $level;
            $user->save();
        } else {
            throw new AuthenticationException('User already exists');
        }
    }

    /* La méthode loginUser
     *  
     * permet de connecter un utilisateur qui a fourni son nom d'utilisateur 
     * et son mot de passe (depuis un formulaire de connexion)
     *
     * @param : $username : le nom d'utilisateur   
     * @param : $password : le mot de passe tapé sur le formulaire
     *
     * Algorithme :
     * 
     *  - Récupérer l'utilisateur avec l'identifiant $username depuis la BD
     *  - Si aucun de trouvé 
     *      - soulever une exception 
     *  - sinon 
     *      - réaliser l'authentification et la connexion
     *
     */
    /**
     * @param $username
     * @param $password
     * @throws AuthenticationException
     */
    public function loginUser($username, $password){
        $expectedUser = User::where('username', '=', $username)->first();
        if($expectedUser){
            try {
                $this->login($username, $expectedUser->password, $password, $expectedUser->level);
            } catch (AuthenticationException $e) {
                throw new AuthenticationException('Check your credentials.');
            }
        } else {
            throw new AuthenticationException('This user doesn\'t exists');
        }
    }

}
