<?php
include ("../header.html");
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

        $.getJSON("../data.php", {
            action : "getTables"},
            function(oRep){
                console.log(oRep);
                for(var i=0; i<oRep.boards.length; i++){
                    (function (i) {
                    var meta = oRep.boards[i];
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
                                var unLabelCol = modelJLabCol.clone(true).html(meta2.label);
                                var uneColonne = modelJColonne.clone(true).append(unLabelCol);
                                ////////////////////////////////////////

                                //Affichage des data
                                $.getJSON("../data.php",{
                                  action:"getData",
                                  idColonne:meta2.id},function(oData){
                                    console.log(oData);
                                    var dataP = modelJP.clone();
                                    var k,meta3;

                                    for(k=0; k<oData.data.length; k++){
                                      meta3=oData.data[k];
                                      dataP.html(meta3.valChar).attr("class","data");
                                      unLabelCol.append(dataP);
                                    }
                                    lesData.append(uneColonne);

                                  });

                            })(j)
                            }
                        }

                    );

                    uneTable.append(lesData).hide();
                    $("#container-table").append(uneTable);
                    })(i);
                }
            }

        )

  })

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
        margin-top: 50px;
        height: 100%;
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
      <div class="tables" id="container-table">
      </div>
    </div>
  </div>
</body>
