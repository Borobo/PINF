<?php
include("../header.html");
?>

<header>
	<script type="text/javascript">

		$(document).ready(function(){
			//LES MODELES//////////////////////////////////////////
			var modelJTable = $("<div class='tables text-center'>");
			var modelJLabel = $("<div class='label label-default'>");
			var modelJP = $("<p>");
			///////////////////////////////////////////////////////

			$.getJSON("../data.php", {
				action : "getTables",
				bdd : 1},
				function(oRep){
					console.log(oRep);
					for(var i=0; i<oRep.boards.length; i++){
						var meta = oRep.boards[i];
						//CREATION DU LABEL////////////////////////////////////////////////////
						var unP = modelJP.clone().html("<b>"+meta.label+"</b>");
						var unLabel = modelJLabel.clone(true).append(unP);
						///////////////////////////////////////////////////////////////////////
						var uneTable = modelJTable.clone(true).append(unLabel)
							.data("label", meta.label); //On stocke le label dans le div.
						$("#content").append(uneTable);
					}
				}

			)

		});

	</script>

	<style>
		#content{
			background-color: lightblue;
			display: flex;
		}
		.tables{
			background-color: orange;
			width: 300px;
			height: 450px;
			border: black 2px solid;
			margin: 20px;
		}
	</style>
</header>

<body>
	<div class="container" id="content">
	</div>
</body>