<?php
    require_once ("modele/modele.class.php");
    class Controleur {
        private $unModele ;

        public function __construct(){
            //instancier la classe modele
            $this->unModele= new Modele ();
        }
        /**********Gestion des clients *************/
        public function inscription($tab){
            //controler les donnees avant de les insertion dans la BDD

            //appel au modele pour inserer les données
            $this->unModele->inscription($tab);
        }

        public function verifConnexion ($email, $mdp){
			//controler les données email et mdp 

			//appel du modele 
			return $this->unModele->verifConnexion ($email, $mdp);
		}


        public function countStand (){
		
			//appel du modele 
			return $this->unModele->countStand ();
		}

        public function listStand_id (){
		
			//appel du modele 
			return $this->unModele->listStand_id ();
		}

        public function getID_client (){
	
			//appel du modele 
			return $this->unModele->getID_client ();
		}

        public function getClientRes (){
		
			//appel du modele 
			return $this->unModele->getClientRes ();
		}

        public function ajouterStandRes ($id_stand){
			
			//appel du modele 
			$this->unModele->ajouterStandRes ($id_stand);
		}

        
        public function remplirPanier (){
			
			//appel du modele 
			$this->unModele->remplirPanier ();
		}

        public function listStandRes (){
	
			//appel du modele 
			return $this->unModele->listStandRes ();
		}

        public function getStand_Panier ($num){
			
			//appel du modele 
			return $this->unModele->getStand_Panier ($num);
		}
        

        public function remplirSommairePanier (){
			
			//appel du modele 
			$this->unModele->remplirSommairePanier ();
		}
        

        public function sommePanierStand (){
		
			//appel du modele 
			return $this->unModele->sommePanierStand ();
		}
		

		public function deleteStandRes ($id_stand){
		
			//appel du modele 
			$this->unModele->deleteStandRes ($id_stand);
		}

		public function ajouterArticleRes ($id_article){
		
			//appel du modele 
			$this->unModele->ajouterArticleRes ($id_article);
		}

		

		public function deleteArticleRes ($id_article){
		
			//appel du modele 
			$this->unModele->deleteArticleRes ($id_article);
		}


		public function listArticle (){
		
			//appel du modele 
			return $this->unModele->listArticle ();
		}

		public function listStand (){
		
			//appel du modele 
			return $this->unModele->listStand ();
		}

		

		public function getArticle_Panier_qte ($id_reservation){
		
			//appel du modele 
			return $this->unModele->getArticle_Panier_qte ($id_reservation);
		}

		

		public function retirerArticleRes ($id_article){
		
			//appel du modele 
			$this->unModele->retirerArticleRes ($id_article);
		}

		

		public function refrshPage (){
		
			//appel du modele 
			$this->unModele->refrshPage ();
		}
    }
?>