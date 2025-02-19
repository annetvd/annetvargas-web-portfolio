<?php
    require('../../libraries/fpdf.php');
    include '../consultar.php'; 

    ///////////////////// Inicialiciar valores
    $meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
    $empacadora = $_POST["empacadoraEC"];
    if ($_POST["empacadoraEC"] != ""){
        $b = mysqli_query($enlace,"select Nombre from empacadora where IdEmpacadora = '".$_POST["empacadoraEC"]."'");
        $myrow=mysqli_fetch_array($b);
        $nomEmp = $myrow[0];
    }
    $estatus = $_POST["estatusEC"];
    if ($_POST["fechaIEC"] != ""){
        $fechaI = substr($_POST["fechaIEC"],8 , 2)."/".$meses[substr($_POST["fechaIEC"],5 , 2) - 1]."/".substr($_POST["fechaIEC"],0 , 4);
    } else{
        $fechaI = "";
    }
    if ($_POST["fechaFEC"] != ""){
        $fechaF = substr($_POST["fechaFEC"],8 , 2)."/".$meses[substr($_POST["fechaFEC"],5 , 2) - 1]."/".substr($_POST["fechaFEC"],0 , 4);
    } else{
        $fechaF = "";
    }
    $hoy = date("d")."/".$meses[date("m") - 1]."/".date("Y");
    
    $factC = 11;
    $expC = 23;
    $kgC = 18;
    $tasaC = 14;
    $cantC = 18;
    $facturadoC = 18;
    $fechaC = 28; 
    $pagadoC = 18;
    $saldoC = 18;
    $estatusC = 12; 
    
    /////////////////////////////////////////////// generar encabezado y pie de página //////////////////////////////////////////////
    class PDF extends FPDF{
        // Cabecera de página
        function Header(){
            global $fechaI;
            global $fechaF;
            global $empacadora;
            global $estatus;
            
            $this->Image('../Imagenes/LogoRI.png',21,5,32);
            $this->Image('../Imagenes/marcaAgua.png',30,81,155);
            $this->SetFont('Arial','B',13);
            $this->SetXY(57,11);
            
            if ($empacadora != ""){
                $this->MultiCell(96,7,utf8_decode('ESTADO DE CUENTA'),0,'L');
            } else{
                if (($fechaI != "" && $fechaF != "") || $estatus != ""){
                    $this->MultiCell(96,7,utf8_decode('ESTADOS DE CUENTA'),0,'L');
                } else{
                    $this->MultiCell(96,7,utf8_decode('ESTADOS DE CUENTA'),0,'C');
                }
            }
            
            impEncabezado($this, $fechaI, $fechaF, $empacadora, $estatus);
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
    $pdf->SetMargins(16, 10, 16);
    $pdf->AddPage();

    //////////////////////////////// Imprimir tabla ////////////////////////////////////
    $x = 0;

    foreach(formatoNumRepEC(obtRepEC($_POST["empacadoraEC"], $_POST["fechaIEC"], $_POST["fechaFEC"], $_POST["estatusEC"])) as $val) { 
        if ($empacadora == ""){
            llenarFila($val);
        } else{
            if ($x == 1){
                llenarFila($val);
            } else{
                $x = 1;
            }
        }
    }

    function llenarFila($val){
        global $pdf;
        global $factC;
        global $expC;
        global $kgC;
        global $tasaC;
        global $cantC;
        global $facturadoC;
        global $fechaC; 
        global $pagadoC;
        global $saldoC;
        global $estatusC; 
        $a = 8;
        
        $pdf->SetFont('Arial','',6);
        $pdf->SetDrawColor(243);
        $pdf->SetTextColor(0);

        if ($val["Factura"] == ""){
            if ($val["Exportacion"] == "<br>"){
                $pdf->Cell($factC,$a,utf8_decode($val["Factura"]),1,0,'C', 0);
                $pdf->Cell($expC,$a,utf8_decode(""),1,0,'L', 0);
                $pdf->Cell($kgC,$a,utf8_decode($val["Kilogramos"]),1,0,'R', 0);
                $pdf->Cell($tasaC,$a,utf8_decode($val["Tasa"]),1,0,'L', 0);
                $pdf->Cell($cantC,$a,utf8_decode($val["Cantidad"]),1,0,'R', 0);
                $pdf->Cell($facturadoC,$a,utf8_decode($val["Facturado"]),1,0,'R', 0);
                $pdf->Cell($fechaC,$a,utf8_decode($val["FechaPago"]),1,0,'L', 0);
                $pdf->Cell($pagadoC,$a,utf8_decode($val["CantidadPagada"]),1,0,'R', 0);
                $pdf->Cell($saldoC,$a,utf8_decode($val["Saldo"]),1,0,'R', 0);
                $pdf->Cell($estatusC,$a,utf8_decode($val["Estatus"]),1,1,'L', 0);
            } else{
                if ($val["Tasa"] != ""){
                    $pdf->Cell($factC,$a,utf8_decode($val["Factura"]),1,0,'C', 0);
                    $pdf->Cell($expC,$a,utf8_decode(""),1,0,'L', 0);
                    $pdf->Cell($kgC,$a,utf8_decode($val["Kilogramos"]),1,0,'R', 0);
                    $pdf->Cell($tasaC,$a,utf8_decode($val["Tasa"]),1,0,'R', 0);
                    $pdf->Cell($cantC,$a,utf8_decode($val["Cantidad"]),1,0,'R', 0);
                    $pdf->Cell($facturadoC,$a,utf8_decode($val["Facturado"]),1,0,'R', 0);
                    $pdf->Cell($fechaC,$a,utf8_decode($val["FechaPago"]),1,0,'L', 0);
                    $pdf->Cell($pagadoC,$a,utf8_decode($val["CantidadPagada"]),1,0,'R', 0);
                    $pdf->Cell($saldoC,$a,utf8_decode($val["Saldo"]),1,0,'R', 0);
                    $pdf->Cell($estatusC,$a,utf8_decode($val["Estatus"]),1,1,'L', 0);
                } else{
                    $pdf->Cell($factC,$a,utf8_decode($val["Factura"]),1,0,'C', 0);
                    $pdf->Cell($expC,$a,utf8_decode($val["Exportacion"]),1,0,'L', 0);
                    $pdf->Cell($kgC,$a,utf8_decode($val["Kilogramos"]),1,0,'R', 0);
                    $pdf->Cell($fechaC + $pagadoC + $saldoC + $estatusC + $tasaC + $cantC + $facturadoC,$a,utf8_decode($val["FechaPago"]),1,1,'L', 0);
                }
            }
        } else{
            $pdf->Cell($factC,$a,utf8_decode($val["Factura"]),1,0,'C', 0);
            $pdf->Cell($expC,$a,utf8_decode($val["Exportacion"]),1,0,'L', 0);
            $pdf->Cell($kgC,$a,utf8_decode($val["Kilogramos"]),1,0,'R', 0);
            $pdf->Cell($tasaC,$a,utf8_decode($val["Tasa"]),1,0,'L', 0);
            $pdf->Cell($cantC,$a,utf8_decode($val["Cantidad"]),1,0,'R', 0);
            $pdf->Cell($facturadoC,$a,utf8_decode($val["Facturado"]),1,0,'R', 0);
            $pdf->Cell($fechaC,$a,utf8_decode($val["FechaPago"]),1,0,'L', 0);
            $pdf->Cell($pagadoC,$a,utf8_decode($val["CantidadPagada"]),1,0,'R', 0);
            $pdf->Cell($saldoC,$a,utf8_decode($val["Saldo"]),1,0,'R', 0);
            $pdf->Cell($estatusC,$a,utf8_decode($val["Estatus"]),1,1,'L', 0);
        }
    }

    function impEncabezado($pdf, $fechaI, $fechaF, $empacadora, $estatus){
        global $factC;
        global $expC;
        global $kgC;
        global $tasaC;
        global $cantC;
        global $facturadoC;
        global $fechaC; 
        global $pagadoC;
        global $saldoC;
        global $estatusC; 
        global $hoy;
        global $nomEmp;
    
        $pdf->SetFont('Arial','', 9);
        $pdf->SetX(57);

        if ($fechaI != "" && $fechaF != ""){
            $pdf->Cell(0,7,utf8_decode("Del ".$fechaI." al ".$fechaF),0, 0, 'L');
        }

        $pdf->Cell(0,7,utf8_decode('Fecha: '.$hoy),0, 1, 'R');

        if ($empacadora != "" || $estatus != ""){
            $pdf->Ln(1);
        }

        if ($empacadora != ""){
            $pdf->Cell(0,7,utf8_decode("Empacadora: ".$nomEmp),0, 0, 'L');
        }

        if ($estatus != ""){
            if ($empacadora == ""){
                $pdf->Cell(0,7,utf8_decode('Fact. estatus: '.$estatus),0, 0, 'L');
            } else{
                $pdf->Cell(0,7,utf8_decode('Fact. estatus: '.$estatus),0, 0, 'R');
            }
        }

        if ($empacadora != "" || $estatus != ""){
            $pdf->Ln(9);
            $y = 35;
        } else{
            $pdf->Ln(7);
            $y = 32;
        }

        ////////////////////////// Imprimir header de la tabla
        
        $pdf->SetFont('Arial','B',7);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(255);
        $pdf->SetFillColor(96, 196, 56);

        $pdf->Cell($factC,10,utf8_decode('Factura'),0,0,'C','True');
        $pdf->MultiCell($expC,5,utf8_decode('Exportación del mes'),0,'C', 'True');
        $pdf->SetXY(($factC + $expC + 16), $y);
        $pdf->Cell($kgC,10,utf8_decode('Kg. Total'),0,0,'C', 'True');
        $pdf->Cell($tasaC,10,utf8_decode('Tasa'),0,0,'C', 'True');
        $pdf->MultiCell($cantC,5,utf8_decode('Cantidad x (Cvos/Kg)'),0,'C', 'True');
        $pdf->SetXY(($factC + $expC + $kgC + $tasaC + $cantC + 16), $y);
        $pdf->Cell($facturadoC,10,utf8_decode('Facturado'),0,0,'C','True');
        $pdf->Cell($fechaC,10,utf8_decode('Fecha de pago'),0,0,'C', 'True');
        $pdf->MultiCell($pagadoC,5,utf8_decode('Cantidad pagada'),0,'C', 'True');
        $pdf->SetXY(($factC + $expC + $kgC + $tasaC + $cantC + $facturadoC + $fechaC + $pagadoC + 16), $y);
        $pdf->MultiCell($saldoC,5,utf8_decode('Saldo a cubrir'),0,'C', 'True');
        $pdf->SetXY(($factC + $expC + $kgC + $tasaC + $cantC + $facturadoC + $fechaC + $pagadoC + $saldoC + 16), $y);
        $pdf->Cell($estatusC,10,utf8_decode('Estatus'),0,1,'C', 'True');
    }
    
    if ($empacadora == ""){
        $pdf->SetTitle('Estados de cuenta', 1);
    } else{
        $pdf->SetTitle('Estado de cuenta, '.$nomEmp, 1);
    }

    if (@$_POST["id"] != ""){
        include '../registrar.php'; 

        //////////////////////////////////// crear documento ////////////////////////////////
        $nombre = 'ReportesPDF/Estado de cuenta.pdf';
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

        if ($estatus != ""){
            $factEst = ", facturas ".strtolower($estatus)."s";
        } else{
            $factEst = "";
        }

        $asunto = "ESTADO DE CUENTA AWOCOCADO";
        $mensaje = "<p>Buen día,<br>
            Adjunto estado de cuenta".$rango.$factEst.".<br>
            Sin más por el momento quedo a sus ordenes.<br><br>
            Atte Lcp. María Hernández</p>";

        echo enviarCorreo($data, $size, $bName, $asunto, $mensaje, $correo, $nomEmp);
    } else{
        $pdf->Output();
    }
?>