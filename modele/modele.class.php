<?php
    class Modele {
        private $unPdo ; 
        //connexion via la classe PDO : PHP DATA Object

        public function __construct(){
            $serveur = "localhost";
            $bdd ="paris_event";
            $user = "root";
            $mdp = "";

            try{
            $this->unPdo = new PDO("mysql:host=".$serveur.";dbname=".$bdd,$user,$mdp);
            }
            catch(PDOException $exp){
                echo "Erreur de connexion a la base de BDD";
            }
        }

        public function refrshPage(){
            echo "<script>alert('Message d\'alerte');</script>";
            echo "<script> location.refresh();</script>";
        }


        /**      INSCRIPTION/CONNEXION       **/
      
        public function inscription($tab){
            $requete = "insert into client values(null, :nom, :prenom,:tel, :email, :mot_de_passe, 'client', sysdate());";
            if ($tab["confirm_password"] != $tab["mot_de_passe"]){echo "Confirmation du mot de passe invalidée, veuillez recommencer.";}
            else {
                $donnees = array(':nom' => $tab['nom'],
                                ':prenom' => $tab['prenom'],
                                ':tel' => $tab['tel'],
                                ':email' => $tab['email'],
                                ':mot_de_passe' => $tab['mot_de_passe'],
                                );
                //on prepare la requete
                $exec = $this->unPdo->prepare ($requete);
                //exécuter la requete
                $exec->execute ($donnees);
                echo " <br> Insertion réussie.";
                header("Location: index.php?page=connexion");
            }
        }

        public function getID_client(){

                $requete = "select id_client from client where email ='".$_SESSION["email"]."';"; 
                $exec = $this->unPdo->prepare ($requete);
                
                $exec->execute ();
                return $exec->fetch()["id_client"]; 
        }

        public function verifConnexion ($email, $mdp){
            $requete = "select * from client where email =:email and mot_de_passe =:mdp ;"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array(":email"=>$email, ":mdp"=>$mdp);
            $exec->execute ($donnees);
            return $exec->fetch(); 
        }

        /**      RESERVATION       **/

        public function countStand (){
            $requete = "select count(id_stand) from stand where disponibilite = true;"; 
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();
            return $exec->fetch()["count(id_stand)"]; 
        }

        public function remplirReservation(){
            if (! isset($_GET['type'])){$this->remplirReservationStand();}
            else {
                if ($_GET['type'] == 'article'){$this->remplirReservationArticle();}
                else {$this->remplirReservationStand();}
            }
        }

        public function listArticle (){
			$requete = "select * from article where quantite>0;"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            return  $exec->fetchAll(); 
		}

        public function remplirReservationArticle(){


            $liste_article = $this->listArticle();

            $nb_article = sizeof($liste_article);

            


            if ($nb_article == 0){echo "Aucun article réservable !";}
            else{

                echo "<ul class='ul_reservationY'>";

                for ($i=0;$i<$nb_article/3;$i++)
                {

                    echo "<ul class='ul_reservationX'>";

                    for ($j=0 ; $j < 3; $j++)
                    {
                        if ($i*3 + $j >=$nb_article){break;}
                        echo "<li class='li_reservation'>
                                <div class='reservation-block'>
                                        <div class='titre_article'><p>".$liste_article[$i*3+$j]['nom_article']."</p></div>
                                        <p>".$liste_article[$i*3+$j]['descrip']."</p>
                                    <br><p>".$liste_article[$i*3+$j]['prix']."€</p>
                                    <div class='image-container'>
                                        <img src='picture/article/".$liste_article[$i*3+$j]['lienImage']."' class='imageRes'>
                                    </div>
                                    <form method='post'>
                                        <button class='ajouter' name='ajouter_id' value=".$liste_article[$i*3+$j]['id_article'].">Ajouter au panier</button>
                                    </form>
                                </div>
                            </li>";
                    }

                    echo "</ul>";
                }

                echo "</ul>";

            }
        }

        public function remplirReservationStand(){


            $liste_stand_id = $this->listStand_id();
            $nb_stand = sizeof($liste_stand_id);

            $liste_stand = $this->listStand();


            if ($nb_stand == 0){echo "Aucun stand réservable !";}
            else{

                echo "<ul class='ul_reservationY'>";

                for ($i=0;$i<$nb_stand/3;$i++)
                {

                    echo "<ul class='ul_reservationX'>";

                    

                    for ($j=0 ; $j < 3; $j++)
                    {
                        if ($i*3 + $j >=$nb_stand){break;}

                       

                        echo "<li class='li_reservation'>
                                <div class='reservation-block'>
                                        <p>".$liste_stand[$i*3+$j]['descrip']."</p>
                                    <br><p>".$liste_stand[$i*3+$j]['prix']."€</p>
                                    <div class='image-container'>
                                        <img src='picture/stand/".$liste_stand[$i*3+$j]['lienImage']."' class='imageRes'>
                                    </div>
                                    <form method='post'>
                                        <button class='ajouter' name='ajouter_id' value=".$liste_stand[$i*3+$j]['id_stand'].">Ajouter au panier</button>
                                    </form>
                                </div>
                            </li>";
                    }

                    echo "</ul>";
                }

                echo "</ul>";

            }
        }


        public function listStand_id (){
			$requete = "select id_stand from stand where disponibilite = true;"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            $res = $exec->fetchAll(); 

            $liste = array();

            for ($i=0;$i<sizeof($res);$i++)
            {
                array_push($liste,$res[$i]["id_stand"]);
            }

            return $liste;
		}

        public function listStand (){
			$requete = "select * from stand where disponibilite = true;"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            return  $exec->fetchAll(); 
		}

        public function getClientRes(){
            $requete = "select id_reservation from reservation where id_client = ".$_SESSION["id_client"]." and etat ='en attente';";
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();
            if ($exec->fetch() == ''){
                $requete = "insert into reservation values(null, ".$_SESSION["id_client"].",null,'en attente');";
                //on prepare la requete
                $exec2 = $this->unPdo->prepare ($requete);
                //exécuter la requete
                $exec2->execute ();

                
            } 
            $requete = "select id_reservation from reservation where id_client = ".$_SESSION["id_client"].";";
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();

            
            
            return $exec->fetch()["id_reservation"];
        }

        public function ajouterStandRes($id_stand){
            $requete = "select count(id_stand) from reserverStand where id_stand = ".$id_stand.";";
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();

            if ( $exec->fetch()["count(id_stand)"] ==0){


                $id_res = $this->getClientRes();
                $requete = "insert into reserverStand values(".$id_res.",".$id_stand.");";

                //on prepare la requete
                $exec = $this->unPdo->prepare ($requete);
                //exécuter la requete
                $exec->execute ();
            }
            else {echo "deja dans votre panier !";}
        }

        public function ajouterArticleRes($id_article){
            $requete = "select count(id_article) from reserverArticle where id_article = ".$id_article.";";
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();

            $id_res = $this->getClientRes();

            

            if ( $exec->fetch()["count(id_article)"] ==0){

                $requete = "insert into reserverArticle values(".$id_res.",".$id_article.",1);";
            }
            else {
                $requete = "update reserverArticle set quantite=quantite+1 where id_reservation = ".$id_res." and id_article = ".$id_article.";";
                
            }

            
            //on prepare la requete
            $exec = $this->unPdo->prepare ($requete);
            //exécuter la requete
            $exec->execute ();
        }

        public function retirerArticleRes($id_article){

            $id_res = $this->getClientRes();
            $requete = "update reserverArticle set quantite=quantite-1 where id_reservation = ".$id_res." and id_article = ".$id_article.";";

            $exec = $this->unPdo->prepare ($requete);
            //exécuter la requete
            $exec->execute ();

            $requete = "delete from reserverarticle where quantite<=0;";

            $exec = $this->unPdo->prepare ($requete);
            //exécuter la requete
            $exec->execute ();
        }
        

        /**      PANIER       **/

        public function listStandRes (){
            $id_res = $this->getClientRes();

			$requete = "select id_stand from reserverStand where id_reservation = ".$id_res.";"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            $res = $exec->fetchAll(); 

            $liste = array();

            for ($i=0;$i<sizeof($res);$i++)
            {
                array_push($liste,$res[$i]["id_stand"]);
            }

            return $liste;
		}

        public function getStandInfo($id_stand){
            $requete = "select * from stand where id_stand = ".$id_stand." ;"; 
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();
            $res = $exec->fetchAll(); 

            $liste = array();

            for ($i=0;$i<sizeof($res);$i++)
            {
                array_push($liste,$res[$i]["id_stand"]);
            }

            return $liste;

        }

        public function getStand_Panier($id_reservation){
            $requete = "select * from stand where id_stand in (select id_stand from reserverstand where id_reservation= ".$id_reservation.");"; 
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();

            return $exec->fetchAll();
        }

        public function getArticle_Panier($id_reservation){
            $requete = "select * from article where id_article in (select id_article from reserverarticle where id_reservation= ".$id_reservation.");"; 
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();

            return $exec->fetchAll();
        }

        public function deleteStandRes($id_stand){
            $id_res = $this->getClientRes();
            $requete = "delete from reserverstand where id_stand = ".$id_stand." and id_reservation = ".$id_res.";";
            $exec = $this->unPdo->prepare($requete);
            $exec->execute();
        }

        public function deleteArticleRes($id_article){
            $id_res = $this->getClientRes();
            $requete = "delete from reserverarticle where id_article = ".$id_article." and id_reservation = ".$id_res.";";
            $exec = $this->unPdo->prepare($requete);
            $exec->execute();
        }

        public function remplirPanier(){
            echo "<ul class='liste'>";
            $this->remplirPanierStand();
            $this->remplirPanierArticle();
            echo "</ul>";
        }

        public function remplirPanierArticle(){
            
            $info_article = $this->getArticle_Panier($_SESSION["id_client"]);
            $info_article_qte = $this->getArticle_Panier_qte($_SESSION["id_client"]);
            $nb_articleRes = sizeof($info_article);

            if ($nb_articleRes == 0){echo "";}
            else{

                for ($i=0;$i<$nb_articleRes;$i++)
                {
                    echo 
                        "<li>
                            <div class='cart-item'>
                                <img src='picture/article/".$info_article[$i]["lienImage"]."' class='image-container'>
                                <div class='item-details'>
                                    <p>Article :".$info_article[$i]["nom_article"]."</p>
                                    <p>x ".$info_article_qte[$info_article[$i]["id_article"]]."</p>
                                    <p>".$info_article[$i]["prix"]."€</p>
                                </div>
                                <a href='index.php?page=panier&action=supObjet&objet=article&id_objet=".$info_article[$i]["id_article"]."'  class=corbeille >
                                    <img src='picture/logo_corbeille.png' class='corbeille'>
                                </a>
                                <div class='plusmoins'>
                                    <a href='index.php?page=panier&action=ajouterObjet&objet=article&id_objet=".$info_article[$i]["id_article"]."'  class=corbeille >
                                        <img src='picture/icon_plus.png' class='plus'>
                                    </a>

                                    <a href='index.php?page=panier&action=retirerObjet&objet=article&id_objet=".$info_article[$i]["id_article"]."'  class=corbeille >
                                        <img src='picture/icon_moins.png' class='moins'>
                                    </a>
                                </div>
                            </div>
                        </li>";
                }

            }
        }

        public function remplirPanierStand(){
            
            $info_stand = $this->getStand_Panier($_SESSION["id_client"]);
            $nb_standRes = sizeof($info_stand);

            if ($nb_standRes == 0){echo "";}
            else{

                
                for ($i=0;$i<$nb_standRes;$i++)
                {
                    echo 
                        "<li>
                            <div class='cart-item'>
                                <img src='picture/stand/".$info_stand[$i]["lienImage"]."' class='image-container'>
                                <div class='item-details'>
                                    <p>Stand n°".$info_stand[$i]["id_stand"]."</p>
                                    <p>x 1</p>
                                    <p>".$info_stand[$i]["prix"]."€</p>
                                </div>
                                <a href='index.php?page=panier&action=supObjet&objet=stand&id_objet=".$info_stand[$i]["id_stand"]."' class=corbeille >
                                    <img src='picture/logo_corbeille.png' class='corbeille'>
                                </a>
                            </div>
                        </li>";
                }
              

            }
        }

        public function remplirSommairePanier(){
            echo "<ul class='liste'>";
            $this->remplirSommairePanierStand();
            $this->remplirSommairePanierArticle();
            echo "</ul>";
        }

        public function getArticle_Panier_qte($id_reservation){
            $requete = "select id_article,quantite from reserverarticle where id_reservation=".$id_reservation.";"; 
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();
            $res = $exec->fetchAll();
           

            if (sizeof($res)==0){$liste=array();}


            for ($i=0;$i<sizeof($res);$i++)
            {
                $liste[$res[$i]["id_article"]]=$res[$i]["quantite"];
            }


            return $liste;
        }

        public function remplirSommairePanierArticle(){
        
            $info_article = $this->getArticle_Panier($_SESSION["id_client"]);
            $info_article_qte = $this->getArticle_Panier_qte($_SESSION["id_client"]);
            $nb_standRes = sizeof($info_article);


            if ($nb_standRes == 0){echo "";}
            else{
                for ($i=0;$i<$nb_standRes;$i++)
                { 
                    echo 
                    "<li>
                        <p>".$info_article[$i]["nom_article"]."  x ".$info_article_qte[$info_article[$i]["id_article"]]." = ".$info_article[$i]["prix"]*$info_article_qte[$info_article[$i]["id_article"]]."€</p>
                    </li>";
                }

            }
        }

        
        public function remplirSommairePanierStand(){
        
            $info_stand = $this->getStand_Panier($_SESSION["id_client"]);
            $nb_standRes = sizeof($info_stand);


            if ($nb_standRes == 0){echo "";}
            else{

            
                for ($i=0;$i<$nb_standRes;$i++)
                { 
                    echo 
                        "<li>
                        <p>Stand n°".$info_stand[$i]["numero_stand"]." x 1 = ".$info_stand[$i]["prix"]."€</p>
                    </li>";
                }

            }
        }

        public function sommePanierStand(){
            $requete = "select sum(prix) from stand where id_stand in 
                        (select id_stand from reserverstand where id_reservation in 
                        (select id_reservation from reservation where id_client = ".$_SESSION["id_client"]." and etat = 'en attente'));"; 
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();
            $sommeStand =$exec->fetch()["sum(prix)"];

            $requete = "select sum(a.quantite*b.prix) from reserverarticle a,article b where a.id_article = b.id_article and id_reservation = ".$this->getClientRes().";";
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();
            $sommeArticle =$exec->fetch()["sum(a.quantite*b.prix)"];

            $somme =$sommeStand + $sommeArticle;
            return $somme; 
        }
    }

?>