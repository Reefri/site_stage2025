<div class="panier">
    <div class="main">
        <h2>MON PANIER</h2>
        
        <div class="content">

            <div class="cart-section">
                <div class="cart-items">

                    <?php

                    $unModele = new Controleur();

                    $nb_article = sizeof($unControleur->getArticle_Panier_qte($unControleur->getClientRes()));
                        $nb_stand =sizeof($unControleur->getStand_Panier($_SESSION["id_client"]));

                    if ($nb_article+$nb_stand == 0){echo "Votre Panier Est Vide !";}
                    else {$unModele->remplirPanier();}
                    
                    
                    ?>

                </div>
                
                <div class="cart-summary">



                    <?php
                        $unModele = new Controleur();

                        $nb_article = sizeof($unControleur->getArticle_Panier_qte($unControleur->getClientRes()));
                        $nb_stand =sizeof($unControleur->getStand_Panier($_SESSION["id_client"]));



                        if ($nb_article+$nb_stand == 0){echo "Votre Panier Est Vide !";}
                        else {$unModele->remplirSommairePanier();}
                    ?>


                    <div class="somme">
                        <hr />
                        <p><strong>Total = <?php 
                        $valeur = $unControleur->sommePanierStand();
                        if ($valeur == ''){echo '0€';}
                        else{echo $valeur."€";} 
                        ?></strong></p>
                    </div>
                </div>
            </div>
        
            <div class="payment-section">
                <div class="payment-option">
                    <h3>Paiement par Carte Bancaire</h3>
                    <p>INFORMATIONS-CB</p>
                </div>
                <div class="payment-option">
                    <h3>Paiement par Paypal</h3>
                    <p>INFORMATIONS-PAYPAL</p>
                </div>
            </div>

        </div>
        
    </div>
</div>