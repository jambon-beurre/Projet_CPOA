<?php
function Connect_db(){
        $host="iutdoua-webetu.univ-lyon1.fr";
        $user="p1402965";
        $password="212498";
        $bdname="p1402965";
        /*$host="localhost";
        $user="root";
        $password="";
        $bdname="cpoa";*/
        try{
                $bdd = new PDO('mysql:host='.$host.';dbname='.$bdname.
                        ';charset=utf8',$user,$password);
                return $bdd;
        }
        catch(Exception $e)
        {
                die('Erreur: ' .$e->getMessage());
        }
}

class Match{
        public $id;
        public $type;
        public $jourMatch;
        public $heureMatch;
        public $joueur1;
        public $joueur2;
        public $joueur3;
        public $joueur4;
}

function afficherTableau(){
        $retour = '';

        $bdd = Connect_db();
        $i = 0; $ligneMax = 0; $colMax = 0;$matrice[0][0] = null;$count = 0;
        $match = new Match();
        $match->id = 0;

        $SQL_Query = 'select max(c) as max from (select count(idMatch) as c from Matchs group by jourMatch) as yolo';

        $query = $bdd -> prepare($SQL_Query);
        $query -> execute();

        while($line = $query -> fetch()){
                $ligneMax = $line["max"];
        }

        $SQL_Query = 'SELECT idMatch as id, typeMatch as t, jourMatch as j FROM Matchs order by jourMatch, heureMatch';

        $query = $bdd -> prepare($SQL_Query);
        $query -> execute();

                while($line = $query -> fetch()){                               //Remplit le tableau "matrice" qui contient tous les matchs simples de la bd. Avec en colonnes les différents jours et en ligne la liste des matchs ce jour.

                        if($line["j"] != $colMax + 1){
                                $colMax = $line["j"] - 1;                       //j représente la colonne à traiter, donc la journée. Quand on change de jour, on met à jour j et on réinitialise i
                                $i = 0;
                        }

                        if($line["t"] == 1){
                                $SQL_QuerySimple = 'SELECT heureMatch as h, nomJoueur as n
                                FROM Matchs, Joueur
                                WHERE (Joueur.idJoueur = Matchs.idJoueur1
                                OR Joueur.idJoueur = Matchs.idJoueur2)
                                AND idMatch = '.$line["id"].'
                                ORDER BY jourMatch, heureMatch';

                                $querySimple = $bdd -> prepare($SQL_QuerySimple);
                                $querySimple -> execute();

                                $count = 0;

                                while($simple = $querySimple -> fetch()){
                                        
                                        if($count == 0){
                                                $match = new Match();
                                                $match->id = $line["id"];
                                                $match->type = 1;
                                                $match->jourMatch = $line["j"];
                                                $match->heureMatch = $simple["h"];
                                                $match->joueur1 = $simple["n"];
                                                $match->joueur2 = null;
                                                $matrice[$i][$colMax] = $match;

                                                $count++;
                                        }
                                        
                                        else{
                                                $matrice[$i][$colMax]->joueur2 = $simple["n"];
                                                $i++;
                                        }
                                }
                        }

                        else{
                                $SQL_QueryDouble = 'SELECT heureMatch AS h, nomJoueur AS n
                                FROM Matchs AS m
                                JOIN Equipe_Joueurs AS eq ON m.idEquipe1 = eq.idEquipeJoueurs
                                        OR m.idEquipe2 = eq.idEquipeJoueurs
                                        JOIN Joueur ON Joueur.idJoueur = eq.idJoueur1
                                                OR Joueur.idJoueur = eq.idJoueur2
                                WHERE idMatch = '.$line["id"];

                                $queryDouble = $bdd -> prepare($SQL_QueryDouble);
                                $queryDouble -> execute();

                                $count = 0;
                                while($double = $queryDouble -> fetch()){

                                        if($count == 0){
                                                $match = new Match();
                                                $match->id = $line["id"];
                                                $match->type = 2;
                                                $match->jourMatch = $line["j"];
                                                $match->heureMatch = $double["h"];
                                                $match->joueur1 = $double["n"];
                                                $matrice[$i][$colMax] = $match;
                                                $match->joueur3 == null;
                                                $match->joueur4 == null;
                                                $match->joueur2 == null;

                                                $count++;
                                        }
                                        
                                        else {
                                                if($count == 1){
                                                        $match->joueur2 = $double["n"];
                                                        $count++;
                                                }
                                                else if($count == 2){
                                                        $match->joueur3 = $double["n"];
                                                        $count++;
                                                }
                                                else if($count == 3){
                                                        $match->joueur4 = $double["n"];
                                                        $count++;
                                                        $i++;
                                                }
                                        }
                                }
                        }
                }

                $i = 0; $j = 0;
                
                while($i < $ligneMax){
                        $retour .= '<tr>';
                        while($j <= 6){
                                $data = '';

                                if(isset($matrice[$i][$j])){
                                        $match = new Match();
                                        $match = $matrice[$i][$j];
                                        $data = '<div class = "match"><a class = "noStyle" href="./place.php?id='.$match->id.'">';
                                        $data .= getHeure($match->heureMatch) . '<br/>';
                                        if($match->type == 1){
                                                $data .= $match->joueur1;
                                                $data .= ' VS. ';
                                                $data .= $match->joueur2;
                                        }
                                        else{
                                                $data .= $match->joueur1;
                                                $data .= ' - ';
                                                $data .= $match->joueur2;
                                                $data .= '<br/>VS.<br/>';
                                                $data .= $match->joueur3;
                                                $data .= ' - ';
                                                $data .= $match->joueur4;
                                        }
                                        $data .= '</a></div>';
                                }

                                $retour .= '<td>';
                                $retour .= $data;
                                $retour .= '</td>';
                                $j++;
                        }
                        $retour .= '</tr>';
                        $i++;
                        $j = 0;
                }
        return $retour;
}

