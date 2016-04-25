<?php
include 'connectDb.php';
include 'acteur.php';
include 'film.php';

//Debugging
//ini_set('display_errors','On');
//error_reporting(E_ALL | E_STRICT);

class filmRepository {

    //Instancie un film à partir de son ID dans la base
    public static function get_film_byid($idfilm)
    {
        $bdd = connectDb();
        $query = $bdd->prepare('SELECT * FROM `films` WHERE id_film = :idfilm limit 0,1');
        $query->execute(array('idfilm' => $idfilm));
        $data = $query->fetch();
        $film = new film($data['nom_film'], $data['annee_film'], $data['score']);
        $film->setFilmid($data['id_film']);
        return $film;
    }
    
    // Instancie un acteur à partir de son ID dans la base
    public static function get_acteur_byid($idacteur)
    {
        $bdd = connectDb();
        $query = $bdd->prepare('SELECT * FROM `acteurs` WHERE id_acteur = :idacteur limit 0,1');
        $query->execute(array('idacteur' => $idacteur));
        $data = $query->fetch();
        $acteur = new acteur($data['nom'], $data['prenom']);
        $acteur->setActeurid($data['id_acteur']);
        return $acteur;
    }    

    //Ajoute un film dans la base
    //Gère le cas où le film est déjà présent en le mettant à jour
    public static function save_film(film $film)
    {
        $bdd = connectDb(); //connexion à la BDD
        $query = $bdd->prepare('SELECT COUNT(*) AS nb_films FROM films WHERE lower(nom_film) = lower(:n)'); 
        $query->execute(array('n' => $film->getTitre())); // paramètres et exécution
        $data = $query->fetch();
        if ($data['nb_films'] == 0)
        {	
            $query = $bdd->prepare('INSERT INTO `putridTomatoes`.`films` (`nom_film`, `annee_film`, `score`) VALUES (:n, :a, :s)'); // requète SQL
            $query->execute(array('n' => $film->getTitre(), 'a' => $film->getAnnee(), 's' => $film->getNote())); 
        }
        else
        {
            $query = $bdd->prepare('UPDATE `putridTomatoes`.`films` SET annee_film=:a, score=:s WHERE nom_film = :n'); // requète SQL
            $query = $query->execute(array('n' => $film->getTitre(), 'a' => $film->getAnnee(), 's' => $film->getNote())); // paramètres et exécution
        }
    }
    
    //Supprime un film de la base
    public static function delete_film(film $film)
    {
        $bdd = connectDb(); //connexion à la BDD
        
        // Supprime le casting du film, ainsi que le film lui-même dans la table des films. 
        $query = $bdd->prepare('SELECT COUNT(*) AS nb_films FROM films WHERE lower(nom_film) = lower(:titre)'); 
        $query->execute(array('titre' => $film->getTitre())); // paramètres et exécution
        $data = $query->fetch();
        if ($data['nb_films'] == 0)
        {
            echo 'Film absent de la base';
        }
        else
        {   
            $query = $bdd->prepare('DELETE FROM `casting` WHERE id_film = :filmid ; DELETE FROM `films` WHERE id_film = :filmid');
            $query->execute(array('filmid' => $film->getFilmid())); 
            echo 'Film supprimé';
        }
    }
    
    //Ajoute un acteur dans la base
    //Gère le cas où l'acteur est déjà présent en affichant un message
    public static function save_acteur(acteur $acteur)
    {
        $bdd = connectDb();
        $query = $bdd->prepare('SELECT COUNT(*) AS nb_acteurs FROM acteurs WHERE lower(nom) = lower(:n) AND lower(prenom) = lower(:p)'); 
        $query->execute(array('n' => $acteur->getNom(), 'p' => $acteur->getPrenom()));
        $data = $query->fetch();
        if ($data['nb_acteurs'] == 0)
        {	
            $query = $bdd->prepare('INSERT INTO `putridTomatoes`.`acteurs` (`nom`, `prenom`) VALUES (:n, :p)');
            $query->execute(array('n' => $acteur->getNom(), 'p' => $acteur->getPrenom())); 
            echo "Acteur sauvegardé";
        }
        else
        {
            echo 'Acteur déjà existant';
        }
    }
    
    //Supprime un acteur de la base
    public static function delete_acteur(acteur $acteur)
    {
        // Supprime l'acteur au casting des films où il apparaît, ainsi que de la liste des acteurs. 
        $bdd = connectDb();
        $query = $bdd->prepare('SELECT COUNT(*) AS nb_acteurs FROM acteurs WHERE lower(nom) = lower(:n) AND lower(prenom) = lower(:p)'); 
        $query->execute(array('n' => $acteur->getNom(), 'p' => $acteur->getPrenom()));
        $data = $query->fetch();
        if ($data['nb_acteurs'] == 0)
        {
            echo 'Acteur absent de la base';
        }
        else
        {   
            $query = $bdd->prepare('DELETE FROM `casting` WHERE id_acteur = :acteurid ; DELETE FROM `acteurs` WHERE id_acteur = :acteurid');
            $query->execute(array('acteurid' => $acteur->getActeurid())); 
            echo 'Acteur supprimé';
        }
    }
    
