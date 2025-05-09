<?php
    
	if (! isset($_SESSION["email"])){ 
			require_once("controleur/c_connexion.php");
	}

	else {
		require_once("vue/deconnexion/deconnexion.php");
	}

	if(isset($_POST["deconnexion"])){
		session_destroy();

		header("Location: index.php?page=connexion"); 
        
	}

	
?>