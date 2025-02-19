<?php
    require('../../libraries/fpdf.php');
    include '../conexion.php'; 

    class PDF extends FPDF{
        function Header(){
            $this->Image('../Imagenes/marcaAgua.png',30,81,155);   
            $this->Image('../Imagenes/LogoR.png',20,10,30);
            $this->SetFont('Arial','B',13);
            $this->SetXY(47,15);
            $this->MultiCell(114,7,utf8_decode('ESTADÍSTICAS COMPARATIVAS POR TEMPORADAS'),0,'C');
            $this->Ln(10);
        }

        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,utf8_decode('AWOCOCADO A.C.'),0,0,'C');
        }
    }

    $pdf = new PDF();
    // $pdf->AliasNbPages();
    $pdf->SetMargins(20, 10, 20);
    $pdf->AddPage();
    
    $pdf->SetFillColor(166, 184, 40);
    $pdf->SetFont('Arial','',12);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetDrawColor(166, 184, 40);

    $temI = $_POST["tempI"];
    $temF = $_POST["tempF"];

    if (($temI != "" && $temF == "") || ($temI == "" && $temF != "") || ($temI == "" && $temF == "")) {
        $r=mysqli_query($enlace,"select year(Fecha) from certificados ORDER BY Fecha ASC");
        $myrow=mysqli_fetch_array($r);
        $anioI = $myrow[0];
        $r=mysqli_query($enlace,"select year(Fecha), month(Fecha) from certificados ORDER BY Fecha DESC");
        $myrow=mysqli_fetch_array($r);
        $anioF = $myrow[0];
        $mesF = $myrow[1];
        
        if ($mesF > 5 && $mesF < 13){
            $anioI = $anioI + 1;
            $anioF = $anioF + 1;
        }

        $temF = ($anioF - 1)." - ".$anioF;
        $anioF = $anioF - 1;
        $temI = ($anioF - 1)." - ".$anioF;
    }

    $pdf->Cell(170,7,utf8_decode('Comparativos de las temporadas '.$temI." y ".$temF." (kg)"),1,1,'C', true);
    $pdf->Ln(5);

    //////////////////////////////////// crear imagenes ////////////////////////////////

    unlink('../Imagenes/grafica1.png');
    unlink('../Imagenes/grafica2.png');
    unlink('../Imagenes/grafica3.png');
    unlink('../Imagenes/grafica4.png');
    // unlink('../Imagenes/grafica5.png');
    
    $bandera1 = 1;
    while ($bandera1 == 1){
        if(!file_exists('../Imagenes/grafica1.png') && !file_exists('../Imagenes/grafica2.png') && !file_exists('../Imagenes/grafica3.png') && !file_exists('../Imagenes/grafica4.png'))
            $bandera1 = 0;
    }

    $data = $_POST['grafT1'];
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);
    file_put_contents('../Imagenes/grafica1.png', $data);

    $data = $_POST['grafT2'];
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);
    file_put_contents('../Imagenes/grafica2.png', $data);

    $data = $_POST['grafT3'];
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);
    file_put_contents('../Imagenes/grafica3.png', $data);

    $data = $_POST['grafT4'];
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);
    file_put_contents('../Imagenes/grafica4.png', $data);

    // $data = $_POST['grafT5'];
    // list($type, $data) = explode(';', $data);
    // list(, $data) = explode(',', $data);
    // $data = base64_decode($data);
    // file_put_contents('../Imagenes/grafica5.png', $data);

    $bandera2 = 1;
    while ($bandera2 == 1){
        if(file_exists('../Imagenes/grafica1.png') && file_exists('../Imagenes/grafica2.png') && file_exists('../Imagenes/grafica3.png') && file_exists('../Imagenes/grafica4.png'))
            $bandera2 = 0;
    }

    //////////////////////////////////////////////////////// gráfica 1 ////////////////////////////////////////////////////

    $pdf->Ln(5);
    $pdf->SetTextColor(0, 0, 0);
    // $pdf->Cell(170,5,utf8_decode('Temporada '.$temI),0,1,'C');

    $pdf->Image('../Imagenes/grafica1.png',25,53,159);
    $pdf->Ln(107);

    $anioI = substr($temI, 2,2);
    $anioF = substr($temI, 9,2);

    $pdf->SetFont('Arial','B',7);
    $pdf->SetFillColor(229, 231, 234);
    $pdf->cell(22, 10, utf8_decode(' Destino'), 0, 0, 'L', 1);
    $pdf->cell(11, 10, utf8_decode('Jun/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Jul/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Ago/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Sep/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Oct/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Nov/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Dic/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Ene/'.$anioF), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Feb/'.$anioF), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Mar/'.$anioF), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Abr/'.$anioF), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('May/'.$anioF), 0, 0, 'C', 1);
    $pdf->cell(16, 10, utf8_decode('Total '), 0, 1, 'R', 1);

    $fecha = array(6, 7, 8, 9, 10, 11, 12, 1, 2, 3, 4, 5);
    $total = 0.0;
    $paises = array();

    $r=mysqli_query($enlace,"select IdPais, Nombre from pais"); 
    while ($myrow=mysqli_fetch_array($r)){ 
        if ($myrow[1] != "México"){
            $total = 0.0;
            $anioI = substr($temI, 0,4);
            $anioF = substr($temI, 7,4);
            for ($i = 0; $i < 12; $i++){
                $kilos = 0.0;
                if ($i == 7){
                    $anioI = $anioF;
                }
                $a=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional' and IdPais = ".$myrow[0]); 
                while ($row=mysqli_fetch_array($a)) { 
                    $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($row[0])), 3, '.', "");
                }
                $a=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional' and IdPais = ".$myrow[0]);
                while ($row=mysqli_fetch_array($a)) { 
                    $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($row[0])*1000)), 3, '.', "");
                }
                $total = $total + round($kilos);
            }

            if ($total != 0){
                $paises[] = $myrow[1];
            }
        }
    }
    
    asort($paises);
    
    foreach ($paises as $val){
        $pdf->SetFont('Arial','',7);
        $pdf->cell(22, 8, utf8_decode(" ".substr($val, 0,17)), 0, 0, 'L', 1);
        $pdf->SetFont('Arial','',5);
        $total = 0.0;
        $anioI = substr($temI, 0,4);
        $anioF = substr($temI, 7,4);
        
        $r=mysqli_query($enlace,'select IdPais from pais where Nombre = "'.$val.'"');
        $myrow=mysqli_fetch_array($r);
    
        for ($i = 0; $i < 12; $i++){
            $kilos = 0.0;
            if ($i == 7){
                $anioI = $anioF;
            }
            $a=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional' and IdPais = ".$myrow[0]); 
            while ($row=mysqli_fetch_array($a)) { 
                $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($row[0])), 3, '.', "");
            }
            $a=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional' and IdPais = ".$myrow[0]);
            while ($row=mysqli_fetch_array($a)) { 
                $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($row[0])*1000)), 3, '.', "");
            }
            $total = $total + round($kilos);
            $pdf->cell(11, 8, number_format(round($kilos), 0, '.', ","), 0, 0, 'C', 0);
        }
        $pdf->cell(16, 8, number_format($total, 0, '.', ",")." ", 0, 1, 'R', 0);
    }

    $pdf->SetFont('Arial','B',7);
    $pdf->cell(22, 8, utf8_decode(" Total general"), 0, 0, 'L', 1);
    $pdf->SetFont('Arial','B',5);

    $total = 0.0;
    $tem1 = array();
    $tem1[] = $temI;
    $anioI = substr($temI, 0,4);
    $anioF = substr($temI, 7,4);
    for ($i = 0; $i < 12; $i++){
        $kilos = 0.0;
        if ($i == 7){
            $anioI = $anioF;
        }
        $a=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional'"); 
        while ($row=mysqli_fetch_array($a)) { 
            $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($row[0])), 3, '.', "");
        }
        $a=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional'");
        while ($row=mysqli_fetch_array($a)) { 
            $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($row[0])*1000)), 3, '.', "");
        }
        $total = $total + round($kilos);
        $pdf->cell(11, 8, number_format(round($kilos), 0, '.', ","), 0, 0, 'C', 0);
        $tem1[] = round($kilos);
    }
    $pdf->cell(16, 8, number_format($total, 0, '.', ",")." ", 0, 1, 'R', 0);
    $tem1[] = $total;


    //////////////////////////////////////////////////////////// grafica 2 ////////////////////////////////////////////////////
    
    $pdf->AddPage();
    
    $pdf->SetTextColor(0);
    $pdf->Image('../Imagenes/grafica2.png',25,35,159);
    $pdf->Ln(106);

    $anioI = substr($temF, 2,2);
    $anioF = substr($temF, 9,2);

    $pdf->SetFont('Arial','B',7);
    $pdf->SetFillColor(229, 231, 234);
    $pdf->cell(22, 10, utf8_decode(' Destino'), 0, 0, 'L', 1);
    $pdf->cell(11, 10, utf8_decode('Jun/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Jul/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Ago/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Sep/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Oct/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Nov/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Dic/'.$anioI), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Ene/'.$anioF), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Feb/'.$anioF), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Mar/'.$anioF), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('Abr/'.$anioF), 0, 0, 'C', 1);
    $pdf->cell(11, 10, utf8_decode('May/'.$anioF), 0, 0, 'C', 1);
    $pdf->cell(16, 10, utf8_decode('Total '), 0, 1, 'R', 1);

    $fecha = array(6, 7, 8, 9, 10, 11, 12, 1, 2, 3, 4, 5);
    $total = 0.0;
    array_splice($paises, 0, count($paises));

    $r=mysqli_query($enlace,"select IdPais, Nombre from pais"); 
    while ($myrow=mysqli_fetch_array($r)){ 
        if ($myrow[1] != "México"){
            $total = 0.0;
            $anioI = substr($temF, 0,4);
            $anioF = substr($temF, 7,4);
            for ($i = 0; $i < 12; $i++){
                $kilos = 0.0;
                if ($i == 7){
                    $anioI = $anioF;
                }
                $a=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional' and IdPais = ".$myrow[0]); 
                while ($row=mysqli_fetch_array($a)) { 
                    $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($row[0])), 3, '.', "");
                }
                $a=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional' and IdPais = ".$myrow[0]);
                while ($row=mysqli_fetch_array($a)) { 
                    $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($row[0])*1000)), 3, '.', "");
                }
                $total = $total + round($kilos);
            }

            if ($total != 0){
                $paises[] = $myrow[1];
            }
        }
    }
    
    asort($paises);
    
    foreach ($paises as $val){
        $pdf->SetFont('Arial','',7);
        $pdf->cell(22, 8, utf8_decode(" ".substr($val, 0,17)), 0, 0, 'L', 1);
        $pdf->SetFont('Arial','',5);
        $total = 0.0;
        $anioI = substr($temF, 0,4);
        $anioF = substr($temF, 7,4);
        
        $r=mysqli_query($enlace,'select IdPais from pais where Nombre = "'.$val.'"');
        $myrow=mysqli_fetch_array($r);
        
        for ($i = 0; $i < 12; $i++){
            $kilos = 0.0;
            if ($i == 7){
                $anioI = $anioF;
            }
            $a=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional' and IdPais = ".$myrow[0]); 
            while ($row=mysqli_fetch_array($a)) { 
                $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($row[0])), 3, '.', "");
            }
            $a=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional' and IdPais = ".$myrow[0]);
            while ($row=mysqli_fetch_array($a)) { 
                $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($row[0])*1000)), 3, '.', "");
            }
            $total = $total + round($kilos);
            $pdf->cell(11, 8, number_format(round($kilos), 0, '.', ","), 0, 0, 'C', 0);
        }
        $pdf->cell(16, 8, number_format($total, 0, '.', ",")." ", 0, 1, 'R', 0);
    }

    $pdf->SetFont('Arial','B',7);
    $pdf->cell(22, 8, utf8_decode(" Total general"), 0, 0, 'L', 1);
    $pdf->SetFont('Arial','B',5);

    $total = 0.0;
    $tem2 = array();
    $tem2[] = $temF;
    $anioI = substr($temF, 0,4);
    $anioF = substr($temF, 7,4);
    for ($i = 0; $i < 12; $i++){
        $kilos = 0.0;
        if ($i == 7){
            $anioI = $anioF;
        }
        $a=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional'"); 
        while ($row=mysqli_fetch_array($a)) { 
            $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($row[0])), 3, '.', "");
        }
        $a=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional'");
        while ($row=mysqli_fetch_array($a)) { 
            $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($row[0])*1000)), 3, '.', "");
        }
        $total = $total + round($kilos);
        $pdf->cell(11, 8, number_format(round($kilos), 0, '.', ","), 0, 0, 'C', 0);
        $tem2[] = round($kilos);
    }
    $pdf->cell(16, 8, number_format($total, 0, '.', ",")." ", 0, 1, 'R', 0);
    $tem2[] = $total;


    /////////////////////////////////////////////////////// grafica 3 y 4 ////////////////////////////////////////////////////
    
    $pdf->AddPage();
    
    $pdf->SetTextColor(0);
    $pdf->Image('../Imagenes/grafica3.png',25,35,159);
    $pdf->Image('../Imagenes/grafica4.png',25,141,159);

    $pdf->Ln(205);
    $pdf->SetFont('Arial','I',8);
    $pdf->SetTextColor(48, 48, 48);
    $pdf->Cell(170,5,utf8_decode('Fuente: Certificados Fitosanitarios Internacionales (SENASICA)'),0,1,'C');
    $pdf->Ln(8);

    $pdf->SetFont('Arial','B',7);
    $pdf->SetFillColor(229, 231, 234);
    $pdf->SetTextColor(0);
    $pdf->cell(22, 7, utf8_decode(' Temporada'), 0, 0, 'L', 1);
    $pdf->cell(11, 7, utf8_decode('Jun'), 0, 0, 'C', 1);
    $pdf->cell(11, 7, utf8_decode('Jul'), 0, 0, 'C', 1);
    $pdf->cell(11, 7, utf8_decode('Ago'), 0, 0, 'C', 1);
    $pdf->cell(11, 7, utf8_decode('Sep'), 0, 0, 'C', 1);
    $pdf->cell(11, 7, utf8_decode('Oct'), 0, 0, 'C', 1);
    $pdf->cell(11, 7, utf8_decode('Nov'), 0, 0, 'C', 1);
    $pdf->cell(11, 7, utf8_decode('Dic'), 0, 0, 'C', 1);
    $pdf->cell(11, 7, utf8_decode('Ene'), 0, 0, 'C', 1);
    $pdf->cell(11, 7, utf8_decode('Feb'), 0, 0, 'C', 1);
    $pdf->cell(11, 7, utf8_decode('Mar'), 0, 0, 'C', 1);
    $pdf->cell(11, 7, utf8_decode('Abr'), 0, 0, 'C', 1);
    $pdf->cell(11, 7, utf8_decode('May'), 0, 0, 'C', 1);
    $pdf->cell(16, 7, utf8_decode('Total '), 0, 1, 'R', 1);
    
    $data = array($tem1, $tem2);

    foreach($data as $row){
        $pdf->SetFont('Arial','', 7);
        $pdf->cell(22, 6, utf8_decode(" ".$row[0]), 0, 0, 'L', 1);
        $pdf->SetFont('Arial','',5);
        $pdf->cell(11, 6, number_format($row[1], 0, '.', ","), 0, 0, 'C', 0);
        $pdf->cell(11, 6, number_format($row[2], 0, '.', ","), 0, 0, 'C', 0);
        $pdf->cell(11, 6, number_format($row[3], 0, '.', ","), 0, 0, 'C', 0);
        $pdf->cell(11, 6, number_format($row[4], 0, '.', ","), 0, 0, 'C', 0);
        $pdf->cell(11, 6, number_format($row[5], 0, '.', ","), 0, 0, 'C', 0);
        $pdf->cell(11, 6, number_format($row[6], 0, '.', ","), 0, 0, 'C', 0);
        $pdf->cell(11, 6, number_format($row[7], 0, '.', ","), 0, 0, 'C', 0);
        $pdf->cell(11, 6, number_format($row[8], 0, '.', ","), 0, 0, 'C', 0);
        $pdf->cell(11, 6, number_format($row[9], 0, '.', ","), 0, 0, 'C', 0);
        $pdf->cell(11, 6, number_format($row[10], 0, '.', ","), 0, 0, 'C', 0);
        $pdf->cell(11, 6, number_format($row[11], 0, '.', ","), 0, 0, 'C', 0);
        $pdf->cell(11, 6, number_format($row[12], 0, '.', ","), 0, 0, 'C', 0);
        $pdf->SetFont('Arial','B');
        $pdf->cell(16, 6, number_format($row[13], 0, '.', ",")." ", 0, 1, 'R', 0);
    }

    $pdf->SetFillColor(255);
    $pdf->SetTitle('Reporte comparativo por temporadas', 1);
    $pdf->Output();
?>