<?php
class Intendant extends DbConnect
{
    public function getIntendants()
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT intendants.intendant_id, intendants.nom, intendants.prenom, intendants.numero_telephone, intendants.email, intendants.photo, universites.nom AS nom_universite, universites.ville AS ville_universite, intendants.code_personnel FROM intendants INNER JOIN universites ON intendants.universite_id = universites.universite_id");
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

    public function getIntendant($id)
    {
        try {
            $stmt = $this->dbConnect->prepare("SELECT intendants.intendant_id, intendants.nom, intendants.prenom, intendants.numero_telephone, intendants.email, intendants.descriptions, intendants.photo, intendants.date_debut, universites.nom AS nom_universite, universites.ville AS ville_universite, intendants.code_personnel FROM intendants INNER JOIN universites ON intendants.universite_id = universites.universite_id WHERE intendant_id =:id");
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


    public function addIntendant($datas)
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
                    ":code_personnel" => $datas["code_personnel"],
                    ":descriptions" => $datas["descriptions"],
                    ":numero_telephone" => $datas["numero_telephone"],
                    ":email" => $email,
                    ":date_debut" => $datas["date_debut"],
                    ":mot_de_passe" => password_hash($datas["mot_de_passe"], PASSWORD_DEFAULT),
                    ":photo" => $datas["photo"],
                    ":universite_id" => $datas["universite_id"]
                ];
                try {
                    $stmt = $this->dbConnect->prepare("INSERT INTO intendants (nom, prenom, code_personnel, numero_telephone, email, mot_de_passe, date_debut, descriptions, photo, universite_id) VALUES (:nom, :prenom, :code_personnel, :numero_telephone, :email, :mot_de_passe, :date_debut, :descriptions, :photo, :universite_id)");
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


    public function deleteIntendant($id)
    {
        try {
            $stmt = $this->dbConnect->prepare("DELETE FROM intendants WHERE intendant_id = :id");
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


    public function updateIntendant($id, $datas)
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
                    ":code_personnel" => $datas["code_personnel"],
                    ":descriptions" => $datas["descriptions"],
                    ":numero_telephone" => $datas["numero_telephone"],
                    ":email" => $email,
                    ":date_debut" => $datas["date_debut"],
                    ":mot_de_passe" => password_hash($datas["mot_de_passe"], PASSWORD_DEFAULT),
                    ":photo" => $datas["photo"],
                    ":universite_id" => $datas["universite_id"]
                ];
                try {
                    $stmt = $this->dbConnect->prepare("UPDATE intendants SET nom = :nom, prenom = :prenom, code_personnel = :code_personnel, numero_telephone = :numero_telephone, email = :email, descriptions = :descriptions, mot_de_passe = :mot_de_passe, date_debut = :date_debut, photo = :photo, universite_id = :universite_id WHERE intendant_id = :id");
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


    public function intendantLogin($datas)
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
                    $stmt = $this->dbConnect->prepare("SELECT intendants.intendant_id, intendants.nom, intendants.prenom, intendants.email, intendants.mot_de_passe, intendants.photo, universites.nom AS nom_universite FROM intendants INNER JOIN universites ON universites.universite_id = intendants.universite_id WHERE intendants.email = :email LIMIT 1");
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