    //Ajoute un acteur au casting d'un film
    //La possibilité d'ajouter plusieurs acteurs à la fois est implémentée, avec gestion des cas où certains acteurs sont déjà au casting et pas d'autres, tous les acteurs sont déjà au casting,
    //Le film ou l'un des acteurs n'existent aps dans la base. 
    public static function add_acteurs($film_id, $acteur_id)
    {
        /* ETAPES
         * 1- Check si l'id du film existe dans la base
         * 2- Check si l'id de l'acteur existe dans la base
         * 3- Check si le couple id_film/id_acteur existe dans la base
         * 4- Si le couple existe déjà dans la base : renvoyer un message d'erreur
         * 5- Si le couple n'existe pas, faire un insert
         */
        $exist_film = FALSE;
        $exist_acteur = FALSE;
        
        $bdd = connectDb(); //connexion à la BDD
        $query = $bdd->prepare('SELECT COUNT(*) AS nb_idfilm FROM films WHERE id_film = :id'); 
        $query->execute(array('id' => $film_id)); // paramètres et exécution
        $data = $query->fetch();
        if ($data['nb_idfilm'] == 1)
        {	
            $exist_film = TRUE;
        }
        
        foreach ($acteur_id as &$current_acteur_id) 
        {
            $bdd = connectDb();
            $query = $bdd->prepare('SELECT COUNT(*) AS nb_idacteur FROM acteurs WHERE id_acteur = :idacteur'); 
            $query->execute(array('idacteur' => $current_acteur_id)); // paramètres et exécution
            $data = $query->fetch();
            if ($data['nb_idacteur'] == 1)
            {
                if($exist_acteur == FALSE) $exist_acteur = TRUE;
            }
            else
            {
                $exist_acteur = FALSE;
                break;
            }
        }
        
        if ($exist_film == FALSE or $exist_acteur == FALSE)
        {
            if ($exist_film == FALSE) echo "Ce film n'est pas répertorié";
            if ($exist_acteur == FALSE) echo "L'un de ces acteurs n'est pas répertorié";
        }
        else 
        {   
            $cpt_added_acteurs = 0;
            foreach ($acteur_id as &$current_acteur_id) 
            {
                $bdd = connectDb();
                $query = $bdd->prepare('SELECT COUNT(*) AS nb_casting FROM casting WHERE id_film = :idfilm AND id_acteur = :idacteur'); 
                $query->execute(array('idfilm' => $film_id,'idacteur' => $current_acteur_id)); // paramètres et exécution
                $data = $query->fetch();
                if ($data['nb_casting'] != 0) continue;
                else
                {
                    $cpt_added_acteurs ++;
                    $bdd = connectDb();
                    $query = $bdd->prepare('INSERT INTO `putridTomatoes`.`casting` (`id_film`, `id_acteur`) VALUES (:idfilm, :idacteur)'); // requète SQL
                    $query->execute(array('idfilm' => $film_id, 'idacteur' => $current_acteur_id)); 
                }
            }
            if ($cpt_added_acteurs == 0) echo "Tous les acteurs sélectionnés sont déjà au casting de ce film.";
            else echo "Modification au casting de ce film sauvegardée : ".$cpt_added_acteurs." ajoutés.";
        }
    }
       
    //Enlève un acteur du casting d'un film
    public static function remove_acteur($film_id, $acteur_id)
    {
        //Vérification des ID d'entrée
        $exist_film = FALSE;
        $exist_acteur = FALSE;
        
        $bdd = connectDb();
        $query = $bdd->prepare('SELECT COUNT(*) AS nb_idfilm FROM films WHERE id_film = :id'); 
        $query->execute(array('id' => $film_id));
        $data = $query->fetch();
        if ($data['nb_idfilm'] == 1) $exist_film = TRUE;
        
        $bdd = connectDb();
        $query = $bdd->prepare('SELECT COUNT(*) AS nb_idacteur FROM acteurs WHERE id_acteur = :idacteur'); 
        $query->execute(array('idacteur' => $acteur_id));
        $data = $query->fetch();
        if ($data['nb_idacteur'] == 1) $exist_acteur = TRUE;
        
        if ($exist_film == FALSE or $exist_acteur == FALSE)
        {
            if ($exist_film == FALSE) echo "Ce film n'est pas répertorié";
            if ($exist_acteur == FALSE) echo "L'un de ces acteurs n'est pas répertorié";
        }
        
        $bdd = connectDb();
        $query = $bdd->prepare('SELECT COUNT(*) AS nb_casting FROM casting WHERE id_film = :idfilm AND id_acteur = :idacteur'); 
        $query->execute(array('idfilm' => $film_id,'idacteur' => $acteur_id));
        $data = $query->fetch();
        if ($data['nb_casting'] == 0)
        {
            echo "L'acteur sélectionné n'apparaît pas au casting de ce film.";
        }
        else
        {
            $bdd = connectDb();
            $query = $bdd->prepare('DELETE FROM `casting` WHERE `id_film` = :idfilm AND `id_acteur` = :idacteur');
            $query->execute(array('idfilm' => $film_id, 'idacteur' => $acteur_id)); 
            echo "Modification au casting de ce film sauvegardée. ";
        }
    }
    
