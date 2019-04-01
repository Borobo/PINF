<?php
session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../libs/bootstrap.css">

    <script src="../libs/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="../libs/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).on("click, keydown, keydown", "input[type=submit], input[type=password], input[type=text]", function(contexte){
            if(contexte.type == "click" || contexte.which == 13){
                $.getJSON("../data.php",
                {
                    action : "connexion",
                    identifiant : $("input[type=text]").val(),
                    password : $("input[type=password]").val()
                }, function(oRep){
                    console.log("Connecté : "+oRep.connecte);
                    console.log(oRep.feedback);
                    if(!oRep.connecte){
                        var alertBox = $("<div class='alert alert-danger'>")
                            .html("<strong>Alerte</strong> : Identifiant ou mot de passe incorrect");
                        $(".alert").remove();
                        $("body").append(alertBox);
                        setTimeout(function(){ alertBox.fadeOut("slow"); }, 5000);
                    } else {
                        <?php
                        if(isset($_SESSION["connecte"]) && $_SESSION["connecte"])
                            header('Location:../affichage/affichageBDD.php');

                            //header('Location:../affichage/test.php');
                        ?>
                        window.location.reload();
                    }

                })
            }
        });


    </script>
</head>
<body>

<div class="jumbotron text-center">
    <h1>DBLOCK</h1>
    <p>Formulaire de connexion</p>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-4">

        </div>
        <div class="col-sm-4 jumbotron text-center alert-dark">
                <h1>Formulaire</h1><br>
                    <input type="text" placeholder="Nom d'utilisateur" name="identifiant" required><br><br><!-- le required permet d'être obligé de rentrer une donnée-->

                    <input type="password" placeholder="Mot de passe" name="password" required><br><br>

                    <input type="submit" id='submit' value='Connexion'>

        </div>
        <div class="col-sm-4">
        </div>
    </div>
</div>

</body>
</html>
