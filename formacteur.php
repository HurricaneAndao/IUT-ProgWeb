<?php 
include 'filmRepository.php';

if (isset($_POST['nom_acteur']) && isset($_POST['prenom_acteur']))
    {
        $acteur = new acteur($_POST['nom_acteur'], $_POST['prenom_acteur']);
        if (filmRepository::check_acteur($acteur))
        {
            filmRepository::save_acteur($acteur);
        }
        else echo "Erreur de saisie. Veuillez modifier vos données";
    }
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8"/>
    <title>formulaire d'ajout d'acteur dans la base</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <div id="header"></div>
        <div id="menu">
        <a href='index.php'>Accueil</a> <a href='contact.php'>Contact</a> <a href='liste_films.php'>Recherche</a>
        <h1>Ajouter un acteur dans la base : </h1>        
        </div><br/>
        <form method="post" action="formacteur.php">
        
            <label>Nom : </label>
            <input type="text" name="nom_acteur" size="35" maxlength="100" /><br/><br/>
            
            <label>Prénom : </label>
            <input type="text" name="prenom_acteur" size="35" maxlength="100" /><br/><br/>

            <input type="submit" value="Insérer" name="submit"/><br/>
        
        </form><br/>
        
        <?php 
        if (isset($_POST['nom_acteur']) && isset($_POST['prenom_acteur']))
            echo "<a href='formcasting.php'>Maintenant, ajoutez cet acteur au casting d'un film !</a>"
        ?>
    </body>
</html>
