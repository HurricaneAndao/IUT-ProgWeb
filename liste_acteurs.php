<?php
include 'filmRepository.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Casting</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head> 

    <body>
        
        <div id="header"></div>
        <div id="menu">
            <li><a href='index.php'>Accueil</a></li>
            <li><a href='contact.php'>Contact</a></li>
            <li><a href='liste_films.php'>Recherche</a></li>
        <h1><?php 
            echo filmRepository::get_film_byid($_GET['filmid'])->getTitre();
             ?>
        </h1>
        </div>
        
        <table>
            <tr>
                <th>PRENOM</th>
                <th>NOM</th>
                <th>FICHE WIKI</th>
            </tr>
            <?php
                filmRepository::print_list_acteurs(filmRepository::get_film_byid($_GET['filmid']));
            ?>
        </table><br/>
        <div id="links">
            <a href='formfilm.php'>Ajouter Film</a> 
            <a href='formacteur.php'>Ajouter Acteur</a> 
            <a href='formcasting.php'>Casting-ajouts</a>
            <a href='formcasting_remove.php'>Casting-retraits</a>
            <a href='formdelete.php'>Supprimer</a>
        </div>
    </body>