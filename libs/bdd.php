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

function mkTable($label)
{
	// Cette fonction crée un nouveau Table à la fin des Tables existants et renvoie son identifiant
	$SQL = "INSERT INTO tab(label) VALUES('$label')";
	return SQLInsert($SQL);
	//TODO : à modifier
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
	$SQL = "SELECT * FROM colonne WHERE idTab=$idTable GROUP BY id ORDER BY id ASC";
	return parcoursRs(SQLSelect($SQL));
}

function majColonne($idTable,$numColonne,$label) {
	//TODO : majColonne --> majDonnee
}

function setColonnes($idTable) {
	$SQL = "INSERT INTO colonnes(idTable,nomCol1,nomCol2,nomCol3) VALUES ('$idTable','A Faire', 'En cours', 'Fait')";
	return SQLUpdate($SQL);
	//TODO : ?????
}

//////////////////////////////////////////////////////////////////////////////

function listerData($idCol)
{
	$SQL = "SELECT * FROM data WHERE idColonne='$idCol GROUP BY idColonne ORDER BY idColonne ASC'";
	return parcoursRs(SQLSelect($SQL));
}

function majData()
{
	//TODO : Mettre a jour la donnee d'une colonne
}

function supprimerData($idData){

	$SQL = "DELETE FROM data WHERE id=$idData";

	return SQLDelete($SQL);

}


//////////////////////////////////////////////////////////////////////////////






















?>
