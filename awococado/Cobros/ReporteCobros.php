<?php
    require('../../libraries/fpdf.php');
    include '../conexion.php'; 
    
    class PDF extends FPDF{
        // Cabecera de página
        function Header(){
            $this->Image('../Imagenes/marcaAgua.png',73,47,155);
            $this->Ln(20);
            $this->SetFont('Arial','B',13);
            //////////////////////////////////////////////// Por fecha ///////////////////////////////////////////
            if($_POST["fechaI"] != "" && $_POST["fechaFin"] != "" && $_POST["empacadora"] == ""){
                headerPe($this);
            } else{
                //////////////////////////////////////////////// Por fecha y empacadora ///////////////////////////////////////////
                if ($_POST["fechaI"] != "" && $_POST["fechaFin"] != "" && $_POST["empacadora"] != ""){
                    headerEmp($this);
                } else{
                    //////////////////////////////////////////////// General ///////////////////////////////////////////
                    if (($_POST["fechaI"] == "" && $_POST["fechaFin"] == "" && $_POST["empacadora"] == "") || ($_POST["fechaI"] != "" && $_POST["fechaFin"] == "" && $_POST["empacadora"] == "") || ($_POST["fechaI"] == "" && $_POST["fechaFin"] != "" && $_POST["empacadora"] == "")){
                        headerPe($this);
                    } else{
                        //////////////////////////////////////////////// Por empacadora ///////////////////////////////////////////
                        headerEmp($this);
                    }
                }
            }
            $this->Ln(6);   
        }

        // Pie de página
        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,utf8_decode('AWOCOCADO A.C.'),0,0,'C');
        }
    }

    // Creación del objeto de la clase heredada
    $pdf = new PDF('L');
    $pdf->SetTitle(utf8_decode($_POST["tituloR"]));
    //////////////////////////////////////////////// Por fecha ///////////////////////////////////////////
    if($_POST["fechaI"] != "" && $_POST["fechaFin"] != "" && $_POST["empacadora"] == ""){
        $pdf->SetMargins(14, 10, 20);
    } else{
        //////////////////////////////////////////////// Por fecha y empacadora ///////////////////////////////////////////
        if ($_POST["fechaI"] != "" && $_POST["fechaFin"] != "" && $_POST["empacadora"] != ""){
            $pdf->SetMargins(26, 10, 20);
        } else{
            //////////////////////////////////////////////// General ///////////////////////////////////////////
            if (($_POST["fechaI"] == "" && $_POST["fechaFin"] == "" && $_POST["empacadora"] == "") || ($_POST["fechaI"] != "" && $_POST["fechaFin"] == "" && $_POST["empacadora"] == "") || ($_POST["fechaI"] == "" && $_POST["fechaFin"] != "" && $_POST["empacadora"] == "")){
                $pdf->SetMargins(14, 10, 20);
            } else{
                //////////////////////////////////////////////// Por empacadora ///////////////////////////////////////////
                $pdf->SetMargins(26, 10, 20);
            }
        }
    }
    $pdf->AliasNbPages();
    $pdf->AddPage();

    //////////////////////////////////////////////// Por fecha ///////////////////////////////////////////
    if($_POST["fechaI"] != "" && $_POST["fechaFin"] != "" && $_POST["empacadora"] == ""){
        $r=mysqli_query($enlace,"select f.FolioFactura, e.Nombre as Empacadora, f.FechaEmision, t.Concepto, f.Estatus, f.Total, f.Saldo, c.NumeroPDD, c.FechaCobro, c.Monto from facturasaporta as f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join bancos as b on e.IdBanco = b.IdBanco inner join regimen as r on e.IdRegimen = r.IdRegimen inner join tipoaportacion as t on t.IdTipoAportacion = f.IdTipoAportacion inner join cobros as c on f.IdFolioAporta = c.IdFolioAporta where c.FechaCobro BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaFin"]."' ORDER BY c.FechaCobro DESC");

        $f=mysqli_query($enlace, "Select Sum(Monto) FROM cobros where FechaCobro BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaFin"]."'");
        periodo($r, $f, $pdf);
    } else{
        //////////////////////////////////////////////// Por fecha y empacadora ///////////////////////////////////////////
        if ($_POST["fechaI"] != "" && $_POST["fechaFin"] != "" && $_POST["empacadora"] != ""){
            $r=mysqli_query($enlace,"select f.FolioFactura, f.FechaEmision, t.Concepto, f.Estatus, f.SubTotal, f.Iva, f.Total, f.Saldo, c.NumeroPDD, c.FechaCobro, c.Monto from facturasaporta as f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join bancos as b on e.IdBanco = b.IdBanco inner join regimen as r on e.IdRegimen = r.IdRegimen inner join tipoaportacion as t on t.IdTipoAportacion = f.IdTipoAportacion inner join cobros as c on f.IdFolioAporta = c.IdFolioAporta where c.FechaCobro BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaFin"]."' AND f.IdEmpacadora = ".$_POST["empacadora"]." ORDER BY c.FechaCobro DESC");
    
            $f=mysqli_query($enlace, "Select Sum(c.Monto) FROM cobros as c inner join facturasaporta as f on f.IdFolioAporta = c.IdFolioAporta where c.FechaCobro BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaFin"]."' AND f.IdEmpacadora = ".$_POST["empacadora"]."");
            empacadora($r, $f, $pdf, $enlace);
        } else{
            //////////////////////////////////////////////// General ///////////////////////////////////////////
            if (($_POST["fechaI"] == "" && $_POST["fechaFin"] == "" && $_POST["empacadora"] == "") || ($_POST["fechaI"] != "" && $_POST["fechaFin"] == "" && $_POST["empacadora"] == "") || ($_POST["fechaI"] == "" && $_POST["fechaFin"] != "" && $_POST["empacadora"] == "")){
                $r=mysqli_query($enlace,"select f.FolioFactura, e.Nombre as Empacadora, f.FechaEmision, t.Concepto, f.Estatus, f.Total, f.Saldo, c.NumeroPDD, c.FechaCobro, c.Monto from facturasaporta as f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join bancos as b on e.IdBanco = b.IdBanco inner join regimen as r on e.IdRegimen = r.IdRegimen inner join tipoaportacion as t on t.IdTipoAportacion = f.IdTipoAportacion inner join cobros as c on f.IdFolioAporta = c.IdFolioAporta ORDER BY c.FechaCobro DESC");


                $f=mysqli_query($enlace, "Select Sum(Monto) FROM cobros");
                periodo($r, $f, $pdf);
            } else{
                //////////////////////////////////////////////// Por empacadora ///////////////////////////////////////////
                $r=mysqli_query($enlace,"select f.FolioFactura, f.FechaEmision, t.Concepto, f.Estatus, f.SubTotal, f.Iva, f.Total, f.Saldo, c.NumeroPDD, c.FechaCobro, c.Monto from facturasaporta as f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join bancos as b on e.IdBanco = b.IdBanco inner join regimen as r on e.IdRegimen = r.IdRegimen inner join tipoaportacion as t on t.IdTipoAportacion = f.IdTipoAportacion inner join cobros as c on f.IdFolioAporta = c.IdFolioAporta where f.IdEmpacadora = ".$_POST["empacadora"]." ORDER BY c.FechaCobro DESC");
    
                $f=mysqli_query($enlace, "Select Sum(c.Monto) FROM cobros as c inner join facturasaporta as f on f.IdFolioAporta = c.IdFolioAporta where f.IdEmpacadora = ".$_POST["empacadora"]."");
                empacadora($r, $f, $pdf, $enlace);
            }
        }
    }

    function periodo($tabla, $total, $pdf){
        $pdf->SetFont('Arial','B',7);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(255);
        $pdf->SetFillColor(96, 196, 56);

        $pdf->Cell(17,8,utf8_decode('Folio factura'),0,0,'C', 'True');
        $pdf->Cell(60,8,utf8_decode('Empacadora'),0,0,'C','True');
        $pdf->Cell(15,8,utf8_decode('Fecha F'),0,0,'C', 'True');
        $pdf->Cell(30,8,utf8_decode('Tipo aportacion'),0,0,'C','True');
        $pdf->Cell(17,8,utf8_decode('Estatus'),0,0,'C', 'True');
        $pdf->Cell(20,8,utf8_decode('Total'),0,0,'C', 'True');
        $pdf->Cell(20,8,utf8_decode('Saldo'),0,0,'C', 'True');
        $pdf->Cell(55,8,utf8_decode('No. PDD'),0,0,'C', 'True');
        $pdf->Cell(15,8,utf8_decode('Fecha C'),0,0,'C', 'True');
        $pdf->Cell(20,8,utf8_decode('Monto'),0,1,'C', 'True');

        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(243);

        while ($myrow=mysqli_fetch_array($tabla)){ 
            $pdf->Cell(17,8,utf8_decode($myrow[0]),1,0,'C', 0);
            $pdf->Cell(60,8,utf8_decode($myrow[1]),1,0,'C', 0);
            $pdf->Cell(15,8,utf8_decode($myrow[2]),1,0,'C', 0);
            $pdf->Cell(30,8,utf8_decode($myrow[3]),1,0,'C', 0);
            $pdf->Cell(17,8,utf8_decode($myrow[4]),1,0,'C', 0);
            $pdf->Cell(20,8,utf8_decode($myrow[5]),1,0,'C', 0);
            $pdf->Cell(20,8,utf8_decode($myrow[6]),1,0,'C', 0);
            $pdf->Cell(55,8,utf8_decode($myrow[7]),1,0,'C', 0);
            $pdf->Cell(15,8,utf8_decode($myrow[8]),1,0,'C', 0);
            $pdf->Cell(20,8,utf8_decode($myrow[9]),1,1,'C', 0);
        }

        $yourow=mysqli_fetch_array($total);
        $pdf->Cell(234);
        $pdf->Cell(15,8,"Total",1,0,'C', 0);
        $pdf->Cell(20,8,$yourow[0],1,1,'C', 0);
    }

    function empacadora($tabla, $total, $pdf, $enlace){
        $pdf->SetFont('Arial','B', 8);
        $pdf->SetDrawColor(243);
        $pdf->SetTextColor(0);

        $r=mysqli_query($enlace,"select e.RFC, r.Concepto, b.Nombre as Banco, b.NumCuenta, b.Clabe, e.Saldo from empacadora as e inner join bancos as b on e.IdBanco = b.IdBanco inner join regimen as r on e.IdRegimen = r.IdRegimen where e.IdEmpacadora = '".$_POST["empacadora"]."'");
        $myrow=mysqli_fetch_array($r);

        $pdf->Cell(27,8,utf8_decode("RFC"),1,0,'C', 0);
        $pdf->Cell(64,8,utf8_decode("Régimen"),1,0,'C', 0);
        $pdf->Cell(64,8,utf8_decode("Banco"),1,0,'C', 0);
        $pdf->Cell(36,8,utf8_decode("No. Cuenta"),1,0,'C', 0);
        $pdf->Cell(36,8,utf8_decode("Clabe"),1,0,'C', 0);
        $pdf->Cell(18,8,utf8_decode("Saldo"),1,1,'C', 0);
        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(27,8,utf8_decode($myrow[0]),1,0,'C', 0);
        $pdf->Cell(64,8,utf8_decode($myrow[1]),1,0,'C', 0);
        $pdf->Cell(64,8,utf8_decode($myrow[2]),1,0,'C', 0);
        $pdf->Cell(36,8,utf8_decode($myrow[3]),1,0,'C', 0);
        $pdf->Cell(36,8,utf8_decode($myrow[4]),1,0,'C', 0);
        $pdf->Cell(18,8,utf8_decode($myrow[5]),1,1,'C', 0);
        
        $pdf->Ln(8);
        
        $pdf->SetFont('Arial','B',8);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(255);
        $pdf->SetFillColor(96, 196, 56);

        $pdf->Cell(19,8,utf8_decode('Folio factura'),1,0,'C', 'True');
        $pdf->Cell(15,8,utf8_decode('Fecha F'),1,0,'C', 'True');
        $pdf->Cell(30,8,utf8_decode('Tipo aportacion'),1,0,'C','True');
        $pdf->Cell(17,8,utf8_decode('Estatus'),1,0,'C', 'True');
        $pdf->Cell(20,8,utf8_decode('Subtotal'),1,0,'C', 'True');
        $pdf->Cell(14,8,utf8_decode('Iva'),1,0,'C', 'True');
        $pdf->Cell(20,8,utf8_decode('Total'),1,0,'C', 'True');
        $pdf->Cell(20,8,utf8_decode('Saldo'),1,0,'C', 'True');
        $pdf->Cell(55,8,utf8_decode('No. PDD'),1,0,'C', 'True');
        $pdf->Cell(15,8,utf8_decode('Fecha C'),1,0,'C', 'True');
        $pdf->Cell(20,8,utf8_decode('Monto'),1,1,'C', 'True');

        $pdf->SetFont('Arial','',7);
        $pdf->SetDrawColor(243);
        $pdf->SetTextColor(0);
        $pdf->SetFillColor(255, 255, 255);
        
        while ($myrow=mysqli_fetch_array($tabla)){ 
            $pdf->Cell(19,8,utf8_decode($myrow[0]),1,0,'C', 0);
            $pdf->Cell(15,8,utf8_decode($myrow[1]),1,0,'C', 0);
            $pdf->Cell(30,8,utf8_decode($myrow[2]),1,0,'C', 0);
            $pdf->Cell(17,8,utf8_decode($myrow[3]),1,0,'C', 0);
            $pdf->Cell(20,8,utf8_decode($myrow[4]),1,0,'C', 0);
            $pdf->Cell(14,8,utf8_decode($myrow[5]),1,0,'C', 0);
            $pdf->Cell(20,8,utf8_decode($myrow[6]),1,0,'C', 0);
            $pdf->Cell(20,8,utf8_decode($myrow[7]),1,0,'C', 0);
            $pdf->Cell(55,8,utf8_decode($myrow[8]),1,0,'C', 0);
            $pdf->Cell(15,8,utf8_decode($myrow[9]),1,0,'C', 0);
            $pdf->Cell(20,8,utf8_decode($myrow[10]),1,1,'C', 0);
        }

        $yourow=mysqli_fetch_array($total);
        $pdf->Cell(210);
        $pdf->Cell(15,8,"Total",1,0,'C','True');
        $pdf->Cell(20,8,$yourow[0],1,1,'C','True');
    }

    function headerEmp($doc){
        $doc->Image('../Imagenes/logoIn.png',26,5,50);
        $doc->SetXY(79, 7);
        $doc->MultiCell(138,7,utf8_decode(mb_strtoupper($_POST["tituloR"])),0,'C');
    }

    function headerPe($doc){
        $doc->Image('../Imagenes/logoIn.png',14,4,50);
        $doc->SetXY(69, 10);
        $doc->MultiCell(160,7,utf8_decode(mb_strtoupper($_POST["tituloR"])),0,'C');
    }
    $pdf->Output();
?>