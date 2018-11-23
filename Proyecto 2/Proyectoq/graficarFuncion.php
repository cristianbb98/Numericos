<?php

function funcion($x,$funcion_String) {
    
    $funcion = str_replace('x', '($x)', $funcion_String);
    $funcion = str_replace('^', '**', $funcion);
    $funcion = preg_replace('/(\d)(\()/i', "\\1*\\2", $funcion);
    eval("\$funcion=" . $funcion . ";");
    return $funcion;
}
 
$a = 0;
$b = 8000;
$ecuacion = $_GET['funcion'];
graficarFuncion($ecuacion, $a, $b);
 
Function graficarFuncion($funcion, $a, $b) { #Se pasa como parámetro la funcion como string(aunque si eso nos complica si le podemos quitar es solo para poner una etiqueta) y los limites que ingreso el usuario
    require_once 'phplot/phplot.php';
    $delta = 1; #mientras mas pequeño sea esto, mas Ultra HD 4K va a salir el gráfico
    $data = array();
    for ($x = $a; $x <= $b; $x += $delta) {
        if (!is_nan(funcion($x, $funcion))) {
            $data[] = array('', $x, 1000*funcion($x,$funcion));
        }
    }
    $plot = new PHPlot_truecolor(1024, 768); #el tamaño del gráfico, hay que ajustarlo según el diseño
    $plot->SetImageBorderType('plain');
    $plot->SetPrintImage(false);
	
    $plot->SetPlotType('thinbarline');
    $plot->SetDataType('data-data');
    $plot->SetDataValues($data);
    $plot->SetLegend(array($funcion));
    $plot->SetPlotAreaWorld(0, 0, 8000, 1200);
    $plot->SetXDataLabelPos('none');
    $plot->SetXTickIncrement(200.0);
    $plot->SetXLabelType('data');
    $plot->SetPrecisionX(1);
    $plot->SetYTickIncrement(200.0);
    $plot->SetYLabelType('data');
    $plot->SetPrecisionY(1);
    $plot->SetDrawYGrid(True);
    //$plot->SetCallback('drawsetup', 'pre_plot');
    $plot->DrawGraph();
   $plot->PrintImage();
}


?>
