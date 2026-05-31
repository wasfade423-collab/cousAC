    // static $routes = [
    //     "GET"=>[
    //         "api/"=>"home",
    //         "api/etudiants" =>"listEtudiants",
    //         "api/etudiants/{id}"=>"getEtudiant",
    //         "api/batiments"=>"listBatiments",
    //         "api/batiments/{id}"=>"getBatiment",
    //         "api/batiments/{id}/paliers"=>"listPaliers",
    //         "api/batiments/{id}/dortoirs"=>"listDortoirs",
    //         "api/intendants"=>"listIntendants",
    //         "api/intendants/{id}"=>"getIntendant",
    //         "api/comptables"=>"listComptables",
    //         "api/comptables/{id}"=>"getComptable",
    //         "api/secretaires"=>"listSecretaires",
    //         "api/secretaires/{id}"=>"getSecretaire"
    //         ],
    //     "POST"=>[
    //         "api/etudiants"=>"addEtudiant",
    //         "api/batiments"=>"addBatiment",
    //         "api/batiments/{id}/paliers"=>"addPalier",
    //         "api/batiments/{id}/dortoirs"=>"addDortoir",
    //         "api/intendants"=>"addIntendant",
    //         "api/comptables"=>"addComptable",
    //         "api/secretaires"=>"addSecretaire"
    //     ],
    //     "PUT"=>[
    //         "api/etudiants/{id}"=>"updateEtudiant",
    //         "api/batiments/{id}"=>"updateBatiment",
    //         "api/batiments/{id}/paliers/{idPalier}"=>"updatePalier",
    //         "api/batiments/{id}/dortoirs/{idDortoir}"=>"updateDortoir",
    //         "api/intendants/{id}"=>"updateIntendant",
    //         "api/comptables/{id}"=>"updateComptable",
    //         "api/secretaires/{id}"=>"updateSecretaire"
    //     ],
    //     "DELETE"=>[
    //         "api/etudiants/{id}"=>"deleteEtudiant",
    //         "api/batiments/{id}"=>"deleteBatiment",
    //         "api/batiments/{id}/paliers/{idPalier}"=>"deletePalier",
    //         "api/batiments/{id}/dortoirs/{idDortoir}"=>"deleteDortoir",
    //         "api/intendants/{id}"=>"deleteIntendant",
    //         "api/comptables/{id}"=>"deleteComptable",
    //         "api/secretaires/{id}"=>"deleteSecretaire" 
    //     ],
    //     "PATCH"=>[
    //         "api/etudiants/{id}"=>"updateEtudiant",
    //         "api/batiments/{id}"=>"updateBatiment",
    //         "api/batiments/{id}/paliers/{idPalier}"=>"updatePalier",
    //         "api/batiments/{id}/dortoirs/{idDortoir}"=>"updateDortoir",
    //         "api/intendants/{id}"=>"updateIntendant",
    //         "api/comptables/{id}"=>"updateComptable",
    //         "api/secretaires/{id}"=>"updateSecretaire"
    //     ]
    // ] ; 
    // private function fetchRessources($route, $requestType){
    //     if(array_key_exists($requestType, $routes)){
    //         foreach($routes[$requestType] as $key=>$value){
    //             if(preg_match("#^(api/)\w*#", $route)){
    //                 $route = preg_replace("#^(api/)\w*#", "", $route);
    //                 if(strlen($route) === 0){
    //                     $this->data->$value();
    //                 }else{
    //                     $route = explode('/', $route);
    //                     if(count($route) > 4){
    //                         $errors["path"] = "Lien de la requète incorrecte.";
    //                     }else{
    //                         $ressourcesNoms = ["etudiants", "batiments", "paliers", "dortoirs", "intendants", "comptables", "secretaires"];
    //                         if(in_array($route[0], $ressourcesNoms)){
    //                            if(!is_numeric($route[1])){
    //                                $errors["path"] = "Lien de la requète incorrecte.";
    //                            }else{
    //                                 switch (count($route)){
    //                                     case 2 :
    //                                         $this->data->$value($route[1]);
    //                                         break;
    //                                     case 3:
    //                                         $underResssourcesNoms = ["paliers", "dortoirs"];
    //                                         if(in_array($route[2], $underResssourcesNoms)){
    //                                             $this->data->$value($route[1]);
    //                                         }
    //                                         break;
    //                                     case 4:
    //                                         $underResssourcesNoms = ["paliers", "dortoirs"];
    //                                         if(in_array($route[2], $underResssourcesNoms)){
    //                                             if(is_numeric($route[3])){
    //                                                 $this->data->$value($route[3]);
    //                                             }else{
    //                                                 $errors["path"] = "Lien de la requète incorrecte.";
    //                                             }
    //                                         }
    //                                         break;
    //                                     default:
    //                                         $errors["path"] = "Lien de la requète incorrecte.";
    //                                         break;
    //                                 }
    //                            }
    //                         }else{
    //                             $errors["path"] = "Lien de la requète incorrecte.";
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }else{
    //         $errors["method"] = "Méthode de la requète incorrecte.";
    //     }
    // }