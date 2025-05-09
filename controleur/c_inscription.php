<?php
    require_once("vue/inscription/inscription.php");

    if (isset($_POST["valider"])){
		//insertion des données dans la base 
		$unControleur->inscription($_POST);
		

		 
	}

	
?>