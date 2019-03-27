<?php
include ("../unHeader.php");
?>

<head>
    <script>
    //var modelJTable = $("<div class='tables shadow text-center rounded border border-dark'>");
    var modelJLabel = $("<div>");
    var modelJData = $("<div class='container-fluid container-colonnes'>");
    var modelJP = $("<p>");
    var modelJColonne = $("<div class='colonnes shadow text-center rounded border border-dark'>");
    var modelJColonneCanvas = $("<div class='container border border-danger'>");
    var modelJTable = $("<div class=\"tables\">");
    var modelJLabCol = $("<div class='card-body text-left'>");
    var modelJBtn = $("<a class='onglet rounded-top'></a>");
    var modelJImg = $("<img src=''>");
    var modelJCheckbox = $("<input type=checkbox class='form-check-input'>");
    var modelJTA = $("<textarea> </textarea>");


    /*///////////////affichageData()////////////////////////////////////////////////////////////
    *  Récupère les colonnes de la table sélectionné
    *  Puis récupère les data de chaque colonne
    *  Ecrit sur la page les colonnes et les data de la table
    */
    function affichageData(){
      $("#container-table").empty();
      //On récupère la table
      $.getJSON("../data.php",{
        action:"getLaTable"},function(oRep){
          var meta = oRep.tab[0];
          //CREATION DU LABEL////////////////////////////////////////////////////
          var unP = modelJP.clone();
          var unLabel = modelJLabel.clone(true);

          var lesData = modelJData.clone(true);
          var uneTable = modelJTable.clone(true).append(unLabel)
              .data("label", meta.label); //On stocke le label dans le div.
          //On récupère les colonnes de la table
          $.getJSON("../data.php", {
                  action : "getColonnes",
                  idTable : meta.id
              },
              function(oCol){
                  for(var j=0; j<oCol.colonnes.length; j++){
                      (function(j){
                      var meta2 = oCol.colonnes[j];
                      //CREATION DUNE COLONNE/////////////////
                      var colP = modelJP.clone(true).html(meta2.label).attr("class","labCol");
                      var unLabelCol = modelJLabCol.clone(true).append(colP).data("idColonne",meta2.id);

                      var uneColonne = modelJColonne.clone(true).append(unLabelCol);

                      //On récupère les data de chaque colonne
                      $.getJSON("../data.php",{
                        action:"getData",
                        idColonne:meta2.id},function(oData){
                          var k,meta3;

                          for(k=0; k<oData.data.length; k++){
                            var dataP = modelJP.clone();
                            meta3=oData.data[k];
                            if(meta3.valInt == null){
                              dataP.html(meta3.valChar).attr("class","data");
                              unLabelCol.append(dataP);
                            }
                            else{
                              dataP.html(meta3.valInt).attr("class","data");
                              unLabelCol.append(dataP);
                            }
                          }
                          lesData.append(uneColonne);

                        });

                  })(j)
                }
              }

          );
          uneTable.append(lesData);
          $("#container-table").append(uneTable);
        })
    }
    /////////////////////FIN affichageData()///////////////////////////////////////////////////////////////////

    /////////////////////Demarrage de la page affichage_colonne.php////////////////////////////////////////////
    $(document).ready(function(){

      //Onglets permettant de passer d'une table à l'autre dans affichage_colonne.php
      $.getJSON("../data.php",{
          action:"getTables"},function(oRep){
            var i;
            for(i=0; i<oRep.boards.length; i++){
              //btn (contenant l'id de la table) redirigeant vers la table souhaité
              var unBtn = modelJBtn.clone(true).html(oRep.boards[i].label).data("idTable",oRep.boards[i].id).attr("href","affichage_colonne.php");
              $("#div-onglet").append(unBtn);

            }

          });

          //affichage des colonnes et des data de la table
          affichageData();

          $("#compter").data("activation",0);

    });
/////////////////////FIN Demarrage de la page affichage_colonne.php////////////////////////////////////////////

