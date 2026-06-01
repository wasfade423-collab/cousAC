<?php
    class Universite extends DbConnect{
        public function getUniversites(){
            try{
                $stmt = $this->dbConnect->prepare("SELECT descriptions, nom, ville, numero_telephone FROM universites");
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

        public function getUniversite($id){
            try{
                $stmt = $this->dbConnect->prepare("SELECT * FROM universites WHERE descriptions =:id");
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


        public function addUniversite($datas){
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
                    ":descriptions"=>$datas["descriptions"],
                    ":ville"=>$datas["ville"],
                    ":numero_telephone"=>$datas["numero_telephone"],
                    ":email"=>$datas["email"],
                    ":photos"=>$datas["photos"],
                    ":photo_plan"=>$datas["photo_plan"]                    
                ];
                try{
                    $stmt = $this->dbConnect->prepare("INSERT INTO universites (nom, descriptions, ville, numero_telephone, email, photos, photo_plan) VALUES (:nom, :descriptions, :ville, :numero_telephone, :email, :photos, :photo_plan)");
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
        
        
        public function deleteUniversite($id){
                try{
                    $stmt = $this->dbConnect->prepare("DELETE FROM universites WHERE universite_id = :id");
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
        
        


        public function updateUniversite($id, $datas){
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
                    ":descriptions"=>$datas["descriptions"],
                    ":ville"=>$datas["ville"],
                    ":numero_telephone"=>$datas["numero_telephone"],
                    ":email"=>$datas["email"],
                    ":photos"=>$datas["photos"],
                    ":photo_plan"=>$datas["photo_plan"]                    
                ];
                try{
                    $stmt = $this->dbConnect->prepare("UPDATE universites SET (nom = :nom, descriptions = :descriptions, ville = :ville, numero_telephone = :numero_telephone, email = :email, photos = :photos, photo_plan = :photo_plan) WHERE universite_id = :id");
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