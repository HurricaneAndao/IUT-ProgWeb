<?php
/* Fonction de connexion en local à la base de données*/
 function connectDb(){
      $host="localhost"; // ou sql.hebergeur.com
      $user="p1512799";      // ou login
      $password="248128";      // mot de passe
      $dbname="p1512799";
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