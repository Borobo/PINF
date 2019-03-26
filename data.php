
<?php
session_start();

	//echo $_SERVER["REQUEST_URI"] . "<br />";

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php";
	include_once "libs/bdd.php";

	$data["connecte"] = valider("connecte","SESSION");
	$data["action"] = valider("action");

	if (!$data["action"])
	{
		// On ne doit rentrer dans le switch que si on y est autoris�
		$data["feedback"] = "Erreur : Non connecté. Redirection";
	}
	else
	{
		// si on a une action, on devrait avoir un message classique
		$data["feedback"] = "entrez action: logout, setUser(login,passe,initiales), getUsers,setNotification(description), getNotifications, delNotification(idNotification), setTable(label),getTables,majTable(idTable,label), getColonnes(idTable), majColonne(idTable,numColonne,label), setPostIt(idTable,[label],[avancement],[numColonne]), getPostIts(idTable,[numColonne]),  majPostIt(idPostIt,[label],[avancement],[numColonne]), delPostIt(idPostIt),setMarqueur(idPostIt,type,valeur), getMarqueurs(idPostIt),delMarqueur(idMarqueur),setCommentaire(idPostIt,contenu),getCommentaires(idPostIt),delCommentaire(idPostIt)";

		// si pas connecte et action n'est pas connexion, on refuse
		if ( (!valider("idUser","SESSION")) && ($data["action"] != "connexion" ) ) {
			$data["feedback"] = "Entrez connexion(identifiant,passe) (eg 'user','user')";
		}
		else {


			switch($data["action"])
			{

				// Connexion //////////////////////////////////////////////////

				case 'connexion' :
					// On verifie la presence des champs login et passe


					if 	(
							!($identifiant = valider("identifiant"))
						|| 	!($passe = valider("password"))
						||	!($data["connecte"] = verifUser($identifiant,$passe))
					)
					{
						// On verifie l'utilisateur, et on cr�e des variables de session si tout est OK
						$data["feedback"] = "Entrez identifiant,passe (eg 'user','user')";

					} else {
						$data["feedback"] = "Utilisateur connecte";
						$data["connecte"] = true;
						$_SESSION["connecte"] = true;
						//header('Location:affichage/test.php');
					}
				break;

				case 'logout' :
					// On supprime juste la session
					session_destroy();
					$data["feedback"] = "Entrez login,passe (eg 'user','user')";
					$data["connecte"] = false;
				break;

				// Utilisateurs //////////////////////////////////////////////////


				case 'getUsers' :
					$data["users"] = listerUsers();
				break;

				case 'getUsersBdd' :
				$idBdd = $_SESSION["idBDD"];
					$data["users"] = listerUsersBdd($idBdd);
					$data["idUser"] = $_SESSION["idUser"];
					$data["superadmin"] = $_SESSION["superadmin"];
				break;

				// BDD //////////////////////////////////////////////////////

				case 'creerBDD'	:
                    $data["feedback"] = "on rentre dans creer BDD";
										$idCreateur = $_SESSION["idUser"];
                    if ($nom = valider("nom"))
                    if ($description = valider("description"))
						{
                            $data["feedback"] = "creation";
                            $SQL = "INSERT INTO bdd(nom,description,idCreateur) VALUES('$nom','$description',$idCreateur)";
                            $data["idBDD"]=SQLInsert($SQL);
						}
					break;

				case 'afficherBDD':

					$idUser = $_SESSION["idUser"];

			        $SQL = "SELECT bdd.nom,bdd.id,bdd.description FROM bdd,liste_user WHERE liste_user.idUser=$idUser AND bdd.id = liste_user.idBdd
							UNION
							SELECT nom,id,description FROM bdd WHERE bdd.idCreateur = $idUser";
			        $data["bdd"]=parcoursRs(SQLSelect($SQL));

	        		break;

				case 'afficherLaBDD':

					$SQL = "SELECT * FROM bdd WHERE id=$idBdd";
					$data["bdd"]=parcoursRs(SQLSelect($SQL));

					break;

				case 'updateGrade':
					if($newGrade = valider("newGrade"));
					if($idUser = valider("idUser")){
						if($newGrade == "Utilisateur")
							$SQL = "UPDATE liste_user SET admin=FALSE WHERE idUser = $idUser";
						else if($newGrade == "Admin")
							$SQL = "UPDATE liste_user SET admin=TRUE WHERE idUser = $idUser";
						if($data["return"] = SQLUpdate($SQL)){
							 $data["feedback"] = "Données mises à jour";
						 }

					}
					break;

				// Tables //////////////////////////////////////////////////

				case 'setTable' :
				if ($label = valider("label"))
				{
					$idBdd = $_SESSION["idBDD"];
					//$data["idTable"] = $_SESSION["admin"];
					$data["idTable"] = mkTable($idBdd,$label);
				}
				break;


                case 'getTables' :
                    $bdd = $_SESSION["idBDD"];
					$data["admin"] = $_SESSION["admin"];
                    $data["boards"] = listerTables($bdd);

                    break;

                case 'getLaTable':
                    $idTab = $_SESSION["idTAB"];
                    $SQL = "SELECT * FROM tab WHERE id=$idTab";
                    $data["tab"] = parcoursRs(SQLSelect($SQL));
                    break;

				case 'majTable' :
					if ($idTable = valider("idTable"))
					if ($label = valider("label"))
					majTable($idTable,$label);
				break;


				// Colonnes //////////////////////////////////////////////////
				case 'setColonne' :
					if($idTable = valider("idTable"))
					if($labelCol = valider("labelCol"))
					if($descCol = valider("descCol") || !isset($descCol))
						mkCol($idTable, $labelCol, $descCol);
				break;

				case 'getColonnes' :
					if ($idTable = valider("idTable"))
						$data["colonnes"] = listerColonnes($idTable);
				break;


                case 'stockIdBDD':
                    if($idBdd = valider("id")){

						$idUser = $_SESSION["idUser"];
                        $_SESSION["idBDD"] = $idBdd;
						$_SESSION["admin"] = grade($idBdd, $idUser);
						$data["feedback"]= grade($idBdd, $idUser);
                    }
                break;

                case 'stockIdTable':
                    if($id = valider("id")){
                        $data["feedback"]="changement de page";
                        $_SESSION["idTAB"] = $id;
                    }
                break;

				case 'majColonne' :
					if ($idTable = valider("idTable"))
					if ($numColonne = valider("numColonne"))
					if ($label = valider("label"))
					majColonne($idTable,$numColonne,$label);
				break;

				// DATA //////////////////////////////////////////////////

				break;

                case 'getData' :
                    if ($idColonne = valider("idColonne")) {
                        //$data["postIts"] = listerPostIts($idTable,$numColonne);
                        $data["data"] = listerData($idColonne);
                    }
                    break;


				case 'majDataChar' :
					if ($idData = valider("idData"))
					if ($valChar = valider("valChar")){
						$data["id"] = $idData;
						$data["valChar"] = $valChar;
						//$data["data"] = modifierData($idData,$valChar,$valInt);
						$SQL = "UPDATE data SET valChar='$valChar', valInt=null WHERE id=$idData";

						$data["data"] = SQLUpdate($SQL);
					}

				break;

				case 'majDataInt' :
					if ($idData = valider("idData"))
					if ($valInt = valider("valInt")){
						$data["id"] = $idData;
						$data["valChar"] = $valChar;
						//$data["data"] = modifierData($idData,$valChar,$valInt);
						$SQL = "UPDATE data SET valChar=null, valInt='$valInt' WHERE id=$idData";

						$data["data"] = SQLUpdate($SQL);
					}

				break;

          case 'delData':

					$idData = valider("idData");
					$data["data"] = supprimerData($idData);
					//$data["data"] = $idData;
					break;

				default :
					$data["action"] = "default";


			}

		}
	}


	echo json_encode($data);

	// todo : notifications
?>
