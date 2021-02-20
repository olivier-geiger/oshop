<?php

    namespace App\Models;

    use App\Utils\Database;
    use PDO;

    class AppUser extends CoreModel
    {
        private $email;
        private $password;
        private $firstname;
        private $lastname;
        private $role;        
        private $status;      
        

        // Pour "remplir" le contrat des méthodes abstraites de CoreModel
        // On implémente les fonction necessaires mais on ne s'en occupe pas
        public static function find( $id ) 
        {
            // se connecter à la BDD
            $pdo = Database::getPDO();

            // écrire notre requête
            $sql = 'SELECT * FROM `app_user` 
                    WHERE `id` = ' . $id;

            // exécuter notre requête
            $pdoStatement = $pdo->query($sql);

            // un seul résultat => fetchObject
            $appuser = $pdoStatement->fetchObject(self::class);

            // retourner le résultat
            return $appuser;
        }

        public static function findAll() 
        {
            $pdo = Database::getPDO();
            $sql = 'SELECT * FROM `app_user`';

            $pdoStatement = $pdo->query($sql);
            $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\AppUser');
            
            return $results;
        }

        public static function findByEmail( string $p_email )
        {
            $pdo = Database::getPDO();
            $sql = 'SELECT * FROM `app_user` WHERE `email` = :email';
            //dd($sql);
            

            $query = $pdo->prepare( $sql );
            $query->bindValue( ":email", $p_email, PDO::PARAM_STR );

            $query->execute();

            
            return $query->fetchObject( self::class );
        }

        public function insert()
        {
            $pdo = Database::getPDO();

            // Ecriture de la requête INSERT INTO (c) Yannick 2020
            $sql = "INSERT INTO `app_user` 
                        (firstname, lastname, email, password, status )
                    VALUES 
                        (:firstname, :lastname, :email, :password, :status)";

            $query = $pdo->prepare( $sql );

            // (c) Loic 2020
            $insertedRows = $query->execute( [
                ':email'     => $this->email,
                ':password'  => $this->password,
                ':firstname' => $this->firstname,
                ':lastname'  => $this->lastname,
                //':role'      => $this->role,
                ':status'    => $this->status,
            ] );

            // Si au moins une ligne ajoutée
            if( $insertedRows > 0 ) 
            {
                // Alors on récupère l'id auto-incrémenté généré par MySQL
                $this->id = $pdo->lastInsertId();
                return true; // 
            }
            
            // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
            return false;
        }
        
    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();
        
        // Ecriture de la requête UPDATE
        $sql = "UPDATE `app_user` SET
                email       = :email,
                firstname    = :firstname,
                lastname   = :lastname,
                role       = :role, 
                updated_at = NOW()
                WHERE id = :id";
        // Préparation de la requête d'insertion
        $query = $pdo->prepare($sql);
        
        // On va préparer nos différentes valeurs une par une
        $query->bindValue(":id", $this->id, PDO::PARAM_INT);
        $query->bindValue(":email", $this->email, PDO::PARAM_STR);
        $query->bindValue(":firstname", $this->firstname, PDO::PARAM_STR);
        $query->bindValue(":lastname", $this->lastname, PDO::PARAM_STR);
        $query->bindValue(":role", $this->role, PDO::PARAM_STR);
        
        // On exécute la requête préparée
        $updatedRows = $query->execute();
        
        // $updatedRows contient le nombre de lignes affectées par la requete
        // Ici, si tout se passe bien, elle contient 1
        return $updatedRows > 0;
    }

        public function delete()
        {
            $pdo = Database::getPDO();
            
            $sql = 'DELETE FROM `app_user`
                    WHERE id = :id';

            $query = $pdo->prepare($sql);
            $query->bindValue(":id", $this->id, PDO::PARAM_INT);
            $deletedRows = $query->execute();
                
            // On return si ça a marché
            return $deletedRows > 0;
        }

        //===============================================
        // Getters
        //===============================================

        public function getFirstname()
        {
            return $this->firstname;
        }

        public function getLastname()
        {
            return $this->lastname;
        }

        public function getPassword()
        {
            return $this->password;
        }

        public function getRole()
        {
            return $this->role;
        }

        //===============================================
        // Setters 
        //===============================================

        public function setEmail(string $email)
        {
            $this->email = $email;
        }

        public function setFirstname( $firstname)
        {
            $this->firstname = $firstname;
        }

        public function setLastname( $lastname)
        {
            $this->lastname = $lastname;
        }

        public function setRole( $role)
        {
            $this->role = $role;
        }

        public function setStatus($status)
        {
            $this->status = $status;
        }

        // Ce setter prends un mdp en "clair" 
        // et stocke la version hashée dans la propriété
        public function setPassword( $password )
        {
            $this->password = password_hash( $password, PASSWORD_DEFAULT );
        }
    }