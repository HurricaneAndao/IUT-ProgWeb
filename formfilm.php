<?php 
include 'filmRepository.php';

if (isset($_POST['nom_film']) && isset($_POST['annee']) && isset($_POST['score']))
    {
        $film = new film($_POST['nom_film'], $_POST['annee'], $_POST['score']);
        if (filmRepository::check_film($film))
        {
            filmRepository::save_film($film);
            echo "film ".$film->getTitre()." sauvegardé";
        }
        else echo "Erreur de saisie. Veuillez modifier vos données";   
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>formulaire d'ajout de film</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
<body>
    <div id="header"></div>
    <div id="menu">
    <a href='liste_films.php'>Accueil</a> <a href='contact.php'>Contact</a> <a href='liste_films.php'>Recherche</a>
    <h1>Ajouter un film dans la base : </h1>     
    </div><br/>
    <form method="post" action="formfilm.php">

    <p>
        <label>Titre du film : </label>
        <input type="text" name="nom_film" size="30" maxlength="255" /><br/><br/>
		<label>Année du film : </label>
		<select name="annee">
			<?php $year = 1949; ?>
			<?php while ($year < 2016): $year++; ?>
                            <option value="<?php echo sprintf('%04d', $year); ?>"><?php echo sprintf('%04d', $year); ?></option>
			<?php endwhile; ?>
		</select><br/><br/>
		
	<label>Score : (entre 0 et 10)</label>
        <input type="number" name="score" size="30" min="0" max="10" step="0.1"" /><br/><br/>
		
	<input type="submit" value="Insérer" name="submit"/>
    </p>
    </form></br>
    
    <?php 
    if (isset($_POST['nom_film']) && isset($_POST['annee']) && isset($_POST['score']))
        echo "<a href='formcasting.php'>Maintenant, ajoutez des acteurs au casting de ce film !</a>"
    ?>   
</body>
</html>