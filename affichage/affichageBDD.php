<!DOCTYPE html>
<?php
include("../header.html");
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
</style>

<script>
    var jModeleBtn = $("<button class='btn btn-secondary'></button>");
    var jModelP = $("<p></p>");
    //Lancement de la page
    $(document).ready(function(){
        $("#envoyer").hide(); //formulaire création de bdd
        //affichage des bdd de l'utilisateur
        $.getJSON("../data.php",{
            action:"afficherBDD"
        },function(oRep){
            var i,meta;
            var btn,p;
            console.log(oRep.bdd.length);
            for(i=0; i<oRep.bdd.length; i++){
                meta = oRep.bdd[i];
                console.log(meta);
                /*p = jModelP.clone();
                btn = jModeleBtn.clone();
                p.append(btn.html(meta.nom));
                $(".affichage").append(p);*/
                $(".affichage").append($("<p></p>")
                    .append($("<div class='btn-group'></div>")
                        .append($("<a href='affichage_table.php' class='btn btn-secondary bdd' style='width: 70%;' ></a>").html(meta.nom).data("id",meta.id))
                        .append("<button type='button' class='btn btn-secondary dropdown-toggle dropdown-toggle-split' data-toggle='dropdown'>")
                        .append($("<div class='dropdown-menu'></div>")
                            .append($("<span class='dropdown-item-text'></span>").html(meta.description)))));
            }
        });
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
        console.log("test creer");
        console.log($("#nom").val());
        console.log($("#description").val());
        $.getJSON("../data.php",{
            action:"creerBDD",
            nom:$("#nom").val(),
            description:$("#description").val()},function(oRep){
        });
        $(".col-sm-6").show(); //page principale affichage bdd
        $(".affichage").empty();
        $("#envoyer").hide(); //formulaire création de bdd
        $.getJSON("../data.php",{
            action:"afficherBDD"
        },function(oRep){
            var i,meta;
            var btn;
            console.log(oRep.bdd.length);
            for(i=0; i<oRep.bdd.length; i++){
                meta = oRep.bdd[i];
                console.log(meta);
                /*p = jModelP.clone();
                btn = jModeleBtn.clone();
                p.append(btn.html(meta.nom));
                $(".affichage").append(p);*/
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
        console.log("wshhhbdddddd");
        console.log($(this).data("id"));
        $.getJSON("../data.php",{
            action:"stockIdBDD",
            id:$(this).data("id")
        },function(oRep){
        });
    });
</script>

<body>

<div class="container align-content-center">
    <div class="row">

        <div class="col-sm-6">
            <fieldset>
                <legend>Mes bases de données:</legend>
                <div class="affichage"></div>
            </fieldset>

        </div>
        <div class="col-sm-6">
            <fieldset>
                <legend>Options:</legend>
                <div class="text-center">
                    <p>
                        Si vous voulez envoyer une demande de création de base de données, cliquez sur le bouton Envoyer
                    </p>
                    <img src="ressource/down-arrow.png"><br/>
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

</body>
</html>
