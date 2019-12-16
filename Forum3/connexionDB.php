<?php
    class connexionDB 
    {
        private $host    = 'localhost';
        private $name    = 'name_bdd';
        private $user    = 'root';
        private $pass    = '';
        private $connexion;

        function __construct($host = null, $name = null, $user = null, $pass = null)
        {
            if($host != null)
            {
                $this->host = $host;           
                $this->name = $name;           
                $this->user = $user;          
                $this->pass = $pass;
            }
            
            try
            {
                $this->connexion = new PDO('mysql:host=localhost;dbname=forumphp;charset=utf8', 'root', '');
            }
            
            catch (PDOException $e)
            {
                echo 'Erreur : Impossible de se connecter à la BDD !';
                die();
            }
        }
        
        public function query($sql, $data = array())
        {
            $req = $this->connexion->prepare($sql);
            $req->execute($data);
            return $req;
        }

        public function insert($sql, $data = array())
        {
            $req = $this->connexion->prepare($sql);
            $req->execute($data);
        }
    }
    
    $DB = new connexionDB();
?>