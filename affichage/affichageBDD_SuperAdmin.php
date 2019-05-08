<!DOCTYPE html>
<?php
    include("../unHeader.php");
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

    .bg-unpeumoinslightblue{
        background-color: #a5cedb;
    }

    .allBDD{
        height: 400px;
        width: 300px;
        overflow: auto;
        text-align:center;

    }

    .col-sm-6 img{
        height: 80px;
        width: 40px;
        margin: 10px;
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

    .option{
        min-width: 300px;
    }

    .test{
        display:flex;
    }

    .margin-bot{
        margin-bottom:35px;
    }

</style>

<script>
    var jModeleBtn = $("<button class='btn btn-secondary'></button>");
    var jModelP = $("<p></p>");

    //Lancement de la page
    $(document).ready(function(){
        $("#envoyer").hide(); //formulaire création de bdd
        $("#confirmerDiv").hide(); //formulaire confirmer
        $("#selection").hide(); //formulaire confirmer
      //  $("#liste").empty();
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

                $(".affichage").append($("<p></p>").append(cloneNextDel)
                    .append($("<div class='btn-group'></div>")
                        .append($("<a href='affichage_table.php' class='btn btn-secondary bdd' style='width: 70%;' ></a>").html(meta.nom).data("id",meta.id).data("nom",meta.nom))
                        .append("<button type='button' class='btn btn-secondary dropdown-toggle dropdown-toggle-split' data-toggle='dropdown'>")
                        .append($("<div class='dropdown-menu'></div>")
                            .append($("<span class='dropdown-item-text'></span>").html(meta.description)))));
            }
        });

        $.getJSON("../data.php",{
            action:"afficherToutesBDD"
        },function(oRep){
            var i,meta;
            var btn,p;
            console.log("Taille = "+oRep.bdd.length);
            for(i=0; i<oRep.bdd.length; i++){
                meta = oRep.bdd[i];
                console.log(meta);

                var cloneNextDel = nextDel.clone().data("idBdd", meta.id);

                $(".affichageToutes").append($("<p></p>").append(cloneNextDel)
                    .append($("<div class='btn-group'></div>")
                        .append($("<a href='affichage_table.php' class='btn btn-secondary bdd' style='width: 70%;' ></a>").html(meta.nom).data("id",meta.id).data("nom",meta.nom))
                        .append("<button type='button' class='btn btn-secondary dropdown-toggle dropdown-toggle-split' data-toggle='dropdown'>")
                        .append($("<div class='dropdown-menu'></div>")
                            .append($("<span class='dropdown-item-text'></span>").html(meta.description)))));
            }
        });


    });



    $(document).on("click","#confirmer",function(){
        $("#liste").empty();
        console.log('test');
        $.getJSON("../data.php",{
            action:"afficherBDDproposes"
        },function(oRep){
            var i ;

            for(i=0; i<oRep.bdd.length; i++){
                meta = oRep.bdd[i];
                console.log(meta);
                var desc = meta.description;
                $("#liste").append($("<p></p>").append($("<div class='test'>"))
                    .append($("<div class='btn-group'></div>")
                        .append($("<a class='btn btn-primary bdd nonconfirmee' style='width: 70%;' ></a>").html(meta.nom).data("id",meta.id))
                        .append($("<div class='dropdown-menu'></div>")
                            .append($("<span class='dropdown-item-text'></span>").html(meta.description)))))
                              .append($("<p></p>").html("Description : "+"<b>"+meta.description+"   </b>"))
                                .append($("<p></p>").html("Créateur : "+"<b>"+meta.userNom+" "+meta.prenom+"   </b><br>"));
            }
           console.log(oRep);
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
    $(document).on("click","#creer  ",function(){
        $(".col-sm-4").hide(); //page principale affichage bdd
        $("#envoyer").show(); //formulaire création de bdd
    });

    $(document).on("click","#confirmer  ",function(){
        $(".col-sm-4").hide(); //page principale affichage bdd
        $("#confirmerDiv").show(); //formulaire création de bdd
    });

    //Clique sur la fleche de retour du formulaire de création de bdd
    $(document).on("click",".fleche",function(){
        $(".col-sm-4").show(); //page principale affichage bdd
        $("#envoyer").hide(); //formulaire création de bdd
        $("#confirmerDiv").hide(); //formulaire création de bdd

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


        $(".col-sm-4").show(); //page principale affichage bdd
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
        console.log($(this).data('id'));
        $.getJSON("../data.php",{
            action:"stockIdBDD",
            id:$(this).data("id"),
            nom:$(this).data("nom")
        },function(oRep){
            console.log("hey");
        });

    });

    $(document).on("click",".nonconfirmee",function(){
        $.getJSON("../data.php",{
            action:"confirmerBDD"
        },function(oRep){
            console.log("letsgo");
        });
        $(".col-sm-4").show(); //page principale affichage bdd
        $("#envoyer").hide(); //formulaire création de bdd
        $("#confirmerDiv").hide(); //formulaire création de bdd
        $("#listeBDD").empty();
        $.getJSON("../data.php",{
            action:"afficherBDD"
        },function(oRep){
            var i,meta;
            var btn,p;
            console.log(oRep.bdd.length);
            for(i=0; i<oRep.bdd.length; i++){
                meta = oRep.bdd[i];
                console.log(meta);

                $(".affichage").append($("<p></p>")
                    .append($("<div class='btn-group'></div>")
                        .append($("<a href='affichage_table.php' class='btn btn-secondary bdd' style='width: 70%;' ></a>").html(meta.nom).data("id",meta.id))
                        .append("<button type='button' class='btn btn-secondary dropdown-toggle dropdown-toggle-split' data-toggle='dropdown'>")
                        .append($("<div class='dropdown-menu'></div>")
                            .append($("<span class='dropdown-item-text'></span>").html(meta.description)))));
            }
        });
    });

</script>

<body>

<div class="container align-content-center">

    <div class="row">

        <div class="col-sm-4">
            <br><br><br><br>

            <fieldset>
                <legend class="margin-bot"><u><b>Toutes les bases de données :</b></u></legend>
                <br><br>
                <div class="affichageToutes allBDD" id="listeToutesBDD"></div>
            </fieldset>
        </div>

        <div class="col-sm-4">
            <br><br><br><br>

            <fieldset>
                <legend><u><b>Mes bases de données :</b></u></legend>
                <br><br><br>
                <div class="affichage" id="listeBDD"></div>
            </fieldset>
        </div>

        <div class="col-sm-4">
            <br><br><br><br>
            <fieldset>
                <legend><u><b>Options :</b></u></legend>
                <br><br>
                <div class="text-center">
                    <br>
                    <button type="button" class="btn btn-secondary option" id="creer">Créer une base de données</button><br><br>
                    <button type="button" class="btn btn-secondary option" id="confirmer">Confirmer une base de données</button><br><br>
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


        <div class="col" id="confirmerDiv">
            <br><br><br><br>
            <button type="button"  class="btn btn-secondary text-center fleche"> < </button>

            <fieldset class="text-center">
                <legend>Bases de données à confirmer :</legend>
                <br>
                <div id="liste"></div>
                <br>                <br>                <br>                <br>                <br>

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
