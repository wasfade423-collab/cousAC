<?php
    include("back/models/models.php");
    require ("vendor/autoload.php");
    class Routes{
    private $data;
    private $router;

    private function setRoute(){
        $this->router->map('GET', 'api/', 'home');
        $this->router->map('GET', 'api/universites/[i:id]/etudiants', 'listEtudiants');
        $this->router->map('GET', 'api/universites/[i:id]/etudiants/[i:id]', 'getEtudiant');
        $this->router->map('GET', 'api/universites/[i:id]/plaintes', 'listPlaintes');
        $this->router->map('GET', 'api/universites/[i:id]/plaintes/[i:id]', 'getPlainte');        
        $this->router->map('GET', 'api/universites/[i:id]/nourritures', 'listNourritures');
        $this->router->map('GET', 'api/universites/[i:id]/nourritures/[i:id]', 'getNourriture');  
        $this->router->map('GET', 'api/universites', 'listUniversites');
        $this->router->map('GET', 'api/universites/[i:id]', 'getUniversite');               
        $this->router->map('GET', 'api/universites/[i:id]/batiments', 'listBatiments');
        $this->router->map('GET', 'api/universites/[i:id]/batiments/[i:id]', 'getBatiment');
        $this->router->map('GET', 'api/universites/[i:id]/batiments/[i:id]/paliers', 'listPaliers');
        $this->router->map('GET', 'api/universites/[i:id]/dortoirs', 'listDortoirs');
        $this->router->map('GET', 'api/universites/[i:id]/batiments/[i:id]/dortoirs', 'dortoirsByBatiment');
        $this->router->map('GET', 'api/universites/[i:id]/batiments/[i:idBatiment]/palliers/[i:idPallier]', 'getPalier');
        $this->router->map('GET', 'api/universites/[i:id]/batiments/[i:id]/dortoirs/[i:idDortoir]', 'getDortoir');
        $this->router->map('GET', 'api/universites/[i:id]/intendants', 'listIntendantsByUniversite');
        $this->router->map('GET', 'api/intendants', 'listIntendants');        
        $this->router->map('GET', 'api/universites/[i:id]/intendants/[i:id]', 'getIntendant');
        $this->router->map('GET', 'api/universites/[i:id]/comptables', 'listComptablesByUniversite');
        $this->router->map('GET', 'api/universites/[i:id]/comptables/[i:id]', 'getComptable');
        $this->router->map('GET', 'api/universites/[i:id]/secretaires', 'listSecretaires');
        $this->router->map('GET', 'api/universites/[i:id]/cc', 'listCc');
        $this->router->map('GET', 'api/universites/[i:id]/secretaires/[i:id]', 'getSecretaire');
        $this->router->map('GET', 'api/universites/[i:id]/cc/[i:id]', 'getCc');
        $this->router->map('GET', 'api/universites/[i:id]/securites', 'listSecurite');
        $this->router->map('GET', 'api/universites/[i:id]/securites/[i:id]', 'getSecurite');        


        $this->router->map('POST', 'api/universites/[i:id]/etudiants', 'addEtudiant');
        $this->router->map('POST', 'api/universites/[i:id]/securites', 'addSecurite');
        $this->router->map('POST', 'api/universites/[i:id]/plaintes', 'addPlainte');
        $this->router->map('POST', 'api/universites/[i:id]/nourritures', 'addNourriture');
        $this->router->map('POST', 'api/universites', 'addUniversite');
        $this->router->map('POST', 'api/universites/[i:id]/batiments', 'addBatiment');
        $this->router->map('POST', 'api/universites/[i:id]/batiments/[i:id]/paliers', 'addPalier');
        $this->router->map('POST', 'api/universites/[i:id]/batiments/[i:id]/dortoirs', 'addDortoir');
        $this->router->map('POST', 'api/universites/[i:id]/intendants', 'addIntendant');
        $this->router->map('POST', 'api/universites/[i:id]/comptables', 'addComptable');
        $this->router->map('POST', 'api/universites/[i:id]/secretaires', 'addSecretaire');
        $this->router->map('POST', 'api/universites/[i:id]/cc', 'addCharge_cabine');


        $this->router->map('PUT', 'api/universites/[i:id]/etudiants/[i:id]', 'updateEtudiant');
        $this->router->map('PUT', 'api/universites/[i:id]/securites/[i:id]', 'updateSecurite');
        $this->router->map('PUT', 'api/universites/[i:id]/plaintes/[i:id]', 'updatePlainte');
        $this->router->map('PUT', 'api/universites/[i:id]/nourritures/[i:id]', 'updateNourriture');
        $this->router->map('PUT', 'api/universites/[i:id]', 'updateUniversite');
        $this->router->map('PUT', 'api/universites/[i:id]/batiments/[i:id]', 'updateBatiment');
        $this->router->map('PUT', 'api/universites/[i:id]/batiments/[i:id]/paliers/[i:idPalier]', 'updatePalier');
        $this->router->map('PUT', 'api/universites/[i:id]/batiments/[i:id]/dortoirs/[i:idDortoir]', 'updateDortoir');
        $this->router->map('PUT', 'api/universites/[i:id]/intendants/[i:id]', 'updateIntendant');
        $this->router->map('PUT', 'api/universites/[i:id]/comptables/[i:id]', 'updateComptable');
        $this->router->map('PUT', 'api/universites/[i:id]/secretaires/[i:id]', 'updateSecretaire');
        $this->router->map('PUT', 'api/universites/[i:id]/cc/[i:id]', 'updateCc');

        
        $this->router->map('DELETE', 'api/universites/[i:id]/etudiants/[i:id]', 'deleteEtudiant');
        $this->router->map('DELETE', 'api/universites/[i:id]/nourritures/[i:id]', 'deleteNourriture');
        $this->router->map('DELETE', 'api/universites/[i:id]', 'deleteUniversite');
        $this->router->map('DELETE', 'api/universites/[i:id]/securites/[i:id]', 'deleteSecurite');
        $this->router->map('DELETE', 'api/universites/[i:id]/intendants/[i:id]', 'deleteIntendant');
        $this->router->map('DELETE', 'api/universites/[i:id]/comptables/[i:id]', 'deleteComptable');                   
        $this->router->map('DELETE', 'api/universites/[i:id]/cc/[i:id]', 'deleteCharge_cabine');
        $this->router->map('DELETE', 'api/universites/[i:id]/secretaires/[i:id]', 'deleteSecretaire');
        $this->router->map('DELETE', 'api/universites/[i:idUniversite]/plaintes/[i:idPlainte]', 'deletePlainte');
    }

    public function __construct(){
        $this->data = new Model();
        $this->router = new AltoRouter();
        $this->router->setBasePath("/back/");
        $this->setRoute();
    }


    public function getUrl($route, $requestType){
        $match = $this->router->match();
        if($match){
            $ressources = [$this->data, $match["target"]];//la fonctio viser par la requete
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