<?php
function Connect_db(){
        $host="iutdoua-webetu.univ-lyon1.fr";
        $user="p1402965";
        $password="212498";
        $bdname="p1402965";
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
        $i = 0; $ligneMax = 0; $colMax = 0;
        $match = new Match();
        $match->id = 0;

        $SQL_Query = 'SELECT idMatch as id, typeMatch as t FROM Matchs order by jourMatch, heureMatch';

        $query = $bdd -> prepare($SQL_Query);
        $query -> execute();

                while($line = $query -> fetch()){                               //Remplit le tableau "matrice" qui contient tous les matchs simples de la bd. Avec en colonnes les différents jours et en ligne la liste des matchs ce jour.
                        if($line["t"] == 1){
                                $SQL_QuerySimple = 'SELECT idMatch as id, jourMatch as j, heureMatch as h, nomJoueur as n
                                FROM Matchs, Joueur
                                WHERE Joueur.idJoueur = Matchs.idJoueur1
                                OR Joueur.idJoueur = Matchs.idJoueur2
                                ORDER BY jourMatch, heureMatch';

                                $querySimple = $bdd -> prepare($SQL_QuerySimple);
                                $querySimple -> execute();

                                while($simple = $querySimple -> fetch()){
                                        if($simple["j"] != $colMax + 1){
                                                $colMax = $simple["j"] - 1;                       //j représente la colonne à traiter, donc la journée. Quand on change de jour, on met à jour j et on réinitialise i
                                                $i = 0;
                                        }
                                        if($match->id != $simple["id"]){
                                                $match = new Match();
                                                $match->id = $simple["id"];
                                                $match->type = 1;
                                                $match->jourMatch = $simple["j"];
                                                $match->heureMatch = $simple["h"];
                                                $match->joueur1 = $simple["n"];
                                                $matrice[$i][$colMax] = $match;

                                                $i++;
                                        }
                                        
                                        else{
                                                $match->joueur2 = $simple["n"];
                                        }
                                }
                        }

                        else{
                                $SQL_QueryDouble = 'SELECT idMatch AS id, jourMatch AS j, heureMatch AS h, nomJoueur AS n
                                FROM Matchs AS m
                                JOIN Equipe_Joueurs AS eq ON m.idEquipe1 = eq.idEquipeJoueurs
                                        OR m.idEquipe2 = eq.idEquipeJoueurs
                                        JOIN Joueur ON Joueur.idJoueur = eq.idJoueur1
                                                OR Joueur.idJoueur = eq.idJoueur2
                                WHERE typeMatch =2
                                ORDER BY j, h';

                                $queryDouble = $bdd -> prepare($SQL_QueryDouble);
                                $queryDouble -> execute();

                                while($double = $queryDouble -> fetch()){
                                        if($double["j"] != $colMax + 1){
                                                $colMax = $double["j"] - 1;
                                                $i = 0;
                                        }
                                        if($match->id != $double["id"]){
                                                $match = new Match();
                                                $match->id = $double["id"];
                                                $match->type = 2;
                                                $match->jourMatch = $double["j"];
                                                $match->heureMatch = $double["h"];
                                                $match->joueur1 = $double["n"];
                                                $matrice[$i][$colMax] = $match;
                                                $match->joueur3 == null;
                                                $match->joueur4 == null;
                                                $match->joueur2 == null;

                                                $i++;
                                        }
                                        
                                        else {
                                                if($match->joueur2 == null){
                                                        $match->joueur2 = $double["n"];
                                                }
                                                else if($match->joueur3 == null){
                                                        $match->joueur3 = $double["n"];
                                                }
                                                else if($match->joueur4 == null){
                                                        $match->joueur4 = $double["n"];
                                                }
                                        }
                                }
                        }

                        if($i > $ligneMax){
                                $ligneMax = $i;
                        }
                }

                $i = 0; $j = 0;
                
                while($i <= $ligneMax){
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
                return "16è de finale";
                break;
                case 2 :
                return "16è de finale";
                break;
                case 3 : 
                return "8è de finale";
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
                        WHERE idMatch = '.$idMatch;

        $query = $bdd -> prepare($SQL_Query);
        $query -> execute();

        while($nb = $query -> fetch()){
                return $nb["n"];
        }
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