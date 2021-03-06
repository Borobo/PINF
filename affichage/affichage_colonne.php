<?php
include ("../unHeader.php");
?>

<head>
    <script>
    //var modelJTable = $("<div class='tables shadow text-center rounded border border-dark'>");
    var modelJLabel = $("<div>");
    var modelJData = $("<div class='container-fluid container-colonnes'>");
    var modelJP = $("<p>");
    var modelJColonne = $("<div class='colonnes text-center'>");
    var modelJColonneCanvas = $("<div class='container border border-danger'>");
    var modelJTable = $("<div class=\"tables\">");
    var modelJLabCol = $("<div class='card-body text-left'>");
    var modelJBtn = $("<a class='onglet rounded-top'></a>");
    var modelJImg = $("<img src=''>");
    var modelJCheckbox = $("<input type=checkbox class='form-check-input'>");
    var modelJTA = $("<textarea> </textarea>");


    function creationPopUp(){
        var popup = $("<div id='popup'>");
        var content = $("<div class='modal-content'>");
        var header = $("<div class='modal-header'>").append($("<h4>").html("Ajouter des données"));
        var body = $("<div class='modal-body'>");
        var footer = $("<div class='modal-footer'>");
        var confirm = $("<button class='btn btn-success'>Confirmer</button>");
        var cancel = $("<button class='btn btn-danger' id='popup-Annuler'>Annuler</button>");

        footer.append(confirm).append(cancel);

        content.append(header).append(body).append(footer);
        popup.append(content);
        $("body").append(popup);
    }

    function addColPopup(label, idCol, type){
        var div = $("<div class='popup-col'>");
        var title = $("<p>").html(label);
        if(type == "Texte")
            var input = $("<input type=\"text\" />").data("idCol", idCol);
        else
            var input = $("<input type=\"number\" />").data("idCol", idCol);
        div.append(title).append(input);
        $(".modal-body").append(div);
    }

    /*///////////////affichageData()////////////////////////////////////////////////////////////
    *  Récupère les colonnes de la table sélectionné
    *  Puis récupère les data de chaque colonne
    *  Ecrit sur la page les colonnes et les data de la table
    */
    function affichageData(){
        creationPopUp();
        $(".popup-ajout").hide();
      $("#container-table").empty();
      //On récupère la table
      $.getJSON("../data.php",{
        action:"getLaTable"},function(oRep){
          var meta = oRep.tab[0];
          //CREATION DU LABEL////////////////////////////////////////////////////
          var unP = modelJP.clone();
          var unLabel = modelJLabel.clone(true);

          var lesData = modelJData.clone(true);
          var uneTable = modelJTable.clone(true).append(unLabel)
              .data("label", meta.label); //On stocke le label dans le div.
          //On récupère les colonnes de la table
          $.getJSON("../data.php", {
                  action : "getColonnes",
                  idTable : meta.id
              },
              function(oCol){
                  for(var j=0; j<oCol.colonnes.length; j++){
                      (function(j){
                      var meta2 = oCol.colonnes[j];
                      addColPopup(meta2.label, meta2.id, meta2.type);
                      //CREATION DUNE COLONNE/////////////////
                      var colP = modelJP.clone(true).html(meta2.label).attr("class","labCol").css("font-weight","bold").css('font-size', '12pt');;
                      var unLabelCol = modelJLabCol.clone(true).append(colP).data("idColonne",meta2.id);

                      var uneColonne = modelJColonne.clone(true).append(unLabelCol).data("idColonne",meta2.id);

                      //On récupère les data de chaque colonne
                      $.getJSON("../data.php",{
                        action:"getData",
                        idColonne:meta2.id},function(oData){
                          var k,meta3;

                          for(k=0; k<oData.data.length; k++){
                            var dataP = modelJP.clone();
                            meta3=oData.data[k];
                            if(meta3.valInt == null){
                                if(k%2==0)
                                    dataP.html(meta3.valChar).attr("class","data").data("idColonne",meta2.id).data("valChar",meta3.valChar).data("idData",meta3.id).data("valInt",null).data("position",k);
                                else
                                    dataP.html(meta3.valChar).attr("class","data data-2").data("idColonne",meta2.id).data("valChar",meta3.valChar).data("idData",meta3.id).data("valInt",null).data("position",k);

                                    unLabelCol.append(dataP).data("valInt",0);
                            }
                            else{
                                if(k%2==0)
                                    dataP.html(meta3.valInt).attr("class","data").data("idColonne",meta2.id).data("valInt",meta3.valInt).data("idData",meta3.id).data("valChar",null).data("position",k);
                                else
                                    dataP.html(meta3.valInt).attr("class","data data-2").data("idColonne",meta2.id).data("valInt",meta3.valInt).data("idData",meta3.id).data("valChar",null).data("position",k);
                              unLabelCol.append(dataP).data("valInt",1);
                            }
                          }
                          lesData.append(uneColonne);

                        });

                  })(j)
                }
              }

          );
          uneTable.append(lesData);
          $("#container-table").append(uneTable);
        })
    }
    /////////////////////FIN affichageData()///////////////////////////////////////////////////////////////////

    /////////////////////Demarrage de la page affichage_colonne.php////////////////////////////////////////////
    $(document).ready(function(){
      //Onglets permettant de passer d'une table à l'autre dans affichage_colonne.php
      $.getJSON("../data.php",{
          action:"getTables"},function(oRep){
            var i;
            for(i=0; i<oRep.boards.length; i++){
              //btn (contenant l'id de la table) redirigeant vers la table souhaité
              var unBtn = modelJBtn.clone(true).html(oRep.boards[i].label).data("idTable",oRep.boards[i].id).attr("href","affichage_colonne.php");
              //On ajoute la classe .active si l'onglet correspont à la table affichée
              if(oRep.idTable == oRep.boards[i].id) unBtn.addClass('active');
              $("#div-onglet").append(unBtn);

            }

          });
          var barre = $("<div class='input-group'></div>").append("<input id='recherche' type='text' class='form-control' name='recherche' placeholder='Barre de recherche'>");

          $("#nomTab").after(barre);
          //affichage des colonnes et des data de la table
          affichageData();

          $("#Compter").data("activation",0);
          $(".mesure").data("activation",0)

    });
