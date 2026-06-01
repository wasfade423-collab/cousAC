<?php
    class Secretaire extends DbConnect{
        public function getSecretaires(){
            try{
                $stmt = $this->dbConnect->prepare("SELECT secretaires.secretaire_id, secretaires.nom, secretaires.prenom, secretaires.photo, secretaires.numero_telephone, universites.nom, universites.ville FROM secretaires INNER JOIN universites ON secretaires.universite_id = universites.universite_id");
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

        public function getSecretaire($id){
            try{
                $stmt = $this->dbConnect->prepare("SELECT secretaires.secretaire_id, secretaires.nom, secretaires.prenom, secretaires.photo, secretaires.numero_telephone, secretaires.email, universites.nom, universites.ville FROM secretaires INNER JOIN universites ON secretaires.universite_id = universites.universite_id WHERE secretaire_id =:id");
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


        public function addSecretaire($datas){
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
                    ":code_personnel"=>$datas["code_personnel"],
                    ":numero_telephone"=>$datas["numero_telephone"],
                    ":email"=>$datas["email"],
                    ":date_debut"=>$datas["date_debut"],
                    ":mot_de_passe"=>$datas["mot_de_passe"],
                    ":photo"=>$datas["photo"],    
                    ":universite_id"=>$datas["universite_id"]                
                ];
                try{
                    $stmt = $this->dbConnect->prepare("INSERT INTO secretaires (nom, prenom, code_personnel, numero_telephone, email, mot_de_passe, date_debut, photo, role, universite_id) VALUES (:nom, :prenom, :code_personnel, :numero_telephone, :email, :mot_de_passe, :date_debut, :photo, :role, :universite_id)");
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
        
        

        public function deleteSecretaire($id){
                try{
                    $stmt = $this->dbConnect->prepare("DELETE FROM secretaires WHERE secretaire_id = :id");
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
        
        
        public function updateSecretaire($id, $datas){
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
                    ":code_personnel"=>$datas["code_personnel"],
                    ":numero_telephone"=>$datas["numero_telephone"],
                    ":email"=>$datas["email"],
                    ":date_debut"=>$datas["date_debut"],
                    ":mot_de_passe"=>$datas["mot_de_passe"],
                    ":photo"=>$datas["photo"],    
                    ":universite_id"=>$datas["universite_id"]                
                ];
                try{
                    $stmt = $this->dbConnect->prepare("UPDATE secretaires SET nom = :nom, prenom = :prenom, code_personnel = :code_personnel, numero_telephone = :numero_telephone, email = :email, mot_de_passe = :mot_de_passe, date_debut = :date_debut, photo = :photo, role = :role, universite_id = :universite_id WHERE secretaire_id = :id");
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