<?php
include ("../header.html");
?>

<head>
    <script>

    </script>

    <style>
      #content{
        display: flex;
        position: relative;
        height: 100%;
        overflow-y: hidden;
      }
      #container-fonction{
        background-color: rgb(111, 176, 185);
        height: 100%;
        width: 200px;
      }
      #affichage{
        background-color: rgb(86, 190, 143);
        height: 100%;
        flex-grow: 1;
      }
      #container-table{
        background-color: rgb(50, 80, 50);
        width: 100%;
        margin-top: 50px;
        height: 100%;
      }
    </style>
</head>


<body>
  <div id="content">
    <div id="container-fonction"></div>
    <div id="affichage" class="container-fluide">
      <div class="tables" id="container-table"></div>
    </div>
  </div>
</body>
