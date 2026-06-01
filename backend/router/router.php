<?php
    include("model/model.php");
    require ("vendor/autoload.php");
    class Router{
    private $data;
    private $router;

    private function setRoute(){
        $this->router->map('GET', 'api/', 'home');
        $this->router->map('GET', 'api/universites', 'getUniversites');
        $this->router->map('GET', 'api/universites/[i:id]', 'getUniversite');
        $this->router->map('GET', 'api/intendants', 'getIntendants');
        $this->router->map('GET', 'api/intendants/[i:id]', 'getIntendant');
        $this->router->map('GET', 'api/secretaires', 'getSecretaires');
        $this->router->map('GET', 'api/secretaires/[i:id]', 'getSecretaire');   
        $this->router->map('GET', 'api/comptables', 'getComptables');
        $this->router->map('GET', 'api/comptables/[i:id]', 'getComptable');  
        $this->router->map('GET', 'api/charge_cabines', 'getChargeCabines');
        $this->router->map('GET', 'api/charge_cabines/[i:id]', 'getChargeCabine');   
        $this->router->map('GET', 'api/securites', 'getSecurites');
        $this->router->map('GET', 'api/securites/[i:id]', 'getSecurite');
        $this->router->map('GET', 'api/restaurants', 'getRestaurants');
        $this->router->map('GET', 'api/restaurants/[i:id]', 'getRestaurant');                                        
        $this->router->map('GET', 'api/etudiants', 'getEtudiants');
        $this->router->map('GET', 'api/universites/[i:idUniversite]/etudiants', 'getEtudiantsByUniversite');
        $this->router->map('GET', 'api/etudiants/[i:id]', 'getEtudiant');
        $this->router->map('GET', 'api/batiments', 'getBatiments');
        $this->router->map('GET', 'api/universites/[i:idUniversite]/batiment', 'getBatimentsByUniversite');
        $this->router->map('GET', 'api/batiments/[i:id]', 'getBatiment');        
        $this->router->map('GET', 'api/dortoirs', 'getDortoirs');
        $this->router->map('GET', 'api/batiments/[i:idBatiment]/dortoirs', 'getDortoirsByBatiment');
        $this->router->map('GET', 'api/dortoirs/[i:id]', 'getDortoir');        
        $this->router->map('GET', 'api/plaintes', 'getPlaintes');
        $this->router->map('GET', 'api/universites/[i:idUniversite]/plaintes', 'getPlaintesByUniversite');
        $this->router->map('GET', 'api/plaintes/[i:id]', 'getPlainte');
        $this->router->map('GET', 'api/nourritures', 'getNourritures');
        $this->router->map('GET', 'api/universites/[i:idUniversite]/nourritures', 'getNourrituresyUniversite');
        $this->router->map('GET', 'api/nourritures/[i:id]', 'getNourriture');

        $this->router->map('POST', 'api/presentations', 'addPresentation');
        $this->router->map('POST', 'api/universites', 'addUniversite');
        $this->router->map('POST', 'api/intendants', 'addIntendant');
        $this->router->map('POST', 'api/secretaires', 'addSecretaire');  
        $this->router->map('POST', 'api/comptables', 'addComptable');
        $this->router->map('POST', 'api/charge_cabines', 'addChargeCabine');
        $this->router->map('POST', 'api/securites', 'addSecurite');
        $this->router->map('POST', 'api/restaurants', 'addRestaurant');                                       
        $this->router->map('POST', 'api/etudiants', 'addEtudiant');
        $this->router->map('POST', 'api/batiments', 'addBatiment');
        $this->router->map('POST', 'api/dortoirs', 'addDortoir');
        $this->router->map('POST', 'api/plaintes', 'addPlainte');
        $this->router->map('POST', 'api/nourritures', 'addNourriture');
        $this->router->map('POST', 'api/nourritures', 'addPalier');


        $this->router->map('PUT', 'api/etudiants/[i:id]', 'updateEtudiant');
        $this->router->map('PUT', 'api/presentations/[i:id]', 'updatePresentation');
        $this->router->map('PUT', 'api/restaurants/[i:id]', 'updateRestaurant');        
        $this->router->map('PUT', 'api/securites/[i:id]', 'updateSecurite');
        $this->router->map('PUT', 'api/plaintes/[i:id]', 'updatePlainte');
        $this->router->map('PUT', 'api/nourritures/[i:id]', 'updateNourriture');
        $this->router->map('PUT', 'api/universites/[i:id]', 'updateUniversite');
        $this->router->map('PUT', 'api/batiments/[i:id]', 'updateBatiment');
        $this->router->map('PUT', 'api/paliers/[i:idPalier]', 'updatePalier');
        $this->router->map('PUT', 'api/dortoirs/[i:idDortoir]', 'updateDortoir');
        $this->router->map('PUT', 'api/intendants/[i:id]', 'updateIntendant');
        $this->router->map('PUT', 'api/comptables/[i:id]', 'updateComptable');
        $this->router->map('PUT', 'api/secretaires/[i:id]', 'updateSecretaire');
        $this->router->map('PUT', 'api/cc/[i:id]', 'updateChargeCabine');

        
        $this->router->map('DELETE', 'api/etudiants/[i:id]', 'deleteEtudiant');
        $this->router->map('DELETE', 'api/restaurants/[i:id]', 'deleteRestaurant');
        $this->router->map('DELETE', 'api/presentations/[i:id]', 'deletePresentation');
        $this->router->map('DELETE', 'api/nourritures/[i:id]', 'deleteNourriture');
        $this->router->map('DELETE', 'api/universites/[i:id]', 'deleteUniversite');
        $this->router->map('DELETE', 'api/securites/[i:id]', 'deleteSecurite');
        $this->router->map('DELETE', 'api/intendants/[i:id]', 'deleteIntendant');
        $this->router->map('DELETE', 'api/comptables/[i:id]', 'deleteComptable');                   
        $this->router->map('DELETE', 'api/cc/[i:id]', 'deleteChargeCabine');
        $this->router->map('DELETE', 'api/secretaires/[i:id]', 'deleteSecretaire');
        $this->router->map('DELETE', 'api/plaintes/[i:idPlainte]', 'deletePlainte');
    }

    public function __construct(){
        $this->data = new Model();
        $this->router = new AltoRouter();
        $this->router->setBasePath("/backend/");
        $this->setRoute();
    }


    public function getUrl(){
        $match = $this->router->match();
        if($match){
            $ressources = [$this->data, $match["target"]]; //la fonctio viser par la requete
            $params = $match["params"];   //les parametres de la requete

            $resultat = call_user_func_array([$this->data, $ressources], $params);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($resultat);
        }else{
            http_response_code(404);
            $errors['path'] = "Route de la requète incorrecte.";
        }
    }








}