/////////////////////Redirection vers la table souhaité dans affichage_colonne/////////////////////////////////
  $(document).on("click",".onglet",function(){

    $.getJSON("../data.php",{
      action:"stockIdTable",
      id:$(this).data("idTable")
    },function(){
    });
/////////////////////FIN Redirection vers la table souhaité dans affichage_colonne/////////////////////////////
  });

/////////////////////Activation de la fonction suppression des data////////////////////////////////////////////
  $(document).on("click","#supprimer",function(){
      $("#supprimer").attr("class","btn btn-success");
      //On refait l'affichage des data mais avec des checkbox poru pouvoir choisir les lignes à suppprimer////
      $("#container-table").empty();
      $.getJSON("../data.php",{
        action:"getLaTable"},function(oRep){
          console.log(oRep);
          var meta = oRep.tab[0];
          var unP = modelJP.clone();
          var unLabel = modelJLabel.clone(true);

          var lesData = modelJData.clone(true);
          var uneTable = modelJTable.clone(true).append(unLabel)
              .data("label", meta.label); //On stocke le label dans le div.

          $.getJSON("../data.php", {
                  action : "getColonnes",
                  idTable : meta.id
              },
              function(oCol){
                  console.log(oCol);
                  for(var j=0; j<oCol.colonnes.length; j++){
                      (function(j){
                      var meta2 = oCol.colonnes[j];
                      //CREATION DUNE COLONNE/////////////////
                      var colP = modelJP.clone(true).html(meta2.label).attr("class","labCol");
                      var unLabelCol = modelJLabCol.clone(true).append(colP);

                      var uneColonne = modelJColonne.clone(true).append(unLabelCol);
                      ////////////////////////////////////////
                      //Affichage des data
                      $.getJSON("../data.php",{
                        action:"getData",
                        idColonne:meta2.id},function(oData){
                          console.log(oData);
                          var k,meta3;

                          for(k=0; k<oData.data.length; k++){
                            //div contenant la croix suppression et la première data de la 1ère colonne

                            meta3=oData.data[k];
                            //On met une position sur chaque data pour savoir à quelle ligne elles correspondent pour simplifier la suppression des lignes
                            var div = modelJLabel.clone().attr("class","data").data("idData",meta3.id).data("position",k);
                            //checkbox
                            var check = $("<div class='form-check'></div>").append(modelJCheckbox.clone().data("idData",meta3.id).data("position",k));
                            var dataP = modelJP.clone();

                            if(meta3.valInt == null){
                              dataP.html(meta3.valChar);
                              //On met les checkbox sur la première colonne
                              if(j==0) div.append(check);
                              div.append(dataP);
                            }
                            else{
                              dataP.html(meta3.valInt);
                              //On met les checkbox sur la première colonne
                              if(j==0) div.append(check);
                              div.append(dataP);
                            }
                            unLabelCol.append(div);
                          }
                          lesData.append(uneColonne);

                        });

                  })(j)
                }
              }

          );
          uneTable.append(lesData);
          $("#container-table").append(uneTable);
          //Bouton annuler
          $(".container-colonnes").after($("<button type='button' class='btn btn-danger' id='Annuler'>Annuler</button>"));
          //Bouton pour confirmer la suppression après avoir checked les lignes
          $(".container-colonnes").after($("<button type='button' class='btn btn-info' id='Suppression'>Supprimer</button>"));

        });
        //FIN on refait l'affichage des data mais avec des checkbox pour pouvoir choisir les lignes à suppprimer////

  });
/////////////////////FIN Activation de la fonction suppression des data////////////////////////////////////////

/////////////////////Suppression des data dans la base de données/////////////////////////////////////////////
    $(document).on("click","#Suppression",function(){
      var pos;
          //On regarde quelles sont les checkbox qui sont checked
          $('.card-body input[type=checkbox]').each(function(){
            if($(this).prop('checked') == true){

              //On sauveguarde la position de la ligne qu'on veut supprimer
              pos = $(this).data("position");

              //On vérifie la position sauveguarder avec la position de chaque data
              //Puis on supprime dans la bdd
              $('.card-body .data').each(function(){
                 if($(this).data("position") == pos){

                   $.getJSON("../data.php",{
                     action:"delData",
                     idData:$(this).data("idData")},function(oRep){
                     });
                 }

              });

            }


       });

       //Après avoir fait la suppression on réaffiche le tout
       affichageData();

       $("#supprimer").attr("class","btn btn-light");

    });
