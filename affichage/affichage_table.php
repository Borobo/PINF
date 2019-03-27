
<?php
include("../unHeader.php");
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
	var modelLien = $("<a href='affichage_colonne.php' class='lien'></a>");
	var modelJDelete = $("<img class='del' data-toggle='modal' data-target='#myModal' src='ressource/delete.png'>");
	var modelJDeleteCol = $("<img class='del-col' src='ressource/delete.png'>");


	var addNom = $("<input type='text' class='input rounded' placeholder='Nom colonne'>");
	var addType = $("<select class='form-control'>")
	.append(modelJOption.clone().html("Texte"))
	.append(modelJOption.clone().html("Nombre"));
	var addDesc = $("<input type='text' class='desc' placeholder='Description'>");
	var addCroix = $("<img class='croix' src='ressource/cancel.png'>");
	var addCol = $("<div class='popup-table-addCol'>").append(addNom.clone())
	.append(addType.clone()).append(addDesc.clone()).append(addCroix.clone(true));
	var addLabel = $("<input type='text' placeholder='Label'>");
	var addDesc = $("<input type='text' placeholder='Description'>");


	///////////////////////////////////////////////////////

		$(document).ready(function(){

			$("#popup-col").hide();
			$("#popup-table").hide();
			$.getJSON("../data.php", {
				action : "getTables"
				},
				function(oRep){
					console.log(oRep);
					for(var i=0; i<oRep.boards.length; i++){
                        (function (i) {
						var meta = oRep.boards[i];
						//CREATION DU LABEL////////////////////////////////////////////////////
						var unDelete = modelJDelete.clone().data("idTable", meta.id);
						var unLien = modelLien.clone().data("id",meta.id).html("<b>"+meta.label+"</b>");
						var unLabel = modelJLabel.clone(true).append(unLien);
						if(oRep.superadmin == 1 || oRep.admin == 1){
							unLabel.append(unDelete);
						}

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
									var unDeleteCol = modelJDeleteCol.clone().data("idCol", meta2.id);
									var unLabelCol = modelJLabCol.clone(true).html(meta2.label);
									if(oRep.superadmin == 1||oRep.admin == 1)
										unLabelCol.append(unDeleteCol);
                                    var uneColonne = modelJColonne.clone(true).append(unLabelCol);
                                    ///////////////////////////////////////////////////////////////////////
                                    lesData.append(uneColonne);
                                }
								var colPlus = $("<div class='card col shadow-sm col-plus'>")
								.append($("<img>").attr("src","ressource/plus.png"))
								.data("idTable", meta.id)
								.data("nomTable", meta.label);
								if(oRep.admin == 1)
									lesData.append(colPlus);
                            }

                        );
						uneTable.append(lesData);
						$("#content").append(uneTable);
                        })(i);
					}

					var divPlus = $("<div id='divPlus' class='tables shadow text-center rounded border border-dark'>")
					.append($("<img>").attr("src","ressource/plus.png"));
					if(oRep.admin == 1)
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
			$("#popup-table").toggle();
			$("#popup-col").hide();
		})

		$(document).on("click", "#popup-table-croix", function(){
			$("#popup-table").hide();
		})

		$(document).on("click", "#popup-table-form #addCol", function(){
			$("#popup-table-cols").append(addCol.clone());
			console.log($(".popup-table-addCol").length);
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
				if($(".popup-table-addCol").length > 0){
					$(".popup-table-addCol").each(function(){
						console.log($(this).find(".input").val());
						//console.log(oRep.idTable);
						$.getJSON("../data.php", {
							action : "setColonne",
							idTable : oRep.idTable,
							labelCol : $(this).find(".input").val(),
							descCol : $(this).find(".desc").val()
						}, function(oRep){
							$("#popup-table").find("input").val("");
							$("#popup-table").find(".desc").val("");
							$("#nomTable").val("");
						})
					})
				}
				window.location.reload();
			})
		})

		var idDeLaTable;
		var nomDeLaTable;
		$(document).on("click", ".del", function(){
			idDeLaTable = $(this).data("idTable");
		})

		$(document).on("click", "#del-btn", function(){
			$.getJSON("../data.php",{
				action : "supprimerTable",
				idTable : idDeLaTable
			}, function(oRep){
				console.log(oRep.feedback);
				window.location.reload();
			})
		})

		$(document).on("click", ".del-col", function(){
			$.getJSON("../data.php",{
				action : "supprimerCol",
				idCol : $(this).data("idCol")
			}, function(oRep){
				console.log("LOL");
				window.location.reload();
			})
		})

		$(document).on("click", ".col-plus", function(){
			var unLabel = addLabel.clone();
			var uneDesc = addDesc.clone();
			$("#popup-col").toggle();
			$("#popup-table").hide();
			idDeLaTable = $(this).data("idTable");
			nomDeLaTable = $(this).data("nomTable");
			$("#popup-col h5").html("Ajouter une colonne dans <b>"+nomDeLaTable+"</b>");
		})

		$(document).on("click", "#popup-col .btn-secondary",function(){
			$("#popup-col").hide();
		})

		$(document).on("click", "#popup-col .btn-primary", function(){
			console.log($("#popup-col input[placeholder=Description]").val());
			if(leLabel = $("#popup-col input[placeholder=Label]").val()){
				$.getJSON("../data.php", {
					action : "setColonne",
					idTable: idDeLaTable,
					labelCol: $("#popup-col input[placeholder=Label]").val(),
					descCol: $("#popup-col input[placeholder=Description]").val()
				},function(){
					console.log("DONE");
					window.location.reload();
				})
			}else{
				var alertBox = $("<div class='alert alert-danger'>")
					.html("<strong>Alerte</strong> : Le label est obligatoire");
				$(".alert").remove();
				$("#content").append(alertBox);
				setTimeout(function(){ alertBox.fadeOut("slow"); }, 5000);
			}
		})


	</script>

	<style>

        body{
            background-color: lightblue;
            overflow-y: auto;
            overflow-x: auto;
            overflow-scrolling: touch;
        }
		.alert{
			position: fixed;
			bottom: 15px;
			width: 98%;
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
            background-color: #c7cbcd;
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
		.del{
			position: absolute;
			right: 12px;
			top: 4px;
			width: 17px;
		}
		.del:hover,.del-col:hover{
			cursor: pointer;
		}
		.del-col{
			position: absolute;
			top: 20px;
			right: 17px;
			width: 17px;
		}
		.col-plus{
			background-color: rgba(255, 255, 255, 0.5);
			height: 59.6px;
		}
		.col-plus:hover{
			cursor: pointer;
			background-color: #ffffff;
			transition: 0.25s;
		}
		.col-plus img{
			width: 40px;
			position: absolute;
			top: 50%;
			left: 50%;
			opacity: 0.8;
			transform: translate(-50%,-50%);
		}
		#popup-col{
			background-color: #dfe3e6;
			position: absolute;
			width: 400px;
			height: 300px;
			top:50%;
			left: 50%;
			transform: translate(-50%,-50%);
			padding: 50px;
			text-align: center;
			border-radius: 15px;
			border: 1px black solid;
		}
		#popup-col h5{
			margin-bottom: 35px;
		}
		#popup-col input{
			display: block;
			margin-left: auto;
			margin-right: auto;
			margin-bottom: 10px;
		}
		#popup-col button{
			margin-top: 20px;
		}

		#popup-col div{
			display: block;
		}

	</style>
