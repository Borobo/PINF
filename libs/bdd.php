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

function supprimerBDD($idBdd)
{
    $SQL = "DELETE FROM bdd WHERE id = $idBdd";
    $res = SQLDelete($SQL);

    $SQL = "SELECT id FROM tab WHERE idBdd = $idBdd";
    $listeTables = parcoursRs(SQLSelect($SQL));

    for($i=0;$i<sizeof($listeTables);$i++){

        foreach ($listeTables[$i] as $idTable){
			supprimerTable($idTable);
        }

	}

	 $SQL = "DELETE FROM tab WHERE idBdd = $idBdd";
	 $res = SQLDelete($SQL);



    return $res ;
}

//////////////////////////////////////////////////////////////////////////////

function mkTable($label,$idBdd,$idUser)
{
	// Cette fonction crée un nouveau Table à la fin des Tables existants et renvoie son identifiant
	$SQL = "INSERT INTO tab(label,idBdd,idUser) VALUES('$label','$idBdd','$idUser')";
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

function supprimerTable($idTable)
{

    $SQL = "SELECT id FROM colonne WHERE idTab = $idTable";
    $listeColonne = parcoursRs(SQLSelect($SQL));

    for($i=0;$i<sizeof($listeColonne);$i++){

        foreach ($listeColonne[$i] as $idColonne){
            supprimerDataCol($idColonne);
        }

    }

    $SQL = "DELETE FROM colonne WHERE idTab = $idTable";
    $res2 = SQLDelete($SQL);

    $SQL = "DELETE FROM tab WHERE id = $idTable";
    $res = SQLDelete($SQL);

	return $res && $res2;
}

//////////////////////////////////////////////////////////////////////////////

function listerColonnes($idTable) {
	$SQL = "SELECT * FROM colonne WHERE idTab=$idTable ORDER BY id";
	return parcoursRs(SQLSelect($SQL));
}

function majColonne($idColonne,$label) {
	$SQL = "UPDATE colonne SET label='$label' WHERE id='$idColonne'";
	return SQLUpdate($SQL);
}

function mkCol($idTable, $label, $desc, $type, $ai, $dbl) {
	$SQL = "INSERT INTO colonne(label,description,idTab, type, A_I, UNIQ) VALUES ('$label','$desc',$idTable, '$type',$ai,$dbl)";
	return SQLInsert($SQL);
}

function supprimerCol($idCol){
	$SQL = "DELETE FROM colonne WHERE id = $idCol";
	return SQLDelete($SQL);
}

//////////////////////////////////////////////////////////////////////////////

function listerData($idCol)
{
	$SQL = "SELECT * FROM data WHERE idColonne='$idCol' ORDER BY id";
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

function addData($id, $val = ""){
	$SQL = "SELECT * FROM colonne WHERE id = $id";
	$res = parcoursRs(SQLSelect($SQL));
	$ai = $res[0]["A_I"];
	$dbl = $res[0]["UNIQ"];
	$type = $res[0]["type"];

	if($ai == true){
		$SQL = "SELECT MAX(valInt) FROM data WHERE idColonne=$id";
		$res = SQLGetChamp($SQL);
		$SQL = "INSERT INTO data(valInt, idColonne) VALUES ($res+1,'$id')";

		return SQLInsert($SQL);
	}
	if($dbl == true){
		//TODO : ajout sans dbl
	}

	if($type == "Nombre")
		$valType = "valInt";
	else
		$valType = "valChar";

	if($val != "NULL")
		$SQL = "INSERT INTO data($valType, idColonne) VALUES ('$val','$id')";
	else
		$SQL = "INSERT INTO data($valType, idColonne) VALUES (NULL,'$id')";

	return SQLInsert($SQL);
}

function supprimerDataCol($idColonne){
	$SQL = "DELETE FROM data WHERE idColonne = $idColonne";

	return SQLDelete($SQL);
}



//////////////////////////////////////////////////////////////////////////////

function grade($idBdd, $idUser){
	$SQL = "SELECT admin FROM liste_user WHERE idUser = '$idUser' AND idBdd='$idBdd'";
	return SQLGetChamp($SQL);
}




















?>