/////////////////////FIN Suppression des data dans la base de données/////////////////////////////////////////


/////////////////////Activation de la fonction modification des data/////////////////////////////////////////
    $(document).on("click","#modifier",function(){
      $("#modifier").attr("class","btn btn-success");
      //On réaffiche les data avec en sauveguardant leur valeur et leur id pou faciliter la modification
      $("#container-table").empty();
      $.getJSON("../data.php",{
        action:"getLaTable"},function(oRep){
          var meta = oRep.tab[0];
          var unP = modelJP.clone();
          var unLabel = modelJLabel.clone(true);
          var lesData = modelJData.clone(true);
          var uneTable = modelJTable.clone(true).append(unLabel)
              .data("label", meta.label);

          $.getJSON("../data.php", {
                  action : "getColonnes",
                  idTable : meta.id
              },
              function(oCol){

                  for(var j=0; j<oCol.colonnes.length; j++){
                      (function(j){
                      var meta2 = oCol.colonnes[j];
                      //CREATION DUNE COLONNE/////////////////
                      var colP = modelJP.clone(true).html(meta2.label).attr("class","labCol");
                      var unLabelCol = modelJLabCol.clone(true).append(colP);

                      var uneColonne = modelJColonne.clone(true).append(unLabelCol);
                      ////////////////////////////////////////
                      //Affichage des data
                      $.getJSON("../data.php",{
                        action:"getData",
                        idColonne:meta2.id},function(oData){
                          console.log(oData);

                          var k,meta3;

                          for(k=0; k<oData.data.length; k++){
                            var dataP = modelJP.clone();
                            meta3=oData.data[k];
                            if(meta3.valInt == null){
                              dataP.html(meta3.valChar).attr("class","dataModifiable").data("valChar",meta3.valChar).data("idData",meta3.id).data("valInt",null);
                              unLabelCol.append(dataP);
                            }
                            else{
                              dataP.html(meta3.valInt).attr("class","dataModifiable").data("valInt",meta3.valInt).data("idData",meta3.id).data("valChar",null);
                              unLabelCol.append(dataP);
                            }
                          }
                          lesData.append(uneColonne);

                        });

                  })(j)
                }
              }

          );
          uneTable.append(lesData);
          $("#container-table").append(uneTable);
          $(".container-colonnes").after($("<button type='button' class='btn btn-danger' id='Annuler'>Annuler</button>"));
          $(".container-colonnes").after($("<button type='button' class='btn btn-info' id='ConfirmModif'>Confimer modification</button>"));

        });

    });
/////////////////////FIN Activation de la fonction modification des data/////////////////////////////////////


/////////////////////Modification d'une data en cliquant dessus/////////////////////////////////////////////
    $(document).on("click",".dataModifiable",function(){
        //variable du textarea
       var nextTA;
       //On regarde si le data est un charactère ou un nombre puis on remplace le paragraphe par un textarea
       if($(this).data("valChar") != null)
        nextTA = modelJTA.clone().val($(this).html()).data("idData",$(this).data("idData")).data("valChar",$(this).data("valChar")).data("valInt",null);
       else
        nextTA = modelJTA.clone().val($(this).html()).data("idData",$(this).data("idData")).data("valInt",$(this).data("valInt")).data("valChar",null);

       $(this).replaceWith(nextTA);
    });
/////////////////////FIN Modification d'une data en cliquant dessus////////////////////////////////////////

