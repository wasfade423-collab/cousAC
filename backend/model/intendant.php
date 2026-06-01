<?php
    class Intendant extends DbConnect{
        public function getIntendants(){
            try{
                $stmt = $this->dbConnect->prepare("SELECT intendants.intendant_id, intendants.nom, intendants.prenom, intendants.numero_telephone, intendants.photo, unversites.nom, unversites.code_personnel FROM intendants INNER JOIN universites ON intendants.universite_id = universites.unversite_id");
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

        public function getIntendant($id){
            try{
                $stmt = $this->dbConnect->prepare("SELECT intendants.intendant_id, intendants.nom, intendants.prenom, intendants.numero_telephone, intendants.photo, intendants.date_debut, unversites.nom, unversites.email, unversites.code_personnel FROM intendants INNER JOIN universites ON intendants.universite_id = universites.unversite_id WHERE intendant_id =:id");
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


        public function addIntendant($datas){
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
                    $stmt = $this->dbConnect->prepare("INSERT INTO intendants (nom, prenom, code_personnel, numero_telephone, email, mot_de_passe, date_debut, photo, universite_id) VALUES (:nom, :prenom, :code_personnel, :numero_telephone, :email, :mot_de_passe, :date_debut, :photo, :universite_id)");
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
        
        
        public function deleteIntendant($id){
                try{
                    $stmt = $this->dbConnect->prepare("DELETE FROM intendants WHERE intendant_id = :id");
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
        
        
        public function updateIntendant($id, $datas){
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
                    $stmt = $this->dbConnect->prepare("UPDATE intendants SET nom = :nom, prenom = :prenom, code_personnel = :code_personnel, numero_telephone = :numero_telephone, email = :email, mot_de_passe = :mot_de_passe, date_debut = :date_debut, photo = :photo, universite_id = :universite_id WHERE intendant_id = :id");
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