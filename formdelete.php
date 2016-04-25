<?php
include 'filmRepository.php';

if (isset($_POST['film_delete']))
    {
        filmRepository::delete_film(filmRepository::get_film_byid($_POST['film_delete']));
    }
elseif (isset($_POST['acteur_delete']))
    {
        filmRepository::delete_acteur(filmRepository::get_acteur_byid($_POST['acteur_delete']));
    }
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8"/>
    <title>Suppression de données dans la base</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <div id="header"></div>
        <div id="menu">
        <a href='index.php'>Accueil</a> <a href='contact.php'>Contact</a> <a href='liste_films.php'>Recherche</a>
        <h1>Suppression de données dans la base : </h1>
        </div><br/>
        <form method="post" action="formdelete.php">
            <fieldset>
                <legend>Supprimer un film :</legend>
                <label></label><br/>
                <select name="film_delete" size="1">
                    <?php 
                        filmRepository::get_list_films();
                    ?>
                </select><br/><br/>
                <input type="submit" value="Valider" name="submit"/><br/>
            </fieldset>
        </form>
        
        <br/>
        
        <form method="post" action="formdelete.php">
            <fieldset>
                <legend>Supprimer un acteur :</legend>
                <label></label><br/>
                <select name="acteur_delete" size="1">
                    <?php 
                        filmRepository::get_list_acteurs();
                    ?>
                </select><br/><br/>
                <input type="submit" value="Valider" name="submit"/><br/>
        </form>
    
    </body>
</html>
