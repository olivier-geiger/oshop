<?php

namespace App\Controllers;

use App\Models\AppUser;

class UserController extends CoreController 
{
    /**
     * Méthode s'occupant de l'affichage du formulaire de connexion
     * @return void
     */
    public function login()
    {
        $this->show( "user/login" );
    }

    /**
     * Méthode s'occupant du traitement du formulaire de connexion
     * @return void
     */
    public function connect()
    {
        global $router;
        
        // On plutot essayer de récupérer le User correspondant directement
        $user = AppUser::findByEmail( $_POST['email'] );
        
        // On a hashé le mdp dans la BDD
        // On utilise password_verify pour vérifier que le mdp entré correspond bien à celui hashé de la bdd
        // password_verify hash le mdp en clair et le compare à celui hashé en bdd.
        // C'est pourquoi ce n'est pas possible de mettre directement le hash dans l'input
        // password_verify s'utilise avec : password_verify($motDePasEnClair, $motDePasseHashe)
        // Si $user existe et que le mot de passe est correct
        if( $user && password_verify( $_POST['password'], $user->getPassword() ) )
        {
            // On met l'utilisateur (l'objet) dans le tableau de session
            $_SESSION['connectedUser'] = $user;
            // dd($_SESSION['connected'] );
            // Redirection vers l'accueil
            header( "Location: ". $router->generate( 'main-home' ) );
        }
        else
        {
            echo '<h1><b>Identifiants incorrects</b></h1>';
            header( "Location: ". $router->generate( 'error-err404' ) );
            // TODO : Gérer l'erreur et rediriger sur le formulaire
        }
    }

    /**
     * Méthode s'occupant de déconnecter l'utilisateur
     * @return void
     */
    public function logout()
    {
        global $router;

        // La méthode unset (on ne supprime que la clé connectedUser)
        unset( $_SESSION['connectedUser'] );

        header( "Location: ". $router->generate( 'user-login' ) );
    }

    /**
     * Méthode s'occupant de lister les utilisateurs
     * @return void
     */
    public function list()
    {
        self::checkAuthorization( ['admin'] );
        $users = AppUser::findAll();

        $this->show( 'user/list', [ 
            "users" => $users 
            ] );
    }

    /**
     * Méthode s'occupant de l'affichage du formulaire d'ajout de user
     * @return void
     */
    public function add()
    {
        
        $this->show('user/add');
    }
    
    /**
     * Méthode s'occupant du traitement du formulaire d'ajout de catégorie
     * @return void
     */
    public function create()
    {
        self::checkAuthorization( ['admin'] );
        // On vérifie les données reçues (en $_POST)
        if( $_POST['password'] !== $_POST['confirm'] ) :
            echo "Les mots de passes ne correspondent pas !";
            return;
        endif;

        // J'instancie une nouvelle catégorie vide
        $user = new AppUser();

        // On peut faire ça plus rapidement grace à la fonction filter_input
        $user->setFirstname( filter_input( INPUT_POST, 'firstname', FILTER_SANITIZE_STRING ) );
        $user->setFirstname( filter_input( INPUT_POST, 'firstname', FILTER_SANITIZE_STRING ) );
        $user->setLastname( filter_input( INPUT_POST, 'lastname', FILTER_SANITIZE_STRING ) );
        $user->setEmail( filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL ) );
        $user->setPassword( Filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING ) );
        $user->setRole( filter_input( INPUT_POST, 'role', FILTER_SANITIZE_STRING ) );
        $user->setStatus( filter_input( INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT ) );


        // J'enregistre ma nouvelle catégorie en BDD
        // et je vérifie si ça a fonctionne (si insert retourne true)
        if( $user->insert() )
        {
            // Redirection : on globalise $router comme dans show()
            global $router;
            header( "Location: ".$router->generate( 'user-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            // (et le pré-remplir avec les données saisies )
        }
    }

    public function edit( int $id )
    {
        
        $user = AppUser::find( $id );

        $this->show( 'user/edit', [ "user" => AppUser::find( $id ) ] );
    }

    public function delete( int $id )
    {
        
        $appuser = AppUser::find( $id );

        if( $appuser->delete() )
        {
            
            global $router;
            header( "Location: ".$router->generate( 'main-home' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La suppression n'a pas été faite";
        }
    }

    public function update( int $id )
    {
        // On récupère la catégorie à modifier via son ID
        $appuser = AppUser::find( $id );

        $appuser->setFirstname( filter_input( INPUT_POST, 'firstname', FILTER_SANITIZE_STRING  ) );
        $appuser->setLastname( filter_input( INPUT_POST, 'lastname', FILTER_SANITIZE_STRING  ) );
        $appuser->setRole( filter_input( INPUT_POST, 'role', FILTER_SANITIZE_STRING) );

        if( $appuser->update() )
        {
            global $router;
            header( "Location: ".$router->generate( 'user-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La mise à jour n'a pas été faite";
        }
    }

}