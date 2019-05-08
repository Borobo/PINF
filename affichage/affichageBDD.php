<!DOCTYPE html>
<?php
include("../unHeader.php");

if($_SESSION["superadmin"]==1)
    header("location : affichageBDD_Superadmin.php");

?>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">

</head>

<style>
    body{
        background-color: lightblue;
    }
    .col-sm-6 img{
        height: 24px;
        width: 24px;
    }

    #envoyer{
        margin-top: 7%;
    }
    #envoyer .fleche{
        width: 40px;
        height: 40px;
    }
    .form-group{
        width: 400px;
        margin: auto;
    }
    .btn-group{
        width: 200px;
        height: 50px;
    }
</style>

<script>
    var jModeleBtn = $("<button class='btn btn-secondary'></button>");
    var jModelP = $("<p></p>");
    //Lancement de la page
    $(document).ready(function(){
        $("#envoyer").hide(); //formulaire création de bdd
        //affichage des bdd de l'utilisateur
        var nextDel = $("<img class='del-bdd' data-toggle='modal' data-target='#myModal' src='ressource/delete.png'/>");
        $.getJSON("../data.php",{
            action:"afficherBDD"
        },function(oRep){
            var i,meta;
            var btn,p;
            console.log(oRep.bdd.length);
            for(i=0; i<oRep.bdd.length; i++){
                meta = oRep.bdd[i];
                console.log(meta);

                var cloneNextDel = nextDel.clone().data("idBdd", meta.id);

                /*p = jModelP.clone();
                btn = jModeleBtn.clone();
                p.append(btn.html(meta.nom));
                $(".affichage").append(p);*/
                $(".affichage").append($("<p></p>")
                    .append($("<div class='btn-group'></div>")
                        .append($("<a href='affichage_table.php' class='btn btn-secondary bdd' style='width: 70%;' ></a>")
                            .html(meta.nom)
                            .data("id",meta.id).data("nom",meta.nom))
                        .append("<button type='button' class='btn btn-secondary dropdown-toggle dropdown-toggle-split' data-toggle='dropdown'>")
                        .append($("<div class='dropdown-menu'></div>")
                            .append($("<span class='dropdown-item-text'></span>").html(meta.description)))));
            }
        });
    });

      var idDeLaBdd;
      var nomDeLaBdd;
      $(document).on("click", ".del-bdd", function(){
          idDeLaBdd = $(this).data("idBdd");

      });
      //Envoi un getJSon permettant de supprimer une bdd

      $(document).on("click", "#del-btn", function(){
          $.getJSON("../data.php",{
              action : "supprimerLaBdd",
              idBdd : idDeLaBdd
          }, function(oRep){
              console.log(oRep.feedback);
              window.location.reload();
          })
      });




    //Clique sur le boutton "envoyer" de la page affichageBDD
    $(document).on("click","#BtnEnvoyer",function(){
        $(".col-sm-6").hide(); //page principale affichage bdd
        $("#envoyer").show(); //formulaire création de bdd
    });
    //Clique sur la fleche de retour du formulaire de création de bdd
    $(document).on("click","#envoyer .fleche",function(){
        $(".col-sm-6").show(); //page principale affichage bdd
        $("#envoyer").hide(); //formulaire création de bdd
    });
    //Envoie du formulaire du création de bdd
    $(document).on("click","#envoyer .exec",function(){

        $.getJSON("../data.php",{
            action:"creerBDD",
            nom:$("#nom").val(),
            description:$("#description").val()},function(oRep){

        });


        $.getJSON("../data.php",{
                action:"idDeBdd"}, function(oRep)
            {
                var idBddCreee;
                idBddCreee = oRep.bdd[0].id;

                $.getJSON("../data.php", {
                        action:"updateListeUser",idBDD:idBddCreee},
                    function(oRep){

                    });



            }
        );


        $(".col-sm-6").show(); //page principale affichage bdd
        $(".affichage").empty();
        $("#envoyer").hide(); //formulaire création de bdd

        $.getJSON("../data.php",{
            action:"afficherBDD"
        },function(oRep){
            var i,meta;
            var btn;

            for(i=0; i<oRep.bdd.length; i++){
                meta = oRep.bdd[i];

                $(".affichage").append($("<p></p>")
                    .append($("<div class='btn-group'></div>")
                        .append($("<a href='affichage_table.php' class='btn btn-secondary bdd' style='width: 70%;'></a>").html(meta.nom).data("id",meta.id))
                        .append("<button type='button' class='btn btn-secondary dropdown-toggle dropdown-toggle-split' data-toggle='dropdown'>")
                        .append($("<div class='dropdown-menu'></div>")
                            .append($("<span class='dropdown-item-text'></span>").html(meta.description)))));
            }
        });
    });

    $(document).on("click",".bdd",function(){
        console.log($(this).data("id"));
        $.getJSON("../data.php",{
            action:"stockIdBDD",
            id:$(this).data("id"),
            nom:$(this).data("nom")
        },function(oRep){
        });
    });
</script>

<body>

<div class="container align-content-center">
    <div class="row">

        <div class="col-sm-6">
            <br><br><br><br>

            <fieldset>
                <legend><u><b>Mes bases de données :</b></u></legend>
                <br><br><br>
                <div class="affichage"></div>
            </fieldset>

        </div>
        <div class="col-sm-6">
            <br><br><br><br>
            <fieldset>
                <legend><u><b>Options :</b></u></legend>
                <br><br>
                <div class="text-center">
                    <p>
                        Si vous voulez envoyer une demande de création de base de données, cliquez sur le bouton Envoyer
                    </p>
                    <img src="ressource/down-arrow.png"><br/>
                    <br>
                    <button type="button" class="btn btn-secondary" id="BtnEnvoyer">Envoyer</button>
                </div>
            </fieldset>
        </div>


        <div class="col" id="envoyer">
            <button type="button"  class="btn btn-secondary text-center fleche"> < </button>
            <fieldset class="text-center">
                <legend>Création de la base de données:</legend>

                <p>Nom de la nouvelle base de données <br/>
                    <input type="text" placeholder="Nom" id="nom"></p>

                <div class="form-group">
                    <label for="description">Description de la base de données</label>
                    <textarea class="form-control" rows="5" id="description" placeholder="Description"></textarea>
                </div>                        <br/>
                <button type="button" class="btn btn-secondary exec">Exécuter</button>
            </fieldset>
        </div>


    </div>

</div>

<?php

    echo '<div class="modal" id="myModal">
			    <div class="modal-dialog">
			      <div class="modal-content">

			        <!-- Modal Header -->
			        <div class="modal-header">
			          <h4 class="modal-title">Alerte !</h4>
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			        </div>

			        <!-- Modal body -->
			        <div class="modal-body">
			          Êtes-vous sûr de vouloir supprimer cette base de donnée (cette action est irréversible).
			        </div>

			        <!-- Modal footer -->
			        <div class="modal-footer">
						<button type="button" id="del-btn" class="btn btn-success" data-dismiss="modal">Confirmer</button>
			          	<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					</div>

			      </div>
			    </div>
			  </div>';


?>

</body>
</html>