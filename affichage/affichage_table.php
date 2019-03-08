<?php
include("../header.html");
?>

<header>
	<script type="text/javascript">

		$(document).ready(function(){
			//LES MODELES//////////////////////////////////////////
			var modelJTable = $("<div class='tables shadow text-center rounded border border-dark'>");
			var modelJLabel = $("<div class='title border border-right-0 border-left-0 border-top-0 border-dark'>");
			var modelJData = $("<div class='container tab-data'>");
			var modelJP = $("<p>");
			var modelJColonne = $("<div class='card col shadow-sm bg-white'>");
			var modelJLabCol = $("<div class='card-body text-left'>");
			var modelLien = $("<a href='affichage_colonne.php' class='lien'></a>");
			///////////////////////////////////////////////////////

			$.getJSON("../data.php", {
				action : "getTables",
				bdd : 1},
				function(oRep){
					console.log(oRep);
					for(var i=0; i<oRep.boards.length; i++){
                        (function (i) {
						var meta = oRep.boards[i];
						//CREATION DU LABEL////////////////////////////////////////////////////
						var unLien = modelLien.clone().data("id",meta.id).html("<b>"+meta.label+"</b>");
						var unLabel = modelJLabel.clone(true).append(unLien);
						///////////////////////////////////////////////////////////////////////text
                        var lesData = modelJData.clone(true);

                        var uneTable = modelJTable.clone(true).append(unLabel)
                            .data({"label":meta.label,"id":meta.id});

                        $.getJSON("../data.php", {
                                action : "getColonnes",
                                idTable : meta.id},
                            function(oCol){
                                console.log(oCol);
                                for(var j=0; j<oCol.colonnes.length; j++){
                                    var meta2 = oCol.colonnes[j];
                                    //CREATION DUNE COLONNE////////////////////////////////////////////////////
                                    var unLabelCol = modelJLabCol.clone(true).html(meta2.label);
                                    var uneColonne = modelJColonne.clone(true).append(unLabelCol);
                                    ///////////////////////////////////////////////////////////////////////
                                    lesData.append(uneColonne);
                                }
                            }

                        );

                        uneTable.append(lesData);
						$("#content").append(uneTable);
                        })(i);
					}
				}
			)
		});

        $(document).on("click",".lien",function(){
            console.log("wshhhbdddddd");
            console.log($(this).data("id"));
            $.getJSON("../data.php",{
                action:"stockIdTable",
                id:$(this).data("id")
            },function(oRep){
            });
        });

	</script>

	<style>
        body{
            background-color: lightblue;
            overflow-y: auto;
            overflow-x: auto;
            overflow-scrolling: touch;
        }
        .table-main-content{
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .table-canvas{
            position: relative;
            display: block;
            flex-grow: 1;
        }
		#content{
            position: absolute;
			display: flex;
			overflow-x: auto;
            top: 0;
            bottom: 0;
            right: 0;
		}
		.tables{
            position: relative;
			height: 450px;
			margin: 10px;
            font-size: 9pt;
            background-color: #dfe3e6;
            white-space: normal;
            min-width: 272px;
        }



        .tables:last-child{
            margin-right: 30px;
        }
		.title{
            font-size: 12pt;
			width: 100%;
		}

        .title:hover{
            transition: 0.4s;
            background-color: #9a9d9f;
        }

        .tab-data{
            position: absolute;
            height: 85%;
            overflow-y: auto;
        }
        .col{
            display: flex;
            margin: 10px 0;
        }
        #name{
            margin-top: 20px;
        }

	</style>
</header>

<body>
    <div class="table-main-content">
        <div id="name" class="lead font-weight-bold text-uppercase ml-sm-5"><u>Nom de la base de données</u></div>
        <div class="table-canvas">
            <div class="container-fluid" id="content">

            </div>
        </div>
    </div>
</body>