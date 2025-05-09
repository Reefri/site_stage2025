<div class="reservation">
    <div class="content">
        

        <?php 
        if (! isset($_GET['type'])){$type='article';echo "<h2>RESERVER DES STANDS</h2>";}
        else {
            if ($_GET['type'] == 'article'){$type='stand';echo "<h2>RESERVER DES ARTICLES</h2>";}
            else {$type='article';echo "<h2>RESERVER des STANDS</h2>";}
        }
        
        echo 
            "<a class='swap' href='index.php?page=reservation&type=".$type."'>
                <button class='btnRes'>Voir les ".$type."s disponibles.</button>
            </a>";
        ?>

        <div class="reservation-section">



            <?php 
                $unModele = new Modele();
                $unModele->remplirReservation();
            ?>

        </div>

        <a href="index.php?page=panier">
            <button class="btnRes">Voir Le Panier</button>
        </a>

    </div>
</div>