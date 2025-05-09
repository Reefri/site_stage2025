<?php
  
  
  
	require_once("vue/reservation/reservation.php");
    

    if(isset($_POST["ajouter_id"])){
      if ( ! isset($_SESSION["email"]))
        {echo 'Connectez-vous avant de commencer une réservation !';}
      else{

        if (isset(($_GET['type']))){
          if ($_GET['type']=='stand'){
            $unControleur->ajouterStandRes($_POST['ajouter_id']);}
          else{$unControleur->ajouterArticleRes($_POST['ajouter_id']);}
        }
        else{$unControleur->ajouterStandRes($_POST['ajouter_id']);}
      }
    }
    

?>