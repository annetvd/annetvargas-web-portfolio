<?php
    require('../../libraries/fpdf.php');
    include '../conexion.php'; 

    class PDF extends FPDF{
        function Header(){
            // $this->SetMargins(2, 1, 2);
            $this->Image('../Imagenes/LogoR.png',20,10,30);
            $this->Image('../Imagenes/marcaAgua.png',30,81,155);
            $this->SetFont('Arial','B',13);
            $this->SetXY(47,15);
            $this->MultiCell(114,7,utf8_decode('DATOS ESTADÍSTICOS HISTÓRICOS DE EXPORTACIÓN DE AGUACATE DE JALISCO'),0,'C');
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
    $pdf->Cell(170,7,utf8_decode('Comparativos anuales (kg)'),1,1,'C', true);
    $pdf->Ln(5);

    //////////////////////////////////// crear imagenes ////////////////////////////////

    unlink('../Imagenes/grafica1.png');
    unlink('../Imagenes/grafica2.png');
    $bandera1 = 1;
    while ($bandera1 == 1){
        if(!file_exists('../Imagenes/grafica1.png') && !file_exists('../Imagenes/grafica2.png'))
            $bandera1 = 0;
    }

    $data = $_POST['grafL1'];
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);
    file_put_contents('../Imagenes/grafica1.png', $data);

    $data = $_POST['grafL2'];
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

    $pdf->Image('../Imagenes/grafica1.png',25,53,159);
    $pdf->Image('../Imagenes/grafica2.png',25,163,159);

    $pdf->Ln(217);
    $pdf->SetFont('Arial','I',8);
    $pdf->SetTextColor(48, 48, 48);
    $pdf->Cell(170,5,utf8_decode('Fuente: Certificados Fitosanitarios Internacionales (SENASICA)'),0,1,'C');

    ///////////////////////////////////////////////////////////// tabla ///////////////////////////////////////////////////////
    
    $pdf->Ln(8);
    $pdf->SetFont('Arial','',10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetDrawColor(0, 0, 0);

    if ($_POST["añoIL"] == "" || $_POST["añoFL"] == ""){
        $r=mysqli_query($enlace,"select Fecha from certificados ORDER BY Fecha ASC");
        $myrow=mysqli_fetch_array($r);
        $fechaI = substr($myrow[0], 0, 4);
        $r=mysqli_query($enlace,"select Fecha from certificados ORDER BY Fecha DESC");
        $myrow=mysqli_fetch_array($r);
        $fechaF = $myrow[0];
    } else{
        $fechaI = $_POST["añoIL"];
        $r=mysqli_query($enlace,"select Fecha from certificados where year(Fecha) = '".$_POST["añoFL"]."' ORDER BY Fecha DESC");
        $myrow=mysqli_fetch_array($r);
        $fechaF = $myrow[0];
    }
    if (substr($fechaF, 5, 2) != "12"){
        $anioF = "parcial ".substr($fechaF, 0, 4);
    } else{
        $anioF = substr($fechaF, 0, 4);
    }

    if ($anioF == $fechaI){
        $encabezado = 'Estadísticas de Exportación de Aguacate Jalisciense de '.$fechaI.'.';
    } else{
        $encabezado = 'Estadísticas de Exportación de Aguacate Jalisciense de '.$fechaI.' a '.$anioF.'.';
    }
    $pdf->Cell(169,5,utf8_decode($encabezado),0,1,'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial','',8);
    $pdf->SetFillColor(229, 231, 234);
    $pdf->cell(10, 10, utf8_decode('Año'), 0, 0, 'C', 1);
    $pdf->cell(12, 10, utf8_decode('Ene'), 0, 0, 'C', 1);
    $pdf->cell(12, 10, utf8_decode('Feb'), 0, 0, 'C', 1);
    $pdf->cell(12, 10, utf8_decode('Mar'), 0, 0, 'C', 1);
    $pdf->cell(12, 10, utf8_decode('Abr'), 0, 0, 'C', 1);
    $pdf->cell(12, 10, utf8_decode('May'), 0, 0, 'C', 1);
    $pdf->cell(12, 10, utf8_decode('Jun'), 0, 0, 'C', 1);
    $pdf->cell(12, 10, utf8_decode('Jul'), 0, 0, 'C', 1);
    $pdf->cell(12, 10, utf8_decode('Ago'), 0, 0, 'C', 1);
    $pdf->cell(12, 10, utf8_decode('Sep'), 0, 0, 'C', 1);
    $pdf->cell(12, 10, utf8_decode('Oct'), 0, 0, 'C', 1);
    $pdf->cell(12, 10, utf8_decode('Nov'), 0, 0, 'C', 1);
    $pdf->cell(12, 10, utf8_decode('Dic'), 0, 0, 'C', 1);
    $pdf->cell(16, 10, utf8_decode('Total, kg'), 0, 1, 'C', 1);

    $aI = $fechaI;
    $aF = intval(substr($fechaF, 0, 4), 10);

    while ($aI <= $aF){
        $Total = 0.0;
        $pdf->SetFont('Arial','',8);
        $pdf->cell(10, 8, $aI, 0, 0, 'C', 1);
        $pdf->SetFont('Arial','',6);
        for ($i = 0; $i < 12; $i++){
            $Kilos = 0.0;
            $r=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$aI." and MONTH(Fecha) = ".($i + 1)." and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
            while ($myrow=mysqli_fetch_array($r)) { 
                $Kilos = number_format((number_format($Kilos, 3, '.', "") + doubleval($myrow[0])), 3, '.', "");
            }
            $r=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$aI." and MONTH(Fecha) = ".($i + 1)." and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
            while ($myrow=mysqli_fetch_array($r)) { 
                $Kilos = number_format((number_format($Kilos, 3, '.', "") + (doubleval($myrow[0])*1000)), 3, '.', "");
            }
            $Total = $Total + round($Kilos);
            $pdf->cell(12, 8, number_format(round($Kilos), 0, '.', ","), 0, 0, 'C', 0);
        }
        $pdf->cell(16, 8, number_format($Total, 0, '.', ","), 0, 1, 'C', 0);
        $aI = $aI + 1;
    }

    $pdf->SetTitle('Reporte histórico', 1);
    $pdf->Output();
?>