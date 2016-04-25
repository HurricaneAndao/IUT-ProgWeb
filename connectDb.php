<?php
<<<<<<< HEAD
/* Fonction de connexion à la base de données*/

//Options de debugging
//ini_set('display_errors','On');
//error_reporting(E_ALL | E_STRICT);

function connectDb(){
      $host="localhost"; // ou sql.hebergeur.com dans lr cas d'une bdd distante
      $user="";                  // login
      $password="";              // mot de passe
      $dbname="putridTomatoes";
=======
/* Fonction de connexion en local à la base de données*/
 function connectDb(){
      $host="localhost"; // ou sql.hebergeur.com
      $user="";      // ou login
      $password="";      // mot de passe
      $dbname="";
>>>>>>> origin/master
  try {
       $bdd=new PDO('mysql:host='.$host.';dbname='.$dbname.
                    ';charset=utf8',$user,$password);
       return $bdd;
      } catch (Exception $e) {
          die('Erreur : '.$e->getMessage());   
  }
<<<<<<< HEAD
      }
=======
 }
 
 // echo "Ca marche";
>>>>>>> origin/master
?>