</header>

<body>
    <div class="table-main-content">
		<?php
		echo '
        <div id="name" class="lead font-weight-bold text-uppercase ml-sm-5"><u>'.$_SESSION["nomBdd"].'</u></div>
		'
        ?>
		<div class="table-canvas">
            <div class="container-fluid" id="content">

            </div>
        </div>
		<?php
		if($_SESSION["admin"]||$_SESSION["superadmin"]){
			echo'
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
			</div>';
			echo'
			<div id="popup-col">
				<h5>Ajouter une colonne</h5>
				<div id="popup-col-input">
					<input type="text" placeholder="Label"></input>
					<input type="text" placeholder="Description"></input>
				</div>
				<button class="btn btn-primary">Valider</button>
				<button class="btn btn-secondary">Annuler</button>
			</div>';
		}

		?>

    </div>

	<?php
		if($_SESSION["admin"]||$_SESSION["superadmin"]){
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
			          Êtes-vous sûr de vouloir supprimer cette table (cette action est irréversible).
			        </div>

			        <!-- Modal footer -->
			        <div class="modal-footer">
						<button type="button" id="del-btn" class="btn btn-success" data-dismiss="modal">Confirmer</button>
			          	<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					</div>

			      </div>
			    </div>
			  </div>';

		}
	 ?>

</body>
