<?php
include('config/envloader.php');
Envloader::load('.env');
class Database
{
    public function dbConnect()
    {
        try {
            $database = new PDO("mysql:host=" . $_ENV["DBHOST"] . ";dbname=" . $_ENV["DBNAME"] . ";charset=utf8", "root", $_ENV["DBPASS"]);
            $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (Exception $e) {
            $database = "Echec de la connection à la base de Données. Erreur: " . $e->getMessage();
        }
        return $database;
    }
}
