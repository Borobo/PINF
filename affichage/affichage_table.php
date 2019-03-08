<?php
include("../header.html");
?>

<header>
	<script type="text/javascript">
	//LES MODELES//////////////////////////////////////////
	var modelJTable = $("<div class='tables shadow text-center rounded border border-dark'>");
	var modelJLabel = $("<div class='title border border-right-0 border-left-0 border-top-0 border-dark'>");
	var modelJData = $("<div class='container tab-data'>");
	var modelJP = $("<p>");
	var modelJColonne = $("<div class='card col shadow-sm bg-white'>");
	var modelJLabCol = $("<div class='card-body text-left'>");
	var modelJOption = $("<option>");

	var addNom = $("<input type='text' class='input rounded' placeholder='Nom colonne'>");
	var addType = $("<select class='form-control'>")
	.append(modelJOption.clone().html("Texte"))
	.append(modelJOption.clone().html("Nombre"));
	var addDesc = $("<input type='text' class='desc rounded' placeholder='Description'>");
	var addCroix = $("<img src='ressource/cancel.png'>");
	var addCol = $("<div class='popup-table-addCol'>").append(addNom.clone())
	.append(addType.clone()).append(addDesc.clone()).append(addCroix.clone(true));

	///////////////////////////////////////////////////////

		$(document).ready(function(){


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
					var divPlus = $("<div id='divPlus' class='tables shadow text-center rounded border border-dark'>")
					.append($("<img>").attr("src","ressource/plus.png"));
					$("#content").append(divPlus);
				}



			)
			$("#popup-table-cols").prepend(addCol.clone());

		});

		$(document).on("click","#divPlus", function(){

		})

		$(document).on("click", "#popup-table-form button", function(){
			$("#popup-table-cols").append(addCol.clone());
		});

		$(document).on("click", "#popup-table-addCol img", function(){
			$("").remove();
		})

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
		#divPlus img{
			margin-top: 65%;
		}
		#divPlus:hover{
			cursor: pointer;
			background-color: #b9b9b9;
		}
		#popup-table{
			height: 450px;
			width: 50%;
			position: absolute;
			background: #dfe3e6;
			top: 20%;
			left: 25%;
			border-radius: 30px;
			text-align: center;
		}
		#popup-table div{
			margin-top: 15px;
		}
		#popup-table-form{
			overflow: auto;
		}

		#popup-table-form button{
			margin-top: 30px;
		}
		.popup-table-addCol{
			position: relative;
			display: flex;
			height: 40px;
		}

		.popup-table-addCol *{
			height: 100%;
			margin: 0 10px;
		}

		.popup-table-addCol img{
			margin-top: 5px;
			height: 25px;
			width: 25px;
		}

		.input{
			float: left;
		}
		.desc{
			flex-grow: 1;
		}
		#popup-table-cols{
			overflow: auto;
			height: 288px;
		}
		#popup-table-cols select{
			width: 115px;
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
		<div id="popup-table" class="border border-dark shadow">
			<div>
				<div><input class="rounded" type="text" placeholder="Nom de la table"></input>
				</div>
				<div id="popup-table-form">
					<div id="popup-table-cols"></div>
					<button type="button" class="btn btn-outline-secondary">Ajouter une colonne</button>
				</div>

			</div>
		</div>
    </div>
</body>
