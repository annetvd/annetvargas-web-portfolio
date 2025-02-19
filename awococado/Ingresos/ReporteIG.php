<?php
    require('../../libraries/fpdf.php');
    include '../consultar.php'; 

    ///////////////////// Inicialiciar valores
    $meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
    $empacadora = $_POST["empacadoraG"];
    if ($_POST["empacadoraG"] != ""){
        $b = mysqli_query($enlace,"select Nombre from empacadora where IdEmpacadora = '".$_POST["empacadoraG"]."'");
        $myrow=mysqli_fetch_array($b);
        $nomEmp = $myrow[0];
    }
    if ($_POST["fechaIG"] != ""){
        $fechaI = substr($_POST["fechaIG"],8 , 2)."/".$meses[substr($_POST["fechaIG"],5 , 2) - 1]."/".substr($_POST["fechaIG"],0 , 4);
    } else{
        $fechaI = "";
    }
    if ($_POST["fechaFG"] != ""){
        $fechaF = substr($_POST["fechaFG"],8 , 2)."/".$meses[substr($_POST["fechaFG"],5 , 2) - 1]."/".substr($_POST["fechaFG"],0 , 4);
    } else{
        $fechaF = "";
    }
    $hoy = date("d")."/".$meses[date("m") - 1]."/".date("Y");

    $fechaC = 15;
    $tipoC = 8;
    $concC = 70; 
    $refC = 17;
    $cargosC = 20;
    $abonosC = 20; 
    $saldoC = 20;
    
    /////////////////////////////////////////////// generar encabezado y pie de página //////////////////////////////////////////////
    class PDF extends FPDF{
        // Cabecera de página
        function Header(){
            global $fechaI;
            global $fechaF;
            global $empacadora;
            
            $this->Image('../Imagenes/LogoRI.png',26,5,32);
            $this->Image('../Imagenes/marcaAgua.png',30,81,155);
            $this->SetFont('Arial','B',13);
            $this->SetXY(47,11);
            $this->MultiCell(116,7,utf8_decode('REPORTE DE INGRESOS GENERAL'),0,'C');
            impEncabezado($this, $fechaI, $fechaF, $empacadora);
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

    foreach(formatoNumRepGen(obtEstadoCuenta($empacadora, $_POST["fechaIG"], $_POST["fechaFG"])) as $val) {
        if ($empacadora == ""){
            llenarFila($val);
        } else{
            if ($x == 1){
                llenarFila($val);
            } else{
                $x = 1;
                $val["Concepto"] = "";
                llenarFila($val);
            }
        }
    }

    function llenarFila($val){
        global $pdf;
        global $fechaC;
        global $tipoC;
        global $concC; 
        global $refC;
        global $cargosC;
        global $abonosC; 
        global $saldoC;
        $a = 8;
        
        $pdf->SetFont('Arial','',7);
        $pdf->SetDrawColor(243);
        $pdf->SetTextColor(0);
        $pdf->SetFillColor(255, 255, 255);

        if ($val["Fecha"] == ""){
            if ($val["Concepto"] == "<br>"){
                $pdf->Cell($fechaC, $a, utf8_decode($val["Fecha"]),1,0,'L', 0);
                $pdf->Cell($tipoC, $a, utf8_decode($val["Tipo"]),1,0,'C', 0);
                $pdf->Cell($concC, $a, utf8_decode(""),1,0,'L', 0);
                $pdf->Cell($refC, $a, utf8_decode($val["Referencia"]),1,0,'L', 0);
                $pdf->Cell($cargosC, $a, utf8_decode($val["Cargos"]),1,0,'R', 0);
                $pdf->Cell($abonosC, $a, utf8_decode($val["Abonos"]),1,0,'R', 0);
                $pdf->Cell($saldoC, $a, utf8_decode($val["Saldo"]),1,1,'R', 0);
            } else{
                if ($val["Referencia"] != ""){
                    $pdf->Cell($fechaC, $a, utf8_decode($val["Fecha"]),1,0,'L', 0);
                    $pdf->Cell($tipoC, $a, utf8_decode($val["Tipo"]),1,0,'C', 0);
                    $pdf->Cell($concC, $a, utf8_decode($val["Concepto"]),1,0,'L', 0);
                    $pdf->Cell($refC, $a, utf8_decode($val["Referencia"]),1,0,'R', 0);
                    $pdf->Cell($cargosC, $a, utf8_decode($val["Cargos"]),1,0,'R', 0);
                    $pdf->Cell($abonosC, $a, utf8_decode($val["Abonos"]),1,0,'R', 0);
                    $pdf->Cell($saldoC, $a, utf8_decode($val["Saldo"]),1,1,'R', 0);
                } else{
                    $pdf->Cell($fechaC, $a, utf8_decode($val["Fecha"]),1,0,'L', 0);
                    $pdf->Cell($tipoC, $a, utf8_decode($val["Tipo"]),1,0,'C', 0);
                    $pdf->Cell($concC + $refC + $cargosC, $a, utf8_decode($val["Concepto"]),1, 0, 'L', 0);
                    $pdf->Cell($abonosC, $a, utf8_decode($val["Abonos"]),1,0,'R', 0);
                    $pdf->Cell($saldoC, $a, utf8_decode($val["Saldo"]),1,1,'R', 0);
                }
            }
        } else{
            $pdf->Cell($fechaC, $a, utf8_decode($val["Fecha"]),1,0,'L', 0);
            $pdf->Cell($tipoC, $a, utf8_decode($val["Tipo"]),1,0,'C', 0);
            $pdf->Cell($concC, $a, utf8_decode($val["Concepto"]),1,0,'L', 0);
            $pdf->Cell($refC, $a, utf8_decode($val["Referencia"]),1,0,'C', 0);
            $pdf->Cell($cargosC, $a, utf8_decode($val["Cargos"]),1,0,'R', 0);
            $pdf->Cell($abonosC, $a, utf8_decode($val["Abonos"]),1,0,'R', 0);
            $pdf->Cell($saldoC, $a, utf8_decode($val["Saldo"]),1,1,'R', 0);
        }
    }

    function impEncabezado($pdf, $fechaI, $fechaF, $empacadora){
        global $fechaC;
        global $tipoC;
        global $concC; 
        global $refC;
        global $cargosC;
        global $abonosC; 
        global $saldoC;
        global $hoy;
        global $nomEmp;
    
        $pdf->SetFont('Arial','', 9);
        $pdf->SetX(64);
        
        if ($fechaI != "" && $fechaF != "" && $empacadora == ""){
            $pdf->Cell(0,7,utf8_decode("Del ".$fechaI." al ".$fechaF),0, 0, 'L');
            $pdf->Cell(0,7,utf8_decode('Fecha: '.$hoy),0, 1, 'R');
            $pdf->Ln(6);
        } else{
            if ($fechaI != "" && $fechaF != "" && $empacadora != ""){
                $pdf->Ln(2);
                $pdf->Cell(0,5,utf8_decode("Del ".$fechaI." al ".$fechaF),0, 0, 'C');
                $pdf->Cell(0,5,utf8_decode('Fecha: '.$hoy),0, 1, 'R');
                $pdf->Ln(2);
                $pdf->Cell(0,5,utf8_decode("Empacadora: ".$nomEmp),0, 1, 'L');
                $pdf->Ln(4);
            } else{
                if (($fechaI == "" && $fechaF == "" && $empacadora != "") ||
                    ($fechaI != "" && $fechaF == "" && $empacadora != "") ||
                    ($fechaI == "" && $fechaF != "" && $empacadora != "")){
                    $pdf->Cell(0,7,utf8_decode('Fecha: '.$hoy),0, 1, 'R');
                    $pdf->Ln(2);
                    $pdf->Cell(0,5,utf8_decode("Empacadora: ".$nomEmp),0, 1, 'L');
                    $pdf->Ln(4);
                } else{
                    $pdf->MultiCell(0,7,utf8_decode('Fecha: '.$hoy),0,'R');
                    $pdf->Ln(6);
                }
            }
        }

        ////////////////////////// Imprimir header de la tabla
        
        $pdf->SetFont('Arial','B',8);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(255);
        $pdf->SetFillColor(96, 196, 56);

        $pdf->Cell($fechaC,10,utf8_decode('Fecha'),0,0,'C', 'True');
        $pdf->Cell($tipoC,10,utf8_decode('Tipo'),0,0,'C', 'True');
        $pdf->Cell($concC,10,utf8_decode('Concepto'),0,0,'C','True');
        $pdf->Cell($refC,10,utf8_decode('Referencia'),0,0,'C', 'True');
        $pdf->Cell($cargosC,10,utf8_decode('Cargos'),0,0,'C', 'True');
        $pdf->Cell($abonosC,10,utf8_decode('Abonos'),0,0,'C', 'True');
        $pdf->MultiCell($saldoC,5,utf8_decode('Saldo inicial/ Saldo'),0,'C', 'True');
    }
    
    $pdf->SetTitle('Reporte de ingresos general', 1);
    
    if (@$_POST["id"] != ""){
        include '../registrar.php'; 

        //////////////////////////////////// crear documento ////////////////////////////////
        $nombre = 'ReportesPDF/Reporte de ingresos general.pdf';
        if(file_exists($nombre)){
            unlink($nombre);
            $bandera = 1;
            while ($bandera == 1){
                if(!file_exists($nombre)){
                    $bandera = 0;
                }
            }
        }

        $pdf->Output("F", $nombre);

        $bandera = 1;
        while ($bandera == 1){
            if(file_exists($nombre)){
                $bandera = 0;
            }
        }

        //////////////////// obtener datos para enviar a la función

        $fp =    @fopen($nombre,"rb");
        $data =  @fread($fp,filesize($nombre));
        @fclose($fp);
        $data = chunk_split(base64_encode($data));
        $size = filesize($nombre);
        $bName = basename($nombre);

        $r=mysqli_query($enlace,"select Correo from empacadora where IdEmpacadora = '".$empacadora."'"); 
        $myrow=mysqli_fetch_array($r);
        $correo = $myrow[0];

        if ($fechaI != "" && $fechaF != ""){
            $rango = " del ".$fechaI." al ".$fechaF;
        } else{
            $rango = "";
        }

        $asunto = "REPORTE DE INGRESOS AWOCOCADO";
        $mensaje = "<p>Buen día,<br>
            Adjunto reporte de ingresos".$rango.".<br>
            Sin más por el momento quedo a sus ordenes.<br><br>
            Atte Lcp. María Hernández</p>";

        echo enviarCorreo($data, $size, $bName, $asunto, $mensaje, $correo, $nomEmp);
    } else{
        $pdf->Output();
    }
?>