function getHeure($creneau){
        switch($creneau){
                case 1 : 
                return "8h";
                break;
                case 2 :
                return "11h";
                break;
                case 3 : 
                return "15h";
                break;
                case 4 :
                return "18h";
                break;
                case 5 : 
                return "21h";
                break;
                default :
                return "?";
                break;
        }
}

function getTour($jourMatch){
        switch($jourMatch){
                case 1 : 
                return "1/16 de finale";
                break;
                case 2 :
                return "1/16 de finale";
                break;
                case 3 : 
                return "1/8 de finale";
                break;
                case 4 :
                return "1/4 de finale";
                break;
                case 5 : 
                return "1/2 finale";
                break;
                case 6 : 
                return "Finale simple";
                break;
                case 7 : 
                return "Finale double";
                break;
                default :
                return "?";
                break;
        }
}

function getVs($idMatch, $typeMatch){           //Retourne en texte le versus des deux joueurs/équipes pour le match entré en paramètre
        $retour='';
        $i=0;
        $bdd = Connect_db();

        if($typeMatch == 1){
                $SQL_Query = 'SELECT nomJoueur as n
                        FROM Matchs, Joueur
                        WHERE (Joueur.idJoueur = Matchs.idJoueur1
                        OR Joueur.idJoueur = Matchs.idJoueur2)
                        AND idMatch = '.$idMatch;

                $querySimple = $bdd -> prepare($SQL_Query);
                $querySimple -> execute();

                while($simple = $querySimple -> fetch()){
                        $retour.=$simple["n"];
                        if($i == 0){
                                $retour.=" VS. ";
                        }
                        $i++;
                }
        }

        else{
                $SQL_Query = 'SELECT nomJoueur AS n
                                FROM Matchs AS m
                                JOIN Equipe_Joueurs AS eq ON m.idEquipe1 = eq.idEquipeJoueurs
                                        OR m.idEquipe2 = eq.idEquipeJoueurs
                                        JOIN Joueur ON Joueur.idJoueur = eq.idJoueur1
                                                OR Joueur.idJoueur = eq.idJoueur2
                                WHERE idMatch = '.$idMatch;

                $queryDouble = $bdd -> prepare($SQL_Query);
                $queryDouble -> execute();

                while($double = $queryDouble -> fetch()){
                        $retour.=$double["n"];
                        if($i == 1){
                                $retour.=" VS. ";
                        }
                        else if($i == 0 || $i == 2){
                                $retour.=" - ";
                        }
                        $i++;
                }
        }

        return $retour;
}

function getCourt($idMatch){
        $bdd = Connect_db();
        $SQL_Query = 'SELECT nomCourt
                        From Court, Matchs
                        WHERE Court.idCourt = Matchs.idCourt
                        AND idMatch = '.$idMatch;

        $query = $bdd -> prepare($SQL_Query);
        $query -> execute();

        while($nom = $query -> fetch()){
                return $nom["nomCourt"];
        }
}

function getJour($jourMatch){
        switch($jourMatch){
                case 1 : 
                return "Lundi";
                break;
                case 2 :
                return "Mardi";
                break;
                case 3 : 
                return "Mercredi";
                break;
                case 4 :
                return "Jeudi";
                break;
                case 5 : 
                return "Vendredi";
                break;
                case 6 : 
                return "Samedi";
                break;
                case 7 : 
                return "Dimanche";
                break;
                default :
                return "?";
                break;
        }
}