/////////////////////FIN Demarrage de la page affichage_colonne.php////////////////////////////////////////////

/////////////////////Redirection vers la table souhaité dans affichage_colonne/////////////////////////////////
  $(document).on("click",".onglet",function(){

    $.getJSON("../data.php",{
      action:"stockIdTable",
      id:$(this).data("idTable")
    },function(){
    });
/////////////////////FIN Redirection vers la table souhaité dans affichage_colonne/////////////////////////////
  });

/////////////////////Activation de la fonction suppression des data////////////////////////////////////////////
  $(document).on("click","#Supprimer",function(){
      $("#Supprimer").attr("class","btn btn-success");
      $(".btn-light").each(function(){
        $(this).addClass("disabled");
        $(this).removeAttr("id");
        if($(this).html() == "Maximum" | $(this).html() == "Minimum" | $(this).html() == "Moyenne") $(this).removeClass("mesure");
      });

      //On refait l'affichage des data mais avec des checkbox poru pouvoir choisir les lignes à suppprimer////
      $("#container-table").empty();
      $.getJSON("../data.php",{
        action:"getLaTable"},function(oRep){
          console.log(oRep);
          var meta = oRep.tab[0];
          var unP = modelJP.clone();
          var unLabel = modelJLabel.clone(true);

          var lesData = modelJData.clone(true);
          var uneTable = modelJTable.clone(true).append(unLabel)
              .data("label", meta.label); //On stocke le label dans le div.

          $.getJSON("../data.php", {
                  action : "getColonnes",
                  idTable : meta.id
              },
              function(oCol){
                  console.log(oCol);
                  for(var j=0; j<oCol.colonnes.length; j++){
                      (function(j){
                      var meta2 = oCol.colonnes[j];
                      //CREATION DUNE COLONNE/////////////////
                      var colP = modelJP.clone(true).html(meta2.label).attr("class","labCol");
                      var unLabelCol = modelJLabCol.clone(true).append(colP);

                      var uneColonne = modelJColonne.clone(true).append(unLabelCol);

                      ////////////////////////////////////////
                      //Affichage des data
                      $.getJSON("../data.php",{
                        action:"getData",
                        idColonne:meta2.id},function(oData){
                          console.log(oData);
                          var k,meta3;

                          for(k=0; k<oData.data.length; k++){
                            //div contenant la croix suppression et la première data de la 1ère colonne

                            meta3=oData.data[k];
                            //On met une position sur chaque data pour savoir à quelle ligne elles correspondent pour simplifier la suppression des lignes
                            if(k%2==0)
                                var div = modelJLabel.clone().attr("class","data").data("idData",meta3.id).data("position",k);
                            else
                                var div = modelJLabel.clone().attr("class","data data-2").data("idData",meta3.id).data("position",k);
                            //checkbox
                            var check = $("<div class='form-check'></div>").append(modelJCheckbox.clone().data("idData",meta3.id).data("position",k));
                            var dataP = modelJP.clone();

                            if(meta3.valInt == null){
                              dataP.html(meta3.valChar);
                              //On met les checkbox sur la première colonne
                              if(j==0) div.append(check);
                              div.append(dataP);
                            }
                            else{
                              dataP.html(meta3.valInt);
                              //On met les checkbox sur la première colonne
                              if(j==0) div.append(check);
                              div.append(dataP);
                            }
                            unLabelCol.append(div);
                          }
                          lesData.append(uneColonne);

                        });

                  })(j)
                }
              }

          );
          uneTable.append(lesData);
          $("#container-table").append(uneTable);
          //Bouton annuler
          $(".container-colonnes").after($("<button type='button' class='btn btn-danger' id='Annuler'>Annuler</button>"));
          //Bouton pour confirmer la suppression après avoir checked les lignes
          $(".container-colonnes").after($("<button type='button' class='btn btn-info' id='Suppression'>Supprimer</button>"));

        });
        //FIN on refait l'affichage des data mais avec des checkbox pour pouvoir choisir les lignes à suppprimer////

  });
