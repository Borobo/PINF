<?php

include_once "maLibUtils.php";	// Car on utilise la fonction valider()
include_once "bdd.php";	// Car on utilise la fonction connecterUtilisateur()

/**
 * @file login.php
 * Fichier contenant des fonctions de v�rification de logins
 */

/**
 * Cette fonction v�rifie si le login/passe pass�s en param�tre sont l�gaux
 * Elle stocke le pseudo de la personne dans des variables de session : session_start doit avoir �t� appel�...
 * Elle enregistre aussi une information permettant de savoir si l'utilisateur qui se connecte est administrateur ou non
 * Elle enregistre l'�tat de la connexion dans une variable de session "connecte" = true
 * @pre login et passe ne doivent pas �tre vides
 * @param string $login
 * @param string $password
 * @return false ou true ; un effet de bord est la cr�ation de variables de session
 */
function verifUser($login,$password)
{
	// NE PAS ETRE UN LOSER
	$sql = "SELECT * FROM user WHERE identifiant='$login' AND password='$password' ";
	$rs = SQLSelect($sql);
	if ($rs)
	{
		// connexion acceptee
		$tabUsers = parcoursRs($rs);
		$dataUser = $tabUsers[0];
		$_SESSION["connecte"] = true;
		$_SESSION["identifiant"] = $dataUser["identifiant"];
		$_SESSION["idUser"] = $dataUser["id"];
		$_SESSION["prenom"] = $dataUser["prenom"];
		$_SESSION["nom"] = $dataUser["nom"];
		$_SESSION["superadmin"] = $dataUser["superadmin"];
		$_SESSION["heureConnexion"] = date("H:i:s");
		return true;
	}
	else
	{
		session_destroy();
		return false;
	}
}




/**
 * Fonction � placer au d�but de chaque page priv�e
 * Cette fonction redirige vers la page $urlBad en envoyant un message d'erreur
	et arr�te l'interpr�tation si l'utilisateur n'est pas connect�
 * Elle ne fait rien si l'utilisateur est connect�, et si $urlGood est faux
 * Elle redirige vers urlGood sinon
 */
function securiser($urlBad,$urlGood=false)
{
	// ou 	if (valider("connecte","SESSION") == false)
	if (valider("pseudo","SESSION") == false)
	{
		// intrus !

		// on redirige en envoyant un message!!
		header("Location:$urlBad?message=" .  urlencode("Hors d'ici !") );
		die("");	// arreter l'interpr�tation du code
		return;

	}

	// Utilisateur autoris� et urlGood n'est pas faux
	if ($urlGood)
	{
		// on redirige puisque urlGood n'est pas faux
		header("Location:$urlGood");
		die("");	// arreter l'interpr�tation du code

	}
}

?>
