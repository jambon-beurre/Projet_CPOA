
 <?php include("begin.php"); ?>

<?php
    if(isset($_POST["place"]) && isset($_POST["nbPlaces"]) && $_POST["place"]!=null && $_POST["nbPlaces"]!=null && isset($_GET['id']) && $_GET['id'] != null){
        setcookie("nbPlaces", $_POST['nbPlaces'], time()+86400);
        $_COOKIE["nbPlaces"] = $_POST['nbPlaces'];

        setcookie("place", $_POST['place'], time()+86400);
        $_COOKIE["place"] = $_POST['place'];

        setcookie("idMatch", $_GET['id'], time()+86400);
        $_COOKIE["idMatch"] = $_GET['id'];

        $placesOk = nbPlacesOk($_COOKIE["idMatch"], $_COOKIE["nbPlaces"], $_COOKIE["place"]);
        if($placesOk >= 0){
            header('Location: place.php?id='.$_GET["id"]."&err=2&nbRest=".$placesOk);
        }
    }

    else if(isset($_GET['red'])){

    }

    else{
        header('Location: place.php?id='.$_GET["id"]."&err=1");
    }

    $prix = getPrixTotal($_COOKIE["idMatch"], $_COOKIE["place"], $_COOKIE["nbPlaces"]); //A chaque fois qu'on retourne sur la page, le prix total est réinitiatisé, et modifié par la suite si un réduction a été appliquée
    setcookie("prix", $prix, time()+86400);
    $_COOKIE["prix"] = $prix;

    $bdd = Connect_db();

    $SQL_Query = 'SELECT jourMatch as j, heureMatch as h, typeMatch as t FROM Matchs WHERE idMatch = ' .$_COOKIE["idMatch"];

    $query = $bdd -> prepare($SQL_Query);
    $query -> execute();

    while($line = $query -> fetch()){
        setcookie("jourMatch", $line["j"], time()+86400);
        $_COOKIE["jourMatch"] = $line["j"];
        setcookie("heureMatch", $line["h"], time()+86400);
        $_COOKIE["heureMatch"] = $line["h"];
        setcookie("typeMatch", $line["t"], time()+86400);
        $_COOKIE["typeMatch"] = $line["t"];
    }

?>
<div class='marg'>
    <h1>Récapitulatif</h1>
    <div class="contour">
        <p>
            <label class = 'strong'>Tour : </label><?php echo(getTour($_COOKIE["jourMatch"])); ?>
        </p>
        <p>
            <label class = 'strong'>Match : </label><?php echo(getVs($_COOKIE["idMatch"], $_COOKIE["typeMatch"])); ?>
        </p>
        <p>
            <label class = 'strong'>Court : </label><?php echo(getCourt($_COOKIE["idMatch"])); ?>
        </p>
        <p>
            <label class = 'strong'>Emplacement : </label><?php echo($_COOKIE["place"]); ?>
        </p>
        <p>
            <label class = 'strong'>Nombre de places : </label><?php echo($_COOKIE["nbPlaces"]); ?>
        </p>
        <p>
            <label class = 'strong'>Date : </label><?php echo(getJour($_COOKIE["jourMatch"])); ?>
        </p>
        <p>
            <label class = 'strong'>Heure : </label><?php echo(getHeure($_COOKIE["heureMatch"])); ?>
        </p>

        <form action="promo.php" method="post">
            <p>
                <label class = 'strong'>Code Promo :</label>
                <input type="number" id="cp" name="cp" min = "0"/>
            </p>
            <p>
                <button type="submit">Valider le code promotionnel</button>
            </p>
        </form>

        <?php
            if(isset($_GET["red"]) && ($_GET["red"])==1 && isset($_COOKIE["reduc"])){
                ?>
                <p class="valide">Code valide, promotion de <?php echo($_COOKIE["reduc"]); ?>% effectuée.</p>
                <?php
                $prix = $_COOKIE["prix"] * (100 - $_COOKIE["reduc"])/100;
                setcookie("prix", $prix, time()+86400);
                $_COOKIE["prix"] = $prix;
            }
            else if(isset($_GET["red"]) && ($_GET["red"])==-1 ){
                ?>
                <p class="err">Code non valide</p>
                <?php
            }
        ?>

        <p>
            <label class = 'strong'>Prix : </label><?php echo($_COOKIE["prix"]." €"); ?>
        </p>

        <button type="button" onclick="location.href='validation.php';">Valider</button>
    </div>
    <p><a class="noStyle underline"<?php echo ('href="place.php?id='.$_GET["id"].'"'); ?>>Annuler et retourner à la page précédente</a></p>
</div>
	
	
<?php include("end.php"); ?>