/////////////////////Appui sur la touche entrée ou echap dans le textarea//////////////////////////////////
    $(document).on("keydown",
        ".card-body textarea",
        function (contexte){
            if (contexte.which == 13) { // 13 <=> touche ENTREE
              var nextP;
              // restaurer le paragraphe avec sa nouvelle valeur en fonction du type de data (charactère ou nombre)
              if($(this).data("valChar") != null)
                nextP = modelJP.clone().html($(this).val()).attr("class","dataModifiable").data("idData",$(this).data("idData")).data("valChar",$(this).val()).data("valInt",null).css("background-color","lightgreen");
              else
                nextP = modelJP.clone().html($(this).val()).attr("class","dataModifiable").data("idData",$(this).data("idData")).data("valInt",$(this).val()).data("valChar",null).css("background-color","lightgreen");

              $(this).replaceWith(nextP);

            }
            if (contexte.which == 27) {	// 27 <=> touche ESCAPE
                // restaurer le paragraphe avec son ancienne valeur
               $(".card-body textarea").each(function(){
                    var nextP = modelJP.clone().attr("class","dataModifiable").html($(this).val());
                    $(this).replaceWith(nextP);
                });
            }

        });
/////////////////////FIN Appui sur la touche entrée ou echap dans le textarea//////////////////////////////

/////////////////////Modification des data dans la base de données/////////////////////////////////////////
    $(document).on("click","#ConfirmModif",function(){
          //On regarde chaque data on modifie la base de donnée avec leur valeur
          $(".dataModifiable").each(function(){
            //On modifie la data si c'est un charactère ou un nombre
            if($(this).data("valChar") != null){
              $.getJSON("../data.php",{
                action:"majDataChar",
                idData:$(this).data("idData"),
                valChar:$(this).data("valChar")},function(oRep){
                  console.log(oRep);
                });
            }
            else{
              $.getJSON("../data.php",{
                action:"majDataInt",
                idData:$(this).data("idData"),
                valInt:$(this).data("valInt")},function(oRep){
                });
            }
            $("#modifier").attr("class","btn btn-light");
            $(".alert-info").empty();
          });

          //On réaffiche les data après avoir modifier la base de données
          affichageData();
      });
/////////////////////FIN Modification des data dans la base de données/////////////////////////////////////////


/////////////////////Annuler la fonction sélectionné//////////////////////////////////////////////////////////
      $(document).on("click","#Annuler",function(){
          affichageData();
          $("#supprimer").attr("class","btn btn-light");
          $("#modifier").attr("class","btn btn-light");
      });
/////////////////////FIN Annuler la fonction sélectionné//////////////////////////////////////////////////////

/////////////////////Activation de la fonction pour compter les data//////////////////////////////////////////
      $(document).on("click","#compter",function(){
          //On regarde d'abord si on active ou on désactive la fonction compter
          if($("#compter").data("activation") == 0){
            $("#compter").attr("class","btn btn-success");
            $("#compter").data("activation",1);
            $(".card-body").attr("class","card-body text-left compter");
          }
          else{
            $("#compter").attr("class","btn btn-light");
            $("#compter").data("activation",0);
            $(".card-body").attr("class","card-body text-left");
            $(".divInfo").css("display","none");
          }
      });
/////////////////////FIN Activation de la fonction pour compter les données//////////////////////////////////

/////////////////////Clique sur une colonne pour savoir son nombre de données////////////////////////////////
      $(document).on("click",".compter",function(){
          var NbData,labelColonne,info,div,img,btn;

          //On compte les données de la colonne sélectionné
          $.getJSON("../data.php",{
            action:"countData",
            idColonne:$(this).data('idColonne')},function(oRep){
              labelColonne = oRep.data[0].label;
              NbData = oRep.data[0].NbData;
              idColonne = oRep.data[0].id;

              //On affiche le résultat dans un div contenant un message et un bouton suppression
              div = modelJLabel.clone().attr("class","divInfo").data("idColonne",idColonne);
              info = modelJLabel.clone().attr("class","alert alert-info").html("La colonne <strong>"+labelColonne+"</strong> contient <strong>"+NbData+"</strong> données.");
              btn = $("<button class='btn btn-dark croix'>X</button>").data("idColonne",idColonne).css("height","52px").css("width","45px").css("margin-left","5px").css("font-size","20");

              //Si le message existe déjà on le supprime pour le réaffiché en première ligne
              $(".divInfo").each(function(){
                if($(this).data("idColonne") == idColonne)
                  $(this).css("display","none");
              });

              div.append(info).append(btn).css("margin","5px").css("display","flex");
              $(".container-colonnes").after(div);
            });

      });