/////////////////////FIN Activation de la fonction suppression des data////////////////////////////////////////

/////////////////////Suppression des data dans la base de données/////////////////////////////////////////////
    $(document).on("click","#Suppression",function(){
      var pos;
          //On regarde quelles sont les checkbox qui sont checked
          $('.card-body input[type=checkbox]').each(function(){
            if($(this).prop('checked') == true){

              //On sauveguarde la position de la ligne qu'on veut supprimer
              pos = $(this).data("position");

              //On vérifie la position sauveguarder avec la position de chaque data
              //Puis on supprime dans la bdd
              $('.card-body .data').each(function(){
                 if($(this).data("position") == pos){

                   $.getJSON("../data.php",{
                     action:"delData",
                     idData:$(this).data("idData")},function(oRep){
                     });
                 }

              });

            }

       });

       //Après avoir fait la suppression on réaffiche le tout
       affichageData();

       $("#Supprimer").attr("class","btn btn-light");

       $(".btn-light").each(function(){
         $( this).removeClass("disabled");
         if($(this).html() == "Gérer les doublons") $(this).attr("id","Doublons");
         else $(this).attr("id",$(this).html());
         if($(this).html() == "Maximum" | $(this).html() == "Minimum" | $(this).html() == "Moyenne") $(this).addClass("mesure");
       });

    });
/////////////////////FIN Suppression des data dans la base de données/////////////////////////////////////////


/////////////////////Activation de la fonction modification des data/////////////////////////////////////////
    $(document).on("click","#Modifier",function(){
      $("#Modifier").attr("class","btn btn-success");
      $(".btn-light").each(function(){
        $(this).addClass("disabled");
        $(this).removeAttr("id");
        if($(this).html() == "Maximum" | $(this).html() == "Minimum" | $(this).html() == "Moyenne") $(this).removeClass("mesure");
      });
      $(".data").attr("class","dataModifiable");

      $(".modif").css("display","none");
      $(".container-colonnes").after($("<button type='button' class='btn btn-danger modif' id='Annuler'>Annuler</button>"));
      $(".container-colonnes").after($("<button type='button' class='btn btn-info modif' id='ConfirmModif'>Confimer modification</button>"));

    });
/////////////////////FIN Activation de la fonction modification des data/////////////////////////////////////


/////////////////////Modification d'une data en cliquant dessus/////////////////////////////////////////////
    $(document).on("click",".dataModifiable",function(){
        //variable du textarea
       var nextTA;
       //On regarde si le data est un charactère ou un nombre puis on remplace le paragraphe par un textarea
       if($(this).data("valChar") != null)
        nextTA = modelJTA.clone().val($(this).html()).data("idData",$(this).data("idData")).data("valChar",$(this).data("valChar")).data("valInt",null);
       else
        nextTA = modelJTA.clone().val($(this).html()).data("idData",$(this).data("idData")).data("valInt",$(this).data("valInt")).data("valChar",null);

       $(this).replaceWith(nextTA);
    });
/////////////////////FIN Modification d'une data en cliquant dessus////////////////////////////////////////

/////////////////////Appui sur la touche entrée ou echap dans le textarea//////////////////////////////////
    $(document).on("keydown",
        ".card-body textarea",
        function (contexte){
            if (contexte.which == 13) { // 13 <=> touche ENTREE
              var nextP;
              // restaurer le paragraphe avec sa nouvelle valeur en fonction du type de data (charactère ou nombre)
              if($(this).data("valChar") != null)
                nextP = modelJP.clone().html($(this).val()).attr("class","dataModifiable").data("idData",$(this).data("idData")).data("valChar",$(this).val()).data("valInt",null).css("background-color","lightgreen");
              else
                nextP = modelJP.clone().html($(this).val()).attr("class","dataModifiable").data("idData",$(this).data("idData")).data("valInt",$(this).val()).data("valChar",null).css("background-color","lightgreen");

              $(this).replaceWith(nextP);

            }
            if (contexte.which == 27) {	// 27 <=> touche ESCAPE
                // restaurer le paragraphe avec son ancienne valeur
               $(".card-body textarea").each(function(){
                    var nextP = modelJP.clone().attr("class","dataModifiable").html($(this).val());
                    $(this).replaceWith(nextP);
                });
            }

        });
/////////////////////FIN Appui sur la touche entrée ou echap dans le textarea//////////////////////////////

