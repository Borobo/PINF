<?php
include("../unHeader.php");
?>

<head>
    <script>
        ///////MODELE////////////////////////////////////////////
        var modelJUser = $("<div class='user px-4'>");
        var modelJDroit = $("<select class='custom-select mx-5'>")
            .append(
                $("<option>").val("Admin").html("Admin")
            )
            .append(
                $("<option>").val("Utilisateur").html("Utilisateur")
            )
            .data("update",0).data("id",0);

        var modelAjouter = $("<button class='btn btn-group-sm mx-5 btn-secondary' id='add'>Ajouter</button>");
        ////////////////////////////////////////////////////////
        $(document).ready(function(){
            var i;
            $.getJSON("../data.php",{
                action : "getUsersNonBdd"
            }, function(oRep){
                for(i=0; i<oRep.users.length; i++){
                    meta = oRep.users[i];
                    var unUser = modelJUser.clone();
                    var unAjouter = modelAjouter.clone().data("id",meta.id);
                    //$("option[value='Utilisateur']").attr("selected", "true");
                    unUser.append($("<p>").html(meta.nom + " " + meta.prenom))
                        .append(unAjouter);
                    $("#selection-user").append(unUser);

                }
            })
        });

        $(document).on("click", "#add", function(){
                    $.getJSON("../data.php",{
                        action : "addUser",
                        idUser : $(this).data("id")
                    }, function(oRep){
                        console.log(oRep.feedback);
                        if(oRep.return){
                            var alertBox = $("<div class='alert alert-success'>")
                                .html("<strong>Ajouté !</strong> L'utilisateur a été ajouté à la BDD ");
                            $("body").append(alertBox);
                            setTimeout(function(){ alertBox.fadeOut("slow"); }, 3000);
                            window.location.reload();
                        }
                    })
        });
    </script>
    <style>
        .alert{
            position:absolute;
            bottom: 0;
            width: 100%;
        }
        .user{
            position: relative;
            height : 40px;
        //background-color: grey;
            display: flex;
            text-align: center;
            margin:20px 0;
        }
        .user:hover{
            background-color: rgba(99, 170, 255, 1);

        }
        .user p{
            line-height: 40px;
            display: flex;

        }
        .user select{
            position: relative;
            max-width: 125px;
            right: 0;
            position: absolute;
        }
        #selection{
            background-color: rgba(99, 170, 255, 0.75);
            position: absolute;
            top : 50%;
            left: 50%;
            transform : translate(-50%,-50%);
            min-width: 300px;
            min-height: 100px;
            text-align: center;
        }
        #selection-btn .btn{
            margin: 0 10px;
        }
        #selection-btn{
            margin: 10px 0;
        }
        .style-div{
            border-radius : 20px;
        }
    </style>
</head>

<body>
<div id="selection" class="style-div">
    <br>
    Utilisateurs
    <div id="selection-user"></div>

    <div id="selection-btn" class="mx-5">
        <br>
        <br>
        <a href="javascript:history.go(-1)"><button class="btn btn-group-sm btn-primary" id="validate">Terminé</button>
    </div>

</div>

</body>
