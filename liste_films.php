<?php
include 'filmRepository.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Base de données putridTomatoes</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head> 

    <body>
        <div id="header"></div>
        <div id="menu">
        <a href='index.php'>Accueil</a> <a href='contact.php'>Contact</a> <a href='liste_films.php'>Recherche</a>
        <h1>Liste des films</h1>        
        </div><br/>        
        <table>
            <tr>
                <th>NOM</th>
                <th>ANNEE</th>
                <th>SCORE</th>
                <th>ACTEURS</th>
            </tr>
            <?php
            filmRepository::print_list_films();
            ?>
        </table><br/>
        <div id="links">
            <li><a href='formfilm.php'>Ajouter Film</a></li>
            <li><a href='formacteur.php'>Ajouter Acteur</a></li> 
            <li><a href='formcasting.php'>Casting-ajouts</a></li>
            <li><a href='formcasting_remove.php'>Casting-retraits</a></li>
            <li><a href='formdelete.php'>Supprimer</a></li>
        </div>
    </body>