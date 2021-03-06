<?php
  session_start();
?>

<head>
    <title>Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../libs/bootstrap.css">

    <script src="../libs/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="../libs/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).on("click", "input[type=submit]", function(){
            console.log($("input[type=text]").val());
            console.log($("input[type=password]").val());
            $.getJSON("../data.php",
                {
                    action : "connexion",
                    identifiant : $("input[type=text]").val(),
                    password : $("input[type=password]").val()
                }, function(oRep){
                    console.log("Connecté : "+oRep.connecte);
                    console.log(oRep.feedback);
                })
        });
        $(document).ready(function () {
            var img = $("<img class='icon' src='./ressource/home.png'>");
            $("#header").append(img);
        });

        $(document).on("click","#deconnexion",function(){

            $.getJSON("../data.php",
                {action:'logout'},function(oRep){
                    console.log(oRep);
                });


        });
    </script>
</head>
<style>
    .header{
        height: 50px;
        background-color: #118d9e;
        border-bottom: #0f6674 5px solid;
    }
    .icon{
        height: 46px;
        width: 50px;
        background-color: red;
        position: absolute;
        top :0;
        left: 0;
    }
    .header p {
        margin-top: 6px;
        position : absolute;
        right : 0px;
    }

    .header img{
        margin-top: 7px;
        margin-left:5px;
        height: 30px;
        width: 30px;
    }

    #deconnexion {
        margin-top: -3px;
        margin-right: 5px;
    }

</style>
<body>
    <nav class="header navbar-static-top">
        <p>

          <?php if (isset($_SESSION['prenom'])){
            echo "Bonjour <u>".$_SESSION['prenom']."</u>, bienvenue !";}
                else
                    { echo "Vous êtes déconnecté ! ";
                    header("Location:../connexion/login.php");
                }
          ?>


          <a href="../connexion/login.php" class="btn btn-info" id="deconnexion">Déconnexion</a>
        </p>


        <a href="javascript:history.go(-1)">        <img src="ressource/back.png"></a>

    </nav>

</body>
