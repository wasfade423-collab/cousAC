<?php
    class Home extends DbConnect{
        public function getHome(){
            try{
                $stmt = $this->dbConnect->prepare("SELECT * FROM presentations");
                if($stmt->execute()){
                    $resultat = $stmt->fetchAll();
                    if(empty($resultat) || count($resultat) == 0){
                        $response["succes"] = "Aucune donnée pour le moment!";
                    }else{
                        $response = [
                            "succes"=>"Données recupérées avec succes!",
                            "données"=>$resultat
                        ];
                    }

                }
            }catch(Exception $e){
                $response = ["error"=>"Informations non récupérées. Erreur : ".$e->getMessage()];
            }
            return $response;
        }
        public function addPresentation($datas){
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
                    ":description"=>$datas["description"],
                    ":universite_id"=>$datas["universite_id"],
                    ":reglements"=>$datas["reglements"],
                    ":images"=>$datas["images"]
                ];
                try{
                    $stmt = $this->dbConnect->prepare("INSERT INTO presentations (description, universite_id, reglements, images) VALUES (:description, :universite_id, :reglements, :images)");
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

        public function deletePresentation($id){
                try{
                    $stmt = $this->dbConnect->prepare("DELETE FROM presentations WHERE id = :id");
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
        
        
        public function updatePresentation($id, $datas){
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
                    ":description"=>$datas["description"],
                    ":universite_id"=>$datas["universite_id"],
                    ":reglements"=>$datas["reglements"],
                    ":images"=>$datas["images"]
                ];
                try{
                    $stmt = $this->dbConnect->prepare("UPDATE presentations SET (description = :description, universite_id = :universite_id, reglements = :reglements, images = :images) WHERE id =:id");
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