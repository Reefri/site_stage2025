<?php


    if (!isset($_SESSION['email'])){header("Location: index.php?page=connexion"); }

    else{
	    require_once("vue/panier/panier.php");

    
        
        if (isset($_GET['action']) ){
            
            if ($_GET['objet'] =='stand'){
                $id_stand = $_GET['id_objet'];
                $unControleur->deleteStandRes($id_stand);
            }else{
                $id_article = $_GET['id_objet'];
                $action = $_GET['action'];

                switch ($action) {
                    case "supObjet" : $unControleur->deleteArticleRes($id_article); break;
                    case "ajouterObjet" : $unControleur->ajouterArticleRes($id_article); break;
                    case "retirerObjet" : $unControleur->retirerArticleRes($id_article); break;
                }
            }
            /*header("Location: index.php?page=panier"); */
            
        }
    }
?>