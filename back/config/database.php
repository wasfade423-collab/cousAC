<?php



class Database{
    private $database;
    public function ___construct(){
        try{
            $this->database = new PDO("mysql:host=localhost;dbname=cousac_services;charset=utf8", "root", "");
            $this->database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }catch(Exception $e){
            $errorCatch = "Erreur de connexion : ".$e->getMessage();
        }

    }
}