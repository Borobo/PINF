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

    $(document).ready(function(){

      $.getJSON("../data.php",{
          action:"getTables"},function(oRep){

            var i;
          //  console.log(oRep.nomTables[0].label);
            for(i=0; i<oRep.boards.length; i++){

              console.log(oRep.boards[i].id);
              var unBtn = modelJBtn.clone(true).html(oRep.boards[i].label).data("idTable",oRep.boards[i].id).attr("href","affichage_colonne.php");
              $("#div-onglet").append(unBtn);

            }

          });



        $.getJSON("../data.php",{
          action:"getLaTable"},function(oRep){
            console.log(oRep);
            var meta = oRep.tab[0];
            //CREATION DU LABEL////////////////////////////////////////////////////
            var unP = modelJP.clone();
            var unLabel = modelJLabel.clone(true);
            ///////////////////////////////////////////////////////////////////////text
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

  })

  $(document).on("click",".onglet",function(){

    $.getJSON("../data.php",{
      action:"stockIdTable",
      id:$(this).data("idTable")
    },function(){
    });



  });

  $(document).on("click","#supprimer",function(){
      console.log("je suppr");
      $("#container-table").empty();

      $.getJSON("../data.php",{
        action:"getLaTable"},function(oRep){
          console.log(oRep);
          var meta = oRep.tab[0];
          //CREATION DU LABEL////////////////////////////////////////////////////
          var unP = modelJP.clone();
          var unLabel = modelJLabel.clone(true);
          ///////////////////////////////////////////////////////////////////////text
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
                            var div = modelJLabel.clone().attr("class","data").data("idData",meta3.id).data("position",k);
                            //var imgSuppr = modelJImg.clone().attr("src","ressource/croix.png").attr("height","20px").attr("width","20px")
                            var check = $("<div class='form-check'></div>").append(modelJCheckbox.clone().data("idData",meta3.id).data("position",k));
                            var dataP = modelJP.clone();

                            if(meta3.valInt == null){
                              dataP.html(meta3.valChar);
                              if(j==0) div.append(check);
                              div.append(dataP);
                            }
                            else{
                              dataP.html(meta3.valInt);
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
          $(".container-colonnes").after($("<button type='button' class='btn btn-info' id='Suppression'>Supprimer</button>"));
        });


  });

    $(document).on("click","#Suppression",function(){

      var pos;

          $('.card-body input[type=checkbox]').each(function(){
            if($(this).prop('checked') == true){

              //enregistrer la position
              pos = $(this).data("position");
              $('.card-body .data').each(function(){
                 if($(this).data("position") == pos){

                   $.getJSON("../data.php",{
                     action:"delData",
                     idData:$(this).data("idData")},function(oRep){
                      console.log(oRep);
                     });
                 }

              });

            }


       });
       $("#container-table").empty();
       $.getJSON("../data.php",{
         action:"getLaTable"},function(oRep){
           var meta = oRep.tab[0];
           //CREATION DU LABEL////////////////////////////////////////////////////
           var unP = modelJP.clone();
           var unLabel = modelJLabel.clone(true);
           ///////////////////////////////////////////////////////////////////////text
           var lesData = modelJData.clone(true);
           var uneTable = modelJTable.clone(true).append(unLabel)
               .data("label", meta.label); //On stocke le label dans le div.

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




    });



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

      }

    </style>
</head>


<body>
  <div id="content">
    <div id="container-fonction"><br>
              <button type="button" class="btn btn-light">Ajouter une ligne</button>
              <button type="button" class="btn btn-light" id="supprimer">Supprimer une ligne</button>
              <button type="button" class="btn btn-light">Modifier une ligne</button>
              <button type="button" class="btn btn-light">Gérer les doublons</button>
              <button type="button" class="btn btn-light">Compter</button>
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
