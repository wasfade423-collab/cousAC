<?php
    include("back/config/database.php");
    class Models{
        private $database;
        public function __construct(){
            $this->database = $database;
        }

        private function nettoyerDonnees($donneesBrutes) {
        if (!is_array($donneesBrutes)) {
            // Si c'est une simple chaîne de caractères, on la nettoie
            return htmlspecialchars(trim($donneesBrutes));
        }
        
        // Si c'est un tableau (comme notre JSON), on nettoie chaque élément un par un
        $donneesNettoyees = [];
        foreach ($donneesBrutes as $cle => $valeur) {
            $donneesNettoyees[$cle] = $this->nettoyerDonnees($valeur);
        }
            return $donneesNettoyees;
        }        
        //get

        public function home(){
            $stmt = $this->database->prepare("SELECT * FROM universites");
            if($stmt->execute()){
                $universites = $stmt->fetchAll();
            }
            $stmt = $this->database->prepare("SELECT * FROM presentations");
            if($stmt->execute()){
                $presentations = $stmt->fetchAll();
            }
            return ['universites'=>$universites, 'presentations'=>$presentations];
        }

        public function listEtudiants($idUniversite){
            $stmt = $this->database->prepare("SELECT * FROM etudiants WHERE universite_id =:idUniversite");
            if($stmt->execute([":idUniversite"=>$idUniversite])){
                $etudiants = $stmt->fetchAll();
            }

            $stmt = $this->database->prepare("SELECT universite_id, nom, ville FROM universites WHERE universite_id =:idUniversite");
            if($stmt->execute([":idUniversite"=>$idUniversite])){
                $universite = $stmt->fetch();
            }
            return ["etudiants"=>$etudiants, "universite"=>$universite];
        }

        public function getEtudiant($idEtudiant){
            $stmt = $this->database->prepare("SELECT 
                etudiants.etudiants_id, 
                etudiants.nom, 
                etudiants.prenom, 
                etudiants.numero_telephone,
                etudiants.photo, 
                etudiants.filiere, 
                etudiants.niveau_etude, 
                etudiants.ecole, 
                universites.universite_id, 
                universites.nom 
                FROM etudiants
                INNER JOIN universites ON etudiants.universite_id = universites.universite_id 
                WHERE etudiant_id =:idEtudiant");
            if($stmt->execute([":idEtudiant"=>$idEtudiant])){
                $etudiant = $stmt->fetch();
            }

            return ["etudiant"=>$etudiant];
        }
        public function listNourritures($idUniversite){
            $stmt = $this->database->prepare("SELECT nourriture_id, nom, prix_ticket FROM nourritures WHERE universite_id =:idUniversite");
            if($stmt->execute([":idUniversite"=>$idUniversite])){
                $nourritures = $stmt->fetchAll();
            }

            $stmt = $this->database->prepare("SELECT universite_id, nom, ville FROM universites WHERE universite_id =:idUniversite");
            if($stmt->execute([":idUniversite"=>$idUniversite])){
                $universite = $stmt->fetch();
            }
            return ["nourritures"=>$nourritures, "universite"=>$universite];
        }
        public function getNourriture($idUniversite, $idNourriture){
            $stmt = $this->database->prepare("SELECT * FROM nourritures WHERE nourriture_id =:idNourriture");
            if($stmt->execute([":idNourriture"=>$idNourriture])){
                $nourriture = $stmt->fetch();
            }

            $stmt = $this->database->prepare("SELECT universite_id, nom FROM universites WHERE universite_id =:idUniversite");
            if($stmt->execute([":idUniversite"=>$idUniversite])){
                $universite = $stmt->fetch();
            }
            return ["nourriture"=>$nourriture, "universite"=>$universite];
        }

        public function listUniversites(){
            $stmt = $this->database->prepare("SELECT * FROM universites");
            if($stmt->execute()){
                $universites = $stmt->fetchAll();
            }
            return ["universites"=>$universites];
        }
        public function getUniversite($idUniversite){
            $stmt = $this->database->prepare("SELECT * FROM universites WHERE universite_id =:idUniversite");
            if($stmt->execute([":idUniversite"=>$idUniversite])){
                $universite = $stmt->fetch();
            }
            return ["universite"=>$universite];
        }

        public function listBatiments($idUniversite){
            $stmt = $this->database->prepare("SELECT 
                batiments.batiment_id,
                batiments.lidelle_batiment,
                universites.universite_id,
                universites.nom 
                FROM batiments
                INNER JOIN universites ON batiments.universite_id = universites.universite_id 
                WHERE batiments.universite_id =:idUniversite");
            if($stmt->execute([":idUniversite"=>$idUniversite])){
                $batiment = $stmt->fetchAll();
            }
            return ["batiment"=>$batiment];
        }

        public function getBatiment($idUniversite, $idBatiment){
            $stmt = $this->database->prepare("SELECT 
                batiments.batiment_id,
                batiments.lidelle_batiment,
                batiments.photos,
                universites.universite_id,
                universites.nom 
                FROM batiments
                INNER JOIN universites ON batiments.universite_id = universites.universite_id 
                WHERE batiment_id =:idBatiment");
            if($stmt->execute([":idBatiment"=>$idBatiment])){
                $batiment = $stmt->fetch();
            }

            return ["batiment"=>$batiment];
        }
        public function listPaliers($idUniversite, $idBatiment){
            $stmt = $this->database->prepare("SELECT 
                paliers.palier_id,
                paliers.libelle_palier,
                batiments.libelle_batiment,
                batiments.batiment_id
                FROM paliers 
                INNER JOIN batiments ON paliers.batiment_id = batiments.batiment_id
                WHERE paliers.batiment_id =:idBatiment");
            if($stmt->execute([":idBatiment"=>$idBatiment])){
                $paliers = $stmt->fetchAll();
            }

            return ["paliers"=>$paliers];
        }

        public function getPalier($idUniversite, $idBatiment, $idPalier){
            $stmt = $this->database->prepare("SELECT 
                batiments.batiment_id,
                paliers.libelle_palier,
                paliers.palier_id,
                paliers.etudiant_id,
                batiments.photos,
                batiments.lidelle_batiment
                FROM paliers
                INNER JOIN batiments ON paliers.batiment_id = batiments.batiment_id
                WHERE palier_id =:idPalier");
            if($stmt->execute([":idPalier"=>$idPalier])){
                $palier = $stmt->fetch();
            }

            return ["palier"=>$palier];
        }
        
        public function listDortoirs($idUniversite){
            $stmt = $this->database->prepare("SELECT 
                doirtoirs.dortoir_id,
                doirtoirs.libelle_chambre,
                doirtoirs.fonctionnelle,
                batiments.batiment_id,
                batiments.libelle_batiment
                FROM dortoirs 
                INNER JOIN batiments ON dortoirs.batiment_id = batiments.batiment_id");
            if($stmt->execute()){
                $dortoirs = $stmt->fetchAll();
            }

            $stmt = $this->database->prepare("SELECT (universite_id, nom, ville) FROM universites WHERE universite_id =:idUniversite");
            if($stmt->execute([":idUniversite"=>$idUniversite])){
                $universite = $stmt->fetch();
            }            

            return ["dortoirs"=>$dortoirs, "universite"=>$universite];
        }
        public function dortoirsByBatiment($idUniversite, $idBatiment){
            $stmt = $this->database->prepare("SELECT 
                doirtoirs.dortoir_id,
                doirtoirs.libelle_chambre,
                doirtoirs.fonctionnelle,
                batiments.batiment_id,
                batiments.libelle_batiment
                FROM dortoirs 
                INNER JOIN batiments ON dortoirs.batiment_id = batiments.batiment_id
                WHERE dortoirs.batiment_id =:idBatiment");
            if($stmt->execute([":idBatiment"=>$idBatiment])){
                $dortoirs = $stmt->fetchAll();
            }

            $stmt = $this->database->prepare("SELECT (universite_id, nom, ville) FROM universites WHERE universite_id =:idUniversite");
            if($stmt->execute([":idUniversite"=>$idUniversite])){
                $universite = $stmt->fetch();
            } 
            
            return ["dortoirs"=>$dortoirs, "universite"=>$universite];
        }
        public function getDortoir($idUniversite, $idBatiment, $idDortoir){
            $stmt = $this->database->prepare("SELECT 
                dortoirs.dortoir_id, 
                dortoirs.libelle_chambre,
                dortoirs.fonctionnelle,
                paliers.palier_id,
                paliers.libelle_palier,
                batiments.batiment_id,
                batiments.libelle_batiment
                FROM dortoirs 
                INNER JOIN paliers ON dortoirs.palier_id = paliers.palier_id 
                INNER JOIN batiments ON dortoirs.batiment_id = batiments.batiment_id
                WHERE dortoir_id =:idDortoir");
            if($stmt->execute([":idDortoir"=>$idDortoir])){
                $dortoir = $stmt->fetch();
            }
            
            return ["dortoir"=>$dortoir];
        }

        public function listIntendants(){
            $stmt = $this->database->prepare("SELECT 
                intendants.intendants_id, 
                intendants.nom, 
                intendants.prenom, 
                intendants.numero_telephone, 
                universites.universite_id, 
                universites.nom
                FROM intendants 
                INNER JOIN universites ON intendants.universite_id = universites.universite_id");
            if($stmt->execute()){
                $intendants = $stmt->fetchAll();
            }

            return ["intendants"=>$intendants];
        }

        public function listIntendantsByUniversite($idUniversite){
            $stmt = $this->database->prepare("SELECT nom, prenom, numero_telephone FROM intendants WHERE universite_id =:idUniversite");
            if($stmt->execute()){
                $intendants = $stmt->fetchAll();
            }
            return ["intendants"=>$intendants];        
        }
        public function getIntendant($idUniversite, $idIntendant){
            $stmt = $this->database->prepare("SELECT 
                intendants.intendants_id, 
                intendants.nom, 
                intendants.prenom, 
                intendants.numero_telephone, 
                intendants.email,
                intendants.photo, 
                universites.universite_id, 
                universites.nom
                FROM intendants 
                INNER JOIN universites ON intendants.universite_id = universites.universite_id
                WHERE intendants.intendants_id =:idIntendant");
            if($stmt->execute([":idIntendant"=>$idIntendant])){
                $intendant = $stmt->fetch();
            }

            return ["intendant"=>$intendant];
        }

        public function listCcByUniversite($idUniversite){
            $stmt = $this->database->prepare("SELECT nom, prenom, numero_telephone FROM chargé_cabines WHERE universite_id =:idUniversite");
            if($stmt->execute()){
                $cc = $stmt->fetchAll();
            }
            return ["cc"=>$cc];        
        }
        public function getCc($idUniversite, $idCc){
            $stmt = $this->database->prepare("SELECT 
            chargé_cabines.cc_id,
            chargé_cabines.nom,
            chargé_cabines.prenom,
            chargé_cabines.numero_telephone,
            chargé_cabines.photo,
            charge_cabines.email,
            universites.universite_id,
            universites.nom
            FROM chargé_cabines
            INNER JOIN universites ON chargé_cabines.universite_id = universites.universite_id
            WHERE chargé_cabines.cc_id =:idCc");
            if($stmt->execute([":idCc"=>$idCc])){
                $cc = $stmt->fetch();
            }

            return ["cc"=>$cc];
        }

        public function listSecretairesByUniversite($idUniversite){
            $stmt = $this->database->prepare("SELECT nom, prenom, numero_telephone FROM secretaires WHERE universite_id =:idUniversite");
            if($stmt->execute()){
                $secretaires = $stmt->fetchAll();
            }
            return ["secretaires"=>$secretaires];        
        }

        public function getSecretaire($idUniversite, $idSecretaire){
            $stmt = $this->database->prepare("SELECT 
            secretaires.secretaire_id,
            secretaires.nom,
            secretaires.prenom,
            secretaires.numero_telephone,
            secretaires.photo,
            secretaires.email,
            universites.universite_id,
            universites.nom
            FROM secretaires
            INNER JOIN universites ON secretaires.universite_id = universites.universite_id
            WHERE secretaires.secretaire_id =:idSecretaire");
            if($stmt->execute([":idSecretaire"=>$idSecretaire])){
                $secretaire = $stmt->fetch();
            }

            return ["secretaire"=>$secretaire];
        }

        public function listSecuriteByUniversite($idUniversite){
            $stmt = $this->database->prepare("SELECT nom, prenom, numero_telephone FROM agent_securite WHERE universite_id =:idUniversite");
            if($stmt->execute()){
                $securites = $stmt->fetchAll();
            }
            return ["securites"=>$securites];        
        }

        public function getSecuriteByUniversite($idUniversite, $idSecurite){
            $stmt = $this->database->prepare("SELECT 
            agent_securite.securite_id,
            agent_securite.nom,
            agent_securite.prenom,
            agent_securite.numero_telephone,
            agent_securite.photo,
            agent_securite.chef_securite,
            universites.universite_id,
            universites.nom
            FROM agent_securite
            INNER JOIN universites ON agent_securite.universite_id = universites.universite_id
            WHERE agent_securite.securite_id =:idSecurite");
            if($stmt->execute([":idSecurite"=>$idSecurite])){
                $securite = $stmt->fetch();
            }

            return ["securite"=>$securite];
        }

        public function listComptablesByUniversite($idUniversite){
            $stmt = $this->database->prepare("SELECT nom, prenom, email, numero_telephone FROM comptables WHERE universite_id =:idUniversite");
            if($stmt->execute()){
                $comptables = $stmt->fetchAll();
            }
            return ["comptables"=>$comptables];        
        }

        public function getComptable($idUniversite, $idComptable){
            $stmt = $this->database->prepare("SELECT 
            comptables.comptable_id,
            comptables.nom,
            comptables.prenom,
            comptables.numero_telephone,
            comptables.photo,
            comptables.email,
            universites.universite_id,
            universites.nom
            FROM comptables
            INNER JOIN universites ON comptables.universite_id = universites.universite_id
            WHERE comptables.comptable_id =:idComptable");
            if($stmt->execute([":idComptable"=>$idComptable])){
                $comptable = $stmt->fetch();
            }

            return ["comptable"=>$comptable];
        }

        public function listPlaintes($idUniversite){
            $stmt = $this->database->prepare("SELECT 
            plaintes.plainte_id, 
            plaintes.sujet, 
            etudiants.nom, 
            etudiants.etudiant_id 
            FROM plaintes 
            INNER JOIN etudiants ON plaintes.etudiants_id = etudiants.etudiant_id
            WHERE universite_id =:idUniversite");

            if($stmt->execute([":idUniversite"=>$idUniversite])){
                $plaintes = $stmt->fetchAll();
            }
            return ["plaintes"=>$plaintes];        
        }

        public function getPlainte($idUniversite, $idPlainte){
            $stmt = $this->database->prepare("SELECT 
            plaintes.plainte_id, 
            plaintes.sujet, 
            plaintes.description, 
            plaintes.date_plainte, 
            etudiants.nom, 
            etudiants.prenom, 
            universites.universite_id, 
            universites.nom
            FROM plaintes 
            INNER JOIN etudiants ON plaintes.etudiants_id = etudiants.etudiant_id
            INNER JOIN universites ON plaintes.universite_id = universites.universite_id
            WHERE plainte_id =:idPlainte");

            if($stmt->execute([":idPlainte"=>$idPlainte])){
                $plainte = $stmt->fetch();
            }
            return ["plainte"=>$plainte];        
        }


        //post

        public function addUniversite(){
            $data = file_get_contents('php://input');
            $inputs = json_decode($data, true);
            
            if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
                return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
                exit; // On arrête l'exécution ici
            }

            $inputsNettoyees = $this->nettoyerDonnees($inputs);

            $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
            
            foreach ($champsObligatoires as $champ) {

                if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                    return ([
                        "status" => "error", 
                        "message" => "Le champ '{$champ}' ne peut pas être vide."
                    ]);
                    exit; // On bloque direct, ça n'ira pas en base de données !
                }
            }
            $stmt = $this->database->prepare("INSERT INTO universites (nom, descriptions, ville, photos, photo_plan) VALUES (:nom, :descriptions, :ville, :photos, :photo_plan)");
            if($stmt->execute([":nom"=>$data['nom'], ":ville"=>$data['ville']])){
                return ["message"=>"Université ajoutée avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout de l'université"];
            }
        }

        public function addIntendant(){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $stmt = $this->database->prepare("INSERT INTO intendants (nom, prenom, email, mot_de_passe, photo, numero_telephone, universite_id) VALUES (:nom, :prenom, :email, :mot_de_passe, :photo, :numero_telephone, :universite_id)");
            if($stmt->execute($data)){
                return ["message"=>"Intendant ajouté avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout de l'intendant"];
            }
        }

        public function addCharge_cabine($idUniversite){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $stmt = $this->database->prepare("INSERT INTO chargé_cabines (nom, prenom, email, mot_de_passe, photo, mot_de_passe, numero_telephone, universite_id) VALUES (:nom, :prenom, :email, :mot_de_passe, :photo, :mot_de_passe, :numero_telephone, :universite_id)");
            if($stmt->execute($data)){
                return ["message"=>"Chargé de cabines ajouté avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout du chargé de cabine"];
            }
        }

        public function addSecretaire($idUniversite){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $stmt = $this->database->prepare("INSERT INTO secretaires (code_personnel, nom, prenom, email, mot_de_passe, photo, numero_telephone, role, mot_de_passe, universite_id) VALUES (:code_personnel, :nom, :prenom, :email, :mot_de_passe, :photo, :numero_telephone, :photo, :role, :mot_de_passe, :universite_id)");
            if($stmt->execute($data)){
                return ["message"=>"Secrétaire ajouté avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout du secrétaire"];
            }
        }

        public function addComptable($idUniversite){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $stmt = $this->database->prepare("INSERT INTO comptables (code_comptable, nom, prenom, email, mot_de_passe, photo, numero_telephone, universite_id) VALUES (:code_comptable, :nom, :prenom, :email, :mot_de_passe, :photo, :numero_telephone, :universite_id)");
            if($stmt->execute($data)){
                return ["message"=>"Comptable ajouté avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout du comptable"];
            }
        }

        public function addSecurite($idUniversite){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $stmt = $this->database->prepare("INSERT INTO agent_securite (matricule, nom, prenom, email, mot_de_passe, photo, numero_telephone, chef_securite, universite_id) VALUES (:matricule, :nom, :prenom, :email, :mot_de_passe, :photo, :numero_telephone, :chef_securite, :universite_id)");
            if($stmt->execute($data)){
                return ["message"=>"Agent de sécurité ajouté avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout de l'agent de sécurité"];
            }
        }

        public function addEtudiant($idUniversite){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $stmt = $this->database->prepare("INSERT INTO etudiants (nom, prenom, numero_telephone, email, mot_de_passe, filiere, niveau_etude, ecole, photo, universite_id) VALUES (:nom, :prenom, :numero_telephone, :email, :mot_de_passe, :filiere, :niveau_etude, :ecole, :photo, :universite_id)");
            if($stmt->execute($data)){
                return ["message"=>"Étudiant ajouté avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout de l'étudiant"];
            }
        }

        public function addNourriture($idUniversite){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $stmt = $this->database->prepare("INSERT INTO nourritures (nom, moment_repas, menu_details, prix_ticket, universite_id) VALUES (:nom, :moment_repas, :menu_details, :prix_ticket, :universite_id)");
            if($stmt->execute($data)){
                return ["message"=>"Nourriture ajoutée avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout de la nourriture"];
            }
        }

        public function addPlainte($idUniversite){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $stmt = $this->database->prepare("INSERT INTO plaintes (sujet, description, date_plainte, etat, etudiant_id, universite_id) VALUES (:sujet, :description, :date_plainte, :etat, :etudiant_id, :universite_id)");
            if($stmt->execute($data)){
                return ["message"=>"Plainte ajoutée avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout de la plainte"];
            }
        }

        public function addBatiment($idUniversite){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $stmt = $this->database->prepare("INSERT INTO batiments (libelle_batiment, photos, universite_id) VALUES (:libelle_batiment, :photos, :universite_id)");
            if($stmt->execute($data)){
                return ["message"=>"Bâtiment ajouté avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout du bâtiment"];
            }
        }

        public function addDortoir($idUniversite){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }            
            $stmt = $this->database->prepare("INSERT INTO dortoirs (libelle_chambre, fonctionnelle, palier_id, batiment_id) VALUES (:libelle_chambre, :fonctionnelle, :palier_id, :batiment_id)");
            if($stmt->execute($data)){
                return ["message"=>"Dortoir ajouté avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout du dortoir"];
            }
        }

        public function addPalier($idUniversite){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $stmt = $this->database->prepare("INSERT INTO paliers (libelle_palier, batiment_id) VALUES (:libelle_palier, :batiment_id)");
            if($stmt->execute($data)){
                return ["message"=>"Palier ajouté avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout du palier"];
            }
        }

        //put


        public function updateUniversite($idUniversite){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }     
            $data[":universite_id"] = $idUniversite;     
            $stmt = $this->database->prepare("UPDATE universites SET nom = :nom, descriptions = :descriptions, ville = :ville, photos = :photos, photo_plan = :photo_plan WHERE universite_id = :universite_id");
            if($stmt->execute($data)){
                return ["message"=>"Université mise à jour avec succès"];
            }else{
                return ["message"=>"Erreur lors de l'ajout de l'université"];
            }
        }

        public function updateIntendant($idUniversite, $idIntendant){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }   
            $data[":intendant_id"] = $idIntendant;       
            $stmt = $this->database->prepare("UPDATE intendants SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, photo = :photo, numero_telephone = :numero_telephone, universite_id = :universite_id WHERE intendant_id = :intendant_id");
            if($stmt->execute($data)){
                return ["message"=>"Intendant mis à jour avec succès"];
            }else{
                return ["message"=>"Erreur lors de la mise à jour de l'intendant"];
            }
        }

        public function updateCharge_cabine($idUniversite, $idCharge_cabine){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $data[":cc_id"] = $idCharge_cabine;
            $stmt = $this->database->prepare("UPDATE chargé_cabines SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, photo = :photo, numero_telephone = :numero_telephone, universite_id = :universite_id WHERE cc_id = :cc_id");
            if($stmt->execute($data)){
                return ["message"=>"Chargé de cabines mis à jour avec succès"];
            }else{
                return ["message"=>"Erreur lors de la mise à jour du chargé de cabine"];
            }
        }

        public function updateSecretaire($idUniversite, $idSecretaire){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $data[":secretaire_id"] = $idSecretaire;
            $stmt = $this->database->prepare("UPDATE secretaires SET code_personnel = :code_personnel, nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, photo = :photo, numero_telephone = :numero_telephone, role = :role WHERE secretaire_id = :secretaire_id");
            if($stmt->execute($data)){
                return ["message"=>"Secrétaire mis à jour avec succès"];
            }else{
                return ["message"=>"Erreur lors de la mise à jour du secrétaire"];
            }
        }

        public function updateComptable($idUniversite, $idComptable){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $data[":comptable_id"] = $idComptable;
            $stmt = $this->database->prepare("UPDATE comptables SET code_comptable = :code_comptable, nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, photo = :photo, numero_telephone = :numero_telephone WHERE comptable_id = :comptable_id");
            if($stmt->execute($data)){
                return ["message"=>"Comptable mis à jour avec succès"];
            }else{
                return ["message"=>"Erreur lors de la mise à jour du comptable"];
            }
        }

        public function updateSecurite($idUniversite, $idSecurite){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $data[":agent_securite_id"] = $idSecurite;
            $stmt = $this->database->prepare("UPDATE agent_securite SET matricule = :matricule, nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, photo = :photo, numero_telephone = :numero_telephone, chef_securite = :chef_securite WHERE agent_securite_id = :agent_securite_id");
            if($stmt->execute($data)){
                return ["message"=>"Agent de sécurité mis à jour avec succès"];
            }else{
                return ["message"=>"Erreur lors de la mise à jour de l'agent de sécurité"];
            }
        }

        public function updateEtudiant($idUniversite, $idEtudiant){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $data[":etudiant_id"] = $idEtudiant;
            $stmt = $this->database->prepare("UPDATE etudiants SET nom = :nom, prenom = :prenom, numero_telephone = :numero_telephone, email = :email, mot_de_passe = :mot_de_passe, filiere = :filiere, niveau_etude = :niveau_etude, ecole = :ecole, photo = :photo WHERE etudiant_id = :etudiant_id");
            if($stmt->execute($data)){
                return ["message"=>"Étudiant mis à jour avec succès"];
            }else{
                return ["message"=>"Erreur lors de la mise à jour de l'étudiant"];
            }
        }

        public function updateNourriture($idUniversite, $idNourriture){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $data[":nourriture_id"] = $idNourriture;
            $stmt = $this->database->prepare("UPDATE nourritures SET nom = :nom, moment_repas = :moment_repas, menu_details = :menu_details, prix_ticket = :prix_ticket WHERE nourriture_id = :nourriture_id");
            if($stmt->execute($data)){
                return ["message"=>"Nourriture mise à jour avec succès"];
            }else{
                return ["message"=>"Erreur lors de la mise à jour de la nourriture"];
            }
        }

        public function updatePlainte($idUniversite, $idPlainte){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $data[":plainte_id"] = $idPlainte;
            $stmt = $this->database->prepare("UPDATE plaintes SET sujet = :sujet, description = :description WHERE plainte_id = :plainte_id");
            if($stmt->execute($data)){
                return ["message"=>"Plainte mise à jour avec succès"];
            }else{
                return ["message"=>"Erreur lors de la mise à jour de la plainte"];
            }
        }

        public function updateBatiment($idUniversite, $idBatiment){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $data[":batiment_id"] = $idBatiment;
            $stmt = $this->database->prepare("UPDATE batiments SET photos = :photos WHERE batiment_id = :batiment_id");
            if($stmt->execute($data)){
                return ["message"=>"Bâtiment mis à jour avec succès"];
            }else{
                return ["message"=>"Erreur lors de la mise à jour du bâtiment"];
            }
        }

        public function updateDortoir($idUniversite, $idDortoir){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $data[":dortoir_id"] = $idDortoir;
            $stmt = $this->database->prepare("UPDATE dortoirs SET libelle_chambre = :libelle_chambre, fonctionnelle = :fonctionnelle WHERE dortoir_id = :dortoir_id");
            if($stmt->execute($data)){
                return ["message"=>"Dortoir mis à jour avec succès"];
            }else{
                return ["message"=>"Erreur lors de la mise à jour du dortoir"];
            }
        }

        public function updatePalier($idUniversite, $idPalier){
            $data = file_get_contents('php://input');
        $inputs = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE || empty($inputs)) {
            http_response_code(400);
            header('Content-Type: application/json');
            return (["status" => "error", "message" => "Aucune donnée valide reçue."]);
            exit; // On arrête l'exécution ici
        }

        $inputsNettoyees = $this->nettoyerDonnees($inputs);

        $champsObligatoires = ['nom', 'prenom', 'email', 'libelle_batiment', 'libelle_palier', 'numero_telephone', 'ecole', 'filliere', 'libelle_chambre', 'libelle_batiment'];
        
        foreach ($champsObligatoires as $champ) {

            if (array_key_exists($champ, $inputsNettoyees) && $inputsNettoyees[$champ] === "") {
                return ([
                    "status" => "error", 
                    "message" => "Le champ '{$champ}' ne peut pas être vide."
                ]);
                exit; // On bloque direct, ça n'ira pas en base de données !
            }
        }
            $data[":palier_id"] = $idPalier;
            $stmt = $this->database->prepare("UPDATE paliers SET libelle_palier = :libelle_palier, etudiant_id = :etudiant_id WHERE palier_id = :palier_id");
            if($stmt->execute($data)){
                return ["message"=>"Palier mis à jour avec succès"];
            }else{
                return ["message"=>"Erreur lors de la mise à jour du palier"];
            }
        }        


        //delete


       public function deleteUniversite($idUniversite){
            $stmt = $this->database->prepare("DELETE FROM universites WHERE universite_id = :universite_id");
            if($stmt->execute([":universite_id"=>$idUniversite])){
                return ["message"=>"Université supprimée avec succès"];
            }else{
                return ["message"=>"Erreur lors de la suppression de l'université"];
            }
        }

        public function deleteIntendant($idUniversite, $idIntendant){
            $stmt = $this->database->prepare("DELETE FROM intendants WHERE intendant_id = :intendant_id");
            if($stmt->execute([":intendant_id"=>$idIntendant])){
                return ["message"=>"Intendant supprimé avec succès"];
            }else{
                return ["message"=>"Erreur lors de la suppression de l'intendant"];
            }
        }

        public function deleteCharge_cabine($idUniversite, $idCharge_cabine){
            $stmt = $this->database->prepare("DELETE FROM chargé_cabines WHERE cc_id = :cc_id");
            if($stmt->execute([":cc_id"=>$idCharge_cabine])){
                return ["message"=>"Chargé de cabines supprimé avec succès"];
            }else{
                return ["message"=>"Erreur lors de la suppression du chargé de cabine"];
            }
        }

        public function deleteSecretaire($idUniversite, $idSecretaire){
            $stmt = $this->database->prepare("DELETE FROM secretaires WHERE secretaire_id = :secretaire_id");
            if($stmt->execute([":secretaire_id"=>$idSecretaire])){
                return ["message"=>"Secrétaire supprimé avec succès"];
            }else{
                return ["message"=>"Erreur lors de la suppression du secrétaire"];
            }
        }

        public function deleteComptable($idUniversite, $idComptable){
            $stmt = $this->database->prepare("DELETE FROM comptables WHERE comptable_id = :comptable_id");
            if($stmt->execute([":comptable_id"=>$idComptable])){
                return ["message"=>"Comptable supprimé avec succès"];
            }else{
                return ["message"=>"Erreur lors de la suppression du comptable"];
            }
        }

        public function deleteSecurite($idUniversite, $idSecurite){
            $stmt = $this->database->prepare("DELETE FROM agent_securite WHERE agent_securite_id = :agent_securite_id");
            if($stmt->execute([":agent_securite_id"=>$idSecurite])){
                return ["message"=>"Agent de sécurité supprimé avec succès"];
            }else{
                return ["message"=>"Erreur lors de la suppression de l'agent de sécurité"];
            }
        }

        public function deleteEtudiant($idUniversite, $idEtudiant){
            $stmt = $this->database->prepare("DELETE FROM etudiants WHERE etudiant_id = :etudiant_id");
            if($stmt->execute([":etudiant_id"=>$idEtudiant])){
                return ["message"=>"Étudiant supprimé avec succès"];
            }else{
                return ["message"=>"Erreur lors de la suppression de l'étudiant"];
            }
        }

        public function deleteNourriture($idUniversite, $idNourriture){
            $stmt = $this->database->prepare("DELETE FROM nourritures WHERE nourriture_id = :nourriture_id");
            if($stmt->execute([":nourriture_id"=>$idNourriture])){
                return ["message"=>"Nourriture supprimée avec succès"];
            }else{
                return ["message"=>"Erreur lors de la suppression de la nourriture"];
            }
        }

        public function deletePlainte($idUniversite, $idPlainte){
            $stmt = $this->database->prepare("DELETE FROM plaintes WHERE plainte_id = :plainte_id");
            if($stmt->execute([":plainte_id"=>$idPlainte])){
                return ["message"=>"Plainte supprimée avec succès"];
            }else{
                return ["message"=>"Erreur lors de la suppression de la plainte"];
            }
        } 
        
                 
    }