
<?php
include ("../unHeader.html");
?>

<head>
    <script>
    $(document).ready(function(){

        //var modelJTable = $("<div class='tables shadow text-center rounded border border-dark'>");
        var modelJLabel = $("<div>");
        var modelJData = $("<div class='container-fluid container-colonnes'>");
        var modelJP = $("<p>");
        var modelJColonne = $("<div class='colonnes shadow text-center rounded border border-dark'>");
        var modelJColonneCanvas = $("<div class='container border border-danger'>");
        var modelJTable = $("<div class=\"tables\">");
        var modelJLabCol = $("<div class='card-body text-left'>");
        var modelJBtn = $("<a class='btn btn-info'></a>");

      $.getJSON("../data.php",{
          action:"getTables"},function(oRep){

            var i;
          //  console.log(oRep.nomTables[0].label);
            for(i=0; i<oRep.boards.length; i++){
              console.log(oRep.boards[i].id);
              var unBtn = modelJBtn.clone(true).html(oRep.boards[i].label).data("idTable",oRep.boards[i].id).attr("class","btn btn-info nomTab").attr("href","affichage_colonne.php");
              $("#nomTab").append(unBtn);

            }

          });



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

  })

  $(document).on("click",".nomTab",function(){

    $.getJSON("../data.php",{
      action:"stockIdTable",
      id:$(this).data("idTable")
    },function(){
    });

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
      }

      .labCol{
        text-align: center;

      }

    </style>
</head>


<body>
  <div id="content">
    <div id="container-fonction"><br>
              <button type="button" class="btn btn-light">Ajouter une ligne</button>
              <button type="button" class="btn btn-light">Supprimer une ligne</button>
              <button type="button" class="btn btn-light">Modifier une ligne</button>
              <button type="button" class="btn btn-light">Gérer les doublons</button>
              <button type="button" class="btn btn-light">Compter</button>
              <button type="button" class="btn btn-light">Moyenne</button>
              <button type="button" class="btn btn-light">Minimum</button>
              <button type="button" class="btn btn-light">Maximum</button>
    </div>
    <div id="affichage" class="container-fluide">
      <div id="nomTab">
      </div>
      <div class="tables" id="container-table">
      </div>
    </div>
  </div>
</body>

