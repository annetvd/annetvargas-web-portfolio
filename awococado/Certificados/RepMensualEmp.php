<?php
    require('../../libraries/fpdf.php');
    include '../conexion.php'; 

    $b = mysqli_query($enlace,"select Nombre from empacadora where IdEmpacadora = '".$_POST["empacadoraME"]."'");
    $myrow=mysqli_fetch_array($b);
    $nomEmp = $myrow[0];

    class PDF extends FPDF{
        function Header(){
            $this->Image('../Imagenes/marcaAgua.png',30,81,155);
            
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
    
    $pdf->Image('../Imagenes/LogoR.png',20,10,30);
    $pdf->SetFont('Arial','B',13);
    $pdf->SetXY(47,15);
    $pdf->MultiCell(114,7,utf8_decode('DATOS ESTADÍSTICOS DEL EMPAQUE '.mb_strtoupper($nomEmp)),0,'C');
    $pdf->Ln(10);
    $pdf->SetFillColor(166, 184, 40);
    $pdf->SetFont('Arial','',12);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetDrawColor(166, 184, 40);

    $anio = substr($_POST["mesME"], 0 ,4);
    $mes = substr($_POST["mesME"], 5 ,2);

    if ($_POST["mesME"] == ""){
        $anio = date("Y");
        $mes = date("m");
    }
    $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
    $pdf->Cell(170,7,utf8_decode('Comparativos mensuales del mes de '.$meses[$mes-1]." de ".$anio." (kg)"),1,1,'C', true);
    $pdf->Ln(5);

    //////////////////////////////////// crear imagenes ////////////////////////////////

    unlink('../Imagenes/grafica1.png');
    unlink('../Imagenes/grafica2.png');
    
    $bandera1 = 1;
    while ($bandera1 == 1){
        if(!file_exists('../Imagenes/grafica1.png') && !file_exists('../Imagenes/grafica2.png'))
            $bandera1 = 0;
    }

    $data = $_POST['grafME1'];
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);
    file_put_contents('../Imagenes/grafica1.png', $data);

    $data = $_POST['grafME2'];
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);
    file_put_contents('../Imagenes/grafica2.png', $data);

    $bandera2 = 1;
    while ($bandera2 == 1){
        if(file_exists('../Imagenes/grafica1.png') && file_exists('../Imagenes/grafica2.png'))
            $bandera2 = 0;
    }

    ////////////////////////////////////////////////////////////////////////////////////

    $pdf->Image('../Imagenes/grafica1.png',28,53,154);

    $pdf->Ln(113);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetDrawColor(255, 255, 255);    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35,1,"",1,1,'C', true);

    ///////////////////////////////////////////////////////////// tabla ///////////////////////////////////////////////////////
    
    $pdf->SetFont('Arial','',10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetDrawColor(0, 0, 0);

    $valores = array();
    $aux = array();
    $filas = 0;
    $total = 0.0;

    $r=mysqli_query($enlace,"select * from pais"); 
    while ($myrow=mysqli_fetch_array($r)){ 
        if ($myrow[1] != "México"){
            $kilos = 0.0;
            $b=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and Unidad = 'Kilogramos' and IdPais = ".$myrow[0]." and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$_POST["empacadoraME"]."'"); 
            while ($row=mysqli_fetch_array($b)) { 
                $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($row[0])), 3, '.', "");
            }
            $b=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and Unidad = 'Toneladas' and IdPais = ".$myrow[0]." and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$_POST["empacadoraME"]."'"); 
            while ($row=mysqli_fetch_array($b)) { 
                $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($row[0])*1000)), 3, '.', "");
            }
            if ($kilos != 0){
                $valores[$myrow[1]] = round($kilos);
                $total = $total + round($kilos);
            }
        }
    }
    arsort($valores);

    foreach($valores as $i => $val) {
        $aux[$i] = number_format($val, 0, '.', ",");
    }
    $valores = $aux;

    $valores["Total"] = number_format($total, 0, '.', ",");
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetFillColor(255, 255, 255);
    if (is_int(count($valores)/5) == true){
        $filas = count($valores)/5;
    } else{
        $filas = intval(count($valores)/5) + 1;
    }

    $i = 1;
    $j = 0;
    $valor = array();
    foreach($valores as $key => $value){
        if ($i == 21){
            $pdf->cell(10, 40, utf8_decode(''), 0, 0, 'C', 1);
            $pdf->Ln(7);
        }
        if ($j == 0){
            $pdf->SetFillColor(255, 255, 255);
            $pdf->cell(10, 10, utf8_decode(''), 0, 0, 'C', 1);
            $pdf->SetFillColor(229, 231, 234);
        }
        if (is_int($i/5) != true){
            $pdf->cell(30, 10, utf8_decode($key), 0, 0, 'C', 1);
            $valor[$j] = $value;
            $j = $j + 1;
        } else{
            $pdf->cell(30, 10, utf8_decode($key), 0, 1, 'C', 1);
            $valor[$j] = $value;
            $j = 0;
            $pdf->SetFillColor(255, 255, 255);
            $pdf->cell(10, 10, utf8_decode(''), 0, 0, 'C', 1);
            $pdf->SetFillColor(248, 248, 248);
            for ($x = 0; $x < count($valor); $x++){
                $pdf->cell(30, 10, utf8_decode($valor[$x]), 0, 0, 'C', 1);
            }
            $pdf->SetFillColor(255, 255, 255);
            $pdf->cell(10, 10, utf8_decode(''), 0, 1, 'C', 1);
            $pdf->Ln(5);
        }
        $i = $i + 1;
    }
    if ($j != 0){
        $pdf->SetFillColor(255, 255, 255);
        $pdf->cell(10, 10, utf8_decode(''), 0, 1, 'C', 1);
        $pdf->cell(10, 10, utf8_decode(''), 0, 0, 'C', 1);
        $pdf->SetFillColor(248, 248, 248);
        for ($x = 0; $x < $j; $x++){
            $pdf->cell(30, 10, utf8_decode($valor[$x]), 0, 0, 'C', 1);
        }
        $pdf->SetFillColor(255, 255, 255);
        $pdf->cell(10, 10, utf8_decode(''), 0, 1, 'C', 1);
        $pdf->Ln(5);
    }
    $pdf->SetFillColor(255, 255, 255);
    $pdf->cell(10, 4, utf8_decode(''), 0, 1, 'C', 1);

    ///////////////////////////////////////////////////////// Embarques /////////////////////////////////////////////////////////
    
    $pdf->AddPage();
    $pdf->Ln(5);
    
    $pdf->Image('../Imagenes/LogoR.png',20,10,30);
    $pdf->SetFont('Arial','B',13);
    $pdf->SetXY(47,15);
    $pdf->MultiCell(114,7,utf8_decode('DATOS ESTADÍSTICOS DEL EMPAQUE '.mb_strtoupper($nomEmp)),0,'C');
    $pdf->Ln(10);
    $pdf->SetFillColor(166, 184, 40);
    $pdf->SetFont('Arial','',12);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetDrawColor(166, 184, 40);
    
    $pdf->Cell(170,7,utf8_decode('Comparativos mensuales de embarques del mes de '.$meses[$mes-1]." de ".$anio),1,1,'C', true);
    $pdf->Ln(5);
    $pdf->Image('../Imagenes/grafica2.png',50, 53 ,111);

    $pdf->SetFont('Arial','I',8);
    $pdf->SetTextColor(48, 48, 48);
    $pdf->Ln(119);
    $pdf->Cell(170,5,utf8_decode('Fuente: Certificados Fitosanitarios Internacionales (SENASICA)'),0,1,'C');


        ///////////////////////////////////////////////////////////// tabla 2 ///////////////////////////////////////////////////////
    
    $pdf->Ln(8);
    $pdf->SetFont('Arial','',10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetDrawColor(0, 0, 0);

    $valores = array();
    $aux = array();
    $total = 0;

    $r=mysqli_query($enlace,"select * from pais"); 
    while ($myrow=mysqli_fetch_array($r)){ 
        if ($myrow[1] != "México"){
            $b=mysqli_query($enlace,"select COUNT(IdCertificado) from certificados where IdPais = ".$myrow[0]." and YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$_POST["empacadoraME"]."'"); 
            $row=mysqli_fetch_array($b);
            if ($row[0] != 0){
                $valores[$myrow[1]] = $row[0];
                $total = $total + $row[0];
            }
        }
    }
    arsort($valores);
    
    foreach($valores as $i => $val) {
        $aux[$i] = number_format($val, 0, '.', ",");
    }
    $valores = $aux;
    
    $valores["Total"] = number_format($total, 0, '.', ",");

    $pdf->SetFont('Arial','',8);
    $pdf->SetFillColor(255, 255, 255);

    $i = 1;
    $j = 0;
    $valor = array();
    foreach($valores as $key => $value){
        if ($i == 21){
            $pdf->Ln(10);
        }
        if ($j == 0){
            $pdf->SetFillColor(255, 255, 255);
            $pdf->cell(10, 9, utf8_decode(''), 0, 0, 'C', 1);
            $pdf->SetFillColor(229, 231, 234);
        }
        if (is_int($i/5) != true){
            $pdf->cell(30, 10, utf8_decode($key), 0, 0, 'C', 1);
            $valor[$j] = $value;
            $j = $j + 1;
        } else{
            $pdf->cell(30, 10, utf8_decode($key), 0, 1, 'C', 1);
            $valor[$j] = $value;
            $j = 0;
            $pdf->SetFillColor(255, 255, 255);
            $pdf->cell(10, 9, utf8_decode(''), 0, 0, 'C', 1);
            $pdf->SetFillColor(248, 248, 248);
            for ($x = 0; $x < count($valor); $x++){
                $pdf->cell(30, 9, utf8_decode($valor[$x]), 0, 0, 'C', 1);
            }
            $pdf->SetFillColor(255, 255, 255);
            $pdf->cell(10, 9, utf8_decode(''), 0, 1, 'C', 1);
            $pdf->Ln(5);
        }
        $i = $i + 1;
    }
    if ($j != 0){
        $pdf->SetFillColor(255, 255, 255);
        $pdf->cell(10, 9, utf8_decode(''), 0, 1, 'C', 1);
        $pdf->cell(10, 9, utf8_decode(''), 0, 0, 'C', 1);
        $pdf->SetFillColor(248, 248, 248);
        for ($x = 0; $x < $j; $x++){
            $pdf->cell(30, 9, utf8_decode($valor[$x]), 0, 0, 'C', 1);
        }
        $pdf->SetFillColor(255, 255, 255);
        $pdf->cell(10, 9, utf8_decode(''), 0, 1, 'C', 1);
        $pdf->Ln(5);
    }
    $pdf->SetFillColor(255, 255, 255);

    $pdf->SetTitle('Reporte mensual del empaque '.$nomEmp, 1);

    $pdf->Output();
?>