/////////////////////FIN Clique sur une colonne pour savoir son nombre de données////////////////////////////


/////////////////////Supprimer un message informant le nombre de données d'une colonne///////////////////////
      $(document).on("click",".croix",function(){

        var idCroix = $(this).data("idColonne");

        $(".divInfo").each(function(){
          if(idCroix == $(this).data("idColonne"))
            $(this).css("display","none");

        });

      });
/////////////////////FIN Supprimer un message informant le nombre de données d'une colonne///////////////////


    </script>

    <style>

      #content{
        display: flex;
        position: relative;
        height: 100%;
        overflow-y: hidden;
      }

      #container-fonction{
        background-color: rgb(100, 170, 255);
        height: 100%;
        width: 200px;
      }

      .container-colonnes{
          position: absolute;

      }

      #affichage{
        background-color: rgb(86, 190, 143);
        height: 100%;
        flex-grow: 1;
      }

      #container-table{
        background-color: rgb(50, 80, 50);
        width: 100%;
        height: 100%;
      }

      #nomTab{
        height: 50px;
        display: flex;
        position: relative;
      }

      .btn-info{
        margin-right: 10px;
        margin-top:5px;
        min-width:100px;
        height:40px;
        }
        .btn-danger{
          margin-right: 10px;
          margin-top:5px;
          min-width:100px;
          height:40px;
          }

      .tables:first-child{
          display: block !important;
      }

      .tables
      {
          height: 100%;
          width: 100%;
          position: relative;
          background-color: red;

      }

      .colonnes{
          position: relative;
          height: 350px;
          margin: 0;
          font-size: 9pt;
          background-color: #dfe3e6;
          white-space: normal;
          min-width: 200px;
          display: flex;

      }

      .container-colonnes{
          position: relative;
          background-color: grey;
          display: flex;
          margin: auto;
      }

      .btn-light{
        margin-bottom: 30px;
        width: 180px;
        height: 50px;
        margin-left: 7px;
      }
      .btn-success{
        margin-bottom: 30px;
        width: 180px;
        height: 50px;
        margin-left: 7px;
      }
      .data:first-child{
        margin-top:20px;
      }

      .data{
        margin-bottom:10px;
        display:flex;
      }

      .data p{
        margin-left:10px;
      }

      .labCol{
        text-align: center;

      }
      .onglet{
          background-color: rgba(70, 125, 247, 0.77);
          margin: 0px 5px;
          height: 20px;
          min-width: 20px;
          width: auto;
          padding: 7px;
          color: white;
          text-decoration: none;
      }
      .onglet:hover{
          text-decoration: none;
          color: white;
          background-color: rgba(70, 125, 247, 1);
      }
      #div-onglet{
          position: absolute;
          bottom: 5;
          min-width: 200px;

      }

      .dataModifiable:hover{
        cursor:text;
      }

      .dataModifiable{
        background-color: lightgrey;
        height:20px;
      }

      .compter:hover{
        background-color:lightgreen;
        cursor:pointer;
      }

      .alert-info{
        width: 750px !important;
        text-align:center;
      }


    </style>
</head>


<body>
  <div id="content">
    <div id="container-fonction"><br>
              <button type="button" class="btn btn-light">Ajouter ligne(s)</button>
              <button type="button" class="btn btn-light" id="supprimer">Supprimer ligne(s)</button>
              <button type="button" class="btn btn-light" id="modifier">Modifier ligne(s)</button>
              <button type="button" class="btn btn-light">Gérer les doublons</button>
              <button type="button" class="btn btn-light" id="compter">Compter</button>
              <button type="button" class="btn btn-light">Moyenne</button>
              <button type="button" class="btn btn-light">Minimum</button>
              <button type="button" class="btn btn-light">Maximum</button>
    </div>
    <div id="affichage" class="container-fluide">
      <div id="nomTab">
          <div id="div-onglet"></div>
      </div>
      <div class="tables" id="container-table">
      </div>
    </div>
  </div>
</body>
