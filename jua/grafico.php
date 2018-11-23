<html>
  <head>
    <title>Polinomio de Legendre</title>
  </head>
  <body>
    <?php
      include_once "grafica.php";
    ?>
    <h1 align = "center">Polinomio de Legendre</h1>
    <table style="width:100%">
      <tr>
        <td>
        <div><fieldset align = "center"> <legend> Polinomio de legendre </legend>
          <?php
          //echo P(3);
          ?>
        </div>
      </td>
        <td>
        <div><fieldset align = "center"> <legend> Grafica de la Funcion </legend>
          <?php
          $path = 'graph.png';
          $fun = 'abs($x)';
          graph($fun, $path);
          ?>
          <img src = <?php echo $path;?> alt="graph">
        </div>
        </td>
      </tr>
    </table>
  </body>
</html>
