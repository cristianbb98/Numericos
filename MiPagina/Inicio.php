<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    *{
      box-sizing: border-box;
    }
    .header{
      background-color: #f1f1f1;
      padding: 1px;
      text-align: center;
      /* font-size: 35px; */
    }
    .column{
      float: left;
      padding: 10px;
      height: 300px;
      text-align: center;
    }
    .column.side{
      width: 10%;
    }
    .column.middle{
      width: 80%;
    }
    .row:after {
      content: "";
      display: table;
      clear: both;
    }
    .footer {

      background-color: #f1f1f1;
      padding: 10px;
      text-align: center;
    }
    </style>
  </head>

  <body>
    <div class="header" style="background-color:Black; color: white;">
      <h1>Titulo</h1>
    </div>
    <div class="row">
      <div class="column side" style="background-color:LightGray;">Izquierda</div>
      <div class="column middle" style="background-color:white;">Centro</div>
      <div class="column side" style="background-color:LightGray;">Derecha</div>
    </div>
    <div class="footer">
      <h2>Pie</h2>
    </div>
  </body>
<?php

?>
</html>
