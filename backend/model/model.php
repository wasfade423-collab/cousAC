<?php
include("model/DbConnect.php");
class Model
{
    private $model;

    public function home()
    {
        include_once("model/home.php");
        $objet = new Home();
        return $objet->getHome();
    }

    public function getUniversites()
    {
        include_once("model/universite.php");
        $objet = new Universite();
        return $objet->getUniversites();
    }

    public function getUniversite($id)
    {
        include_once("model/universite.php");
        $objet = new Universite();
        return $objet->getUniversite($id);
    }

    public function getIntendants()
    {
        include_once("model/intendant.php");
        $objet = new Intendant();
        return $objet->getIntendants();
    }

    public function getIntendant($id)
    {
        include_once("model/intendant.php");
        $objet = new Intendant();
        return $objet->getIntendant($id);
    }

    public function getChargeCabines()
    {
        include_once("model/charge_cabines.php");
        $objet = new ChargeCabine();
        return $objet->getChargeCabines();
    }

    public function getChargeCabine($id)
    {
        include_once("model/charge_cabines.php");
        $objet = new ChargeCabine();
        return $objet->getChargeCabine($id);
    }

    public function getSecretaires()
    {
        include_once("model/secretaire.php");
        $objet = new Secretaire();
        return $objet->getSecretaires();
    }

    public function getSecretaire($id)
    {
        include_once("model/secretaire.php");
        $objet = new Secretaire();
        return $objet->getSecretaire($id);
    }

    public function getComptables()
    {
        include_once("model/comptable.php");
        $objet = new Comptable();
        return $objet->getComptables();
    }

    public function getComptable($id)
    {
        include_once("model/comptable.php");
        $objet = new Comptable();
        return $objet->getComptable($id);
    }

    public function getSecurites()
    {
        include_once("model/securite.php");
        $objet = new Securite();
        return $objet->getSecurites();
    }

    public function getSecurite($id)
    {
        include_once("model/securite.php");
        $objet = new Securite();
        return $objet->getSecurite($id);
    }

    public function getRestaurants()
    {
        include_once("model/restaurant.php");
        $objet = new agent_restauration();
        return $objet->getRestaurants();
    }

    public function getRestaurant($id)
    {
        include_once("model/restaurant.php");
        $objet = new agent_restauration();
        return $objet->getRestaurant($id);
    }

    public function getEtudiants()
    {
        include_once("model/etudiant.php");
        $objet = new Etudiant();
        return $objet->getEtudiants();
    }

    public function getEtudiantsByUniversite($idUniversite)
    {
        include_once("model/etudiant.php");
        $objet = new Etudiant();
        return $objet->getEtudiantsByUniversite($idUniversite);
    }

    public function getEtudiant($id)
    {
        include_once("model/etudiant.php");
        $objet = new Etudiant();
        return $objet->getEtudiant($id);
    }

    public function getBatiments()
    {
        include_once("model/batiment.php");
        $objet = new Batiment();
        return $objet->getBatiments();
    }

    public function getBatimentsByUniversite($idUniversite)
    {
        include_once("model/batiment.php");
        $objet = new Batiment();
        return $objet->getBatimentsByUniversite($idUniversite);
    }

    public function getBatiment($id)
    {
        include_once("model/batiment.php");
        $objet = new Batiment();
        return $objet->getBatiment($id);
    }

    public function getDortoirs()
    {
        include_once("model/dortoir.php");
        $objet = new Dortoir();
        return $objet->getDortoirs();
    }

    public function getDortoirsByBatiment($idBatiment)
    {
        include_once("model/dortoir.php");
        $objet = new Dortoir();
        return $objet->getDortoirsByBatiment($idBatiment);
    }

    public function getDortoir($id)
    {
        include_once("model/dortoir.php");
        $objet = new Dortoir();
        return $objet->getDortoir($id);
    }

    public function getPlaintes()
    {
        include_once("model/plainte.php");
        $objet = new Plainte();
        return $objet->getPlaintes();
    }

    public function getPlaintesByUniversite($idUniversite)
    {
        include_once("model/plainte.php");
        $objet = new Plainte();
        return $objet->getPlaintesByUniversite($idUniversite);
    }

    public function getPlainte($id)
    {
        include_once("model/plainte.php");
        $objet = new Plainte();
        return $objet->getPlainte($id);
    }

    public function getNourritures()
    {
        include_once("model/nourriture.php");
        $objet = new Nourriture();
        return $objet->getNourritures();
    }

    public function getNourrituresByUniversite($idUniversite)
    {
        include_once("model/nourriture.php");
        $objet = new Nourriture();
        return $objet->getNourrituresByUniversite($idUniversite);
    }

    public function getNourriture($id)
    {
        include_once("model/nourriture.php");
        $objet = new Nourriture();
        return $objet->getNourriture($id);
    }





    public function addPresentations()
    {
        include("model/home.php");
        $objet = new Home();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addPresentation($datas);
    }

    public function addUniversite()
    {
        include("model/universite.php");
        $objet = new Universite();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addUniversite($datas);
    }

    public function addIntendant()
    {
        include("model/intendant.php");
        $objet = new Intendant();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addIntendant($datas);
    }
    public function addSecretaire()
    {
        include("model/secretaire.php");
        $objet = new Secretaire();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addSecretaire($datas);
    }

    public function addComptable()
    {
        include("model/comptable.php");
        $objet = new Comptable();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addComptable($datas);
    }

    public function addChargeCabine()
    {
        include("model/charge_cabines.php");
        $objet = new ChargeCabine();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addChargeCabine($datas);
    }

