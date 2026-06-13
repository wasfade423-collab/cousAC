<?php
class agent_restauration extends DbConnect
{
    public function getRestaurants()
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT agent_restauration.agent_restauration_id, agent_restauration.nom, agent_restauration.prenom, agent_restauration.photo, agent_restauration.numero_telephone, universites.nom AS nom_universite, universites.ville AS ville_universite FROM agent_restauration INNER JOIN universites ON agent_restauration.universite_id = universites.universite_id");
            if ($stmt->execute()) {
                $resultat = $stmt->fetchAll();
                if (empty($resultat) || count($resultat) == 0) {
                    $response["succes"] = "Aucune donnée pour le moment!";
                } else {
                    $response = [
                        "succes" => "Données recupérées avec succes!",
                        "donnees" => $resultat
                    ];
                }
            }
        } catch (Exception $e) {
            $response = ["error" => "Informations non récupérées. Erreur : " . $e->getMessage()];
        }

        return $response;
    }

    public function getRestaurant($id)
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT agent_restauration.agent_restauration_id, agent_restauration.nom, agent_restauration.prenom, agent_restauration.photo, agent_restauration.numero_telephone, universites.nom AS nom_universite, universites.ville AS ville_universite FROM agent_restauration INNER JOIN universites ON agent_restauration.universite_id = universites.universite_id WHERE agent_restauration_id =:id");
            if ($stmt->execute([":id" => $id])) {
                $resultat = $stmt->fetch();
                if (empty($resultat) || count($resultat) == 0) {
                    $response["succes"] = "Aucune donnée pour le moment!";
                } else {
                    $response = [
                        "succes" => "Données recupérées avec succes!",
                        "donnees" => $resultat
                    ];
                }
            }
        } catch (Exception $e) {
            $response = ["error" => "Informations non récupérées. Erreur : " . $e->getMessage()];
        }

        return $response;
    }



    public function addRestaurant($datas)
    {
        foreach ($datas as $key => $value) {
            $value = htmlspecialchars(trim($value));
            if (empty($value)) {
                $dataVide[$key] = $value;
            }
        }
        if (!empty($dataVide)) {
            $response = [
                "error" => "Certaines informations ne sont pas fournies",
                "données" => array_keys($dataVide)
            ];
        } else {
            $dataInsert = [
                ":nom" => $datas["nom"],
                ":prenom" => $datas["prenom"],
                ":numero_telephone" => $datas["numero_telephone"],
                ":date_debut" => $datas["date_debut"],
                ":code_personnel" => $datas["code_personnel"],
                ":mot_de_passe" => password_hash($datas["mot_de_passe"], PASSWORD_DEFAULT),
                ":photo" => $datas["photo"],
                ":universite_id" => $datas["universite_id"]
            ];
            try {
                $stmt = $this->dbConnect->prepare("INSERT INTO agent_restauration (nom, prenom, numero_telephone, mot_de_passe, date_debut, code_personnel, photo, universite_id) VALUES (:nom, :prenom, :numero_telephone, :mot_de_passe, :date_debut, :code_personnel, :photo, :universite_id)");
                if ($stmt->execute($dataInsert)) {
                    $response = [
                        "succes" => "Données ajoutées avec succes!"
                    ];
                }
            } catch (Exception $e) {
                $response = ["error" => "Informations non ajoutées. Erreur : " . $e->getMessage()];
            }
        }

        return $response;
    }


    public function deleteRestaurant($id)
    {
        try {
            $stmt = $this->dbConnect->prepare("DELETE FROM agent_restauration WHERE agent_restauration_id = :id");
            if ($stmt->execute([":id" => $id])) {
                $response = [
                    "succes" => "Données supprimées avec succes!"
                ];
            }
        } catch (Exception $e) {
            $response = ["error" => "Informations non ajoutées. Erreur : " . $e->getMessage()];
        }

        return $response;
    }



    public function updateRestaurant($id, $datas)
    {
        foreach ($datas as $key => $value) {
            $value = htmlspecialchars(trim($value));
            if (empty($value)) {
                $dataVide[$key] = $value;
            }
        }
        if (!empty($dataVide)) {
            $response = [
                "error" => "Certaines informations ne sont pas fournies",
                "données" => array_keys($dataVide)
            ];
        } else {
            $dataInsert = [
                ":id" => $id,
                ":nom" => $datas["nom"],
                ":prenom" => $datas["prenom"],
                ":numero_telephone" => $datas["numero_telephone"],
                ":date_debut" => $datas["date_debut"],
                ":mot_de_passe" => password_hash($datas["mot_de_passe"], PASSWORD_DEFAULT),
                ":code_personnel" => $datas["code_personnel"],
                ":photo" => $datas["photo"],
                ":universite_id" => $datas["universite_id"]
            ];
            try {
                $stmt = $this->dbConnect->prepare("UPDATE agent_restauration SET nom = :nom, prenom = :prenom, numero_telephone = :numero_telephone, mot_de_passe = :mot_de_passe, date_debut = :date_debut, code_personnel = :code_personnel, photo = :photo, universite_id = :universite_id WHERE agent_restauration_id = :id");
                if ($stmt->execute($dataInsert)) {
                    $response = [
                        "succes" => "Données modifiées avec succes!"
                    ];
                }
            } catch (Exception $e) {
                $response = ["error" => "Informations non modifiées. Erreur : " . $e->getMessage()];
            }
        }

        return $response;
    }

    public function restaurantLogin($datas)
    {
        if (!isset($datas["numero_telephone"]) || !isset($datas["mot_de_passe"]) || count($datas) != 2) {
            $response = [
                "error" => "Vous devez envoyer les Informations nécessaires."
            ];
        } else { {
                $dataInsert = [
                    ":numero_telephone" => $datas["numero_telephone"]
                ];
                try {
                    $stmt = $this->dbConnect->prepare("SELECT agent_restauration.agent_restauration_id, agent_restauration.nom, agent_restauration.prenom, universites.nom AS nom_universite FROM agent_restauration INNER JOIN universites ON universites.universite_id = agent_restauration.universite_id WHERE agent_restauration.numero_telephone = :numero_telephone LIMIT 1");
                    if ($stmt->execute($dataInsert)) {
                        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($resultat && password_verify($datas["mot_de_passe"], $resultat["mot_de_passe"])) {
                            unset($resultat["mot_de_passe"]);
                            $response = [
                                "succes" => "Connexion Réussie",
                                "données" => $resultat
                            ];
                        } else {
                            $response = [
                                "error" => "Identifiants incorrects"
                            ];
                        }
                    }
                } catch (Exception $e) {
                    $response = ["error" => "Connexion Echouées. Erreur : " . $e->getMessage()];
                }
            }
        }
        return $response;
    }
}