/////////////////////Modification des data dans la base de données/////////////////////////////////////////
    $(document).on("click","#ConfirmModif",function(){
          //On regarde chaque data on modifie la base de donnée avec leur valeur
          $(".dataModifiable").each(function(){
            //On modifie la data si c'est un charactère ou un nombre
            if($(this).data("valChar") != null){
              $.getJSON("../data.php",{
                action:"majDataChar",
                idData:$(this).data("idData"),
                valChar:$(this).data("valChar")},function(oRep){
                });
            }
            else{
              $.getJSON("../data.php",{
                action:"majDataInt",
                idData:$(this).data("idData"),
                valInt:$(this).data("valInt")},function(oRep){
                });
            }
            $("#Modifier").attr("class","btn btn-light");
            $(".alert-info").empty();
          });

          //On réaffiche les data après avoir modifier la base de données
          affichageData();

          $(".btn-light").each(function(){
            $( this).removeClass("disabled");
            if($(this).html() == "Gérer les doublons") $(this).attr("id","Doublons");
            else $(this).attr("id",$(this).html());
            if($(this).html() == "Maximum" | $(this).html() == "Minimum" | $(this).html() == "Moyenne") $(this).addClass("mesure");
          });
      });
/////////////////////FIN Modification des data dans la base de données/////////////////////////////////////////


/////////////////////Annuler la fonction sélectionné//////////////////////////////////////////////////////////
      $(document).on("click","#Annuler",function(){
          $(".btn-light").each(function(){
            $( this).removeClass("disabled");
            if($(this).html() == "Gérer les doublons") $(this).attr("id","Doublons");
            else $(this).attr("id",$(this).html());
            if($(this).html() == "Maximum" | $(this).html() == "Minimum" | $(this).html() == "Moyenne") $(this).addClass("mesure");
          });
          affichageData();
          $("#Supprimer").attr("class","btn btn-light");
          $("#Modifier").attr("class","btn btn-light");
          $("#Copier").attr("class","btn btn-light");
      });

      $(document).on('click', '#popup-Annuler', function(event) {
          $("#popup").remove();
          affichageData();

      });
/////////////////////FIN Annuler la fonction sélectionné//////////////////////////////////////////////////////

/////////////////////Activation de la fonction pour compter les data//////////////////////////////////////////
      $(document).on("click","#Compter",function(){
          //On regarde d'abord si on active ou on désactive la fonction compter
          if($(this).data("activation") == 0){
            $(this).attr("class","btn btn-success");
            $(this).data("activation",1);
            $(".card-body").attr("class","card-body text-left compter");
            $(".btn-light").each(function(){
              $(this).addClass("disabled");
              $(this).removeAttr("id");
              if($(this).html() == "Maximum" | $(this).html() == "Minimum" | $(this).html() == "Moyenne") $(this).removeClass("mesure");
            });
          }
          else{
            $(".btn-light").each(function(){
              $(this).removeClass("disabled");
              $(this).attr("id",$(this).html());
              if($(this).html() == "Maximum" | $(this).html() == "Minimum" | $(this).html() == "Moyenne") $(this).addClass("mesure");
            });
            $(this).attr("class","btn btn-light");
            $(this).data("activation",0);
            $(".card-body").attr("class","card-body text-left");
            $(".divInfo").css("display","none");
          }
      });
/////////////////////FIN Activation de la fonction pour compter les données//////////////////////////////////

/////////////////////Clique sur une colonne pour savoir son nombre de données////////////////////////////////
      $(document).on("click",".compter",function(){

          var NbData,labelColonne,idColonne,info,div,img,btn;
          idColonne = $(this).data('idColonne');
          NbData = 0;
          $(".data").each(function(){
            if($(this).data("idColonne") == idColonne){
                if($(this).html() != "")
                    NbData += 1;
            }
          });

          //On récupère le label de la colonne
          $.getJSON("../data.php",{
            action:"getLaColonne",
            idColonne:$(this).data("idColonne")},function(oRep){
              labelColonne = oRep.colonne[0].label;

              //On affiche le résultat dans un div contenant un message et un bouton suppression
              div = modelJLabel.clone().attr("class","divInfo").data("idColonne",idColonne);
              if(NbData > 1)
                info = modelJLabel.clone().attr("class","alert alert-info").html("La colonne <strong>"+labelColonne+"</strong> contient <strong>"+NbData+"</strong> données.");
              else
              info = modelJLabel.clone().attr("class","alert alert-info").html("La colonne <strong>"+labelColonne+"</strong> contient <strong>"+NbData+"</strong> donnée.");
              btn = $("<button class='btn btn-dark croix'>X</button>").data("idColonne",idColonne)
              .css("height","52px").css("width","45px").css("margin-left","5px").css("font-size","20");

              //Si le message existe déjà on le supprime pour le réaffiché en première ligne
              $(".divInfo").each(function(){
                if($(this).data("idColonne") == idColonne)
                  $(this).css("display","none");
              });

              div.append(info).append(btn).css("margin","5px").css("display","flex");
              $(".container-colonnes").after(div);
            });

      });
/////////////////////FIN Clique sur une colonne pour savoir son nombre de données////////////////////////////


/////////////////////Supprimer un message informant le nombre de données d'une colonne///////////////////////
      $(document).on("click",".croix",function(){

        var idCroix = $(this).data("idColonne");

        $(".divInfo").each(function(){
          if(idCroix == $(this).data("idColonne"))
            $(this).css("display","none");

        });

      });
