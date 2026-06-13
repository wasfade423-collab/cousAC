<?php
class Comptable extends DbConnect
{
    public function getComptables()
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT comptables.comptable_id, comptables.nom, comptables.prenom, comptables.photo, comptables.numero_telephone, comptables.code_personnel, universites.nom AS nom_universite, universites.ville AS ville_universite FROM comptables INNER JOIN universites ON comptables.universite_id = universites.universite_id");
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

    public function getComptable($id)
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT comptables.comptable_id, comptables.nom, comptables.prenom, comptables.photo, comptables.descriptions, comptables.numero_telephone, comptables.code_personnel, comptables.email, comptables.date_debut, universites.nom AS nom_universite, universites.ville AS ville_universite FROM comptables INNER JOIN universites ON comptables.universite_id = universites.universite_id WHERE comptable_id =:id");
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




    public function addComptable($datas)
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
                ":code_personnel" => $datas["code_personnel"],
                ":descriptions" => $datas["descriptions"],
                ":numero_telephone" => $datas["numero_telephone"],
                ":email" => $datas["email"],
                ":date_debut" => $datas["date_debut"],
                ":mot_de_passe" => password_hash($datas["mot_de_passe"], PASSWORD_DEFAULT),
                ":photo" => $datas["photo"],
                ":universite_id" => $datas["universite_id"]
            ];
            try {
                $stmt = $this->dbConnect->prepare("INSERT INTO comptables (nom, prenom, code_personnel, numero_telephone,  descriptions, email, mot_de_passe, date_debut, photo, universite_id) VALUES (:nom, :prenom, :code_personnel, :numero_telephone, :descriptions,  :email, :mot_de_passe, :date_debut, :photo, :universite_id)");
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


    public function deleteComptable($id)
    {
        try {
            $stmt = $this->dbConnect->prepare("DELETE FROM comptables WHERE comptable_id = :id");
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


    public function updateComptable($id, $datas)
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
                ":code_comptable" => $datas["code_comptable"],
                ":descriptions" => $datas["descriptions"],
                ":numero_telephone" => $datas["numero_telephone"],
                ":email" => $datas["email"],
                ":date_debut" => $datas["date_debut"],
                ":mot_de_passe" => password_hash($datas["mot_de_passe"], PASSWORD_DEFAULT),
                ":photo" => $datas["photo"],
                ":universite_id" => $datas["universite_id"]
            ];
            try {
                $stmt = $this->dbConnect->prepare("UPDATE comptables SET nom = :nom, prenom = :prenom, code_comptable = :code_comptable, numero_telephone = :numero_telephone, email = :email, mot_de_passe = :mot_de_passe, date_debut = :date_debut, photo = :photo, descriptions = :descriptions, universite_id = :universite_id WHERE comptable_id = :id");
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


    public function comptableLogin($datas)
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
                    $stmt = $this->dbConnect->prepare("SELECT comptables.comptable_id, comptables.nom, comptables.prenom, comptables.email, comptables.mot_de_passe, comptables.photo, comptables.descriptions, universites.nom AS nom_universite FROM comptables INNER JOIN universites ON universites.universite_id = comptables.universite_id WHERE comptables.email = :email LIMIT 1");
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
