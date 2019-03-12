
<?php
include("../unHeader.html");
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
	var addCroix = $("<img class='croix' src='ressource/cancel.png'>");
	var addCol = $("<div class='popup-table-addCol'>").append(addNom.clone())
	.append(addType.clone()).append(addDesc.clone()).append(addCroix.clone(true));

	///////////////////////////////////////////////////////

		$(document).ready(function(){

			$("#popup-table").hide();

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
				action : "getTables"
				},
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

					var divPlus = $("<div id='divPlus' class='tables shadow text-center rounded border border-dark'>")
					.append($("<img>").attr("src","ressource/plus.png"));
					if(oRep.grade == 1)
						$("#content").append(divPlus);
				}


			)
			$("#popup-table-cols").prepend(addCol.clone());

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

		$(document).on("click","#divPlus", function(){
			$("#popup-table").fadeToggle("fast");
		})

		$(document).on("click", "#popup-table-croix", function(){
			$("#popup-table").hide();
		})

		$(document).on("click", "#popup-table-form #addCol", function(){
			$("#popup-table-cols").append(addCol.clone());
		});

		$(document).on("click", ".croix",function(){
			$(this).parent().remove();
		})

		$(document).on("click", "#validate", function(){
			console.log($("#nomTable").val());
			$.getJSON("../data.php", {
				action : "setTable",
				label : $("#nomTable").val()
			}, function(oRep){
				//if(oRep)
				$(".popup-table-addCol").each(function(){
					console.log($(this).find(".input").val());
					//console.log(oRep.idTable);
					$.getJSON("../data.php", {
						action : "setColonne",
						idTable : oRep.idTable,
						labelCol : $(this).find(".input").val(),
						descCol : $(this).find(".desc").val()
					}, function(){
						console.log("ENVOIE"); //TODO : à finir
						$("#popup-table").find(".input").val("");
						$("#popup-table").find(".desc").val("");
						$("#nomTable").val("");
						window.location.reload();
					})
				})
			})
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
		#divPlus{
			background-color: rgba(223, 227, 230, 0.5);
		}
		#divPlus img{
			margin-top: 65%;
		}
		#divPlus:hover{
			cursor: pointer;
			background-color: rgba(223, 227, 230, 0.85);
		}
		#popup-table{
			height: 450px;
			min-width: 50%;
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
			cursor: pointer;
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
		#popup-table-croix{
			position: absolute;
			top: 12px;
			right: 12px;
			cursor: pointer;
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
				<div><input id="nomTable" class="rounded" type="text" placeholder="Nom de la table"></input>
				</div>
				<div id="popup-table-form">
					<div id="popup-table-cols"></div>
					<img src="ressource/cancel.png" id="popup-table-croix">
					<button type="button" id="validate" class="btn btn-primary">Valider</button>
					<button type="button" id="addCol" class="btn btn-outline-secondary">Ajouter une colonne</button>
				</div>

			</div>
		</div>
    </div>
</body>