/////////////////////FIN Supprimer un message informant le nombre de données d'une colonne///////////////////

/////////////////////Clique sur une fonction compter,maximum,minimum,moyenne////////////////////////////////
    $(document).on("click",".mesure",function(){
      //On vérifie si on active ou on désactive la fonction
      if($(this).data("activation") == 0){
        $(this).data("activation",1);
        $(this).attr("class","btn btn-success mesure");

        $(".card-body").each(function(){
          if($(this).data("valInt"))
            $(this).addClass("mesurable");
        });

        //On fait en sorte de désactivé les fonctions autres que celle sélectionné
        $(".btn-light").each(function(){
          $(this).addClass("disabled");
          if($(this).html() == "Maximum" | $(this).html() == "Minimum" | $(this).html() == "Moyenne") $(this).removeClass("mesure");
          $(this).removeAttr("id");
        });
      }
      else{
        //On fait en sorte de réactivé les fonctions qui ont été désactivé pendant l'utilisation d'une autre fonction
        $(".btn-light").each(function(){
          $(this).removeClass("disabled");
          if($(this).html() == "Maximum" | $(this).html() == "Minimum" | $(this).html() == "Moyenne") $(this).addClass("mesure");
          if($(this).html() == "Gérer les doublons") $(this).attr("id","Doublons");
          else $(this).attr("id",$(this).html());
        });
        $(this).data("activation",0);
        $(this).attr("class","btn btn-light mesure");
        $(".card-body").each(function(){
          $(this).attr("class","card-body text-left");
        });
          $(".divInfo").css("display","none");
      }
    });
/////////////////////FIN Clique sur une fonction compter,maximum,minimum,moyenne////////////////////////////

/////////////////////Clique sur la fonction maximum////////////////////////////////////////////////////////
    $(document).on("click","#Maximum",function(){
      if($(this).data("activation")){
        $(".card-body").each(function(){
          if($(this).data("valInt"))
            $(this).addClass("max");
        });
      }
    });
/////////////////////FIN Clique sur la fonction maximum////////////////////////////////////////////////////

/////////////////////Clique sur la fonction minimum///////////////////////////////////////////////////////
    $(document).on("click","#Minimum",function(){
      if($(this).data("activation")){
        $(".card-body").each(function(){
          if($(this).data("valInt"))
            $(this).addClass("min");
        });
      }
    });
/////////////////////FIN Clique sur la fonction minimum///////////////////////////////////////////////////

/////////////////////Clique sur la fonction moyenne//////////////////////////////////////////////////////
    $(document).on("click","#Moyenne",function(){
      if($(this).data("activation")){
        $(".card-body").each(function(){
          if($(this).data("valInt"))
            $(this).addClass("moy");
        });
      }
    });
/////////////////////FIN Clique sur la fonction moyenne//////////////////////////////////////////////////

/////////////////////Clique sur une colonne pour connaitre son maximum//////////////////////////////////
    $(document).on("click",".max",function(){
      var idColonne = $(this).data("idColonne");
      var max = null;
      //On récupère la valeur max de la colonne
      $(".data").each(function(){
        if(idColonne == $(this).data("idColonne")){
          if(max == null)
            max = $(this).html();
          else if($(this).html() > max) max = $(this).html();
        }
      });

      //On récupère le label de la colonne
      $.getJSON("../data.php",{
        action:"getLaColonne",
        idColonne:$(this).data("idColonne")},function(oRep){
          labelColonne = oRep.colonne[0].label;

          //On affiche le résultat dans un div contenant un message et un bouton suppression
          div = modelJLabel.clone().attr("class","divInfo").data("idColonne",idColonne);
          info = modelJLabel.clone().attr("class","alert alert-info").html("Le maximum de la colonne <strong>"+labelColonne+"</strong> est <strong>"+max+"</strong>.");
          btn = $("<button class='btn btn-dark croix'>X</button>").data("idColonne",idColonne).css("height","52px").css("width","45px").css("margin-left","5px").css("font-size","20");

          //Si le message existe déjà on le supprime pour le réaffiché en première ligne
          $(".divInfo").each(function(){
            if($(this).data("idColonne") == idColonne)
              $(this).css("display","none");
          });

          div.append(info).append(btn).css("margin","5px").css("display","flex");
          $(".container-colonnes").after(div);
        });

    });
/////////////////////FIN Clique sur une colonne pour connaitre son maximum//////////////////////////////

