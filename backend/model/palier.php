<?php
    class Palier extends DbConnect{
        public function addPalier($datas){
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
                    ":libele_palier"=>$datas["libele_palier"],
                    ":etudiant_id"=>$datas["etudiant_id"],    
                    ":batiment_id"=>$datas["batiment_id"]             
                ];
                try{
                    $stmt = $this->dbConnect->prepare("INSERT INTO paliers (libele_palier, etudiant_id, batiment_id) VALUES (:libele_palier, :etudiant_id, :batiment_id)");
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
        
        public function updatePalier($id, $datas){
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
                    ":libele_palier"=>$datas["libele_palier"],
                    ":etudiant_id"=>$datas["etudiant_id"],    
                    ":batiment_id"=>$datas["batiment_id"]             
                ];
                try{
                    $stmt = $this->dbConnect->prepare("UPDATE paliers SET libele_palier = :libele_palier, etudiant_id = :etudiant_id, batiment_id = :batiment_id WHERE palier_id = :id");
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