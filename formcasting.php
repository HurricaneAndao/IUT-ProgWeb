<?php
include 'filmRepository.php';

if (isset($_POST['film_casting']) && isset($_POST['acteurs_ajoutes']))
    {
        filmRepository::add_acteurs($_POST['film_casting'], $_POST['acteurs_ajoutes']);
    }
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8"/>
    <title>formulaire d'ajout d'acteur dans un film</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <div id="header"></div>
        <div id="menu">
        <a href='index.php'>Accueil</a> <a href='contact.php'>Contact</a> <a href='liste_films.php'>Recherche</a>
        <h1>Ajouter un acteur au casting d'un film : </h1>
        </div><br/>
        <form method="post" action="formcasting.php">
        
            <label>Film : </label><br/>
            <select name="film_casting" size="1">
                <?php 
                    filmRepository::get_list_films();
                ?>
            </select><br/><br/>
            
            <label>Casting : (maintenez ctrl pour une sélection multiple)</label><br/>
            <select name="acteurs_ajoutes[]" size="20" multiple="multiple">
                <?php 
                    filmRepository::get_list_acteurs();
                ?>
            </select><br/><br/>

            <input type="submit" value="Valider" name="submit"/><br/>
        </form>
    </body>
</html>
