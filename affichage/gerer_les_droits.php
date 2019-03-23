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
    ////////////////////////////////////////////////////////
    $(document).ready(function(){
        var i;
        $.getJSON("../data.php",{
            action : "getUsersBdd"
        }, function(oRep){
            for(i=0; i<oRep.users.length; i++){
                meta = oRep.users[i];
                var unUser = modelJUser.clone();
                var unSelect = modelJDroit.clone().data("id",meta.id);
                //$("option[value='Utilisateur']").attr("selected", "true");
                unUser.append($("<p>").html(meta.nom + " " + meta.prenom))
                .append(unSelect)
                $("#selection-user").append(unUser);
                if(meta.admin == 0){
                     $("option[value='Utilisateur']:last").attr("selected","true");
                 }
                 if(meta.idUser == oRep.idUser){
                    unSelect.attr("disabled","true");
                 }
                 if(oRep.superadmin == 0){
                    if(unSelect.val()=="Admin"){
                        console.log($(this));
                        unSelect.attr("disabled","true");
                    }
                 }
            }
        })
    })

    $(document).on("change", "select", function(){
        $(this).data("update",1);
    })

    $(document).on("click", "#validate", function(){
        $(".user").each(function(){
            var leSelect = $(this).children("select");
            if(leSelect.data("update")==1){
                $.getJSON("../data.php",{
                    action : "updateGrade",
                    newGrade : leSelect.val(),
                    idUser : leSelect.data("id")
                }, function(oRep){
                    console.log(oRep.feedback);
                    if(oRep.return){
                        var alertBox = $("<div class='alert alert-success'>")
                        .html("<strong>Envoyé !</strong> Les mises à jour ont été éffectuées ");
                        $("body").append(alertBox);
                        setTimeout(function(){ alertBox.fadeOut("slow"); }, 3000);
                    }
                })
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
            <button class="btn btn-group-sm btn-primary" id="validate">Mettre à jour les droits</button>
            <button class="btn btn-group-sm btn-secondary">Renitialiser</button>
        </div>

     </div>

 </body>
