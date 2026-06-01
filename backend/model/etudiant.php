<?php
    class Etudiant extends DbConnect{
        public function getEtudiants(){
            try{
                $stmt = $this->dbConnect->prepare("SELECT etudiants.etudiant_id, etudiants.nom, etudiants.prenom, etudiants.numero_telephone, etudiants.email, etudiants.photo, etudiants.ecole, universites.nom, universtes.ville FROM etudidants INNER JOIN universites ON etudiants.universite_id = universites.universite_id GROUP BY etudiants.universite_id");
                if($stmt->execute()){
                    $resultat = $stmt->fetchAll();
                    if(empty($resultat) || count($resultat) == 0){
                        $response["succes"] = "Aucune donnée pour le moment!";
                    }else{
                        $response = [
                            "succes"=>"Données recupérées avec succes!",
                            "donnees"=>$resultat
                        ];
                    }
                }

            }catch(Exception $e){
                $response = ["error"=>"Informations non récupérées. Erreur : ".$e->getMessage()];
            }

            return $response;
        }

        public function getEtudiantsByUniversite($idUniversite){
            try{
                $stmt = $this->dbConnect->prepare("SELECT etudiants.etudiant_id, etudiants.nom, etudiants.prenom, etudiants.numero_telephone, etudiants.email, etudiants.photo, etudiants.ecole, universites.nom, universtes.ville FROM etudiants INNER JOIN universites ON etudiants.universite_id = universites.universite_id WHERE etudiants.universite_id = :id");
                if($stmt->execute([":id"=>$idUniversite])){
                    $resultat = $stmt->fetchAll();
                    if(empty($resultat) || count($resultat) == 0){
                        $response["succes"] = "Aucune donnée pour le moment!";
                    }else{
                        $response = [
                            "succes"=>"Données recupérées avec succes!",
                            "donnees"=>$resultat
                        ];
                    }
                }

            }catch(Exception $e){
                $response = ["error"=>"Informations non récupérées. Erreur : ".$e->getMessage()];
            }

            return $response;
        }

        public function getEtudiant($id){
            try{
                $stmt = $this->dbConnect->prepare("SELECT etudiants.etudiant_id, etudiants.nom, etudiants.prenom, etudiants.numero_telephone, etudiants.email, etudiants.photo, etudiants.ecole, etudiants.filiere, etudiants.niveau_etude, universites.nom, universtes.ville FROM etudiants INNER JOIN universites ON etudiants.universite_id = universites.universite_id WHERE etudiants.etudiant_id = :id");
                if($stmt->execute([":id"=>$id])){
                    $resultat = $stmt->fetch();
                    if(empty($resultat) || count($resultat) == 0){
                        $response["succes"] = "Aucune donnée pour le moment!";
                    }else{
                        $response = [
                            "succes"=>"Données recupérées avec succes!",
                            "donnees"=>$resultat
                        ];
                    }
                }

            }catch(Exception $e){
                $response = ["error"=>"Informations non récupérées. Erreur : ".$e->getMessage()];
            }

            return $response;            
        }     
        
        
        public function addEtudiant($datas){
            foreach($datas as $key=>$value){
                $value = htmlspecialchars(trim($value));
                if(empty($value)){
                    $dataVide[$key] = $value;
                }
            }
            if(!empty($dataVide)){
                $response = [
                            "error"=>"Certaines informations ne sont pas fournies",
                            "données"=>array_keys($dataVide)
                        ];
            }else{
                $dataInsert = [
                    ":nom"=>$datas["nom"],
                    ":prenom"=>$datas["prenom"],
                    ":numero_telephone"=>$datas["numero_telephone"],
                    ":email"=>$datas["email"],
                    ":date_debut"=>$datas["date_debut"],
                    ":mot_de_passe"=>$datas["mot_de_passe"],
                    ":photo"=>$datas["photo"],  
                    ":filiere"=>$datas["filiere"],
                    ":ecole"=>$datas["ecole"],
                    ":niveau_etude"=>$datas["niveau_etude"],                     
                    ":universite_id"=>$datas["universite_id"]                
                ];
                try{
                    $stmt = $this->dbConnect->prepare("INSERT INTO etudiants (nom, prenom, numero_telephone, email, mot_de_passe, date_debut, photo, filiere, ecole, niveau_etude, universite_id) VALUES (:nom, :prenom, :numero_telephone, :email, :mot_de_passe, :date_debut, :photo, :filiere, :ecole, :niveau_etude, :universite_id)");
                    if($stmt->execute($dataInsert)){
                        $response = [
                            "succes"=>"Données ajoutées avec succes!"
                        ];                        
                    }
                }catch(Exception $e){
                    $response = ["error"=>"Informations non ajoutées. Erreur : ".$e->getMessage()];
                }
            }

            return $response;
        }  
        
        
        public function deleteEtudiant($id){
                try{
                    $stmt = $this->dbConnect->prepare("DELETE FROM etudiants WHERE etudiant_id = :id");
                    if($stmt->execute([":id"=>$id])){
                        $response = [
                            "succes"=>"Données supprimées avec succes!"
                        ];
                    }
                }catch(Exception $e){
                    $response = ["error"=>"Informations non ajoutées. Erreur : ".$e->getMessage()];
                }

            return $response;            
        }  
        
        

        public function updateEtudiant($id, $datas){
            foreach($datas as $key=>$value){
                $value = htmlspecialchars(trim($value));
                if(empty($value)){
                    $dataVide[$key] = $value;
                }
            }
            if(!empty($dataVide)){
                $response = [
                            "error"=>"Certaines informations ne sont pas fournies",
                            "données"=>array_keys($dataVide)
                        ];
            }else{
                $dataInsert = [
                    ":id"=>$id,
                    ":nom"=>$datas["nom"],
                    ":prenom"=>$datas["prenom"],
                    ":numero_telephone"=>$datas["numero_telephone"],
                    ":email"=>$datas["email"],
                    ":date_debut"=>$datas["date_debut"],
                    ":mot_de_passe"=>$datas["mot_de_passe"],
                    ":photo"=>$datas["photo"],  
                    ":filiere"=>$datas["filiere"],
                    ":ecole"=>$datas["ecole"],
                    ":niveau_etude"=>$datas["niveau_etude"],                     
                    ":universite_id"=>$datas["universite_id"]                
                ];
                try{
                    $stmt = $this->dbConnect->prepare("UPDATE etudiants SET (nom = :nom, prenom = :prenom, numero_telephone = :numero_telephone, email = :email, mot_de_passe = :mot_de_passe, date_debut = :date_debut, photo = :photo, filiere = :filiere, ecole = :ecole, niveau_etude = :niveau_etude, universite_id = :universite_id) WHERE etudiant_id = :id");
                    if($stmt->execute($dataInsert)){
                        $response = [
                            "succes"=>"Données modifiées avec succes!"
                        ];                        
                    }
                }catch(Exception $e){
                    $response = ["error"=>"Informations non modifiées. Erreur : ".$e->getMessage()];
                }
            }

            return $response;
        }        
    }
?>