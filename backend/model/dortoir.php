<?php
class Dortoir extends DbConnect
{
    public function getDortoirs()
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT dortoirs.dortoir_id, dortoirs.libele_chambre, dortoirs.photo, batiments.libele_batiment FROM dortoirs INNER JOIN batiments ON dortoirs.batiment_id = batiments.batiment_id GROUP BY dortoirs.batiment_id");
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

    public function getDortoirsByBatiment($idBatiment)
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT dortoirs.dortoir_id, dortoirs.libele_chambre, dortoirs.photo, paliers.libele_palier, batiments.libele_batiment FROM dortoirs INNER JOIN batiments ON dortoirs.batiment_id = batiments.batiment_id INNER JOIN paliers ON dortoirs.palier_id = paliers.palier_id WHERE dortoirs.batiment_id = :id");
            if ($stmt->execute([":id" => $idBatiment])) {
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

    public function getDortoir($id)
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT dortoirs.dortoir_id, dortoirs.libele_chambre, dortoirs.photo, paliers.libele_palier, batiments.libele_batiment FROM dortoirs INNER JOIN batiments ON dortoirs.batiment_id = batiments.batiment_id INNER JOIN paliers ON dortoirs.palier_id = paliers.palier_id WHERE dortoirs.dortoir_id = :id");
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


    public function addDortoir($datas)
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
                ":libele_chambre" => $datas["libele_chambre"],
                ":photo" => $datas["photo"],
                ":palier_id" => $datas["palier_id"],
                ":batiment_id" => $datas["batiment_id"],
                ":fonctionnelle" => $datas["fonctionnelle"]
            ];
            try {
                $stmt = $this->dbConnect->prepare("INSERT INTO dortoirs (libele_chambre, photo, palier_id, batiment_id, fonctionnelle) VALUES (:libele_chambre, :photo, :palier_id, :batiment_id, :fonctionnelle)");
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

    public function updateDortoir($id, $datas)
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
                ":libele_chambre" => $datas["libele_chambre"],
                ":photo" => $datas["photo"],
                ":palier_id" => $datas["palier_id"],
                ":batiment_id" => $datas["batiment_id"],
                ":fonctionnelle" => $datas["fonctionnelle"]
            ];
            try {
                $stmt = $this->dbConnect->prepare("UPDATE dortoirs SET libele_chambre = :libele_chambre, photo = :photo, palier_id = :palier_id, batiment_id = :batiment_id, fonctionnelle = :fonctionnelle WHERE dortoir_id = :id");
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
