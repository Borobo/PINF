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
		// On ne doit rentrer dans le switch que si on y est autorisé
		$data["feedback"] = "Entrez connexion(login,passe) (eg 'tom','web2')";
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
						// On verifie l'utilisateur, et on crée des variables de session si tout est OK
						$data["feedback"] = "Entrez identifiant,passe (eg 'user','user')";

					} else {
						$data["feedback"] = "Utilisateur connecté";
						$data["connecte"] = true;
						header('Location:../affichage/test.php');
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

				// Tables //////////////////////////////////////////////////

				case 'setTable' :
				if ($label = valider("label"))
				{
					$data["idTable"] = mkTable($label);
					// On définit aussi ses colonnes 
					setColonnes($data["idTable"]); 

					mkNotification(valider("idUser","SESSION"),"Creation du Table \'$label\'"); 
					//TODO : à Modifier
				}
				break;


				case 'getTables' : 
					$data["boards"] = listerTables();
				break;

				case 'majTable' : 
					if ($idTable = valider("idTable"))
					if ($label = valider("label"))
					majTable($idTable,$label); 
				break;

				// Colonnes //////////////////////////////////////////////////


				case 'getColonnes' : 
					if ($idTable = valider("idTable"))
					$data["colonnes"] = listerColonnes($idTable);
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
					if ($idTable = valider("idTable")) {
						$numColonne = valider("numColonne"); 
						$data["postIts"] = listerPostIts($idTable,$numColonne); 
					}
				break;

				case 'majData' : 
					if ($idPostIt = valider("idPostIt"))
					{
						//TODO : à faire avec majData() dans bdd.php
					}
				break;

				default : 				
					$data["action"] = "default";


			}

		}
	}

		
	echo json_encode($data);

	// todo : notifications
?>










