<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>formulaire d'ajout de film</title>
  </head>

<body>
  <?php include 'connectDb.php'; 
	if (isset($_POST['nom_film']) && isset($_POST['annee']) && isset($_POST['score']))
	{
		$bdd = connectDb(); //connexion � la BDD
		$query = $bdd->prepare('SELECT COUNT(*) AS nb FROM films WHERE nom_film = :n'); 
		$query->execute(array('n' => $_POST['nom_film'])); // param�tres et ex�cution
		$data = $query->fetch();
		if ($data['nb'] == 0)
		{	
			echo 'entre dans le if';
			$bdd = connectDb(); //connexion � la BDD
			$query = $bdd->prepare('INSERT INTO `p1512799`.`films` (`nom_film`, `annee_film`, `score`) VALUES (:n, :a, :s)'); // requ�te SQL
			$query->execute(array('n' => $_POST['nom_film'], 'a' => $_POST['annee'], 's' => $_POST['score'])); // param�tres et ex�cution
		
		}
		else
		{
			echo 'entre dans le else';
			$bdd = connectDb(); //connexion � la BDD
			$query = $bdd->prepare('UPDATE `p1512799`.`films` SET annee_film=:a, score=:s WHERE nom_film = :n'); // requ�te SQL
			$test = $query->execute(array('n' => $_POST['nom_film'], 'a' => $_POST['annee'], 's' => $_POST['score'])); // param�tres et ex�cution
		}
	}

 ?>
  
  <form method="post" action="formfilm.php">

    <p>

        <label>Titre du film : </label>
        <input type="text" name="nom_film" size="30" maxlength="255" /><br><br>
		<label>Ann�e du film : </label>
		<select name="annee">
			<?php $year = 1949; ?>
			<?php while ($year < 2016): ?>
				<?php $year++; ?>
				<option value="<?php echo sprintf('%04d', $year); ?>"><?php echo sprintf('%04d', $year); ?></option>
			<?php endwhile; ?>
		</select><br>
		<br>
		
		<label>Score : </label>
        <input type="text" name="score" size="30" maxlength="3" /><br>
		<br>
		
		<input type="submit" value="Ins�rer" name="submit"/><br>
    
	</p>
	
</form>
</body>
</html>