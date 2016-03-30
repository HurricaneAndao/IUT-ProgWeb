<?php
/* Fonction de connexion en local à la base de données*/
 function connectDb(){
      $host="localhost"; // ou sql.hebergeur.com
      $user="";      // ou login
      $password="";      // mot de passe
      $dbname="";
  try {
       $bdd=new PDO('mysql:host='.$host.';dbname='.$dbname.
                    ';charset=utf8',$user,$password);
        // echo "Ca marche";
	   return $bdd;
      } catch (Exception $e) {
       die('Erreur : '.$e->getMessage());
  }
 }
 
 // echo "Ca marche";
?>
