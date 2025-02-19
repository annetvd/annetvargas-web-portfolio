<?php
    require('../../libraries/fpdf.php');
    include '../conexion.php'; 
    
    class PDF extends FPDF{
        // Cabecera de página
        function Header(){
            // Logo
            $this->Image('../Imagenes/LogoR.png',10,8,30);
            $this->Ln(20);
            $this->SetFont('Arial','B',13);
            $this->SetXY(50,15);
            $this->MultiCell(114,7,utf8_decode('REPORTE DE FACTURAS POR ESTATUS'),0,'C');
            $this->Ln(10);
            // Arial bold 15
            $this->SetFont('Arial','B',10);
            // Movernos a la derecha
            $this->Cell(10);
            $this->SetFillColor(124, 252, 0);
            // Título
            $this->cell(0.1);
            $this->Cell(30,10,'IdFolioFactura',1,0,'C', 'True');
            $this->Cell(50,10,'Empacadora',1,0,'C','True');
            $this->Cell(30,10,'FolioFactura',1,0,'C', 'True');
            $this->Cell(30,10,utf8_decode('FechaEmisión'),1,0,'C','True');
            $this->Cell(40,10,'Concepto',1,0,'C', 'True');
            $this->Cell(40,10,'Estatus',1,0,'C', 'True');
            $this->Cell(30,10,'Cantidad',1,0,'C', 'True');
            $this->Cell(20,10, utf8_decode('Saldo'),1,1,'C', 'True');
            
            // Salto de línea
            
            
        }

        function construct(){
            $this->SetDrawColor(248 , 249, 251);
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
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',10);

    $r=mysqli_query($enlace,"select f.IdFolioAporta, e.Nombre as empacadora, f.FolioFactura, f.FechaEmision, f.Cantidad, f.Concepto, f.Estatus, f.Saldo from facturasaporta As f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora where f.Estatus = '".$_POST['estatus']."'ORDER BY f.FechaEmision DESC");

    while ($myrow=mysqli_fetch_array($r)){ 
        $pdf->cell(10);
        $pdf->cell(30, 10, utf8_decode($myrow[0]), 1, 0, 'C', 0);
        $pdf->cell(50, 10, utf8_decode($myrow[1]), 1, 0, 'C', 0);
        $pdf->cell(30, 10, $myrow[2], 1, 0, 'C', 0);
        $pdf->cell(30, 10, $myrow[3], 1, 0, 'C', 0);
        $pdf->cell(40, 10, $myrow[5], 1, 0, 'C', 0);
        $pdf->cell(40, 10, $myrow[6], 1, 0, 'C', 0);
        $pdf->cell(30, 10, $myrow[4], 1, 0, 'C', 0);
        $pdf->cell(20, 10, $myrow[7], 1, 1, 'C', 0);

        
    }
    $f=mysqli_query($enlace, "Select Sum(f.Cantidad) FROM facturasaporta As f where f.Estatus = '".$_POST['estatus']."'");
    while($yourow=mysqli_fetch_array($f)){
        $pdf->cell(10);
        $pdf->cell(30, 10,'', 0, 0, 'C', 0);
        $pdf->cell(50, 10, '', 0, 0, 'C', 0);
        $pdf->cell(30, 10, '', 0, 0, 'C', 0);
        $pdf->cell(30, 10, '', 0, 0, 'C', 0);
        $pdf->cell(40, 10, '', 0, 0, 'C', 0);
        $pdf->cell(40, 10, 'Total', 1, 0, 'C', 0,'True');
        $pdf->cell(30, 10, $yourow[0], 1, 0, 'C', 0);
        
    }

    $e=mysqli_query($enlace, "Select Sum(f.Saldo) FROM facturasaporta As f where f.Estatus = '".$_POST['estatus']."'");
    while($torow=mysqli_fetch_array($e)){
        $pdf->cell(20, 10, $torow[0], 1, 1, 'C', 0);
    }

    $pdf->Output();
?>