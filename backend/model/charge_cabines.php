<?php
class ChargeCabine extends DbConnect
{
    public function getchargé_cabines()
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT chargé_cabines.cc_id, chargé_cabines.nom, chargé_cabines.prenom, chargé_cabines.photo, chargé_cabines.numero_telephone, universites.nom AS nom_universite, universites.ville AS ville_universite FROM chargé_cabines INNER JOIN universites ON chargé_cabines.universite_id = universites.universite_id");
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

    public function getChargeCabine($id)
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT chargé_cabines.cc_id, chargé_cabines.nom, chargé_cabines.prenom, chargé_cabines.photo, chargé_cabines.descriptions, chargé_cabines.numero_telephone, chargé_cabines.email, chargé_cabines.date_debut, universites.nom AS nom_universite, universites.ville AS ville_universite FROM chargé_cabines INNER JOIN universites ON chargé_cabines.universite_id = universites.universite_id WHERE cc_id =:id");
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


    public function addChargeCabine($datas)
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
            $email = filter_var($datas["email"], FILTER_VALIDATE_EMAIL);
            if (!$email) {
                $response = [
                    "error" => "Adresse Mail invalide."
                ];
            } else {
                $dataInsert = [
                    ":nom" => $datas["nom"],
                    ":prenom" => $datas["prenom"],
                    ":numero_telephone" => $datas["numero_telephone"],
                    ":email" => $email,
                    ":descriptions" => $datas["descriptions"],
                    ":date_debut" => $datas["date_debut"],
                    ":mot_de_passe" => password_hash($datas["mot_de_passe"], PASSWORD_DEFAULT),
                    ":photo" => $datas["photo"],
                    ":universite_id" => $datas["universite_id"]
                ];
                try {
                    $stmt = $this->dbConnect->prepare("INSERT INTO chargé_cabines (nom, prenom, numero_telephone, email, mot_de_passe, descriptions, date_debut, photo, universite_id) VALUES (:nom, :prenom, :numero_telephone, :email, :mot_de_passe, :descriptions, :date_debut, :photo, :universite_id)");
                    if ($stmt->execute($dataInsert)) {
                        $response = [
                            "succes" => "Données ajoutées avec succes!"
                        ];
                    }
                } catch (Exception $e) {
                    $response = ["error" => "Informations non ajoutées. Erreur : " . $e->getMessage()];
                }
            }
        }

        return $response;
    }


    public function deleteChargeCabine($id)
    {
        try {
            $stmt = $this->dbConnect->prepare("DELETE FROM chargé_cabines WHERE cc_id = :id");
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



    public function updateChargeCabine($id, $datas)
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
            $email = filter_var($datas["email"], FILTER_VALIDATE_EMAIL);
            if (!$email) {
                $response = [
                    "error" => "Adresse Mail invalide."
                ];
            } else {
                $dataInsert = [
                    ":id" => $id,
                    ":nom" => $datas["nom"],
                    ":prenom" => $datas["prenom"],
                    ":descriptions" => $datas["descriptions"],
                    ":numero_telephone" => $datas["numero_telephone"],
                    ":email" => $email,
                    ":date_debut" => $datas["date_debut"],
                    ":mot_de_passe" => password_hash($datas["mot_de_passe"], PASSWORD_DEFAULT),
                    ":photo" => $datas["photo"],
                    ":universite_id" => $datas["universite_id"]
                ];
                try {
                    $stmt = $this->dbConnect->prepare("UPDATE chargé_cabines SET nom = :nom, prenom = :prenom, numero_telephone = :numero_telephone, email = :email, mot_de_passe = :mot_de_passe, date_debut = :date_debut, photo = :photo, descriptions= :descriptions, universite_id = :universite_id WHERE cc_id = :id");
                    if ($stmt->execute($dataInsert)) {
                        $response = [
                            "succes" => "Données modifiées avec succes!"
                        ];
                    }
                } catch (Exception $e) {
                    $response = ["error" => "Informations non modifiées. Erreur : " . $e->getMessage()];
                }
            }
        }

        return $response;
    }


    public function chargeCabineLogin($datas)
    {
        if (!isset($datas["email"]) || !isset($datas["mot_de_passe"]) || count($datas) != 2) {
            $response = [
                "error" => "Vous devez envoyer les Informations nécessaires."
            ];
        } else {
            $email = filter_var($datas["email"], FILTER_VALIDATE_EMAIL);
            if (!$email) {
                $response = [
                    "email" => $datas["email"],
                    "error" => "Adresse Mail invalide."
                ];
            } else {
                $dataInsert = [
                    ":email" => $email
                ];
                try {
                    $stmt = $this->dbConnect->prepare("SELECT chargé_cabines.cc_id, chargé_cabines.nom, chargé_cabines.prenom, chargé_cabines.email, chargé_cabines.mot_de_passe, chargé_cabines.photo, chargé_cabines.descriptions, universites.nom AS nom_universite FROM chargé_cabines INNER JOIN universites ON universites.universite_id = chargé_cabines.universite_id WHERE chargé_cabines.email = :email LIMIT 1");
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