function getNbPlacesRestantes($idMatch){
        $bdd = Connect_db();
        $SQL_Query = 'SELECT count(noPlace) as n
                        From Place
                        WHERE reserve = 0
                        AND idMatch = '.$idMatch;

        $query = $bdd -> prepare($SQL_Query);
        $query -> execute();

        while($nb = $query -> fetch()){
                return $nb["n"];
        }
}

function getPrixTotal($idMatch, $place, $nbPlaces){
        $bdd = Connect_db();
        $SQL_Query = 'SELECT prix as p
                        From Place
                        WHERE idMatch = '.$idMatch.'
                        AND emplacement = \''.$place.'\'
                        LIMIT 1';

        $query = $bdd -> prepare($SQL_Query);
        $query -> execute();

        while($prix = $query -> fetch()){
                return $prix["p"]*$nbPlaces;
        }
}

function nbPlacesOk($idMatch, $nbPlaces, $place){
        $bdd = Connect_db();
        $SQL_Query = "SELECT count(noPlace) as n
                        From Place
                        WHERE idMatch = ".$idMatch."
                        AND reserve = 0
                        AND emplacement = '".$place."'";

        $query = $bdd -> prepare($SQL_Query);
        $query -> execute();

        while($nb = $query -> fetch()){
                if($nb["n"] >= $nbPlaces) return -1;
                else return $nb["n"];
        }
}

function reduction($cp){
        $bdd = Connect_db();
        $SQL_Query = 'SELECT reduction as r
                        From Promotion
                        WHERE codePromo = '.$cp;

        $query = $bdd -> prepare($SQL_Query);
        $query -> execute();

        while($reduction = $query -> fetch()){
                return $reduction["r"];
        }
        return(-1);
}

function reserver($idMatch, $nbPlaces, $place){
        $places = array();
        $i = 0;
        $retour='';

        $bdd = Connect_db();
        $SQL_Query = "SELECT noPlace as n
                        From Place
                        WHERE idMatch = ".$idMatch."
                        AND reserve = 0
                        AND emplacement = '".$place."'
                        LIMIT ".$nbPlaces;

        $query = $bdd -> prepare($SQL_Query);
        $query -> execute();

        while($line = $query -> fetch()){
                $places[$i] = $line["n"];
                $i++;
        }

        for($i = 0; $i < count($places); $i++){
                $SQL_Query = "UPDATE Place SET reserve = 1
                        WHERE noPlace = ".$places[$i];

                $query = $bdd -> prepare($SQL_Query);
                $query -> execute();

                if($i != count($places) - 1){
                        $retour .= $places[$i] . ", ";
                }
                else{
                        $retour .= $places[$i];
                }
        }

        return $retour;
}

function getNbPlacesRestantesEmplacement($idMatch){
        $array["A"] = 0;
        $array["B"] = 0;
        $array["C"] = 0;
        $array["E"] = 0;
        $array["G"] = 0;
        $array["H"] = 0;
        $array["I"] = 0;
        $array["J"] = 0;
        $array["K"] = 0;
        $array["L"] = 0;
        $array["N"] = 0;
        $array["Libre"] = 0;

        $bdd = Connect_db();
        $SQL_Query = 'SELECT count(noPlace) as n, emplacement as e
                        From Place
                        WHERE reserve = 0
                        AND idMatch = '.$idMatch.'
                        GROUP BY e';

        $query = $bdd -> prepare($SQL_Query);
        $query -> execute();

        while($nb = $query -> fetch()){
                $array[$nb["e"]] = $nb["n"];
        }

        return $array;
}

function getPrixPlaces($idMatch){
        $array[0] = 0;
        $bdd = Connect_db();
        $SQL_Query = 'SELECT prix as p, emplacement as e
                        From Place
                        WHERE idMatch = '.$idMatch.'
                        GROUP BY e, p';

        $query = $bdd -> prepare($SQL_Query);
        $query -> execute();
        $i = 0;
        while($nb = $query -> fetch()){
                $array[$i] = $nb["p"];
                $i++;
        }

        return $array;
}

?>

        <!DOCTYPE html>
        <html>

        <head>
                <title>Grand Prix de Tennis de Lyon</title>
                <meta charset="utf-8"/>
                <link rel="stylesheet" type="text/css" href="./style.css">

        </head>

        <body>

                <header>
                        <a href="index.php"><img src="images/banniere.png" alt="Bannière"></a>
                </header>