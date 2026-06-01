<?php
    class Batiment extends DbConnect{
        public function getBatiments(){
            try{
                $stmt = $this->dbConnect->prepare("SELECT batiments.batiment_id, batiments.libele_batiment, batiments.photos, universites.libele_batiment, universtes.ville FROM batiments INNER JOIN universites ON batiments.universite_id = universites.universite_id GROUP BY batiments.universite_id");
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

        public function getBatimentsByUniversite($idUniversite){
            try{
                $stmt = $this->dbConnect->prepare("SELECT batiments.batiment_id, batiments.libele_batiment, batiments.photos, universites.libele_batiment, universtes.ville FROM batiments INNER JOIN universites ON batiments.universite_id = universites.universite_id WHERE batiments.universite_id = :id");
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

        public function getBatiment($id){
            try{
                $stmt = $this->dbConnect->prepare("SELECT batiments.batiment_id, batiments.libele_batiment, batiments.photos, universites.libele_batiment, universtes.ville FROM batiments INNER JOIN universites ON batiments.universite_id = universites.universite_id WHERE batiments.batiment_id = :id");
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
        
        
        public function addBatiment($datas){
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
                    ":libele_batiment"=>$datas["libele_batiment"],
                    ":mot_de_passe"=>$datas["mot_de_passe"],
                    ":photos"=>$datas["photos"],    
                    ":universite_id"=>$datas["universite_id"]                
                ];
                try{
                    $stmt = $this->dbConnect->prepare("INSERT INTO batiments (libele_batiment, photos, universite_id) VALUES (:libele_batiment, :photos, :universite_id)");
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
        
        

        public function updateBatiment($id, $datas){
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
                    ":libele_batiment"=>$datas["libele_batiment"],
                    ":mot_de_passe"=>$datas["mot_de_passe"],
                    ":photos"=>$datas["photos"],    
                    ":universite_id"=>$datas["universite_id"]                
                ];
                try{
                    $stmt = $this->dbConnect->prepare("UPDATE batiments SET libele_batiment = :libele_batiment, photos = :photos, universite_id = :universite_id WHERE batiment_id = :id");
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