    public function addSecurite()
    {
        include("model/securite.php");
        $objet = new Securite();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addSecurite($datas);
    }
    public function addRestaurant()
    {
        include("model/restaurant.php");
        $objet = new agent_restauration();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addRestaurant($datas);
    }

    public function addEtudiant()
    {
        include("model/etudiant.php");
        $objet = new Etudiant();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addEtudiant($datas);
    }


    public function intendantLogin()
    {
        include("model/intendant.php");
        $objet = new Intendant();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->intendantLogin($datas);
    }
    public function secretaireLogin()
    {
        include("model/secretaire.php");
        $objet = new Secretaire();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->secretaireLogin($datas);
    }

    public function comptableLogin()
    {
        include("model/comptable.php");
        $objet = new Comptable();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->comptableLogin($datas);
    }

    public function chargeCabineLogin()
    {
        include("model/charge_cabines.php");
        $objet = new ChargeCabine();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->chargeCabineLogin($datas);
    }

    public function securiteLogin()
    {
        include("model/securite.php");
        $objet = new Securite();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->securiteLogin($datas);
    }
    public function restaurantLogin()
    {
        include("model/restaurant.php");
        $objet = new agent_restauration();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->restaurantLogin($datas);
    }

    public function etudiantLogin()
    {
        include("model/etudiant.php");
        $objet = new Etudiant();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->etudiantLogin($datas);
    }

    public function addBatiment()
    {
        include("model/batiment.php");
        $objet = new Batiment();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addBatiment($datas);
    }

    public function addDortoir()
    {
        include("model/dortoir.php");
        $objet = new Dortoir();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addDortoir($datas);
    }
    public function addPlainte()
    {
        include("model/plainte.php");
        $objet = new Plainte();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addPlainte($datas);
    }

    public function addNourriture()
    {
        include("model/nourriture.php");
        $objet = new Nourriture();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addNourriture($datas);
    }
    public function addPalier()
    {
        include("model/palier.php");
        $objet = new Palier();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->addPalier($datas);
    }





    public function deletePresentation($id)
    {
        include("model/home.php");
        $objet = new Home();
        return $objet->deletePresentation($id);
    }

    public function deleteUniversite($id)
    {
        include("model/universite.php");
        $objet = new Universite();
        return $objet->deleteUniversite($id);
    }

    public function deleteIntendant($id)
    {
        include("model/intendant.php");
        $objet = new Intendant();
        return $objet->deleteIntendant($id);
    }
    public function deleteSecretaire($id)
    {
        include("model/secretaire.php");
        $objet = new Secretaire();
        return $objet->deleteSecretaire($id);
    }

    public function deleteComptable($id)
    {
        include("model/comptable.php");
        $objet = new Comptable();
        return $objet->deleteComptable($id);
    }

    public function deleteChargeCabine($id)
    {
        include("model/charge_cabines.php");
        $objet = new ChargeCabine();
        return $objet->deleteChargeCabine($id);
    }

    public function deleteSecurite($id)
    {
        include("model/securite.php");
        $objet = new Securite();
        return $objet->deleteSecurite($id);
    }
    public function deleteRestaurant($id)
    {
        include("model/restaurant.php");
        $objet = new agent_restauration();
        return $objet->deleteRestaurant($id);
    }

    public function deleteEtudiant($id)
    {
        include("model/etudiant.php");
        $objet = new Etudiant();
        return $objet->deleteEtudiant($id);
    }

    public function deletePlainte($id)
    {
        include("model/plainte.php");
        $objet = new Plainte();
        return $objet->deletePlainte($id);
    }

    public function deleteNourriture($id)
    {
        include("model/nourriture.php");
        $objet = new Nourriture();
        return $objet->deleteNourriture($id);
    }




    public function updatePresentation($id)
    {
        include("model/home.php");
        $objet = new Home();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updatePresentation($id, $datas);
    }

    public function updateUniversite($id)
    {
        include("model/universite.php");
        $objet = new Universite();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updateUniversite($id, $datas);
    }

    public function updateIntendant($id)
    {
        include("model/intendant.php");
        $objet = new Intendant();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updateIntendant($id, $datas);
    }
    public function updateSecretaire($id)
    {
        include("model/secretaire.php");
        $objet = new Secretaire();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updateSecretaire($id, $datas);
    }

    public function updateComptable($id)
    {
        include("model/comptable.php");
        $objet = new Comptable();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updateComptable($id, $datas);
    }

    public function updateChargeCabine($id)
    {
        include("model/charge_cabines.php");
        $objet = new ChargeCabine();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updateChargeCabine($id, $datas);
    }

    public function updateSecurite($id)
    {
        include("model/securite.php");
        $objet = new Securite();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updateSecurite($id, $datas);
    }
    public function updateRestaurant($id)
    {
        include("model/restaurant.php");
        $objet = new agent_restauration();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updateRestaurant($id, $datas);
    }

    public function updateEtudiant($id)
    {
        include("model/etudiant.php");
        $objet = new Etudiant();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updateEtudiant($id, $datas);
    }

    public function updateBatiment($id)
    {
        include("model/batiment.php");
        $objet = new Batiment();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updateBatiment($id, $datas);
    }

    public function updateDortoir($id)
    {
        include("model/dortoir.php");
        $objet = new Dortoir();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updateDortoir($id, $datas);
    }
    public function updatePlainte($id)
    {
        include("model/plainte.php");
        $objet = new Plainte();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updatePlainte($id, $datas);
    }

    public function updateNourriture($id)
    {
        include("model/nourriture.php");
        $objet = new Nourriture();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updateNourriture($id, $datas);
    }
    public function updatePalier($id)
    {
        include("model/palier.php");
        $objet = new Palier();
        $datas = json_decode(file_get_contents("php://input"), true);
        return $objet->updatePalier($id, $datas);
    }
}
