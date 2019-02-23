<?php
include("../header.html");
?>

<header>
	<script type="text/javascript">

		$(document).ready(function(){
			//LES MODELES//////////////////////////////////////////
			var modelJTable = $("<div class='tables col-sm-2 shadow bg-white text-center rounded border border-dark'>");
			var modelJLabel = $("<div class='title border border-right-0 border-left-0 border-top-0 border-dark'>");
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
			overflow: auto; 
		}
		.tables{		
			height: 450px;
			margin: 10px;
			padding: 0;
			min-width: 70px;
		}
		.title{
			width: 100%;
			font-size: auto;
		}
	</style>
</header>

<body>
	<div class="container" id="content">

	</div>
</body>