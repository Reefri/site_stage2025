<?php
    
	if ( ! isset($_SESSION["email"])){ 
			require_once("vue/connexion/connexion.php");
	}

	else {
		require_once("controleur/c_deconnexion.php");
	}

	if(isset($_POST["connexion"])){
		$email = $_POST["email"];
		$mdp = $_POST["mdp"];

		//on vérifie dans la BDD - User 
		$unUser = $unControleur->verifConnexion($email, $mdp);
		if ($unUser){
			//enregistrement de la session 
			$_SESSION["nom"] = $unUser["nom"]; 
			$_SESSION["prenom"] = $unUser["prenom"]; 
			$_SESSION["email"] = $unUser["email"];
			$_SESSION["role"] = $unUser["role"]; 
			$_SESSION["id_client"] = $unUser["id_client"]; 

			header("Location: index.php?page=home"); 

		}
		else {
			echo "<br> Veuillez Vérifier vos identifiants."; 
		}


	}
?>