    // Affiche la liste des films
    public static function print_list_films()
    {
        $bdd = connectDb(); //connexion à la BDD
        $query = $bdd->prepare('SELECT * FROM `films` ORDER BY nom_film ASC LIMIT 0 , 40'); // requête SQL
        $query->execute(); // paramètres et exécution
        while($data = $query->fetch()) 
        { // lecture par ligne
            echo "<tr><td>".$data['nom_film']."</td>";
            echo "<td>".$data['annee_film']."</td>", "<td>".$data['score']."</td>", "<td><a href='liste_acteurs.php?filmid=".$data['id_film']."'>voir</a>", "</td></tr>";
        }
        $query->closeCursor();
    }
    
    //Affiche la liste des acteurs au casting d'un film passé en paramètre
    public static function print_list_acteurs(film $film)
    {
        $bdd = connectDb(); //connexion à la BDD
        $query = $bdd->prepare('SELECT * FROM `acteurs` INNER JOIN `casting` ON `acteurs`.id_acteur = `casting`.id_acteur WHERE `casting`.id_film = :idfilm ORDER BY nom ASC LIMIT 0 , 25'); 
        $query->execute(array('idfilm' => $film->getFilmid())); 
        while($data = $query->fetch()) 
        { // lecture par ligne
            echo "<tr><td>".$data['prenom']."</td>";
            echo "<td>".$data['nom']."</td>";
            echo "<td><a href='https://fr.wikipedia.org/wiki/".$data['prenom']."_".$data['nom']."'>bio</a></td></tr>";
        }
        $query->closeCursor();
    }
    
    //Pour récupérer la liste des films et des acteurs, de telle sorte qu'ils apparaissent dans des menus déroulants. 
        public static function get_list_films()
    {
        $bdd = connectDb();
        $query = $bdd->prepare('SELECT id_film, nom_film FROM `films` ORDER BY nom_film ASC');
        $query->execute();
        while($data = $query->fetch()) 
        { 
            echo "<option value=".$data['id_film'].">".$data['nom_film']."</option>";
        }
        $query->closeCursor();
    }
    
    //récupère la liste des acteurs
    public static function get_list_acteurs()
    {
        $bdd = connectDb();
        $query = $bdd->prepare('SELECT id_acteur, nom, prenom FROM `acteurs` ORDER BY nom ASC'); // requête SQL
        $query->execute();
        while($data = $query->fetch()) 
        {
            echo "<option value=".$data['id_acteur'].">".$data['prenom']." ".$data['nom']."</option>";
        }
        $query->closeCursor();
    }
    
    // Pour afficher une liste d'acteurs dépendante d'un film sélectionné sur la même page, 
    // javascript serait nécessaire (dynamique). Cependant, nous proposons une alternative, en utilisant get_casting()
    public static function get_casting(film $film)
    {
        $bdd = connectDb();
        $query = $bdd->prepare('SELECT * FROM `acteurs` INNER JOIN `casting` ON `acteurs`.id_acteur = `casting`.id_acteur WHERE `casting`.id_film = :idfilm ORDER BY nom ASC LIMIT 0 , 25'); 
        $query->execute(array('idfilm' => $film->getFilmid())); 
        while($data = $query->fetch()) 
        {
            echo "<option value=".$data['id_acteur'].">".$data['prenom']." ".$data['nom']."</option>";
        }
        $query->closeCursor();
    }
    
    // fonctions qui permettent de vérifier la validité des infos avant de les passer à la base
    // Pour le moment, utilise uniquement isset ; à revoir
    public static function check_film(film $film)
    {
        if (strlen($film->getTitre()<=255))
        {
            if (is_numeric($film->getAnnee()) && strlen($film->getAnnee())== 4)
            {
                if (is_numeric($film->getNote())&& (0<=($film->getNote())) && (10>=($film->getNote())))
                {
                    return true;
                }
                else
                    echo "pb note";
                    return false;
            }
            else
                echo "pb annee";
                return false;
        }
        else
            echo"pb titre";
            return false;
    }
    
    public static function check_acteur(acteur $acteur)
    {
        if (strlen($acteur->getNom()<=100) && strlen($acteur->getPrenom()<=100))
            return true;
        else
            return false;
    }
 }

