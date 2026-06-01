<?php
    class Plainte extends DbConnect{
        public function getPlaintes(){
            try{
                $stmt = $this->dbConnect->prepare("SELECT plaintes.plainte_id, plaintes.sujet, plaintes.date_plainte, universites.nom, universtes.ville FROM plaintes INNER JOIN universites ON plaintes.universite_id = universites.universite_id GROUP BY plaintes.universite_id");
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

        public function getPlaintesByUniversite($idUniversite){
            try{
                $stmt = $this->dbConnect->prepare("SELECT plaintes.plainte_id, plaintes.sujet, plaintes.date_plainte, universites.nom, universtes.ville FROM plaintes INNER JOIN universites ON plaintes.universite_id = universites.universite_id WHERE plaintes.universite_id = :id");
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

        public function getPlainte($id){
            try{
                $stmt = $this->dbConnect->prepare("SELECT plaintes.plainte_id, plaintes.sujet, plaintes.description, plaintes.date_plainte, plaintes.photos, etudiants.nom, etudiants.prenom, universites.nom, universtes.ville FROM plaintes INNER JOIN universites ON plaintes.universite_id = universites.universite_id INNER JOIN etudiants ON plaintes.etudiant_id = etudiants.etudiant_id WHERE plaintes.plainte_id = :id");
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
        
        
        public function addPlainte($datas){
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
                    ":sujet"=>$datas["sujet"],
                    ":description"=>$datas["description"],
                    ":photos"=>$datas["photos"],    
                    ":universite_id"=>$datas["universite_id"], 
                    ":etudiant_id"=>$datas["etudiant_id"], 
                    ":date_plainte"=>$datas["date_plainte"]                
                ];
                try{
                    $stmt = $this->dbConnect->prepare("INSERT INTO plaintes (sujet, description, photos, etudiant_id, date_plainte, universite_id) VALUES (:sujet, :description, :photos, :etudiant_id, :date_plainte, :universite_id)");
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
        
        
        public function deletePlainte($id){
                try{
                    $stmt = $this->dbConnect->prepare("DELETE FROM plaintes WHERE id = :id");
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
        
        

        public function updatePlainte($id, $datas){
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
                    ":sujet"=>$datas["sujet"],
                    ":description"=>$datas["description"],
                    ":photos"=>$datas["photos"],    
                    ":universite_id"=>$datas["universite_id"], 
                    ":etudiant_id"=>$datas["etudiant_id"], 
                    ":date_plainte"=>$datas["date_plainte"]               
                ];
                try{
                    $stmt = $this->dbConnect->prepare("UPDATE plaintes SET sujet = :sujet, description = :description, photos = :photos, etudiant_id = :etudiant_id, date_plainte = :date_plainte, universite_id = :universite_id WHERE plainte_id = :id");
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