<?php
    include_once 'config/EnvLoader.php';
    EnvLoader::load('.env');


        try{
            $database = new PDO("mysql:host=localhost;dbname=".$_ENV['DBNAME'].";charset=utf8", "root", "");
            $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }catch(Exception $e){
            $errors["dbConexion"] = "Erreur de connexion : ".$e->getMessage();
        }
