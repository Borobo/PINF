<?php


include_once("maLibSQL.pdo.php");
// définit les fonctions SQLSelect, SQLUpdate...

function listerUsers()
{
	// liste tous les Tables disponibles, triés par valeur du champ 'ordre' croissant
	$SQL = "SELECT * FROM user ORDER BY nom, prenom ASC";
	return parcoursRs(SQLSelect($SQL));
}

//////////////////////////////////////////////////////////////////////////////

function mkTable($idBdd,$label)
{
	// Cette fonction crée un nouveau Table à la fin des Tables existants et renvoie son identifiant
	$SQL = "INSERT INTO tab(label,idBdd) VALUES('$label','$idBdd')";
	return SQLInsert($SQL);
}

function listerTables($idBdd)
{
	// liste tous les Tables disponibles, triés par valeur du champ 'ordre' croissant
	$SQL = "SELECT * FROM tab WHERE idBdd = '$idBdd' ORDER BY id ASC";
	return parcoursRs(SQLSelect($SQL));
}

// fonction ajoutee
function majTable($idTable,$label)
{
	$SQL = "UPDATE tab SET label='$label' WHERE id='$idTable'";
	return SQLUpdate($SQL);
}

//////////////////////////////////////////////////////////////////////////////

function listerColonnes($idTable) {
	$SQL = "SELECT * FROM colonne WHERE idTab=$idTable";
	return parcoursRs(SQLSelect($SQL));
}

function majColonne($idTable,$numColonne,$label) {
	//TODO : majColonne --> majDonnee
}

function mkCol($idTable, $label, $desc) {
	$SQL = "INSERT INTO colonne(label,description,idTab) VALUES ('$label','$desc','$idTable')";
	return SQLUpdate($SQL);
}

//////////////////////////////////////////////////////////////////////////////

function listerData($idCol)
{
	$SQL = "SELECT * FROM data WHERE idColonne='$idCol'";
	return parcoursRs(SQLSelect($SQL));
}

function majData()
{
	//TODO : Mettre a jour la donnee d'une colonne
}

//////////////////////////////////////////////////////////////////////////////

function grade($idBdd, $idUser){
	$SQL = "SELECT gradeBdd FROM liste_user WHERE idUser = '$idUser' AND idBdd='$idBdd'";
	return SQLGetChamp($SQL);
}




















?>
