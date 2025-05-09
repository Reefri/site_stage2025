<?php
    session_start();
    require_once("controleur/controleur.class.php");
    //instancier la classe controleur :
    $unControleur = new Controleur();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheet/stylesheet.css">
    <title>Paris Events</title>
    <!--<script type="text/javascript">
            function refreshPage () {
                var page_y = document.getElementsByTagName("body")[0].scrollTop;
                window.location.href = window.location.href.split('?')[0] + '?page_y=' + page_y;
            }
            window.onload = function () {
                setTimeout(refreshPage, 35000);
                if ( window.location.href.indexOf('page_y') != -1 ) {
                    var match = window.location.href.split('?')[1].split("&")[0].split("=");
                    document.getElementsByTagName("body")[0].scrollTop = match[1];
                }
            }
        </script>-->
</head>
<body>
    <div id="header"></div>
    <script>
    fetch('vue/header/header.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header').innerHTML = data;
        });
    </script>

    <center>
        <?php
            
            
            if (isset($_GET['page'])){
                $page = $_GET['page'];
            }else {
                $page = "home" ;
            }
            switch ($page) {
                case "home" : require_once ("vue/home/home.php"); break;
                case "connexion" : require_once ("controleur/c_connexion.php"); break;
                case "inscription" : require_once ("controleur/c_inscription.php"); break;
                case "reservation" : require_once ("controleur/c_reservation.php"); break;
                case "panier" : require_once ("controleur/c_panier.php"); break;
            }

        ?>
    </center>


    <div id="footer"></div>
    <script>
    fetch('vue/footer/footer.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer').innerHTML = data;
        });
    </script>

</body>
</html>