<?php
/* Fonction de connexion à la base de données*/

//Options de debugging
//ini_set('display_errors','On');
//error_reporting(E_ALL | E_STRICT);

function connectDb(){
      $host="localhost"; // ou sql.hebergeur.com dans lr cas d'une bdd distante
      $user="chris";                  // login
      $password="balleaupanier";      // mot de passe
      $dbname="putridTomatoes";
  try {
       $bdd=new PDO('mysql:host='.$host.';dbname='.$dbname.
                    ';charset=utf8',$user,$password);
       return $bdd;
      } catch (Exception $e) {
          die('Erreur : '.$e->getMessage());   
  }
      }
?>
