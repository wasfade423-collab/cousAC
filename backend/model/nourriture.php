<?php
class Nourriture extends DbConnect
{
    public function getNourritures()
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT nourritures.nourriture_id, nourritures.nom, nourritures.prix_ticket, universites.nom AS nom_universite, universites.ville AS ville_universite FROM nourritures INNER JOIN universites ON nourritures.universite_id = universites.universite_id GROUP BY nourritures.universite_id");
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

    public function getNourrituresByUniversite($idUniversite)
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT nourritures.nourriture_id, nourritures.nom, nourritures.prix_ticket, universites.nom AS nom_universite, universites.ville AS ville_universite FROM nourritures INNER JOIN universites ON nourritures.universite_id = universites.universite_id WHERE nourritures.universite_id = :id");
            if ($stmt->execute([":id" => $idUniversite])) {
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

    public function getNourriture($id)
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT nourritures.nourriture_id, nourritures.nom, nourritures.prix_ticket, nourritures.menu_details, nourritures.moment_repas, universites.nom AS nom_universite, universites.ville AS ville_universite FROM nourritures INNER JOIN universites ON nourritures.universite_id = universites.universite_id WHERE nourritures.nourriture_id = :id");
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





    public function addNourriture($datas)
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
                ":moment_repas" => $datas["moment_repas"],
                ":menu_details" => $datas["menu_details"],
                ":universite_id" => $datas["universite_id"],
                ":prix_ticket" => $datas["prix_ticket"]
            ];
            try {
                $stmt = $this->dbConnect->prepare("INSERT INTO nourritures (nom, menu_details, prix_ticket, universite_id) VALUES (:nom, :menu_details, :prix_ticket, :universite_id)");
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


    public function deleteNourriture($id)
    {
        try {
            $stmt = $this->dbConnect->prepare("DELETE FROM nourritures WHERE id = :id");
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



    public function updateNourriture($id, $datas)
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
                ":moment_repas" => $datas["moment_repas"],
                ":menu_details" => $datas["menu_details"],
                ":universite_id" => $datas["universite_id"],
                ":prix_ticket" => $datas["prix_ticket"]
            ];
            try {
                $stmt = $this->dbConnect->prepare("UPDATE nourritures SET nom = :nom, menu_details = :menu_details, prix_ticket = :prix_ticket, universite_id = :universite_id WHERE nourriture_id = :id");
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
}
