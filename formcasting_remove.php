<?php
include 'filmRepository.php';

if (isset($_POST['film_casting'])&& !isset($_POST['removed_acteur']))
    {
        $film = filmRepository::get_film_byid($_POST['film_casting']);
        setcookie('film_stock', $film->getFilmid());
    }
elseif (isset($_POST['removed_acteur']))
    {
        $film = filmRepository::get_film_byid($_COOKIE['film_stock']);
        filmRepository::remove_acteur($film->getFilmid(), $_POST['removed_acteur']);
    }
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8"/>
    <title>formulaire de suppression d'acteur dans un film</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <div id="header"></div>
        <div id="menu">
        <a href='index.php'>Accueil</a> <a href='contact.php'>Contact</a> <a href='liste_films.php'>Recherche</a>
        <h1>Supprimer un acteur du casting d'un film : </h1>         
        </div><br/>
        
        <form method="post" action="formcasting_remove.php" <?php if (!empty($film)) echo 'hidden="hidden"';?>>
            <fieldset>
                <legend>Sélectionner un film : </legend>
                <label></label><br/>
                <select name="film_casting" size="1">
                    <?php 
                        filmRepository::get_list_films();
                    ?>
                </select><br/><br/>
                <input type="submit" value="Sélectionner" name="submit"/><br/>
            </fieldset>
        </form><br/><br/>
            
        <form method="post" action="formcasting_remove.php">    
            <fieldset>
                <legend>Acteur à retirer : </legend>
                <label></label><br/>
                <select name="removed_acteur" size="1">
                    <?php 
                        if ($film) filmRepository::get_casting($film);
                    ?>
                </select><br/><br/>
                <input type="submit" value="Valider" name="submit"/><br/>
            </fieldset>
        </form>
    </body>
</html>
