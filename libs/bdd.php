<?php


include_once("maLibSQL.pdo.php");
// définit les fonctions SQLSelect, SQLUpdate...

function listerUsers()
{
	// liste tous les Tables disponibles, triés par valeur du champ 'ordre' croissant
	$SQL = "SELECT * FROM user ORDER BY nom, prenom ASC";
	return parcoursRs(SQLSelect($SQL));
}

function listerUsersBdd($idBdd)
{
	// liste tous les Tables disponibles, triés par valeur du champ 'ordre' croissant
	$SQL = "SELECT * FROM user, liste_user WHERE idUser = user.id AND idBdd = '$idBdd' ORDER BY nom, prenom ASC";
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
	$SQL = "SELECT * FROM colonne WHERE idTab=$idTable ORDER BY id ASC";
	return parcoursRs(SQLSelect($SQL));
}

function majColonne($idColonne,$label) {
	$SQL = "UPDATE colonne SET label='$label' WHERE id='$idColonne'";
	return SQLUpdate($SQL);
}


function mkCol($idTable, $label, $desc) {
	$SQL = "INSERT INTO colonne(label,description,idTab) VALUES ('$label','$desc','$idTable')";
	return SQLInsert($SQL);

}

//////////////////////////////////////////////////////////////////////////////

function listerData($idCol)
{

	$SQL = "SELECT * FROM data WHERE idColonne='$idCol'  ORDER BY id ASC";

	return parcoursRs(SQLSelect($SQL));
}

function modifierData($idData,$valChar,$valInt)
{
	$SQL = "UPDATE data SET valChar='$valChar', valInt=$valInt WHERE id=$idData";

	return SQLUpdate($SQL);
}


function supprimerData($idData){

	$SQL = "DELETE FROM data WHERE id=$idData";

	return SQLDelete($SQL);

}



//////////////////////////////////////////////////////////////////////////////

function grade($idBdd, $idUser){
	$SQL = "SELECT admin FROM liste_user WHERE idUser = '$idUser' AND idBdd='$idBdd'";
	return SQLGetChamp($SQL);
}




















?>
