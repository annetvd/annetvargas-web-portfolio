<?php
    require('../../libraries/fpdf.php');
    include '../consultar.php'; 

    ///////////////////// Inicialiciar valores
    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $tipo = $_POST["aportacionS"];
    if ($_POST["aportacionS"] != ""){
        $b = mysqli_query($enlace,"select Concepto from tipoaportacion where IdTipoAportacion = '".$_POST["aportacionS"]."'");
        $myrow=mysqli_fetch_array($b);
        $concTipo = $myrow[0];
    }
    if ($_POST["mesS"] != ""){
        $mes = $meses[substr($_POST["mesS"],5 , 2) - 1]."/".substr($_POST["mesS"],0 , 4);
    } else{
        $mes = $meses[date("m") - 1]."/".date("Y");
    }
    $hoy = date("d")."/".substr($meses[date("m") - 1],0 , 3)."/".date("Y");

    $empC = 82; 
    $saldoIC = 22;
    $cargosC = 22;
    $abonosC = 22; 
    $saldoC = 22;
    
    /////////////////////////////////////////////// generar encabezado y pie de página //////////////////////////////////////////////
    class PDF extends FPDF{
        // Cabecera de página
        function Header(){
            global $mes;
            global $tipo;
            
            $this->Image('../Imagenes/LogoRI.png',23,6,34);
            $this->Image('../Imagenes/marcaAgua.png',30,81,155);
            $this->SetFont('Arial','B',13);
            $this->SetXY(47,11);
            $this->MultiCell(116,7,utf8_decode('RESUMEN DE REPORTE DE INGRESOS'),0,'C');
            impEncabezado($this, $mes, $tipo);
        }

        // Pie de página
        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,utf8_decode('AWOCOCADO A.C.'),0,0,'C');
            $this->Cell(4,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'R');
        }
    }

    // Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->SetMargins(20, 10, 20);
    $pdf->AddPage();

    //////////////////////////////// Imprimir tabla ////////////////////////////////////
    $x = 0;

    foreach(formatoNumRepSal(obtRepSaldos($_POST["mesS"], $_POST["aportacionS"])) as $val) { 
        $a = 8;
        
        $pdf->SetFont('Arial','',7);
        $pdf->SetDrawColor(243);
        $pdf->SetTextColor(0);
        $pdf->SetFillColor(255, 255, 255);

        if ($val["Empacadora"] == "Suma:"){
            $pdf->Cell($empC, $a, utf8_decode(substr($val["Empacadora"], 0 ,55)),1,0,'R', 0);
        } else{
            $pdf->Cell($empC, $a, utf8_decode(substr($val["Empacadora"], 0 ,55)),1,0,'L', 0);
        }
        $pdf->Cell($saldoC, $a, utf8_decode($val["SaldoI"]),1,0,'R', 0);
        $pdf->Cell($cargosC, $a, utf8_decode($val["Cargos"]),1,0,'R', 0);
        $pdf->Cell($abonosC, $a, utf8_decode($val["Abonos"]),1,0,'R', 0);
        $pdf->Cell($saldoC, $a, utf8_decode($val["SaldoF"]),1,1,'R', 0);
    }

    function impEncabezado($pdf, $mes, $tipo){
        global $empC; 
        global $saldoIC;
        global $cargosC;
        global $abonosC; 
        global $saldoC;
        global $hoy;
        global $concTipo;
    
        $pdf->SetFont('Arial','', 9);
        $pdf->SetX(60);

        if ($mes != "" && $tipo == ""){
            $pdf->Cell(0,7,utf8_decode($mes),0, 0, 'L');
            $pdf->Cell(0,7,utf8_decode('Fecha: '.$hoy),0, 1, 'R');
            $pdf->Ln(6);
        } else{
            if ($mes != "" && $tipo != ""){
                $pdf->Ln(1);
                $pdf->SetX(60);
                $pdf->Cell(29,5,utf8_decode($mes),0, 0, 'L');
                $pdf->Cell(72,5,utf8_decode("Tipo de aportación: ".$concTipo),0, 0, 'C');
                $pdf->Cell(29,5,utf8_decode('Fecha: '.$hoy),0, 1, 'R');
                $pdf->Ln(7);
            }
        }

        ////////////////////////// Imprimir header de la tabla
        
        $pdf->SetFont('Arial','B',8);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(255);
        $pdf->SetFillColor(96, 196, 56);

        $pdf->Cell($empC,10,utf8_decode('Empacadora'),0,0,'C','True');
        $pdf->Cell($saldoIC,10,utf8_decode('Saldo inicial'),0,0,'C', 'True');
        $pdf->Cell($cargosC,10,utf8_decode('Cargos'),0,0,'C', 'True');
        $pdf->Cell($abonosC,10,utf8_decode('Abonos'),0,0,'C', 'True');
        $pdf->Cell($saldoC,10,utf8_decode('Saldo final'),0,1,'C', 'True');
    }
    
    $pdf->SetTitle('Resumen de reporte de ingresos', 1);
    $pdf->Output();
?>