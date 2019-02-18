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
        $(document).on("click", "input[type=submit]", function(){
            console.log($("input[type=text]").val());
            console.log($("input[type=password]").val());
            $.getJSON("../data.php", 
            {
                action : "connexion",
                identifiant : $("input[type=text]").val(),
                password : $("input[type=password]").val()
            }, function(oRep){
                console.log(oRep.feedback);
            })
        })
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

                <input type="text" placeholder="Nom d'utilisateur" name="username" required><br><br><!-- le required permet d'être obligé de rentrer une donnée-->

                <input type="password" placeholder="Mot de passe" name="password" required><br><br>

                <input type="submit" id='submit' value='Connexion'>
        </div>
        <div class="col-sm-4">
        </div>
    </div>
</div>

</body>
</html>