/////////////////////Clique sur une colonne pour connaitre son minimum/////////////////////////////////
    $(document).on("click",".min",function(){

      var idColonne = $(this).data("idColonne");
      var min = null;
      //On récupère la valeur minimum de la colonne
      $(".data").each(function(){
        if(idColonne == $(this).data("idColonne")){
          if(min == null)
            min = $(this).html();
          else if($(this).html() < min) min = $(this).html();
        }
      });

      //On récupère le label de la colonne
      $.getJSON("../data.php",{
        action:"getLaColonne",
        idColonne:$(this).data("idColonne")},function(oRep){
          labelColonne = oRep.colonne[0].label;

          //On affiche le résultat dans un div contenant un message et un bouton suppression
          div = modelJLabel.clone().attr("class","divInfo").data("idColonne",idColonne);
          info = modelJLabel.clone().attr("class","alert alert-info").html("Le minimum de la colonne <strong>"+labelColonne+"</strong> est <strong>"+min+"</strong>.");
          btn = $("<button class='btn btn-dark croix'>X</button>").data("idColonne",idColonne).css("height","52px").css("width","45px").css("margin-left","5px").css("font-size","20");

          //Si le message existe déjà on le supprime pour le réaffiché en première ligne
          $(".divInfo").each(function(){
            if($(this).data("idColonne") == idColonne)
              $(this).css("display","none");
          });

          div.append(info).append(btn).css("margin","5px").css("display","flex");
          $(".container-colonnes").after(div);
        });
    });
/////////////////////FIN Clique sur une colonne pour connaitre son minimum/////////////////////////////

/////////////////////Clique sur une colonne pour connaitre sa moyenne/////////////////////////////////
    $(document).on("click",".moy",function(){

      var idColonne = $(this).data("idColonne");
      var som = 0;
      var moy;
      var nbData = 0;
      //On récupère la valeur moyenne de la colonne
      $(".data").each(function(){
        if(idColonne == $(this).data("idColonne")){
            som = parseInt(som) + parseInt($(this).html());
            nbData += 1;
        }
      });
      moy = som/nbData;

      //On récupère le label de la colonne
      $.getJSON("../data.php",{
        action:"getLaColonne",
        idColonne:$(this).data("idColonne")},function(oRep){
          labelColonne = oRep.colonne[0].label;

          //On affiche le résultat dans un div contenant un message et un bouton suppression
          div = modelJLabel.clone().attr("class","divInfo").data("idColonne",idColonne);
          info = modelJLabel.clone().attr("class","alert alert-info").html("La moyenne de la colonne <strong>"+labelColonne+"</strong> est <strong>"+moy+"</strong>.");
          btn = $("<button class='btn btn-dark croix'>X</button>").data("idColonne",idColonne).css("height","52px").css("width","45px").css("margin-left","5px").css("font-size","20");

          //Si le message existe déjà on le supprime pour le réaffiché en première ligne
          $(".divInfo").each(function(){
            if($(this).data("idColonne") == idColonne)
              $(this).css("display","none");
          });

          div.append(info).append(btn).css("margin","5px").css("display","flex");
          $(".container-colonnes").after(div);
        });
    });
/////////////////////FIN Clique sur une colonne pour connaitre sa moyenne/////////////////////////////

/////////////////////Fonction gérer les doublons/////////////////////////////////////////////////////
  $(document).on("click","#Doublons",function(){

  $(".colonnes").each(function(){
    $(this).addClass("doublons");
  });

  div = modelJLabel.clone().attr("class","divInfo modif");
  info = modelJLabel.clone().attr("class","alert alert-info").html("Sélectionnez les colonnes où les doublons doivent être enlevés");
  info2 = modelJLabel.clone().attr("class","alert alert-info").html("Ne rien sélectionner pour enlever les doublons de toutes les colonnes");
  div.append(info).append(info2).css("margin","5px");

  $(".container-colonnes").after(div);
  });
/////////////////////FIN Fonction gérer les doublons/////////////////////////////////////////////////

/////////////////////Clique sur une colonne pour enlever ses doublons (PAS FINIE)////////////////////
  $(document).on("click",".doublons",function(){

    var idCol = $(this).data("idColonne");
    var valData,position;
    var i=0;
    $(".data").each(function(){
      $(this).data("flag",0);
      if(idCol == $(this).data("idColonne")){
        valData = $(this).html();
        position = $(this).data("position");
        $(this).data("flag",1);
        $(".data").each(function(){

          i = i+1;
          if(idCol == $(this).data("idColonne") && valData == $(this).html() && ($(this).data("flag") == undefined || $(this).data("flag") == 0)){
          }
        });
      }
    });
  });
/////////////////////FIN Clique sur une colonne pour enlever ses doublons (PAS FINIE)////////////////

/////////////////////Fonction copier une ou plusieurs lignes////////////////////////////////////////
    $(document).on("click","#Copier",function(){

      $("#Copier").attr("class","btn btn-success");
      $(".btn-light").each(function(){
        $(this).addClass("disabled");
        $(this).removeAttr("id");
        if($(this).html() == "Maximum" | $(this).html() == "Minimum" | $(this).html() == "Moyenne") $(this).removeClass("mesure");
      });

      $(".data").addClass("dataCopiable").data("copie","0");

      $(".modif").css("display","none");

      $(".container-colonnes").after($("<button type='button' class='btn btn-danger modif' id='Annuler'>Annuler</button>"));
      $(".container-colonnes").after($("<button type='button' class='btn btn-info modif' id='ConfirmCopie'>Confimer copie</button>").css("margin","5px"));

      div = modelJLabel.clone().attr("class","divInfo modif");
      info = modelJLabel.clone().attr("class","alert alert-info").html("Cliquez sur les lignes à copier");
      div.append(info).css("margin","5px").css("display","flex");

      $(".container-colonnes").after(div);

    });
