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
						var unP = modelJP.clone().html("<b>"+meta.label+"</b>");
						var unLabel = modelJLabel.clone(true).append(unP);
						///////////////////////////////////////////////////////////////////////text
                        var lesData = modelJData.clone(true);
                        var uneTable = modelJTable.clone(true).append(unLabel)
                            .data("label", meta.label); //On stocke le label dans le div.

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

	</script>

	<style>
		#content{
			background-color: lightblue;
			display: flex;
			overflow: auto;
		}
		.tables{
            position: relative;
			height: 450px;
			margin: 10px;
			padding: 0;
            font-size: 9pt;
            background-color: #dfe3e6 !important;
            white-space: normal;
            min-width: 272px;
        }
		.title{
            font-size: 12pt;
			width: 100%;
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
        .col div{
            float: left;
        }
	</style>
</header>

<body>
	<div class="container" id="content">

	</div>
</body>