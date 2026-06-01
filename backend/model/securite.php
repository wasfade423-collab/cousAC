<?php
    class Securite extends DbConnect{
        public function getSecurites(){
            try{
                $stmt = $this->dbConnect->prepare("SELECT agent_securite.securite_id, agent_securite.nom, agent_securite.prenom, agent_securite.photo, agent_securite.numero_telephone, universites.nom, universites.ville FROM agent_securite INNER JOIN universites ON agent_securite.universite_id = universites.universite_id");
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

        public function getSecurite($id){
            try{
                $stmt = $this->dbConnect->prepare("SELECT agent_securite.securite_id, agent_securite.nom, agent_securite.prenom, agent_securite.photo, agent_securite.numero_telephone, agent_securite.chef_securite, universites.nom, universites.ville FROM agent_securite INNER JOIN universites ON agent_securite.universite_id = universites.universite_id WHERE securite_id =:id");
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


        public function addSecurite($datas){
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
                    ":chef_securite"=>$datas["chef_securite"],
                    ":date_debut"=>$datas["date_debut"],
                    ":mot_de_passe"=>$datas["mot_de_passe"],
                    ":photo"=>$datas["photo"],    
                    ":universite_id"=>$datas["universite_id"]                
                ];
                try{
                    $stmt = $this->dbConnect->prepare("INSERT INTO agent_securite (nom, prenom, numero_telephone, chef_securite, mot_de_passe, date_debut, photo, universite_id) VALUES (:nom, :prenom, :numero_telephone, :chef_securite, :mot_de_passe, :date_debut, :photo, :universite_id)");
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
        
        
        public function deleteSecurite($id){
                try{
                    $stmt = $this->dbConnect->prepare("DELETE FROM agent_securite WHERE securite_id = :id");
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
        
        

        public function updateSecurite($id, $datas){
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
                    ":chef_securite"=>$datas["chef_securite"],
                    ":date_debut"=>$datas["date_debut"],
                    ":mot_de_passe"=>$datas["mot_de_passe"],
                    ":photo"=>$datas["photo"],    
                    ":universite_id"=>$datas["universite_id"]                
                ];
                try{
                    $stmt = $this->dbConnect->prepare("UPDATE agent_securite SET (nom = :nom, prenom = :prenom, numero_telephone = :numero_telephone, chef_securite = :chef_securite, mot_de_passe = :mot_de_passe, date_debut = :date_debut, photo = :photo, universite_id = :universite_id) WHERE securite_id = :id");
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