/////////////////////FIN Fonction copier une ou plusieurs lignes////////////////////////////////////

/////////////////////Clique sur la ligne à copier//////////////////////////////////////////////////
    $(document).on("click",".dataCopiable",function(){

      var pos = $(this).data("position");

      $(".dataCopiable").each(function(){
        if(pos == $(this).data("position")){
          if($(this).data("copie") == 0){
            $(this).css("background-color","yellow");
            $(this).data("copie","1");
          }

          else{
            $(this).css("background-color","rgb(134, 138, 143)");
            $(this).data("copie","0");
          }
        }
      });
    });
/////////////////////Clique sur la ligne à copier//////////////////////////////////////////////////

/////////////////////Confirmation copie des lignes/////////////////////////////////////////////////
    $(document).on("click","#ConfirmCopie",function(){
      var text="";
      nbData = 0;
      var i = 0;
      var flag = 0;

        $(".dataCopiable").each(function(){
          nbData = $(this).data("position");
        });
        //ON récupère les valeurs de chaque élément de la ligne
        for(i=0;i<=nbData;i++){
           $(".dataCopiable").each(function(){
              if(i == $(this).data("position")){
                if($(this).data("copie") == 1){
                  if(flag == 0) text = text + $(this).html();
                  else text = text + " " + $(this).html();
                  flag=1;
                }
              }
           });
           if(flag == 1) text = text + "\n";
          flag = 0;
        }


        //on crée un textarea invisible avec le texte a copier pour l'enregistrer dans le presse papier
        var $temp = $("<textarea>");
        $(".container-colonnes").after($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();

        //ON réactive les boutons des autres fonctions à la fin de celle ci
        $("#Copier").attr("class","btn btn-light");
        $(".btn-light").each(function(){
          $( this).removeClass("disabled");
          if($(this).html() == "Gérer les doublons") $(this).attr("id","Doublons");
          else $(this).attr("id",$(this).html());
          if($(this).html() == "Maximum" | $(this).html() == "Minimum" | $(this).html() == "Moyenne") $(this).addClass("mesure");
        });
        $(".data").removeClass("dataCopiable").css("background-color","rgb(134, 138, 143)");

        $(".modif").remove();
    });
/////////////////////FIN Confirmation copie des lignes/////////////////////////////////////////////

    $(document).on("click","#ajouter", function(){
        $("#popup").fadeToggle(100,'swing');
    })

    $(document).on('click', '#popup .btn-success', function(event) {
        $(".modal-body div").each(function(){
            console.log($(this));
            input = $(this).children('input');
            val = input.val();
            console.log(input);
            console.log(val);
            $.ajax({
                url: '../data.php',
                async : false,
                data: {
                    action: 'addLigne',
                    idCol: input.data("idCol"),
                    newVal: val
                }

            })
            .done(function() {
            })

        });
        $("#popup").remove();
        affichageData();
    });

/////////////////////Fonction recherche selon un mot/////////////////////////////////////////////
    $(document).on("keyup",
    "#recherche",
    function (contexte){
      //Lorsque l'on appuie sur entré après avoir tapé un mot dans la barre de recherche on lance la fonction
      if(contexte.which == 13){
        //Bulle informative pour quitter la fonction de recherche
        div = modelJLabel.clone().attr("class","divInfo modif");
        info = modelJLabel.clone().attr("class","alert alert-info").html("Appuyez sur Echap pour annuler la recherche");
        div.append(info).css("margin","5px");
        $(".divInfo").empty();
        $(".container-colonnes").after(div);

        //ON enregistre les position des mots correspondant à la recherche
        var val=$("#recherche").val();
        var position = [];
        $(".data").each(function(){
          var data = $(this).html();
          reg = new RegExp(val);
          if(reg.test(data)) position.push($(this).data("position"));

        });
        var flag = 0;
        //On fait un display:none pour toutes les lignes n'ayant pas la position enregistrée
        $(".data").each(function(){
          flag = 0;
          for(var i=0; i<position.length; i++){
            if(position[i] == $(this).data("position")) flag = 1;
          }
          if(flag == 0) $(this).css("display","none");
        });
      }

      //L'appuie sur Echap fais quitter la fonction et on réaffiche toutes les data
      if(contexte.which == 27){
        $("#recherche").val("");
        affichageData();
      }

    });
/////////////////////FIN Fonction recherche selon un mot/////////////////////////////////////////

    </script>

    <style>
    /*    .test{
            background-color: yellow;
        }*/

        #content{
            display: flex;
            position: relative;
            height: 100%;
            overflow-y: hidden;
          }

        #container-fonction{
            background-color: rgb(100, 170, 255);
            height: 100%;
            min-width: 200px;
            display: flex;
            flex-direction: column;
          }

        .container-colonnes{
              position: absolute;
          }

        #affichage{
            background-color: rgb(86, 190, 143);
            height: 100%;
            flex-grow: 1;
          }

        #container-table{
            background-color: rgba(70, 125, 247, 0.77);
            width: 100%;
            height: 100%;
          }

        #nomTab{
            height: 50px;
            display: flex;
            position: relative;
          }

        .btn-info{
            margin-right: 10px;
            margin-top:5px;
            min-width:100px;
            height:40px;
            }

          .btn-danger{
              margin-right: 10px;
              margin-top:5px;
              min-width:100px;
              height:40px;
              }

          .tables:first-child{
              display: block !important;
          }



          .tables
          {
              height: 100%;
              width: 100%;
              position: relative;
              //background-color: red;
          }

          .colonnes{
              position: relative;
              height: 350px;
              margin: 0;
              font-size: 9pt;
              background-color: #dfe3e6;
              white-space: normal;
              min-width: 200px;
              display: flex;
          }

          .container-colonnes{
              position: relative;
              display: flex;
              margin: auto;
          }

          .btn-light{
            margin-bottom: 30px;
            width: 180px;
            height: 50px;
            margin-left: 7px;
          }
          .btn-success{
            margin-bottom: 30px;
            width: 180px;
            height: 50px;
            margin-left: 7px;
          }

          .data:first-child{
            margin-top:20px;
          }

          .data{
            text-align: center;
            margin-bottom:10px;
            display:flex;
          }

          .data p{
            margin-left:10px;
          }

          .labCol{
            text-align: center;
          }

          .onglet{
              background-color: rgba(119, 159, 250, 0.77);
              margin: 0px 5px;
              height: 20px;
              min-width: 20px;
              width: auto;
              padding: 7px;
              color: white;
              text-decoration: none;
          }

          .onglet:hover{
            text-decoration: none;
            color: white;
            background-color: rgba(70, 125, 247, 1);
          }

          #div-onglet{
              position: absolute;
              bottom: 5;
              min-width: 200px;
          }

          .dataModifiable:hover{
            cursor:text;
          }

          .dataModifiable{
            background-color: lightgrey;
            height:25px;
        }
        .dataCopiable{
          background-color: lightgrey;
          height:25px;
        }
        .dataCopiable:hover{
          cursor:pointer;
        }

      .active{
        background-color: rgba(70, 125, 247, 0.77);
        box-shadow: 1px 1px 5px rgba(0,0,0,0.17);
      }

      .compter:hover{
        background-color:lightgreen;
        cursor:pointer;
      }

      .alert-info{
        width: 750px !important;
        text-align:center;
      }
      .btn-excel{
          background-color: #fa6e6e;
          border-color: #fa6e6e;
      }
      .btn-excel:hover{
        background-color: #ec5050;
        border-color: #ec5050;
      }
      .data{
          background-color: rgb(134, 138, 143);
          width: 100%;
          height: 30px;
          line-height: 30px;
          margin-bottom: 0;
      }
      .data-2{
          background-color: rgb(172, 174, 177);
      }
      .card-body{
          padding: 0 !important;
      }
      .card-body:first-child{
          margin-top: 1.25em;
      }
      .mesurable{
        background-color: lightgreen;
      }
      .mesurable:hover{
        background-color: rgba(5, 100, 10, 60);
        cursor:pointer;
      }
      #popup{
          position: absolute;
          display: none;
          left: 50%;
          top: 50%;
          transform: translate(-50%,-50%);
          min-width: 500px;
          height: 300px;
      }
      .modal-body{
          display: flex;
      }
      .modal-body div{
          margin-right: 10px;
          text-align: center;
      }
      .doublons{
          cursor:pointer;
        }
        .doublons:hover{
            background-color: lightgreen;
        }


    </style>
</head>


<body>
  <div id="content">
    <div id="container-fonction"><br>
              <button type="button" class="btn btn-light" id="ajouter">Ajouter</button>
              <button type="button" class="btn btn-light" id="Supprimer">Supprimer</button>
              <button type="button" class="btn btn-light" id="Modifier">Modifier</button>
              <button type="button" class="btn btn-light" id="Copier">Copier</button>
              <button type="button" class="btn btn-light" id="Doublons">Gérer les doublons</button>
              <button type="button" class="btn btn-light" id="Compter">Compter</button>
              <button type="button" class="btn btn-light mesure" id="Moyenne">Moyenne</button>
              <button type="button" class="btn btn-light mesure" id="Minimum">Minimum</button>
              <button type="button" class="btn btn-light mesure" id="Maximum">Maximum</button>
    </div>
    <div id="affichage" class="container-fluide">
      <div id="nomTab">
          <div id="div-onglet"></div>
      </div>
      <div class="tables" id="container-table">
      </div>
    </div>
  </div>

</body>
