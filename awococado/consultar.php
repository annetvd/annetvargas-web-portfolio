<?php
    include 'conexion.php'; 
    $id = @$_POST['id'];

    if ($id == 'tipoAport') {
		$r=mysqli_query($enlace,"select IdTipoAportacion, Concepto from tipoaportacion ORDER BY Concepto ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}

	if ($id == 'municipios') {
		$r=mysqli_query($enlace,"select IdMunicipio, Nombre from municipio where IdEstado = ".$_POST["idEstado"]." ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
	
	if ($id == 'municipiosO') {
		$r=mysqli_query($enlace,"select m.IdMunicipio, m.Nombre from municipio as m inner join estado as e on m.IdEstado = e.IdEstado where lower(e.Nombre) = 'jalisco' ORDER BY m.Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}

	if ($id == 'idEmpacadora') {
		$r=mysqli_query($enlace,"select IdEmpacadora from empacadora"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[0]."</option>";
		}
	}

	if ($id == 'empacadora') {
		$r=mysqli_query($enlace,"select e.*, ta.Concepto, m.Nombre from empacadora As e inner join tipoaportacion As ta on e.IdTipoAportacion = ta.IdTipoAportacion inner join municipio As m on e.IdMunicipio = m.IdMunicipio ORDER BY e.Nombre ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[0]."</td>";
			echo "<td>".$myrow[2]."</td>";
			echo "<td>".$myrow[15]."</td>";
			echo "<td>".$myrow[3]."</td>";
			echo "<td>".$myrow[5]."</td>";
			echo "<td>".$myrow[4]."</td>";
			echo "<td>".$myrow[16]."</td>";
			echo "<td>".$myrow[7]."</td>";
			echo "<td>".$myrow[8]."</td>";
			echo "<td>".$myrow[9]."</td>";
			echo "<td>".$myrow[10]."</td>";
			echo "<td>".$myrow[11]."</td>";
			echo "<td>".$myrow[12]."</td>";
			echo "<td>".$myrow[13]."</td>";
			echo "<td>".$myrow[14]."</td>";
			echo "</tr>";
		}
	}

	if ($id == 'obtEmpacadora') {
		$r=mysqli_query($enlace,"select e.*, b.IdNombreBanco as Banco, b.NumCuenta, b.Clabe from empacadora as e inner join bancos as b on e.IdBanco = b.IdBanco where e.IdEmpacadora = '".$_POST["idEmpacadora"]."'"); 
		$datos = array();
		$resultado = $r->fetch_assoc();
        $datos['result'] = $resultado;
		echo json_encode($datos);
	}

	if ($id == 'tipoaportacion') {
		$r=mysqli_query($enlace,"select * from tipoaportacion ORDER BY Concepto ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[1]."</td>";
			if ($myrow[2] == 1){
			    echo "<td>Si</td>";
			} else{
			    echo "<td>No</td>";
			}
			echo "</tr>";
		}
	}

	if ($id == 'estado') {
		$r=mysqli_query($enlace,"select p.Nombre as Pais, e.Nombre as Estado from estado as e inner join pais as p on e.IdPais = p.IdPais ORDER BY p.Nombre, e.Nombre ASC"); 
		$resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}

	if ($id == 'pais') {
		$r=mysqli_query($enlace,"select c.NombreContinente, g.NombreGrupo, p.Nombre from pais as p inner join grupos as g on p.IdGrupo = g.IdGrupo inner join continentes as c on c.IdContinente = p.IdContinente ORDER BY c.NombreContinente, g.NombreGrupo, p.Nombre ASC"); 
		$resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}

	if ($id == 'transporte') {
		$r=mysqli_query($enlace,"select IdTransporte, Descripcion from transporte ORDER BY Descripcion ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[1]."</td>";			
			echo "</tr>";
		}
	}
	
	if ($id == 'tercerias') {
		$r=mysqli_query($enlace,"select Nombre from tercerias ORDER BY Nombre ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[0]."</td>";			
			echo "</tr>";
		}
	}
	
	if ($id == 'tercerosEspecialistas') {
		$r=mysqli_query($enlace,"select t.Nombre, ti.Nombre from terceroespecialista as t inner join tercerias as ti on ti.IdTerceria = t.IdTerceria ORDER BY t.Nombre ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[0]."</td>";	
			echo "<td>".$myrow[1]."</td>";			
			echo "</tr>";
		}
	}
	
	if ($id == 'expedidorcfi') {
		$r=mysqli_query($enlace,"select * from expedidorcfi ORDER BY Nombre ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[1]."</td>";
			echo "</tr>";
		}
	}
	
	if ($id == 'nombresBancos') {
		$r=mysqli_query($enlace,"select Nombre from nombresbancos ORDER BY Nombre ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[0]."</td>";
			echo "</tr>";
		}
	}

	if ($id == 'proveedores') {
		$r=mysqli_query($enlace,"select * from proveedores ORDER BY Nombre ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[1]."</td>";
			echo "<td>".$myrow[2]."</td>";
			echo "<td>".$myrow[3]."</td>";
			echo "</tr>";
		}
	}

	if ($id == 'areas') {
		$r=mysqli_query($enlace,"select * from areas ORDER BY Concepto ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[1]."</td>";
			echo "</tr>";
		}
	}

	if ($id == 'bancos') {
		$r=mysqli_query($enlace,"select * from bancos ORDER BY Nombre ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[1]."</td>";
			echo "</tr>";
		}
	}
	
	if ($id == 'impCuenta') {
		$r=mysqli_query($enlace,"select b.IdBanco, nb.Nombre, b.NumCuenta from bancos as b inner join nombresbancos as nb on nb.IdNombreBanco  = b.IdNombreBanco where b.TipoBanco = 'A' ORDER BY nb.Nombre, b.NumCuenta ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1].", ".$myrow[2]."</option>";
		}
	}

	if ($id == 'municipio') {
		$r=mysqli_query($enlace,"select p.Nombre as Pais, e.Nombre as Estado, m.Nombre as Municipio from municipio as m inner join estado as e on m.IdEstado = e.IdEstado inner join pais as p on e.IdPais = p.IdPais ORDER BY p.Nombre, e.Nombre, m.Nombre ASC"); 
		$resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'regimen') {
		$r=mysqli_query($enlace,"select * from regimen ORDER BY Concepto ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[2]."</td>";
			echo "<td>".$myrow[1]."</td>";			
			echo "</tr>";
		}
	}

	if ($id == 'imprTransporte') {
		$r=mysqli_query($enlace,"select IdTransporte, Descripcion from transporte ORDER BY Descripcion ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
	
	if ($id == 'idPais') {
		$r=mysqli_query($enlace,"select IdPais, Nombre from estado ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}

	if ($id == 'impExpedidorCFI') {
		$r=mysqli_query($enlace,"select IdExpedidorCFI, Nombre from expedidorcfi ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
	
	if ($id == 'impNombresBancos') {
		$r=mysqli_query($enlace,"select IdNombreBanco, Nombre from nombresbancos ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
	
	if ($id == 'cuentasBancarias') {
		$r=mysqli_query($enlace,"select n.Nombre, b.NumCuenta, b.Clabe, date_format(b.Fecha, '%d/%m/%Y') as Fecha, b.Saldo, b.IdBanco from bancos as b inner join nombresbancos as n on n.IdNombreBanco = b.IdNombreBanco where TipoBanco = 'A' ORDER BY n.Nombre, b.NumCuenta, b.Clabe ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[0]."</td>";
			echo "<td>".$myrow[1]."</td>";
			echo "<td>".$myrow[2]."</td>";
			echo "<td>".$myrow[3]."</td>";
			echo "<td>".number_format($myrow[4], 2, ".", ",")."</td>";
			$sumar = 0;
			$p=mysqli_query($enlace, "select Monto from pagos where IdBancoO = '".$myrow[5]."'");
			while ($pago=mysqli_fetch_array($p)) {
			    $sumar = $sumar + $pago[0];
			}
			$restar = 0;
			$c=mysqli_query($enlace, "select Monto from cobros where IdBancoAs = '".$myrow[5]."'");
			while ($cobro=mysqli_fetch_array($c)) {
			    $restar = $restar - $cobro[0];
			}
			$saldo = $myrow[4] + $sumar - $restar;
			echo "<td>".number_format($saldo, 2, ".", ",")."</td>";
			echo "</tr>";
		}
	}

	if ($id == 'impPais') {
		$r=mysqli_query($enlace,"select IdPais, Nombre from pais ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
	
	if ($id == 'impTerceria') {
		$r=mysqli_query($enlace,"select IdTerceria, Nombre from tercerias ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}

	if ($id == 'impEstado') {
		$r=mysqli_query($enlace,"select IdEstado, Nombre from estado where IdPais = ".$_POST["pais"]." ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) { 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}

	if ($id == 'impFolioCFI') {
		$r=mysqli_query($enlace,"select FolioCFI from certificados where IdEmpacadora = ".$_POST["idEmpacadora"]." ORDER BY FolioCFI DESC");
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[0]."</option>";
		}
	}
	
	if ($id == 'impRegimen') {
		$r=mysqli_query($enlace,"select * from regimen ORDER BY Concepto ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[2]."</option>";
		}
	}

	if ($id == 'impTE') {
		$r=mysqli_query($enlace,"select IdTerceroEspecialista, Nombre from terceroespecialista ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
    
    if ($id == 'regulaciones') {
		$r=mysqli_query($enlace,"select p.Nombre as Pais, e.Nombre as Estado, m.Nombre as Municipio, r.Nombre as Puerto from regulaciones as r inner join municipio as m on r.IdMunicipio = m.IdMunicipio inner join estado as e on m.IdEstado = e.IdEstado inner join pais as p on e.IdPais = p.IdPais ORDER BY p.Nombre, e.Nombre, m.Nombre, r.Nombre ASC"); 
		$resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
    
	if ($id == 'imprRegulacion') {
		$r=mysqli_query($enlace,"select IdRegulacion, Nombre from regulaciones where IdMunicipio = ".$_POST["municipio"]." ORDER BY Nombre ASC");
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}

	if ($id == 'imprRegulacionRe') {
		$r=mysqli_query($enlace,"select IdRegulacion, Nombre from regulaciones where IdMunicipio = ".$_POST["municipio"]." ORDER BY Nombre ASC");
		echo "<option value=''>...</option>";
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[0] == $_POST["reg"]){
				echo "<option value='".$myrow[0]."' selected>".$myrow[1]."</option>";
			} else{
			    echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
			}
		}
	}
	
	if ($id == 'impEstadoRe') {
		$r=mysqli_query($enlace,"select IdEstado, Nombre from estado where IdPais = ".$_POST["pais"]." ORDER BY Nombre ASC");
		echo "<option value=''>...</option>";
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[0] == $_POST["estado"]){
				echo "<option value='".$myrow[0]."' selected>".$myrow[1]."</option>";
			} else{
			    echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
			}
		}
	}

	if ($id == 'impMunicipioRe') {
		$r=mysqli_query($enlace,"select IdMunicipio, Nombre from municipio where IdEstado = ".$_POST["estado"]." ORDER BY Nombre ASC");
		echo "<option value=''>...</option>";
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[0] == $_POST["municipio"]){
				echo "<option value='".$myrow[0]."' selected>".$myrow[1]."</option>";
			} else{
			    echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
			}
		}
	}

	if ($id == 'certModFecha') {
		$r=mysqli_query($enlace,"select FolioCFI from certificados where Fecha BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' AND IdEmpacadora = ".$_POST["idEmpacadora"]." ORDER BY FolioCFI ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[0]."</option>";
		}
	}

	if ($id == 'proveedor') {
		$r=mysqli_query($enlace,"select IdProveedor, Nombre from proveedores ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}

	if ($id == 'area') {
		$r=mysqli_query($enlace,"select idArea, Concepto from areas ORDER BY Concepto ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}

	if ($id == 'facturasgastos') {
		$r=mysqli_query($enlace,"select * from facturasgastos"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[0]."</td>";
			echo "<td>".$myrow[1]."</td>";
			echo "<td>".$myrow[2]."</td>";
			echo "<td>".$myrow[3]."</td>";
			echo "<td>".$myrow[4]."</td>";
			echo "<td>".$myrow[5]."</td>";
			echo "<td>".$myrow[6]."</td>";
			echo "<td>".$myrow[7]."</td>";
			echo "<td>".$myrow[8]."</td>";
			echo "<td>".$myrow[9]."</td>";
			echo "<td>".$myrow[10]."</td>";
			echo "<td>".$myrow[11]."</td>";
			echo "<td>".$myrow[12]."</td>";
			echo "</tr>";
		}
	}

	if ($id == 'empacadoras') {
		$r=mysqli_query($enlace,"select IdEmpacadora, Nombre from empacadora ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
	
	if ($id == 'empConta') {
		$r=mysqli_query($enlace,"select IdEmpacadora, Nombre from empacadora where Facturacion = '1' ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}

	if ($id == 'conslFactEmp') {
		$r=mysqli_query($enlace,"select f.*, e.Nombre ,ta.Concepto, m.Nombre from facturasaporta As f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join tipoaportacion As ta on e.IdTipoAportacion = ta.IdTipoAportacion inner join municipio As m on e.IdMunicipio = m.IdMunicipio ORDER BY e.Nombre ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[0]."</td>";
			echo "<td>".$myrow[1]."</td>";
			echo "<td>".$myrow[2]."</td>";
			echo "<td>".$myrow[3]."</td>";
			echo "<td>".$myrow[4]."</td>";
			echo "<td>".$myrow[6]."</td>";
			echo "<td>".$myrow[7]."</td>";
			echo "<td>".$myrow[5]."</td>";
			echo "</tr>";
		}
	}

	if ($id == 'obtDatosEmp') {	
		$nombreempacadora= $_POST['empacadora'];
		$r=mysqli_query($enlace,"select e.*, m.Nombre as Municipio, b.NumCuenta, b.Clabe, format(e.Saldo, 2) as SaldoFormato from empacadora As e inner join bancos as b on e.IdBanco = b.IdBanco inner join municipio As m on e.IdMunicipio = m.IdMunicipio where e.IdEmpacadora = $nombreempacadora");
		$resultado = $r->fetch_assoc(); 

		$r=mysqli_query($enlace,"select r.Concepto as Regimen from empacadora As e inner join regimen as r on e.IdRegimen = r.IdRegimen where e.IdEmpacadora = '".$resultado["IdEmpacadora"]."'");
	    $myrow=mysqli_fetch_array($r);
	    $resultado["Regimen"] = @$myrow[0];
	    
	    $r=mysqli_query($enlace,"select nb.Nombre from nombresbancos as nb inner join bancos as b on nb.IdNombreBanco = b.IdNombreBanco inner join empacadora as e on e.IdBanco = b.IdBanco where e.IdEmpacadora = '".$resultado["IdEmpacadora"]."'");
	    $myrow=mysqli_fetch_array($r);
	    $resultado["Banco"] = @$myrow[0];

		$datos = array();
        $datos['result'] = $resultado;
		echo json_encode($datos);
	}

	if ($id == 'empacadorasC') {
		$r=mysqli_query($enlace,"select IdEmpacadora, Nombre from empacadora ORDER BY Nombre ASC"); 
		echo "<option value='' selected>Todas las empacadoras</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}

	if ($id == 'busquedaC') {
		$datos = array();
		
		$r=mysqli_query($enlace,"select COUNT(*) from certificados where lower(FolioCFI) = '".mb_strtolower($_POST["folioCFI"])."'");
	    $myrow=mysqli_fetch_array($r);
		
		if (@$myrow[0] == 1){
	        $r=mysqli_query($enlace,"select e.Nombre as Empacadora, c.FolioCFI, c.Tipo, ex.Nombre as ExpedidorCFI, c.FolioRPV, te.Nombre as TE, ter.Nombre as Terceria, c.Producto, c.Variedad, format(c.Cantidad, 2) as Cantidad, c.Unidad, mD.Nombre as MunicipioD, est.Nombre as Estado, p.Nombre as Pais, r.Nombre as Regulacion, c.Estatus, c.NumeroCajas, date_format(c.Fecha, '%d/%m/%Y') as Fecha, c.Observaciones from certificados As c inner join empacadora As e on c.IdEmpacadora = e.IdEmpacadora inner join expedidorcfi As ex on c.IdExpedidorCFI = ex.IdExpedidorCFI inner join municipio As mD on c.IdMunicipio = mD.IdMunicipio inner join estado As est on c.IdEstado = est.IdEstado inner join pais As p on c.IdPais = p.IdPais inner join regulaciones as r on c.IdRegulacion = r.IdRegulacion inner join terceroespecialista as te on te.IdTerceroEspecialista = c.IdTerceroEspecialista inner join tercerias as ter on te.IdTerceria = ter.IdTerceria where lower(FolioCFI) = '".mb_strtolower($_POST["folioCFI"])."'"); 
			$resultado = $r->fetch_assoc();
			if ($resultado['NumeroCajas'] == 0){
			    $resultado['NumeroCajas'] = "";
			}
			
			$r=mysqli_query($enlace,"select t.Descripcion as Transporte from transporte as t inner join certificados as c on t.IdTransporte = c.IdTransporte where lower(c.FolioCFI) = '".mb_strtolower($_POST["folioCFI"])."'");
			$row=mysqli_fetch_array($r);
		    if (@$row[0] != ""){
		    	$resultado['Transporte'] = $row[0];
		    } else{
		    	$resultado['Transporte'] = "";
		    }

            $r=mysqli_query($enlace,"select m.Nombre from municipio as m inner join detorigen as do on m.IdMunicipio = do.IdMunicipio inner join certificados as c on c.IdCertificado = do.IdCertificado where lower(c.FolioCFI) = '".mb_strtolower($_POST["folioCFI"])."' ORDER BY m.Nombre");
			$resultado['Municipios'] = $r->fetch_all(MYSQLI_ASSOC);
			
			$datos['status'] = 'ok';
	        $datos['result'] = $resultado;
			echo json_encode($datos);
	    } else{
	        echo "2";
	    } 
	}
	
	if ($id == 'confirmarRe') {
	    $r=mysqli_query($enlace,"select COUNT(*) from certificados where FolioCFI LIKE '".substr($_POST["folioCFI"], 0, -1)."_'");
	    $myrow=mysqli_fetch_array($r);
	    
	    if ($myrow[0] >= 2){
	        echo "2";
	    } else{
	        echo "1";
	    }
	    exit();
	}

	if ($id == 'busquedaRe') {
		$datos = array();
		
		if (is_numeric($_POST["folioCFI"])){
		    $r=mysqli_query($enlace,"select COUNT(*) from certificados where FolioCFI = '".$_POST["folioCFI"]."'");
		} else{
		    $r=mysqli_query($enlace,"select COUNT(*) from certificados where FolioCFI LIKE '".substr($_POST["folioCFI"], 0, -1)."_'");
	        $myrow=mysqli_fetch_array($r);
	        
	        if (@$myrow[0] >= 3){
	            echo "3";
	            exit();
	        } else{
	        	$b=mysqli_query($enlace,"select COUNT(*) from certificados where FolioCFI LIKE '".substr($_POST["folioCFI"], 0, -1)."_' and Estatus = 'Cancelado'");
				@$row=mysqli_fetch_array($b);

				if ($myrow[0] == $row[0] && $myrow[0] > 0){
				    echo "4";
				    exit;
				} else{
		            $r=mysqli_query($enlace,"select COUNT(*) from certificados where lower(FolioCFI) = '".mb_strtolower($_POST["folioCFI"])."'");
				}
	        }
		}
		@$myrow=mysqli_fetch_array($r);
		
		if ($myrow[0] == 1){
            $r=mysqli_query($enlace,"select e.Nombre as Empacadora, c.*, ter.Nombre as Terceria from certificados as c inner join empacadora as e on c.IdEmpacadora = e.IdEmpacadora inner join terceroespecialista as te on te.IdTerceroEspecialista = c.IdTerceroEspecialista inner join tercerias as ter on ter.IdTerceria = te.IdTerceria where lower(FolioCFI) = '".mb_strtolower($_POST["folioCFI"])."'"); 
			$resultado = $r->fetch_assoc();
			if ($resultado['NumeroCajas'] == 0){
			    $resultado['NumeroCajas'] = "";
			}
			
			if ($resultado['IdTransporte'] == 0){
			    $resultado['IdTransporte'] = "";
			}

            $r=mysqli_query($enlace,"select do.IdMunicipio, m.Nombre from municipio as m inner join detorigen as do on m.IdMunicipio = do.IdMunicipio inner join certificados as c on c.IdCertificado = do.IdCertificado where lower(c.FolioCFI) = '".mb_strtolower($_POST["folioCFI"])."' ORDER BY m.Nombre");
            
            $resultado['Municipios'] = $r->fetch_all(MYSQLI_ASSOC);
            $datos['status'] = 'ok';
            $datos['result'] = $resultado;
            echo json_encode($datos);
        } else{
            echo "2";
        }
        exit();
	}

	// if ($id == 'obtCertificado') {
	// 	$r=mysqli_query($enlace,"select * from certificados where FolioCFI = '".$_POST["folioCFI"]."'"); 
	// 	$datos = array();
	// 	$resultado = $r->fetch_assoc();
	// 	$datos['status'] = 'ok';
 //        $datos['result'] = $resultado;
	// 	echo json_encode($datos);
		// }

	if ($id == 'conCertificados') {
		$arreglo = array();
		$aux = array();
		$x = 0;

		if($_POST["fechaI"] != "" && $_POST["fechaF"] != "" && $_POST["tipo"] == ""){
			$r=mysqli_query($enlace,"select c.FolioCFI, e.Nombre as Empacadora, date_format(c.Fecha, '%Y/%m/%d') as Fecha, c.Tipo, ex.Nombre as ExpedidorCFI, c.FolioRPV, te.Nombre as TE, ter.Nombre as Terceria, c.Producto, c.Variedad, format(c.Cantidad, 4) as Cantidad, c.Unidad, p.Nombre as Pais, est.Nombre as Estado, c.Estatus, format(c.NumeroCajas, 0) as NumeroCajas, c.Referencia, c.Observaciones, p.IdGrupo, cont.IdContinente, cont.NombreContinente from certificados As c inner join empacadora As e on c.IdEmpacadora = e.IdEmpacadora inner join expedidorcfi As ex on c.IdExpedidorCFI = ex.IdExpedidorCFI inner join estado As est on c.IdEstado = est.IdEstado inner join pais As p on c.IdPais = p.IdPais inner join terceroespecialista as te on te.IdTerceroEspecialista = c.IdTerceroEspecialista inner join tercerias as ter on ter.IdTerceria = te.IdTerceria inner join continentes as cont on p.IdContinente = cont.IdContinente where c.Fecha BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' ORDER BY c.Fecha DESC");
		} else{
			if ($_POST["fechaI"] != "" && $_POST["fechaF"] != "" && $_POST["tipo"] != ""){
		     	$r=mysqli_query($enlace,"select c.FolioCFI, e.Nombre as Empacadora, date_format(c.Fecha, '%Y/%m/%d') as Fecha, c.Tipo, ex.Nombre as ExpedidorCFI, c.FolioRPV, te.Nombre as TE, ter.Nombre as Terceria, c.Producto, c.Variedad, format(c.Cantidad, 4) as Cantidad, c.Unidad, p.Nombre as Pais, est.Nombre as Estado, c.Estatus, format(c.NumeroCajas, 0) as NumeroCajas, c.Referencia, c.Observaciones, p.IdGrupo, cont.IdContinente, cont.NombreContinente from certificados As c inner join empacadora As e on c.IdEmpacadora = e.IdEmpacadora inner join expedidorcfi As ex on c.IdExpedidorCFI = ex.IdExpedidorCFI inner join estado As est on c.IdEstado = est.IdEstado inner join pais As p on c.IdPais = p.IdPais inner join terceroespecialista as te on te.IdTerceroEspecialista = c.IdTerceroEspecialista inner join tercerias as ter on ter.IdTerceria = te.IdTerceria inner join continentes as cont on p.IdContinente = cont.IdContinente where c.Fecha BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' AND c.Tipo = '".$_POST["tipo"]."' ORDER BY c.Fecha DESC"); 
		    } else{
		    	if (($_POST["fechaI"] == "" && $_POST["fechaF"] == "" && $_POST["tipo"] == "") || ($_POST["fechaI"] != "" && $_POST["fechaF"] == "" && $_POST["tipo"] == "") || ($_POST["fechaI"] == "" && $_POST["fechaF"] != "" && $_POST["tipo"] == "")){
			     	$r=mysqli_query($enlace,"select c.FolioCFI, e.Nombre as Empacadora, date_format(c.Fecha, '%Y/%m/%d') as Fecha, c.Tipo, ex.Nombre as ExpedidorCFI, c.FolioRPV, te.Nombre as TE, ter.Nombre as Terceria, c.Producto, c.Variedad, format(c.Cantidad, 4) as Cantidad, c.Unidad, p.Nombre as Pais, est.Nombre as Estado, c.Estatus, format(c.NumeroCajas, 0) as NumeroCajas, c.Referencia, c.Observaciones, p.IdGrupo, cont.IdContinente, cont.NombreContinente from certificados As c inner join empacadora As e on c.IdEmpacadora = e.IdEmpacadora inner join expedidorcfi As ex on c.IdExpedidorCFI = ex.IdExpedidorCFI inner join estado As est on c.IdEstado = est.IdEstado inner join pais As p on c.IdPais = p.IdPais inner join terceroespecialista as te on te.IdTerceroEspecialista = c.IdTerceroEspecialista inner join tercerias as ter on ter.IdTerceria = te.IdTerceria inner join continentes as cont on p.IdContinente = cont.IdContinente ORDER BY c.Fecha DESC"); 
			    } else {
			    	$r=mysqli_query($enlace,"select c.FolioCFI, e.Nombre as Empacadora, date_format(c.Fecha, '%Y/%m/%d') as Fecha, c.Tipo, ex.Nombre as ExpedidorCFI, c.FolioRPV, te.Nombre as TE, ter.Nombre as Terceria, c.Producto, c.Variedad, format(c.Cantidad, 4) as Cantidad, c.Unidad, p.Nombre as Pais, est.Nombre as Estado, c.Estatus, format(c.NumeroCajas, 0) as NumeroCajas, c.Referencia, c.Observaciones, p.IdGrupo, cont.IdContinente, cont.NombreContinente from certificados As c inner join empacadora As e on c.IdEmpacadora = e.IdEmpacadora inner join expedidorcfi As ex on c.IdExpedidorCFI = ex.IdExpedidorCFI inner join estado As est on c.IdEstado = est.IdEstado inner join pais As p on c.IdPais = p.IdPais inner join terceroespecialista as te on te.IdTerceroEspecialista = c.IdTerceroEspecialista inner join tercerias as ter on ter.IdTerceria = te.IdTerceria inner join continentes as cont on p.IdContinente = cont.IdContinente where c.Tipo = '".$_POST["tipo"]."' ORDER BY c.Fecha DESC"); 
			    }
		    }
	    }

        $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;

		foreach($datos as $valores) {
        	foreach($valores as $val) {
	    	    foreach($val as $i => $value) {
	    	    	if ($i == 'FolioCFI'){
	    	    		$folio = $value;
	    	    	}

	    	        if ($i == 'Pais'){
	    	            $origen = "";
	    	        	$r=mysqli_query($enlace,"select m.Nombre from detorigen as do inner join municipio as m on m.IdMunicipio = do.IdMunicipio inner join certificados as c on c.IdCertificado = do.IdCertificado where c.FolioCFI = '".$folio."' ORDER BY m.Nombre ASC"); 
						while ($myrow=mysqli_fetch_array($r)){ 
							$origen = $origen.", ".$myrow[0];
						}

						$aux["MunicipioO"] = substr($origen, 2, strlen($origen) - 1);
	    	            $aux[$i] = $value;
	    	        } else{
	    	            if ($i == 'IdGrupo'){
	    	                $r=mysqli_query($enlace,"select cc.Justificacion from cancelacioncertificados as cc inner join certificados as c on c.IdCertificado = cc.IdCertificado where c.FolioCFI = '".$folio."'"); 
	    		            $row=mysqli_fetch_array($r);
	    		            if (@$row[0] != ""){
	    		             	$aux["Justificacion"] = $row[0];
	    		            } else{
	    		              	$aux["Justificacion"] = "";
	    		            }
	    		            
	    		            $aux[$i] = $value;
	    	            } else{
	    	            	if ($i == 'Cantidad'){
	    	            		$r=mysqli_query($enlace,"select t.Descripcion as Transporte from transporte as t inner join certificados as c on t.IdTransporte = c.IdTransporte where c.FolioCFI = '".$folio."'"); 
	    	            		$fila=mysqli_fetch_array($r);
		    		            if (@$fila[0] != ""){
		    		             	$aux["Transporte"] = $fila[0];
		    		            } else{
		    		              	$aux["Transporte"] = "";
		    		            }

	    	                    $aux[$i] = $value;
	    	            	} else{
	    	            		if ($i == 'NumeroCajas'){
	    	            			if ($value == 0){
	    	            				$aux[$i] = "";
	    	            			} else{
	    	            				$aux[$i] = $value;
	    	            			}
	    	            		} else{
	    	            			if ($i == 'Estatus'){
	    	            				/////////////////////////////// municipioD
	    	            			    $r=mysqli_query($enlace,"select m.Nombre from municipio as m inner join certificados as c on m.IdMunicipio = c.IdMunicipio where c.FolioCFI = '".$folio."'"); 
			    	            		$fila=mysqli_fetch_array($r);
				    		            if (@$fila[0] != ""){
				    		             	$aux["MunicipioD"] = $fila[0];
				    		            } else{
				    		              	$aux["MunicipioD"] = "";
				    		            }

				    		            ////////////////////////////// Puerto de entrada
				    		            $r=mysqli_query($enlace,"select r.Nombre from regulaciones as r inner join certificados as c on r.IdRegulacion = c.IdRegulacion where c.FolioCFI = '".$folio."'"); 
			    	            		$fila=mysqli_fetch_array($r);
				    		            if (@$fila[0] != ""){
				    		             	$aux["Regulacion"] = $fila[0];
				    		            } else{
				    		              	$aux["Regulacion"] = "";
				    		            }

				    		            $aux[$i] = $value;
	    	            			} else{
	    	            				$aux[$i] = $value;
	    	            			}
	    	            		}
	    	            	}
	    	            }
	    	        }
	    		}
				
		        $arreglo[$x] = $aux;
	    		$x = $x + 1;
    	    }
		}

		$datos['data'] = $arreglo;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}

	if ($id == 'expCertificado'){
        $datos [] = json_decode($_POST["datos"]);
        $cadena = "";
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        // fputs($archivo, "\xEF\xBB\xBF");

        fputs($archivo, 'Folio CFI,Empacadora,Fecha expedición,Tipo,Oficial,Folio RPV,Tercero especialista,Tercería,Producto,Variedad,Transporte,Cantidad,Uni. Medida,Mpio. Origen,País Destino,Estado destino,Mpio. Destino,Puerto de entrada,Estatus,No. cajas,Referencia,Observaciones,Justificación,Id Predicción,Id Continente,Continente'.PHP_EOL);

        foreach($datos as $certificado) {
		    foreach($certificado as $valor) {
		    	$x = 0;
		    	foreach($valor as $val) {
		    		if ($x == 11 || $x == 19){
		    			$val = str_replace(",", "", $val);
		    		} else{
		    			if ($x == 13){
		    			    $val = str_replace(",", ";", $val);
		    		    } else{
		    		    	$val = str_replace(",", ".", $val);
		    		    }
		    		}

		    		$cadena = $cadena.$val.',';
		    		$x = $x + 1;
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
        fclose($archivo);
    }

    if ($id == 'impAnios') {
    	$r=mysqli_query($enlace,"select year(Fecha) from certificados ORDER BY Fecha ASC LIMIT 1");
	    $myrow=mysqli_fetch_array($r);
	    $anioI = $myrow[0];
	    $r=mysqli_query($enlace,"select year(Fecha) from certificados ORDER BY Fecha DESC LIMIT 1");
	    $myrow=mysqli_fetch_array($r);
	    $anioF = $myrow[0];

	    echo "<option value='' selected>...</option>";
	    while ($anioI <= $anioF){
			echo "<option value='".$anioI."'>".$anioI."</option>";
		    $anioI = $anioI + 1;
		}
	}

	if ($id == 'repGenA') {
    	$r=mysqli_query($enlace,"select year(Fecha) from certificados ORDER BY Fecha ASC LIMIT 1");
	    $myrow=mysqli_fetch_array($r);
	    $anioI = $myrow[0];
	    $r=mysqli_query($enlace,"select year(Fecha) from certificados ORDER BY Fecha DESC LIMIT 1");
	    $myrow=mysqli_fetch_array($r);
	    $anioF = $myrow[0];
	    $anios = array();
	    $a = array();

	    while ($anioI <= $anioF){
			for ($i = 0; $i < 12; $i++){
				$kilos = 0.0;
		        $r=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".($i + 1)." and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($myrow=mysqli_fetch_array($r)) { 
		            $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($myrow[0])), 3, '.', "");
		        }
		        $r=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".($i + 1)." and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($myrow=mysqli_fetch_array($r)) { 
		            $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($myrow[0])*1000)), 3, '.', "");
		        }
		        $a[$i] = round($kilos);

			}
			$anios[$anioI] = $a;
		    $anioI = $anioI + 1;
		}
		echo json_encode($anios);
	}

	if ($id == 'repPerA') {
    	$anioI = $_POST["anioI"];
	    $anioF = $_POST["anioF"];
	    $anios = array();
	    $a = array();

	    while ($anioI <= $anioF){
			for ($i = 0; $i < 12; $i++){
				$kilos = 0.0;
		        $r=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".($i + 1)." and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($myrow=mysqli_fetch_array($r)) { 
		            $kilos =  number_format((number_format($kilos, 3, '.', "") + doubleval($myrow[0])), 3, '.', "");
		        }
		        $r=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".($i + 1)." and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($myrow=mysqli_fetch_array($r)) { 
		            $kilos =  number_format((number_format($kilos, 3, '.', "") + (doubleval($myrow[0])*1000)), 3, '.', "");
		        }
		        $a[$i] = round($kilos);

			}
			$anios[$anioI] = $a;
		    $anioI = $anioI + 1;
		}
		echo json_encode($anios);
	}

	if ($id == 'repMesK') {
    	$anio = substr($_POST["fecha"], 0 ,4);
	    $mes = substr($_POST["fecha"], 5 ,2);
	    $valores = array();
	    // $paises = array();

		$r=mysqli_query($enlace,"select * from pais"); 
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[1] != "México"){
				$kilos = 0.0;
		        $b=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and Unidad = 'Kilogramos' and IdPais = ".$myrow[0]." and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($row[0])), 3, '.', "");
		        }
		        $b=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and Unidad = 'Toneladas' and IdPais = ".$myrow[0]." and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($row[0])*1000)), 3, '.', "");
		        }
		        if ($kilos != 0){
		            $valores[$myrow[1]] = round($kilos);
		        }
			}
		}
		arsort($valores);

		echo json_encode($valores);
	}

	if ($id == 'repMesE') {
    	$anio = substr($_POST["fecha"], 0 ,4);
	    $mes = substr($_POST["fecha"], 5 ,2);
	    $valores = array();

		$r=mysqli_query($enlace,"select * from pais"); 
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[1] != "México"){
		        $b=mysqli_query($enlace,"select COUNT(IdCertificado) from certificados where IdPais = ".$myrow[0]." and YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        $row=mysqli_fetch_array($b);
		      //  $valores[$myrow[1]] = $row[0];
		        if ($row[0] != 0){
		            $valores[$myrow[1]] = $row[0];
		        }
			}
		}
		arsort($valores);

		echo json_encode($valores);
	}

	if ($id == 'conBitacora') {
		$r=mysqli_query($enlaceBitacora,"select FechaHora, Formulario, Usuario, Descripcion, Mensaje from errores ORDER BY IdBitacora DESC");
        $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}

	if ($id == 'fechaModFolio') {
		$nombreempacadora4= $_POST['empacadoraM'];
		$r=mysqli_query($enlace,"select FolioFactura from facturasaporta where FechaEmision BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' AND IdEmpacadora = $nombreempacadora4 AND Estatus = 'Pendiente' ORDER BY FolioFactura DESC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[0]."</option>";
		}
	}

	if ($id == 'idFolio') {
		$r=mysqli_query($enlace,"select FolioFactura from facturasaporta ORDER BY FolioFactura DESC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[0]."</option>";
		}
	}

	if ($id == 'empacadoraFA') {
		$r=mysqli_query($enlace,"select f.*, e.Nombre ,ta.Concepto, m.Nombre from facturasaporta As f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join tipoaportacion As ta on e.IdTipoAportacion = ta.IdTipoAportacion inner join municipio As m on e.IdMunicipio = m.IdMunicipio ORDER BY e.Nombre ASC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td>".$myrow[8]."</td>";
			echo "<td>".$myrow[3]."</td>";
			echo "<td>".$myrow[4]."</td>";
			echo "<td>".$myrow[6]."</td>";
			echo "<td>".$myrow[5]."</td>";
			echo "</tr>";
		}
	}

    if ($id == 'obtEmpacadoraC') {	
		$nombreempacadora2= $_POST['empacadora'];
		$folioempacadora = $_POST['folio'];
		$r=mysqli_query($enlace,"select * from facturasaporta where IdEmpacadora = $nombreempacadora2 and IdFolioAporta = $folioempacadora"); 
		$datos = array();
		$resultado = $r->fetch_assoc();
		$datos['status'] = 'ok';
		$datos['result'] = $resultado;
		echo json_encode($datos);
	}

	if ($id == 'fechaModFolioCob') {
		$nombreempacadora4= $_POST['empacadora'];
		$r=mysqli_query($enlace,"select * from facturasaporta where FechaEmision BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' AND IdEmpacadora = $nombreempacadora4 AND Estatus = 'Pendiente' ORDER BY FolioFactura DESC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[2]."</option>";
		}
	}

	if ($id == 'idFolioCob') {
		$r=mysqli_query($enlace,"select * from facturasaporta ORDER BY FolioFactura DESC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[2]."</option>";
		}
		if ($id == 'idBanco') {
			$r=mysqli_query($enlace,"select IdBanco, Nombre from bancos ORDER BY Nombre ASC"); 
			echo "<option value='' selected>...</option>";
			while ($myrow=mysqli_fetch_array($r)) 
			{ 
				echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
			}
		}
	}

	if ($id == 'expCobros'){
		$datos [] = json_decode($_POST["datos"]);
		$cadena = "";
		
		$filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);
		
		$archivo = fopen('php://output', 'w');

		fputs($archivo, 'Número PDD,Fecha cobro,Monto,Folio factura,Empacadora,Estatus,Total,Saldo,Tipo aportación,Fecha factura,Banco empacadora,Num cuenta empacadora,Banco asociación,Num cuenta asociación,Observaciones'.PHP_EOL);

		foreach($datos as $cobro) {
			foreach($cobro as $valor) {
				$x = 0;
		    	foreach($valor as $val) {
		    		if ($x <= 14){
			    		if ($x == 2 || $x == 6 || $x == 7 || $x == 14){
			    			$val = str_replace(",", "", $val);
			    		} else{
			    			$val = str_replace(",", ".", $val);
			    		}

			    		$cadena = $cadena.$val.',';
			    		$x = $x + 1;
		    		}
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
		fclose($archivo); 
	}

	if ($id == 'cargRespaldo'){
		$ficheros  = scandir("Backups");

		for ($i = 2; $i < count($ficheros); $i++){
            echo '<div class="py-2 px-4 text-center overflow-hidden col-4 col-md-3 col-lg-2">
				<img src = "Imagenes/archivo.png" class = "img-fluid">
				<p>'.$ficheros[$i].'</p>
			</div>';
		}
	}

	if ($id == 'impArchivos'){
		$ficheros  = scandir("Backups");

		echo "<option value='' selected>...</option>";
		for ($i = 2; $i < count($ficheros); $i++){
			echo "<option value='".$ficheros[$i]."'>".$ficheros[$i]."</option>";
		}
	}

	if ($id == 'banco') {
		$r=mysqli_query($enlace,"select * from bancos ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}

	if ($id == 'gasto') {
		$r=mysqli_query($enlace,"select IdFolioGasto, Factura from facturasgastos where IdProveedor = ".$_POST["prove"]." and estatus = 'Autorizada' ORDER BY Factura DESC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}

	if ($id == 'facturaInfo') {
		$r=mysqli_query($enlace,"select F.Cantidad, A.concepto as Area, F.FechaFactura, F.FechaSolicitud, F.Concepto, au.Nombre as Autoriza, au.Puesto as Puesto, F.Estatus, F.MesPago, F.Observaciones, F.Saldo from facturasgastos as F inner join areas as A on F.IdArea = A.IdArea inner join autoriza as au on F.IdAutoriza = au.IdAutoriza where F.IdFolioGasto = ".$_POST["fac"].""); 
		$datos = array();
		$resultado = $r->fetch_assoc();
		$datos['status'] = 'ok';
        $datos['result'] = $resultado;
		echo json_encode($datos);		
	}

	if ($id == 'proveedorInfo') {
		$r=mysqli_query($enlace,"select p.*, nb.IdNombreBanco as Banco, b.NumCuenta, b.Clabe, r.Concepto from proveedores as p inner join bancos as b on p.IdBanco = b.IdBanco inner join regimen as r on p.IdRegimen = r.IdRegimen inner join nombresbancos as nb on b.IdNombreBanco = nb.IdNombreBanco where IdProveedor =  '".$_POST["idProveedor"]."'"); 
		$datos = array();
		$resultado = $r->fetch_assoc();
		$datos['status'] = 'ok';
        $datos['result'] = $resultado;
		echo json_encode($datos);	
	}
	
	if ($id == 'proveedorDatos') {
		$r=mysqli_query($enlace,"select p.*, nb.Nombre as Banco, b.NumCuenta, b.Clabe, r.Concepto from proveedores as p inner join bancos as b on p.IdBanco = b.IdBanco inner join regimen as r on p.IdRegimen = r.IdRegimen inner join nombresbancos as nb on b.IdNombreBanco = nb.IdNombreBanco where IdProveedor =  '".$_POST["idProveedor"]."'"); 
		$datos = array();
		$resultado = $r->fetch_assoc();
		$datos['status'] = 'ok';
        $datos['result'] = $resultado;
		echo json_encode($datos);	
	}
	
	if ($id == 'gastosConta') {
	    $arreglo = array();
	    $aux = array();
	    $pdf = '"pdf"';
	    $x = 0;
	    
	    if ($_POST["fechaI"] != "" && $_POST["fechaF"] != "") {
	        if ($_POST["estatus"] != "") {
	            $r=mysqli_query($enlace,"select f.Factura, p.Nombre as Proveedor, a.Concepto as Area, f.FechaFactura, f.FechaSolicitud, f.Autorizada, f.Cantidad, f.Concepto, f.Estatus, concat(au.Nombre, ' (', pu.Puesto,')') as Autoriza, date_format(concat('0000-',f.MesPago, '-00'), '%M') as MesPago, f.Saldo, f.Observaciones, f.IdFolioGasto, c.Fecha, c.Motivo, c.Anotaciones from facturasgastos As f inner join proveedores as p on f.IdProveedor = p.IdProveedor inner join areas as a on f.IdArea = a.IdArea inner join autoriza as au on f.IdAutoriza = au.IdAutoriza LEFT JOIN cancelargasto as c on f.IdFolioGasto = c.IdFolioGasto inner join puestos as pu on f.IdPuesto = pu.IdPuesto where f.FechaFactura BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' AND f.Estatus = '".$_POST["estatus"]."' ORDER BY f.FechaFactura DESC");
	            
	        } else {
	            $r=mysqli_query($enlace,"select f.Factura, p.Nombre as Proveedor, a.Concepto as Area, f.FechaFactura, f.FechaSolicitud, f.Autorizada, f.Cantidad, f.Concepto, f.Estatus, concat(au.Nombre, ' (', pu.Puesto,')') as Autoriza, date_format(concat('0000-',f.MesPago, '-00'), '%M') as MesPago, f.Saldo, f.Observaciones, f.IdFolioGasto, c.Fecha, c.Motivo, c.Anotaciones from facturasgastos As f inner join proveedores as p on f.IdProveedor = p.IdProveedor inner join areas as a on f.IdArea = a.IdArea inner join autoriza as au on f.IdAutoriza = au.IdAutoriza LEFT JOIN cancelargasto as c on f.IdFolioGasto = c.IdFolioGasto inner join puestos as pu on f.IdPuesto = pu.IdPuesto where f.FechaFactura BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' ORDER BY f.FechaFactura DESC");
	        }
	    } else {
	        if ($_POST["estatus"] != "") {
	            $r=mysqli_query($enlace,"select f.Factura, p.Nombre as Proveedor, a.Concepto as Area, f.FechaFactura, f.FechaSolicitud, f.Autorizada, f.Cantidad, f.Concepto, f.Estatus, concat(au.Nombre, ' (', pu.Puesto,')') as Autoriza, date_format(concat('0000-',f.MesPago, '-00'), '%M') as MesPago, f.Saldo, f.Observaciones, f.IdFolioGasto, c.Fecha, c.Motivo, c.Anotaciones from facturasgastos As f inner join proveedores as p on f.IdProveedor = p.IdProveedor inner join areas as a on f.IdArea = a.IdArea inner join autoriza as au on f.IdAutoriza = au.IdAutoriza LEFT JOIN cancelargasto as c on f.IdFolioGasto = c.IdFolioGasto inner join puestos as pu on f.IdPuesto = pu.IdPuesto where f.Estatus = '".$_POST["estatus"]."' ORDER BY f.Factura ASC;");
	        } else {
	            $r=mysqli_query($enlace,"select f.Factura, p.Nombre as Proveedor, a.Concepto as Area, f.FechaFactura, f.FechaSolicitud, f.Autorizada, f.Cantidad, f.Concepto, f.Estatus, concat(au.Nombre, ' (', pu.Puesto,')') as Autoriza, date_format(concat('0000-',f.MesPago, '-00'), '%M') as MesPago, f.Saldo, f.Observaciones, f.IdFolioGasto, c.Fecha, c.Motivo, c.Anotaciones from facturasgastos As f inner join proveedores as p on f.IdProveedor = p.IdProveedor inner join areas as a on f.IdArea = a.IdArea inner join autoriza as au on f.IdAutoriza = au.IdAutoriza LEFT JOIN cancelargasto as c on f.IdFolioGasto = c.IdFolioGasto inner join puestos as pu on f.IdPuesto = pu.IdPuesto ORDER BY f.Factura ASC;");
	        }
	    }
	    
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		
		foreach ($datos as $valores){
		    foreach ($valores as $val) {
		        foreach ($val as $i => $value) {
		            $aux[$i] = $value;
		        }
		        
		        ///////////////////////////////////
		        
		        $folio = '"'.$aux["IdFolioGasto"].'"';
		        $factura = '"'.$aux["Factura"].'"';
		        $estatus = '"'.$aux["Estatus"].'"';
		        $concepto = '"'.$aux["Concepto"].'"';
		        $emision = '"'.$aux["FechaFactura"].'"';
		        $cantidad = '"'.$aux["Cantidad"].'"';
		        $observaciones = '"'.$aux["Observaciones"].'"';
		        
		        //Factura
		        if (file_exists("archivos/facturas/".$aux["IdFolioGasto"].".pdf")) {
		            $aux["factPDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrFac(".$folio.");'></INPUT> <br> <br> <INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Subir PDF' TYPE='button' style = 'background-color: #318a3a; color: white;' onClick='folio = ".$folio."; subirFact(".$folio.", ".$factura.");'></INPUT>";
		        } else {
		            $aux["factPDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrFac(".$folio.");' disabled></INPUT> <br> <br> <INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Subir PDF' TYPE='button' style = 'background-color: #318a3a; color: white;' onClick='folio = ".$folio."; subirFact(".$folio.", ".$factura.");'></INPUT>";
		        }
		        
		        //Acuse
		        if (file_exists("archivos/acuse/".$aux["IdFolioGasto"].".pdf")) {
		            $aux["acusePDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrAcuse(".$folio.");'></INPUT> <br> <br> <INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Subir PDF' TYPE='button' style = 'background-color: #318a3a; color: white;' onClick='folio = ".$folio."; factura = ".$factura."; subirAcuse(".$folio.", ".$factura.");'></INPUT>";
		        } else {
		            $aux["acusePDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrAcuse(".$folio.");' disabled></INPUT> <br> <br> <INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Subir PDF' TYPE='button' style = 'background-color: #318a3a; color: white;' onClick='folio = ".$folio."; factura = ".$factura."; subirAcuse(".$folio.", ".$factura.");'></INPUT>";
		        }
		        
		        //Cancelar
		        if ($aux["Estatus"] == "Pagada") {
		            $aux["modificar"] = "<br><INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Cancelar' TYPE='button' style = 'background-color: #F14722; color: white;' onClick='folio = ".$folio."; cancelar(".$folio.", ".$factura.");' disabled></INPUT>";
		        } else if ($aux["Estatus"] == 'Cancelada') {
		            $aux["modificar"] = "<br><INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Cancelar' TYPE='button' style = 'background-color: #F14722; color: white;' onClick='folio = ".$folio."; cancelar(".$folio.", ".$factura.");' disabled></INPUT>";
		        }else {
		            $aux["modificar"] = "<br><INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Cancelar' TYPE='button' style = 'background-color: #F14722; color: white;' onClick='folio = ".$folio."; cancelar(".$folio.", ".$factura.", ".$estatus.", ".$concepto.", ".$emision.", ".$cantidad.", ".$observaciones."); '></INPUT>";
		        }
		     
		        
		        
		        
		        
		        
		        $arreglo[$x] = $aux;
	    		$x = $x + 1;
		    }
		}
		
		$datos['data'] = $arreglo;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	    
	}
	
	if ($id == 'gastosAuto') {
	    $arreglo = array();
	    $aux = array();
	    $x = 0;
	    
	    
	    if ($_POST["fechaI"] != "" && $_POST["fechaF"] != ""){
	        $r=mysqli_query($enlace,"select f.Factura, p.Nombre as Proveedor, a.Concepto as Area, f.FechaFactura, f.FechaSolicitud, f.Cantidad, f.Concepto, f.Estatus, concat(au.Nombre, ' (', pu.Puesto,')') as Autoriza, date_format(concat('0000-',f.MesPago, '-00'), '%M') as MesPago, f.Saldo, f.Observaciones, f.IdFolioGasto from facturasgastos As f inner join proveedores as p on f.IdProveedor = p.IdProveedor inner join areas as a on f.IdArea = a.IdArea inner join autoriza as au on f.IdAutoriza = au.IdAutoriza inner join puestos as pu on f.IdPuesto = pu.IdPuesto where f.Estatus = 'Pendiente' AND f.FechaFactura BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' ORDER BY f.FechaFactura DESC");
	    } else {
	        $r=mysqli_query($enlace,"select f.Factura, p.Nombre as Proveedor, a.Concepto as Area, f.FechaFactura, f.FechaSolicitud, f.Cantidad, f.Concepto, f.Estatus, concat(au.Nombre, ' (', pu.Puesto,')') as Autoriza, date_format(concat('0000-',f.MesPago, '-00'), '%M') as MesPago, f.Saldo, f.Observaciones, f.IdFolioGasto from facturasgastos As f inner join proveedores as p on f.IdProveedor = p.IdProveedor inner join areas as a on f.IdArea = a.IdArea inner join autoriza as au on f.IdAutoriza = au.IdAutoriza inner join puestos as pu on f.IdPuesto = pu.IdPuesto where f.Estatus = 'Pendiente' ORDER BY f.Factura ASC;");
	    }
	    
	    
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		
		foreach ($datos as $valores){
		    foreach ($valores as $val) {
		        foreach ($val as $i => $value) {
		            $aux[$i] = $value;
		        }
		        
		        $folio = '"'.$aux["IdFolioGasto"].'"';
		        $factura = '"'.$aux["Factura"].'"';
		        $estatus = '"'.$aux["Estatus"].'"';
		        $concepto = '"'.$aux["Concepto"].'"';
		        $emision = '"'.$aux["FechaFactura"].'"';
		        $cantidad = '"'.$aux["Cantidad"].'"';
		        $observaciones = '"'.$aux["Observaciones"].'"';
		        
		        //Factura
		        if (file_exists("archivos/facturas/".$aux["IdFolioGasto"].".pdf")) {
		            $aux["factPDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrFac(".$folio.");'></INPUT>";
		        } else {
		            $aux["factPDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrFac(".$folio.");' disabled></INPUT>";
		        }
		        
		        //Acuse
		        if (file_exists("archivos/acuse/".$aux["IdFolioGasto"].".pdf")) {
		            $aux["acusePDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrAcuse(".$folio.");'></INPUT>";
		        } else {
		            $aux["acusePDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrAcuse(".$folio.");' disabled></INPUT>";
		        }
		        
		        //Autorizar
		        $aux["modificarA"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Autorizar' TYPE='button' style = 'background-color: #7eca28; color: white;' onClick='folio = ".$folio."; autorizar(".$folio.", ".$factura.", ".$estatus.", ".$concepto.", ".$emision.", ".$cantidad.", ".$observaciones."); '></INPUT>";
		        
		        //Rechazar
		        $aux["modificarR"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Rechazar' TYPE='button' style = 'background-color: #F14722; color: white;' onClick='folio = ".$folio."; rechazar(".$folio.", ".$factura.", ".$estatus.", ".$concepto.", ".$emision.", ".$cantidad.", ".$observaciones."); '></INPUT>";

		        $arreglo[$x] = $aux;
	    		$x = $x + 1;
		    }
		}
		
		$datos['data'] = $arreglo;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'pagarGastos') {
	    $arreglo = array();
	    $aux = array();
	    $x = 0;
	    
	    
	    if ($_POST["fechaI"] != "" && $_POST["fechaF"] != ""){
	        $r=mysqli_query($enlace,"select f.Factura, p.Nombre as Proveedor, a.Concepto as Area, f.FechaFactura, f.FechaSolicitud, f.Autorizada, f.Cantidad, f.Concepto, f.Estatus, concat(au.Nombre, ' (', pu.Puesto,')') as Autoriza, date_format(concat('0000-',f.MesPago, '-00'), '%M') as MesPago, f.Saldo, f.Observaciones, f.IdFolioGasto, nb.Nombre as Banco, b.NumCuenta, b.Clabe from facturasgastos As f inner join proveedores as p on f.IdProveedor = p.IdProveedor inner join areas as a on f.IdArea = a.IdArea inner join autoriza as au on f.IdAutoriza = au.IdAutoriza inner join bancos as b on b.IdBanco = p.IdBanco inner join nombresbancos as nb on b.IdNombreBanco = nb.IdNombreBanco inner join puestos as pu on f.IdPuesto = pu.IdPuesto where f.Estatus = 'Autorizada' AND f.FechaFactura BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' ORDER BY f.FechaFactura DESC");
	    } else {
	        $r=mysqli_query($enlace,"select f.Factura, p.Nombre as Proveedor, a.Concepto as Area, f.FechaFactura, f.FechaSolicitud, f.Autorizada, f.Cantidad, f.Concepto, f.Estatus, concat(au.Nombre, ' (', pu.Puesto,')') as Autoriza, date_format(concat('0000-',f.MesPago, '-00'), '%M') as MesPago, f.Saldo, f.Observaciones, f.IdFolioGasto, nb.Nombre as Banco, b.NumCuenta, b.Clabe from facturasgastos As f inner join proveedores as p on f.IdProveedor = p.IdProveedor inner join areas as a on f.IdArea = a.IdArea inner join autoriza as au on f.IdAutoriza = au.IdAutoriza inner join bancos as b on b.IdBanco = p.IdBanco inner join nombresbancos as nb on b.IdNombreBanco = nb.IdNombreBanco inner join puestos as pu on f.IdPuesto = pu.IdPuesto where f.Estatus = 'Autorizada' ORDER BY f.Factura ASC;");
	    }
	    
	    
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		
		foreach ($datos as $valores){
		    foreach ($valores as $val) {
		        foreach ($val as $i => $value) {
		            $aux[$i] = $value;
		        }
		        
		        $folio = '"'.$aux["IdFolioGasto"].'"';
		        $factura = '"'.$aux["Factura"].'"';
		        $estatus = '"'.$aux["Estatus"].'"';
		        $concepto = '"'.$aux["Concepto"].'"';
		        $emision = '"'.$aux["FechaFactura"].'"';
		        $cantidad = '"'.$aux["Cantidad"].'"';
		        $observaciones = '"'.$aux["Observaciones"].'"';
		        $autoriza = '"'.$aux["Autoriza"].'"';
		        $proveedor = '"'.$aux["Proveedor"].'"';
		        $banco = '"'.$aux["Banco"].'"';
		        $cuenta = '"'.$aux["NumCuenta"].'"';
		        $clabe = '"'.$aux["Clabe"].'"';
		        $saldo = '"'.$aux["Saldo"].'"';
		        
		        //Factura
		        if (file_exists("archivos/facturas/".$aux["IdFolioGasto"].".pdf")) {
		            $aux["factPDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrFac(".$folio.");'></INPUT>";
		        } else {
		            $aux["factPDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrFac(".$folio.");' disabled></INPUT>";
		        }
		        
		        //Acuse
		        if (file_exists("archivos/acuse/".$aux["IdFolioGasto"].".pdf")) {
		            $aux["acusePDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrAcuse(".$folio.");'></INPUT>";
		        } else {
		            $aux["acusePDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrAcuse(".$folio.");' disabled></INPUT>";
		        }
		        
		        //Pagar
		        $aux["modificarP"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Pagar' TYPE='button' style = 'background-color: #7eca28; color: white;' onClick='folio = ".$folio."; pagar(".$folio.", ".$factura.", ".$estatus.", ".$concepto.", ".$emision.", ".$cantidad.", ".$observaciones.", ".$autoriza.", ".$proveedor.", ".$banco.", ".$cuenta.", ".$clabe.", ".$saldo."); '></INPUT>";
		        
		        $arreglo[$x] = $aux;
	    		$x = $x + 1;
		    }
		}
		
		$datos['data'] = $arreglo;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'consultarPagos') {
	    $arreglo = array();
	    $aux = array();
	    $x = 0;
	    
	    if ($_POST["fechaI"] != "" && $_POST["fechaF"] != ""){
	        $r=mysqli_query($enlace,"select F.Factura, Pr.Nombre as Proveedor, nb.Nombre as Banco, B.NumCuenta, B.Clabe, F.FechaFactura, F.FechaSolicitud, F.Autorizada, P.Referencias, P.FechaPago, P.ModoPago, P.Monto, P.Observaciones, P.IdPago from  pagos as P inner join facturasgastos as F on P.IdFolioGasto = F.IdFolioGasto inner join proveedores as Pr on Pr.IdProveedor = F.IdProveedor inner join bancos as B on P.IdBanco = B.IdBanco inner join nombresbancos as nb on B.IdNombreBanco = nb.IdNombreBanco where P.FechaPago BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' ORDER BY P.FechaPago DESC");
	    } else {
	        $r=mysqli_query($enlace,"select F.Factura, Pr.Nombre as Proveedor, nb.Nombre as Banco, B.NumCuenta, B.Clabe, F.FechaFactura, F.FechaSolicitud, F.Autorizada, P.Referencias, P.FechaPago, P.ModoPago, P.Monto, P.Observaciones, P.IdPago from  pagos as P inner join facturasgastos as F on P.IdFolioGasto = F.IdFolioGasto inner join proveedores as Pr on Pr.IdProveedor = F.IdProveedor inner join bancos as B on P.IdBanco = B.IdBanco inner join nombresbancos as nb on B.IdNombreBanco = nb.IdNombreBanco ORDER BY F.Factura ASC");
	    }
	    
	    
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		
		foreach ($datos as $valores){
		    foreach ($valores as $val) {
		        foreach ($val as $i => $value) {
		            $aux[$i] = $value;
		        }
		        
		        $folio = '"'.$aux["IdPago"].'"';
		        
		        //Acuse
		        if (file_exists("archivos/acusePago/".$aux["IdPago"].".pdf")) {
		            $aux["acusePDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrAcuse(".$folio.");'></INPUT>";
		        } else {
		            $aux["acusePDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrAcuse(".$folio.");' disabled></INPUT>";
		        }
		        
		        $r=mysqli_query($enlace,"select p.IdBancoO, nb.Nombre, b.NumCuenta from pagos as p inner join bancos as b on p.IdBancoO = b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco  = nb.IdNombreBanco where p.IdPago = ".$folio.""); 
				$myrow=mysqli_fetch_array($r);
		        $aux["CuentaOrigen"] = $myrow[1].', '.$myrow[2];
		        
		        $arreglo[$x] = $aux;
	    		$x = $x + 1;
		    }
		}
		
		$datos['data'] = $arreglo;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'EdoCuentaProveedores') {
	    if ($_POST["fechaI"] != "" && $_POST["fechaF"] != "") {
	        //Hay un período
	        if ($_POST["proveedor"] != "") {
	            //Hay un proveedor seleccionado en un período establecido
	            $r=mysqli_query($enlace, "select Factura, FechaFactura, Concepto, Cantidad, IdFolioGasto, Observaciones from facturasgastos where IdProveedor = '".$_POST["proveedor"]."' AND FechaFactura BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."'");
	            while ($myrow=mysqli_fetch_array($r)) {
	                echo "<tr  bgcolor='#CEFFC1'>";
	                echo "<td>Gasto</td>";
	                echo "<td>".$myrow[0]."</td>";
	                echo "<td>".$myrow[1]."</td>";
	                echo "<td>".$myrow[2]."</td>";
	                echo "<td></td>";
	                echo "<td>".$myrow[3]."</td>";
	                echo "<td></td>";
	                echo "<td>".$myrow[3]."</td>";
	                echo "<td>".$myrow[5]."</td>";
	                echo "</tr>";
	                
	                $p=mysqli_query($enlace, "select Referencias, FechaPago, Observaciones, Monto, ModoPago from pagos where IdFolioGasto = ".$myrow[4]." AND FechaPago BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."'");
	                $saldo = $myrow[3];
	                while ($row=mysqli_fetch_array($p)) {
	                    $saldo = $saldo - $row[3];
	                    echo "<tr>";
	                    echo "<td>Pago</td>";
	                    echo "<td>".$row[0]."</td>";
	                    echo "<td>".$row[1]."</td>";
	                    echo "<td>".$row[2]."</td>";
	                    echo "<td>".$row[4]."</td>";
	                    echo "<td></td>";
	                    echo "<td>".$row[3]."</td>";
	                    echo "<td>".$saldo."</td>";
	                    echo "<td></td>";
	                    echo "</tr>";
	                }
	            }
	            
	        } else {
	            //Estado de cuenta de un periodo de todos los proveedores
	            $r=mysqli_query($enlace, "select Factura, FechaFactura, Concepto, Cantidad, IdFolioGasto, Observaciones from facturasgastos where FechaFactura BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."'");
	            while ($myrow=mysqli_fetch_array($r)) {
	                echo "<tr  bgcolor='#CEFFC1'>";
	                echo "<td>Gasto</td>";
	                echo "<td>".$myrow[0]."</td>";
	                echo "<td>".$myrow[1]."</td>";
	                echo "<td>".$myrow[2]."</td>";
	                echo "<td></td>";
	                echo "<td>".$myrow[3]."</td>";
	                echo "<td></td>";
	                echo "<td>".$myrow[3]."</td>";
	                echo "<td>".$myrow[5]."</td>";
	                echo "</tr>";
	                
	                $p=mysqli_query($enlace, "select Referencias, FechaPago, Observaciones, Monto, ModoPago from pagos where IdFolioGasto = ".$myrow[4]." AND FechaPago BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."'");
	                $saldo = $myrow[3];
	                while ($row=mysqli_fetch_array($p)) {
	                    $saldo = $saldo - $row[3];
	                    echo "<tr>";
	                    echo "<td>Pago</td>";
	                    echo "<td>".$row[0]."</td>";
	                    echo "<td>".$row[1]."</td>";
	                    echo "<td>".$row[2]."</td>";
	                    echo "<td>".$row[4]."</td>";
	                    echo "<td></td>";
	                    echo "<td>".$row[3]."</td>";
	                    echo "<td>".$saldo."</td>";
	                    echo "<td></td>";
	                    echo "</tr>";
	                }
	            }
	        }
	        
	    } else {
	        //No hay período
	        if ($_POST["proveedor"] != "") {
	            //Hay un proveedor seleccionado sin período establecido
	            $r=mysqli_query($enlace, "select Factura, FechaFactura, Concepto, Cantidad, IdFolioGasto, Observaciones from facturasgastos where IdProveedor = '".$_POST["proveedor"]."'");
	            while ($myrow=mysqli_fetch_array($r)) {
	                echo "<tr  bgcolor='#CEFFC1'>";
	                echo "<td>Gasto</td>";
	                echo "<td>".$myrow[0]."</td>";
	                echo "<td>".$myrow[1]."</td>";
	                echo "<td>".$myrow[2]."</td>";
	                echo "<td></td>";
	                echo "<td>".$myrow[3]."</td>";
	                echo "<td></td>";
	                echo "<td>".$myrow[3]."</td>";
	                echo "<td>".$myrow[5]."</td>";
	                echo "</tr>";
	                
	                $p=mysqli_query($enlace, "select Referencias, FechaPago, Observaciones, Monto, ModoPago from pagos where IdFolioGasto = ".$myrow[4]."");
	                $saldo = $myrow[3];
	                while ($row=mysqli_fetch_array($p)) {
	                    $saldo = $saldo - $row[3];
	                    echo "<tr>";
	                    echo "<td>Pago</td>";
	                    echo "<td>".$row[0]."</td>";
	                    echo "<td>".$row[1]."</td>";
	                    echo "<td>".$row[2]."</td>";
	                    echo "<td>".$row[4]."</td>";
	                    echo "<td></td>";
	                    echo "<td>".$row[3]."</td>";
	                    echo "<td>".$saldo."</td>";
	                    echo "<td></td>";
	                    echo "</tr>";
	                }
	            }
	            
	        } else {
	            //No hay un proveedor seleccionado ni un período
	            $r=mysqli_query($enlace, "select Factura, FechaFactura, Concepto, Cantidad, IdFolioGasto, Observaciones from facturasgastos");
	            while ($myrow=mysqli_fetch_array($r)) {
	                echo "<tr  bgcolor='#CEFFC1'>";
	                echo "<td>Gasto</td>";
	                echo "<td>".$myrow[0]."</td>";
	                echo "<td>".$myrow[1]."</td>";
	                echo "<td>".$myrow[2]."</td>";
	                echo "<td></td>";
	                echo "<td>".$myrow[3]."</td>";
	                echo "<td></td>";
	                echo "<td>".$myrow[3]."</td>";
	                echo "<td>".$myrow[5]."</td>";
	                echo "</tr>";
	                
	                $p=mysqli_query($enlace, "select Referencias, FechaPago, Observaciones, Monto, ModoPago from pagos where IdFolioGasto = ".$myrow[4]."");
	                $saldo = $myrow[3];
	                while ($row=mysqli_fetch_array($p)) {
	                    $saldo = $saldo - $row[3];
	                    echo "<tr>";
	                    echo "<td>Pago</td>";
	                    echo "<td>".$row[0]."</td>";
	                    echo "<td>".$row[1]."</td>";
	                    echo "<td>".$row[2]."</td>";
	                    echo "<td>".$row[4]."</td>";
	                    echo "<td></td>";
	                    echo "<td>".$row[3]."</td>";
	                    echo "<td>".$saldo."</td>";
	                    echo "<td></td>";
	                    echo "</tr>";
	                }
	            }
	            
	        }
	    }
	    
	}
	
	/*if ($id == 'EdoCuenta') {
	    //Truncate table aux
	    $sql = 'truncate table aux';
	    mysqli_query($enlace, $sql);
	    
	    //Llenar la tabla aux
	    $r=mysqli_query($enlace, "select IdCobro, IdbancoAs, FechaCobro from cobros order by FechaCobro");
	    while ($myrow=mysqli_fetch_array($r)) {
	        $sql = 'insert into aux values (null, "'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'", "C")';
	        mysqli_query($enlace, $sql);
	    }
	    
	    $r=mysqli_query($enlace, "select IdPago, IdBancoO, FechaPago from pagos order by FechaPago");
	    while ($myrow=mysqli_fetch_array($r)) {
	        $sql = 'insert into aux values (null, "'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'", "P")';
	        mysqli_query($enlace, $sql);
	    }
	    
	    $banco = 0;
	    $saldo = 0;
	    $egreso = 0;
	    $ingreso = 0;
	    //Consultar la tabla aux
	    $r=mysqli_query($enlace, "select IdFactura, IdBanco, Fecha, Tipo from aux order by IdBanco");
	    while ($myrow=mysqli_fetch_array($r)) {
	        if ($banco != $myrow[1]) {
	            //Asignar banco
	            $banco = $myrow[1];
	            $b=mysqli_query($enlace, "select nb.Nombre, b.NumCuenta, b.Fecha, b.Saldo from bancos as b inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where b.IdBanco = '".$banco."'");
	            $row=mysqli_fetch_array($b);
	            echo "<tr bgcolor = '#F2E778'>";
	            echo "<td></td>";
	            echo "<td></td>";
	            echo "<td></td>";
	            echo "<td>".$row[0]."</td>"; //Banco
	            echo "<td>".$row[1]."</td>";
	            echo "<td></td>";
	            echo "<td>".$row[2]."</td>";
	            echo "<td>SALDO INICIAL</td>";
	            echo "<td></td>";
	            echo "<td></td>";
	            echo "<td>".number_format($row[3], 2, ".", ",")."</td>"; //number_format($c[2], 2, ".", ",")
	            echo "<td></td>";
	            echo "<td></td>";
	            echo "<td></td>";
	            echo "<td></td>";
	            echo "<td></td>";
	            echo "<td></td>";
	            echo "<td></td>";
	            echo "<td></td>";
	            echo "</tr>";
	            $saldo = $row[3];
	            
	            
	            //Cobros y pagos
	            if ($myrow[3] == 'C') {
	                //Cobros
	                $cobro=mysqli_query($enlace, "select c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones, e.Nombre, e.RFC, nb.Nombre, b.NumCuenta, f.FolioFactura, f.FechaEmision, f.Concepto, a.Concepto from cobros as c inner join bancos as b on c.IdBancoEmp=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco inner join facturasaporta as f on c.IdFolioAporta=f.IdFolioAporta inner join empacadora as e on f.IdEmpacadora=e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion=a.IdTipoAportacion where IdCobro= '".$myrow[0]."'");
	                $c=mysqli_fetch_array($cobro);
	                $saldo = $saldo + $c[2];
	                $ingreso = $ingreso + $c[2];
	                echo "<tr bgcolor = '#F3F3F3'>";
	                echo "<td>PRODUCTOR</td>";
	                echo "<td>".$c[11]."</td>";
	                echo "<td>".$c[1]."</td>";
	                echo "<td>".$c[6]."</td>";
	                echo "<td>".$c[7]."</td>";
	                echo "<td>".$c[5]."</td>";
	                echo "<td></td>";
	                echo "<td>".$c[4]."</td>";
	                echo "<td></td>";
	                echo "<td>".number_format($c[2], 2, ".", ",")."</td>";
	                echo "<td>".number_format($saldo, 2, ".", ",")."</td>"; //Saldo
	                echo "<td>".$c[10]."</td>";
	                echo "<td>".$c[8]."</td>";
	                echo "<td>".$c[9]."</td>";
	                echo "<td></td>"; //Subtotal
	                echo "<td></td>"; //IVA
	                echo "<td>".number_format($c[2], 2, ".", ",")."</td>"; //Total
	                echo "<td>".$c[0]."</td>";
	                echo "<td>".$c[3]."</td>";
	                echo "</tr>";
	            } else {
	                //Pagos
	                $pago=mysqli_query($enlace, "select A.Concepto, P.FechaPago, nb.Nombre, b.NumCuenta, Pr.RFC, F.Autorizada, Pr.Nombre, P.Monto, F.Concepto, F.Factura, F.FechaFactura, P.Referencias, P.Observaciones from pagos as P inner join facturasgastos as F on P.IdFolioGasto=F.IdFolioGasto inner join areas as A on F.IdArea=A.IdArea inner join proveedores as Pr on P.IdProveedor=Pr.IdProveedor inner join bancos as b on P.IdBanco=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where IdPago = '".$myrow[0]."'");
	                $p=mysqli_fetch_array($pago);
	                $saldo = $saldo - $p[7];
	                $egreso = $egreso + $p[7];
	                echo "<tr bgcolor = '#F3F3F3'>";
	                echo "<td>PROVEEDOR</td>";
	                echo "<td>".$p[0]."</td>";
	                echo "<td>".$p[1]."</td>";
	                echo "<td>".$p[2]."</td>";
	                echo "<td>".$p[3]."</td>";
	                echo "<td>".$p[4]."</td>";
	                echo "<td>".$p[5]."</td>";
	                echo "<td>".$p[6]."</td>";
	                echo "<td>".number_format($p[7], 2, ".", ",")."</td>";//Monto
	                echo "<td></td>";
	                echo "<td>".number_format($saldo, 2, ".", ",")."</td>";//Saldo
	                echo "<td>".$p[8]."</td>";
	                echo "<td>".$p[9]."</td>";
	                echo "<td>".$p[10]."</td>";
	                echo "<td></td>";
	                echo "<td></td>";
	                echo "<td>".number_format($p[7], 2, ".", ",")."</td>";
	                echo "<td>".$p[11]."</td>";
	                echo "<td>".$p[12]."</td>";
	                echo "</tr>";
	            }
	            
	        } else {
	            //Cobros y pagos
	            if ($myrow[3] == 'C') {
	                //Cobros
	                $cobro=mysqli_query($enlace, "select c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones, e.Nombre, e.RFC, nb.Nombre, b.NumCuenta, f.FolioFactura, f.FechaEmision, f.Concepto, a.Concepto from cobros as c inner join bancos as b on c.IdBancoEmp=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco inner join facturasaporta as f on c.IdFolioAporta=f.IdFolioAporta inner join empacadora as e on f.IdEmpacadora=e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion=a.IdTipoAportacion where IdCobro= '".$myrow[0]."'");
	                $c=mysqli_fetch_array($cobro);
	                $saldo = $saldo + $c[2];
	                $ingreso = $ingreso + $c[2];
	                echo "<tr bgcolor = '#F3F3F3'>";
	                echo "<td>PRODUCTOR</td>";
	                echo "<td>".$c[11]."</td>";
	                echo "<td>".$c[1]."</td>";
	                echo "<td>".$c[6]."</td>";
	                echo "<td>".$c[7]."</td>";
	                echo "<td>".$c[5]."</td>";
	                echo "<td></td>";
	                echo "<td>".$c[4]."</td>";
	                echo "<td></td>";
	                echo "<td>".number_format($c[2], 2, ".", ",")."</td>";
	                echo "<td>".number_format($saldo, 2, ".", ",")."</td>"; //Saldo
	                echo "<td>".$c[10]."</td>";
	                echo "<td>".$c[8]."</td>";
	                echo "<td>".$c[9]."</td>";
	                echo "<td></td>"; //Subtotal
	                echo "<td></td>"; //IVA
	                echo "<td>".number_format($c[2], 2, ".", ",")."</td>"; //Total
	                echo "<td>".$c[0]."</td>";
	                echo "<td>".$c[3]."</td>";
	                echo "</tr>";
	            } else {
	                //Pagos
	                $pago=mysqli_query($enlace, "select A.Concepto, P.FechaPago, nb.Nombre, b.NumCuenta, Pr.RFC, F.Autorizada, Pr.Nombre, P.Monto, F.Concepto, F.Factura, F.FechaFactura, P.Referencias, P.Observaciones from pagos as P inner join facturasgastos as F on P.IdFolioGasto=F.IdFolioGasto inner join areas as A on F.IdArea=A.IdArea inner join proveedores as Pr on P.IdProveedor=Pr.IdProveedor inner join bancos as b on P.IdBanco=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where IdPago = '".$myrow[0]."'");
	                $p=mysqli_fetch_array($pago);
	                $saldo = $saldo - $p[7];
	                $egreso = $egreso + $p[7];
	                echo "<tr bgcolor = '#F3F3F3'>";
	                echo "<td>PROVEEDOR</td>";
	                echo "<td>".$p[0]."</td>";
	                echo "<td>".$p[1]."</td>";
	                echo "<td>".$p[2]."</td>";
	                echo "<td>".$p[3]."</td>";
	                echo "<td>".$p[4]."</td>";
	                echo "<td>".$p[5]."</td>";
	                echo "<td>".$p[6]."</td>";
	                echo "<td>".number_format($p[7], 2, ".", ",")."</td>";//Monto
	                echo "<td></td>";
	                echo "<td>".number_format($saldo, 2, ".", ",")."</td>";//Saldo
	                echo "<td>".$p[8]."</td>";
	                echo "<td>".$p[9]."</td>";
	                echo "<td>".$p[10]."</td>";
	                echo "<td></td>";
	                echo "<td></td>";
	                echo "<td>".number_format($p[7], 2, ".", ",")."</td>";
	                echo "<td>".$p[11]."</td>";
	                echo "<td>".$p[12]."</td>";
	                echo "</tr>";
	                
	            }
	        }
	        
	    }
	    
	    echo "<tr>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th style='text-align: right'>TOTAL: </th>";
	    echo "<th style='text-align: right'>$".number_format($egreso, 2, ".", ",")."</th>";
	    echo "<th style='text-align: right'>$".number_format($ingreso, 2, ".", ",")."</th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";//Subtotal
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "</tr>";
	    
	}*/
	
	if ($id == 'EdoCuenta') {
		//Truncate table aux
    	$sql = 'truncate table aux';
    	mysqli_query($enlace, $sql);
    	    
    	//Llenar la tabla aux
    	$r=mysqli_query($enlace, "select IdCobro, IdbancoAs, FechaCobro from cobros order by FechaCobro");
    	while ($myrow=mysqli_fetch_array($r)) {
    	    $sql = 'insert into aux values (null, "'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'", "C")';
    	    mysqli_query($enlace, $sql);
    	}
    	    
    	$r=mysqli_query($enlace, "select IdPago, IdBancoO, FechaPago from pagos order by FechaPago");
    	while ($myrow=mysqli_fetch_array($r)) {
    	    $sql = 'insert into aux values (null, "'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'", "P")';
    	    mysqli_query($enlace, $sql);
    	}
    	    
    	$banco = 0;
    	$saldo = 0;
    	$egreso = 0;
    	$ingreso = 0;

    	//En un período sin tipo
    	if ($_POST["FI"] != "" && $_POST["FF"] != "" && $_POST["T"] == "") {
    		$r=mysqli_query($enlace, "select IdFactura, IdBanco, Fecha, Tipo from aux order by IdBanco");
    		while ($myrow=mysqli_fetch_array($r)) {
    			if ($banco != $myrow[1]) {
    				//Asignar banco
    				$banco = $myrow[1];
					$b=mysqli_query($enlace, "select nb.Nombre, b.NumCuenta, b.Fecha, b.Saldo from bancos as b inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where b.IdBanco = '".$banco."'  AND b.Fecha BETWEEN '0000-01-01' AND '".$_POST["FF"]."'");
		        	$row=mysqli_fetch_array($b);
		        	if ($_POST["FI"]>=$row[2]) {
		        		//Calcular los cobros y pagos hechos antes de FI para calcular el saldo
		        		//Cobros
		        		$cobro=mysqli_query($enlace, "select Monto from cobros  where IdCobro= '".$myrow[0]."' AND FechaCobro >= '".$_POST["FI"]."' AND FechaCobro < '".$_POST["FF"]."'");
						$c=mysqli_fetch_array($cobro);
						$saldo = $saldo + @$c[0];
						//Pagos
				    	$pago=mysqli_query($enlace, "select Monto from pagos where IdPago = '".$myrow[0]."' AND FechaPago >= '".$_POST["FI"]."' AND FechaPago < '".$_POST["FF"]."'");
			        	$p=mysqli_fetch_array($pago);
				    	$saldo = $saldo - @$p[0];

				    	echo "<tr bgcolor = '#F2E778'>";
				        echo "<td></td>";
				        echo "<td></td>";
				        echo "<td></td>";
				        echo "<td>".$row[0]."</td>"; //Banco
				        echo "<td>".$row[1]."</td>";
				        echo "<td></td>";
				        echo "<td>".$row[2]."</td>";
				        echo "<td>SALDO INICIAL</td>";
				        echo "<td></td>";
				        echo "<td></td>";
				        echo "<td>".number_format($row[3], 2, ".", ",")."</td>"; //number_format($c[2], 2, ".", ",")
				        echo "<td></td>";
				        echo "<td></td>";
				        echo "<td></td>";
				        echo "<td></td>";
				        echo "<td></td>";
				        echo "<td></td>";
				        echo "<td></td>";
				        echo "<td></td>";
				        echo "</tr>";
				        $saldo = $row[3];

				        if ($myrow[3] == 'C') {
				        	//Cobros
				            $cobro=mysqli_query($enlace, "select c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones, e.Nombre, e.RFC, nb.Nombre, b.NumCuenta, f.FolioFactura, f.FechaEmision, f.Concepto, a.Concepto from cobros as c inner join bancos as b on c.IdBancoEmp=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco inner join facturasaporta as f on c.IdFolioAporta=f.IdFolioAporta inner join empacadora as e on f.IdEmpacadora=e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion=a.IdTipoAportacion where IdCobro= '".$myrow[0]."' AND c.FechaCobro BETWEEN '".$_POST["FI"]."' AND '".$_POST["FF"]."'");
				            $c=mysqli_fetch_array($cobro);
				            $saldo = $saldo + $c[2];
				            $ingreso = $ingreso + $c[2];
				            echo "<tr bgcolor = '#F3F3F3'>";
				            echo "<td>PRODUCTOR</td>";
				            echo "<td>".$c[11]."</td>";
				            echo "<td>".$c[1]."</td>";
				            echo "<td>".$c[6]."</td>";
				            echo "<td>".$c[7]."</td>";
				            echo "<td>".$c[5]."</td>";
				            echo "<td></td>";
				            echo "<td>".$c[4]."</td>";
				            echo "<td></td>";
				            echo "<td>".number_format($c[2], 2, ".", ",")."</td>";
				            echo "<td>".number_format($saldo, 2, ".", ",")."</td>"; //Saldo
				            echo "<td>".$c[10]."</td>";
				            echo "<td>".$c[8]."</td>";
				            echo "<td>".$c[9]."</td>";
				            echo "<td></td>"; //Subtotal
				            echo "<td></td>"; //IVA
				            echo "<td>".number_format($c[2], 2, ".", ",")."</td>"; //Total
				            echo "<td>".$c[0]."</td>";
				            echo "<td>".$c[3]."</td>";
				            echo "</tr>";
				        } else {
				        	//Pagos
				            $pago=mysqli_query($enlace, "select A.Concepto, P.FechaPago, nb.Nombre, b.NumCuenta, Pr.RFC, F.Autorizada, Pr.Nombre, P.Monto, F.Concepto, F.Factura, F.FechaFactura, P.Referencias, P.Observaciones from pagos as P inner join facturasgastos as F on P.IdFolioGasto=F.IdFolioGasto inner join areas as A on F.IdArea=A.IdArea inner join proveedores as Pr on P.IdProveedor=Pr.IdProveedor inner join bancos as b on P.IdBanco=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where IdPago = '".$myrow[0]."' AND P.FechaPago BETWEEN '".$_POST["FI"]."' AND '".$_POST["FF"]."'");
				            $p=mysqli_fetch_array($pago);
				            $saldo = $saldo - $p[7];
				            $egreso = $egreso + $p[7];
				            echo "<tr bgcolor = '#F3F3F3'>";
				            echo "<td>PROVEEDOR</td>";
				            echo "<td>".$p[0]."</td>";
				            echo "<td>".$p[1]."</td>";
				            echo "<td>".$p[2]."</td>";
				            echo "<td>".$p[3]."</td>";
				            echo "<td>".$p[4]."</td>";
				            echo "<td>".$p[5]."</td>";
				            echo "<td>".$p[6]."</td>";
				            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";//Monto
				            echo "<td></td>";
				            echo "<td>".number_format($saldo, 2, ".", ",")."</td>";//Saldo
				            echo "<td>".$p[8]."</td>";
				            echo "<td>".$p[9]."</td>";
				            echo "<td>".$p[10]."</td>";
				            echo "<td></td>";
				            echo "<td></td>";
				            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";
				            echo "<td>".$p[11]."</td>";
				            echo "<td>".$p[12]."</td>";
				            echo "</tr>";
				        }
		        	} else {
		        		if ($_POST["FF"]>=$row[2]) {
		        			//Buscar directamente los movimientos entre FI y FF
		        			echo "<tr bgcolor = '#F2E778'>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td>".$row[0]."</td>"; //Banco
					        echo "<td>".$row[1]."</td>";
					        echo "<td></td>";
					        echo "<td>".$row[2]."</td>";
					        echo "<td>SALDO INICIAL</td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td>".number_format($row[3], 2, ".", ",")."</td>"; //number_format($c[2], 2, ".", ",")
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "</tr>";
					        $saldo = $row[3];

					        if ($myrow[3] == 'C') {
					        	//Cobros
					            $cobro=mysqli_query($enlace, "select c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones, e.Nombre, e.RFC, nb.Nombre, b.NumCuenta, f.FolioFactura, f.FechaEmision, f.Concepto, a.Concepto from cobros as c inner join bancos as b on c.IdBancoEmp=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco inner join facturasaporta as f on c.IdFolioAporta=f.IdFolioAporta inner join empacadora as e on f.IdEmpacadora=e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion=a.IdTipoAportacion where IdCobro= '".$myrow[0]."' AND c.FechaCobro BETWEEN '".$_POST["FI"]."' AND '".$_POST["FF"]."'");
					            $c=mysqli_fetch_array($cobro);
					            $saldo = $saldo + $c[2];
					            $ingreso = $ingreso + $c[2];
					            echo "<tr bgcolor = '#F3F3F3'>";
					            echo "<td>PRODUCTOR</td>";
					            echo "<td>".$c[11]."</td>";
					            echo "<td>".$c[1]."</td>";
					            echo "<td>".$c[6]."</td>";
					            echo "<td>".$c[7]."</td>";
					            echo "<td>".$c[5]."</td>";
					            echo "<td></td>";
					            echo "<td>".$c[4]."</td>";
					            echo "<td></td>";
					            echo "<td>".number_format($c[2], 2, ".", ",")."</td>";
					            echo "<td>".number_format($saldo, 2, ".", ",")."</td>"; //Saldo
					            echo "<td>".$c[10]."</td>";
					            echo "<td>".$c[8]."</td>";
					            echo "<td>".$c[9]."</td>";
					            echo "<td></td>"; //Subtotal
					            echo "<td></td>"; //IVA
					            echo "<td>".number_format($c[2], 2, ".", ",")."</td>"; //Total
					            echo "<td>".$c[0]."</td>";
					            echo "<td>".$c[3]."</td>";
					            echo "</tr>";
					        } else {
					        	//Pagos
					            $pago=mysqli_query($enlace, "select A.Concepto, P.FechaPago, nb.Nombre, b.NumCuenta, Pr.RFC, F.Autorizada, Pr.Nombre, P.Monto, F.Concepto, F.Factura, F.FechaFactura, P.Referencias, P.Observaciones from pagos as P inner join facturasgastos as F on P.IdFolioGasto=F.IdFolioGasto inner join areas as A on F.IdArea=A.IdArea inner join proveedores as Pr on P.IdProveedor=Pr.IdProveedor inner join bancos as b on P.IdBanco=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where IdPago = '".$myrow[0]."' AND P.FechaPago BETWEEN '".$_POST["FI"]."' AND '".$_POST["FF"]."'");
					            $p=mysqli_fetch_array($pago);
					            $saldo = $saldo - $p[7];
					            $egreso = $egreso + $p[7];
					            echo "<tr bgcolor = '#F3F3F3'>";
					            echo "<td>PROVEEDOR</td>";
					            echo "<td>".$p[0]."</td>";
					            echo "<td>".$p[1]."</td>";
					            echo "<td>".$p[2]."</td>";
					            echo "<td>".$p[3]."</td>";
					            echo "<td>".$p[4]."</td>";
					            echo "<td>".$p[5]."</td>";
					            echo "<td>".$p[6]."</td>";
					            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";//Monto
					            echo "<td></td>";
					            echo "<td>".number_format($saldo, 2, ".", ",")."</td>";//Saldo
					            echo "<td>".$p[8]."</td>";
					            echo "<td>".$p[9]."</td>";
					            echo "<td>".$p[10]."</td>";
					            echo "<td></td>";
					            echo "<td></td>";
					            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";
					            echo "<td>".$p[11]."</td>";
					            echo "<td>".$p[12]."</td>";
					            echo "</tr>";
					        }
		        		}
		        	}
    			} else {
    				//Cobros y pagos entre FI y FF
    				if ($myrow[3] == 'C') {
    					//Cobros
						$cobro=mysqli_query($enlace, "select c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones, e.Nombre, e.RFC, nb.Nombre, b.NumCuenta, f.FolioFactura, f.FechaEmision, f.Concepto, a.Concepto from cobros as c inner join bancos as b on c.IdBancoEmp=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco inner join facturasaporta as f on c.IdFolioAporta=f.IdFolioAporta inner join empacadora as e on f.IdEmpacadora=e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion=a.IdTipoAportacion where IdCobro= '".$myrow[0]."' AND c.FechaCobro BETWEEN '".$_POST["FI"]."' AND '".$_POST["FF"]."'");
						$c=mysqli_fetch_array($cobro);
						$saldo = $saldo + $c[2];
						$ingreso = $ingreso + $c[2];
			            echo "<tr bgcolor = '#F3F3F3'>";
			            echo "<td>PRODUCTOR</td>";
			            echo "<td>".$c[11]."</td>";
			            echo "<td>".$c[1]."</td>";
			            echo "<td>".$c[6]."</td>";
			            echo "<td>".$c[7]."</td>";
			            echo "<td>".$c[5]."</td>";
			            echo "<td></td>";
			            echo "<td>".$c[4]."</td>";
			            echo "<td></td>";
			            echo "<td>".number_format($c[2], 2, ".", ",")."</td>";
			            echo "<td>".number_format($saldo, 2, ".", ",")."</td>"; //Saldo
			            echo "<td>".$c[10]."</td>";
			            echo "<td>".$c[8]."</td>";
			            echo "<td>".$c[9]."</td>";
			            echo "<td></td>"; //Subtotal
			            echo "<td></td>"; //IVA
			            echo "<td>".number_format($c[2], 2, ".", ",")."</td>"; //Total
			            echo "<td>".$c[0]."</td>";
			            echo "<td>".$c[3]."</td>";
			            echo "</tr>";
    				} else {
    					//Pagos
			            $pago=mysqli_query($enlace, "select A.Concepto, P.FechaPago, nb.Nombre, b.NumCuenta, Pr.RFC, F.Autorizada, Pr.Nombre, P.Monto, F.Concepto, F.Factura, F.FechaFactura, P.Referencias, P.Observaciones from pagos as P inner join facturasgastos as F on P.IdFolioGasto=F.IdFolioGasto inner join areas as A on F.IdArea=A.IdArea inner join proveedores as Pr on P.IdProveedor=Pr.IdProveedor inner join bancos as b on P.IdBanco=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where IdPago = '".$myrow[0]."' AND P.FechaPago BETWEEN '".$_POST["FI"]."' AND '".$_POST["FF"]."'");
			            $p=mysqli_fetch_array($pago);
			            $saldo = $saldo - $p[7];
			            $egreso = $egreso + $p[7];
			            echo "<tr bgcolor = '#F3F3F3'>";
			            echo "<td>PROVEEDOR</td>";
			            echo "<td>".$p[0]."</td>";
			            echo "<td>".$p[1]."</td>";
			            echo "<td>".$p[2]."</td>";
			            echo "<td>".$p[3]."</td>";
			            echo "<td>".$p[4]."</td>";
			            echo "<td>".$p[5]."</td>";
			            echo "<td>".$p[6]."</td>";
			            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";//Monto
			            echo "<td></td>";
			            echo "<td>".number_format($saldo, 2, ".", ",")."</td>";//Saldo
			            echo "<td>".$p[8]."</td>";
			            echo "<td>".$p[9]."</td>";
			            echo "<td>".$p[10]."</td>";
			            echo "<td></td>";
			            echo "<td></td>";
			            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";
			            echo "<td>".$p[11]."</td>";
			            echo "<td>".$p[12]."</td>";
			            echo "</tr>";
    				}
    			}
    		}
    	} else {
    		//En un período con tipo
    		if ($_POST["FI"] != "" && $_POST["FF"] != "" && $_POST["T"] != "") {
    			$r=mysqli_query($enlace, "select IdFactura, IdBanco, Fecha, Tipo from aux order by IdBanco");
				while ($myrow=mysqli_fetch_array($r)) {
					if ($banco != $myrow[1]) {
						//Asignar banco
						$banco = $myrow[1];
						$b=mysqli_query($enlace, "select nb.Nombre, b.NumCuenta, b.Fecha, b.Saldo from bancos as b inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where b.IdBanco = '".$banco."'  AND b.Fecha BETWEEN '0000-01-01' AND '".$_POST["FF"]."'");
			        	$row=mysqli_fetch_array($b);
			        	if ($_POST["FI"]>=$row[2]) {
			        		//Calcular los cobros y pagos hechos antes de FI para calcular el saldo
			        		//Cobros
			        		$cobro=mysqli_query($enlace, "select Monto from cobros  where IdCobro= '".$myrow[0]."' AND FechaCobro >= '".$_POST["FI"]."' AND FechaCobro < '".$_POST["FF"]."'");
							$c=mysqli_fetch_array($cobro);
							$saldo = $saldo + $c[0];
							//Pagos
					    	$pago=mysqli_query($enlace, "select Monto from pagos where IdPago = '".$myrow[0]."' AND FechaPago >= '".$_POST["FI"]."' AND FechaPago < '".$_POST["FF"]."'");
				        	$p=mysqli_fetch_array($pago);
					    	$saldo = $saldo - $p[0];

					    	echo "<tr bgcolor = '#F2E778'>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td>".$row[0]."</td>"; //Banco
					        echo "<td>".$row[1]."</td>";
					        echo "<td></td>";
					        echo "<td>".$row[2]."</td>";
					        echo "<td>SALDO INICIAL</td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td>".number_format($row[3], 2, ".", ",")."</td>"; //number_format($c[2], 2, ".", ",")
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "</tr>";
					        $saldo = $row[3];

					        if ($_TIPO["C"]) {
					        	if ($myrow[3] == 'C') {
					        		//Cobros
						            $cobro=mysqli_query($enlace, "select c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones, e.Nombre, e.RFC, nb.Nombre, b.NumCuenta, f.FolioFactura, f.FechaEmision, f.Concepto, a.Concepto from cobros as c inner join bancos as b on c.IdBancoEmp=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco inner join facturasaporta as f on c.IdFolioAporta=f.IdFolioAporta inner join empacadora as e on f.IdEmpacadora=e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion=a.IdTipoAportacion where IdCobro= '".$myrow[0]."' AND c.FechaCobro BETWEEN '".$_POST["FI"]."' AND '".$_POST["FF"]."'");
						            $c=mysqli_fetch_array($cobro);
						            $saldo = $saldo + $c[2];
						            $ingreso = $ingreso + $c[2];
						            echo "<tr bgcolor = '#F3F3F3'>";
						            echo "<td>PRODUCTOR</td>";
						            echo "<td>".$c[11]."</td>";
						            echo "<td>".$c[1]."</td>";
						            echo "<td>".$c[6]."</td>";
						            echo "<td>".$c[7]."</td>";
						            echo "<td>".$c[5]."</td>";
						            echo "<td></td>";
						            echo "<td>".$c[4]."</td>";
						            echo "<td></td>";
						            echo "<td>".number_format($c[2], 2, ".", ",")."</td>";
						            echo "<td>".number_format($saldo, 2, ".", ",")."</td>"; //Saldo
						            echo "<td>".$c[10]."</td>";
						            echo "<td>".$c[8]."</td>";
						            echo "<td>".$c[9]."</td>";
						            echo "<td></td>"; //Subtotal
						            echo "<td></td>"; //IVA
						            echo "<td>".number_format($c[2], 2, ".", ",")."</td>"; //Total
						            echo "<td>".$c[0]."</td>";
						            echo "<td>".$c[3]."</td>";
						            echo "</tr>";
					        	}
					        } else {
					        	if ($myrow[3] == 'P') {
					        		//Pagos
						            $pago=mysqli_query($enlace, "select A.Concepto, P.FechaPago, nb.Nombre, b.NumCuenta, Pr.RFC, F.Autorizada, Pr.Nombre, P.Monto, F.Concepto, F.Factura, F.FechaFactura, P.Referencias, P.Observaciones from pagos as P inner join facturasgastos as F on P.IdFolioGasto=F.IdFolioGasto inner join areas as A on F.IdArea=A.IdArea inner join proveedores as Pr on P.IdProveedor=Pr.IdProveedor inner join bancos as b on P.IdBanco=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where IdPago = '".$myrow[0]."' AND P.FechaPago BETWEEN '".$_POST["FI"]."' AND '".$_POST["FF"]."'");
						            $p=mysqli_fetch_array($pago);
						            $saldo = $saldo - $p[7];
						            $egreso = $egreso + $p[7];
						            echo "<tr bgcolor = '#F3F3F3'>";
						            echo "<td>PROVEEDOR</td>";
						            echo "<td>".$p[0]."</td>";
						            echo "<td>".$p[1]."</td>";
						            echo "<td>".$p[2]."</td>";
						            echo "<td>".$p[3]."</td>";
						            echo "<td>".$p[4]."</td>";
						            echo "<td>".$p[5]."</td>";
						            echo "<td>".$p[6]."</td>";
						            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";//Monto
						            echo "<td></td>";
						            echo "<td>".number_format($saldo, 2, ".", ",")."</td>";//Saldo
						            echo "<td>".$p[8]."</td>";
						            echo "<td>".$p[9]."</td>";
						            echo "<td>".$p[10]."</td>";
						            echo "<td></td>";
						            echo "<td></td>";
						            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";
						            echo "<td>".$p[11]."</td>";
						            echo "<td>".$p[12]."</td>";
						            echo "</tr>";
					        	}
					        }
			        	} else {
			        		if ($_POST["FF"]>=$row[2]){			        				  
		        				//Buscar directamente los movimientos entre FI y FF
			        			echo "<tr bgcolor = '#F2E778'>";
						        echo "<td></td>";
						        echo "<td></td>";
						        echo "<td></td>";
						        echo "<td>".$row[0]."</td>"; //Banco
						        echo "<td>".$row[1]."</td>";
						        echo "<td></td>";
						        echo "<td>".$row[2]."</td>";
						        echo "<td>SALDO INICIAL</td>";
						        echo "<td></td>";
						        echo "<td></td>";
						        echo "<td>".number_format($row[3], 2, ".", ",")."</td>"; //number_format($c[2], 2, ".", ",")
						        echo "<td></td>";
						        echo "<td></td>";
						        echo "<td></td>";
						        echo "<td></td>";
						        echo "<td></td>";
						        echo "<td></td>";
						        echo "<td></td>";
						        echo "<td></td>";
						        echo "</tr>";
						        $saldo = $row[3];

						        if ($_TIPO["C"]) {
						        	if ($myrow[3] == 'C') {
						        		//Cobros
							            $cobro=mysqli_query($enlace, "select c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones, e.Nombre, e.RFC, nb.Nombre, b.NumCuenta, f.FolioFactura, f.FechaEmision, f.Concepto, a.Concepto from cobros as c inner join bancos as b on c.IdBancoEmp=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco inner join facturasaporta as f on c.IdFolioAporta=f.IdFolioAporta inner join empacadora as e on f.IdEmpacadora=e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion=a.IdTipoAportacion where IdCobro= '".$myrow[0]."' AND c.FechaCobro BETWEEN '".$_POST["FI"]."' AND '".$_POST["FF"]."'");
							            $c=mysqli_fetch_array($cobro);
							            $saldo = $saldo + $c[2];
							            $ingreso = $ingreso + $c[2];
							            echo "<tr bgcolor = '#F3F3F3'>";
							            echo "<td>PRODUCTOR</td>";
							            echo "<td>".$c[11]."</td>";
							            echo "<td>".$c[1]."</td>";
							            echo "<td>".$c[6]."</td>";
							            echo "<td>".$c[7]."</td>";
							            echo "<td>".$c[5]."</td>";
							            echo "<td></td>";
							            echo "<td>".$c[4]."</td>";
							            echo "<td></td>";
							            echo "<td>".number_format($c[2], 2, ".", ",")."</td>";
							            echo "<td>".number_format($saldo, 2, ".", ",")."</td>"; //Saldo
							            echo "<td>".$c[10]."</td>";
							            echo "<td>".$c[8]."</td>";
							            echo "<td>".$c[9]."</td>";
							            echo "<td></td>"; //Subtotal
							            echo "<td></td>"; //IVA
							            echo "<td>".number_format($c[2], 2, ".", ",")."</td>"; //Total
							            echo "<td>".$c[0]."</td>";
							            echo "<td>".$c[3]."</td>";
							            echo "</tr>";
						        	}
						        } else {
						        	if ($myrow[3] == 'P') {
						        		//Pagos
							            $pago=mysqli_query($enlace, "select A.Concepto, P.FechaPago, nb.Nombre, b.NumCuenta, Pr.RFC, F.Autorizada, Pr.Nombre, P.Monto, F.Concepto, F.Factura, F.FechaFactura, P.Referencias, P.Observaciones from pagos as P inner join facturasgastos as F on P.IdFolioGasto=F.IdFolioGasto inner join areas as A on F.IdArea=A.IdArea inner join proveedores as Pr on P.IdProveedor=Pr.IdProveedor inner join bancos as b on P.IdBanco=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where IdPago = '".$myrow[0]."' AND P.FechaPago BETWEEN '".$_POST["FI"]."' AND '".$_POST["FF"]."'");
							            $p=mysqli_fetch_array($pago);
							            $saldo = $saldo - $p[7];
							            $egreso = $egreso + $p[7];
							            echo "<tr bgcolor = '#F3F3F3'>";
							            echo "<td>PROVEEDOR</td>";
							            echo "<td>".$p[0]."</td>";
							            echo "<td>".$p[1]."</td>";
							            echo "<td>".$p[2]."</td>";
							            echo "<td>".$p[3]."</td>";
							            echo "<td>".$p[4]."</td>";
							            echo "<td>".$p[5]."</td>";
							            echo "<td>".$p[6]."</td>";
							            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";//Monto
							            echo "<td></td>";
							            echo "<td>".number_format($saldo, 2, ".", ",")."</td>";//Saldo
							            echo "<td>".$p[8]."</td>";
							            echo "<td>".$p[9]."</td>";
							            echo "<td>".$p[10]."</td>";
							            echo "<td></td>";
							            echo "<td></td>";
							            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";
							            echo "<td>".$p[11]."</td>";
							            echo "<td>".$p[12]."</td>";
							            echo "</tr>";
						        	}
						        }
			        		}
			        	}
					} else {
						//Cobros y pagos entre FI y FF
		        		if ($_TIPO["C"]) {
		        			if ($myrow[3] == 'C') {
		        				//Cobros
								$cobro=mysqli_query($enlace, "select c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones, e.Nombre, e.RFC, nb.Nombre, b.NumCuenta, f.FolioFactura, f.FechaEmision, f.Concepto, a.Concepto from cobros as c inner join bancos as b on c.IdBancoEmp=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco inner join facturasaporta as f on c.IdFolioAporta=f.IdFolioAporta inner join empacadora as e on f.IdEmpacadora=e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion=a.IdTipoAportacion where IdCobro= '".$myrow[0]."' AND c.FechaCobro BETWEEN '".$_POST["FI"]."' AND '".$_POST["FF"]."'");
								$c=mysqli_fetch_array($cobro);
								$saldo = $saldo + $c[2];
								$ingreso = $ingreso + $c[2];
					            echo "<tr bgcolor = '#F3F3F3'>";
					            echo "<td>PRODUCTOR</td>";
					            echo "<td>".$c[11]."</td>";
					            echo "<td>".$c[1]."</td>";
					            echo "<td>".$c[6]."</td>";
					            echo "<td>".$c[7]."</td>";
					            echo "<td>".$c[5]."</td>";
					            echo "<td></td>";
					            echo "<td>".$c[4]."</td>";
					            echo "<td></td>";
					            echo "<td>".number_format($c[2], 2, ".", ",")."</td>";
					            echo "<td>".number_format($saldo, 2, ".", ",")."</td>"; //Saldo
					            echo "<td>".$c[10]."</td>";
					            echo "<td>".$c[8]."</td>";
					            echo "<td>".$c[9]."</td>";
					            echo "<td></td>"; //Subtotal
					            echo "<td></td>"; //IVA
					            echo "<td>".number_format($c[2], 2, ".", ",")."</td>"; //Total
					            echo "<td>".$c[0]."</td>";
					            echo "<td>".$c[3]."</td>";
					            echo "</tr>";
		        			}
		        		} else {
		        			if ($myrow[3] == 'P') {
		        				//Pagos
					            $pago=mysqli_query($enlace, "select A.Concepto, P.FechaPago, nb.Nombre, b.NumCuenta, Pr.RFC, F.Autorizada, Pr.Nombre, P.Monto, F.Concepto, F.Factura, F.FechaFactura, P.Referencias, P.Observaciones from pagos as P inner join facturasgastos as F on P.IdFolioGasto=F.IdFolioGasto inner join areas as A on F.IdArea=A.IdArea inner join proveedores as Pr on P.IdProveedor=Pr.IdProveedor inner join bancos as b on P.IdBanco=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where IdPago = '".$myrow[0]."' AND P.FechaPago BETWEEN '".$_POST["FI"]."' AND '".$_POST["FF"]."'");
					            $p=mysqli_fetch_array($pago);
					            $saldo = $saldo - $p[7];
					            $egreso = $egreso + $p[7];
					            echo "<tr bgcolor = '#F3F3F3'>";
					            echo "<td>PROVEEDOR</td>";
					            echo "<td>".$p[0]."</td>";
					            echo "<td>".$p[1]."</td>";
					            echo "<td>".$p[2]."</td>";
					            echo "<td>".$p[3]."</td>";
					            echo "<td>".$p[4]."</td>";
					            echo "<td>".$p[5]."</td>";
					            echo "<td>".$p[6]."</td>";
					            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";//Monto
					            echo "<td></td>";
					            echo "<td>".number_format($saldo, 2, ".", ",")."</td>";//Saldo
					            echo "<td>".$p[8]."</td>";
					            echo "<td>".$p[9]."</td>";
					            echo "<td>".$p[10]."</td>";
					            echo "<td></td>";
					            echo "<td></td>";
					            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";
					            echo "<td>".$p[11]."</td>";
					            echo "<td>".$p[12]."</td>";
					            echo "</tr>";
		        			}
		        		}
					}
				}

    		} else {
    			//Sin período con tipo
    			if ($_POST["T"] != ""){
    				//Consultar la tabla aux
					$r=mysqli_query($enlace, "select IdFactura, IdBanco, Fecha, Tipo from aux order by IdBanco");
					while ($myrow=mysqli_fetch_array($r)) {
						if ($banco != $myrow[1]) {
							$banco = $myrow[1];
					        $b=mysqli_query($enlace, "select nb.Nombre, b.NumCuenta, b.Fecha, b.Saldo from bancos as b inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where b.IdBanco = '".$banco."'");
					        $row=mysqli_fetch_array($b);
					        echo "<tr bgcolor = '#F2E778'>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td>".$row[0]."</td>"; //Banco
					        echo "<td>".$row[1]."</td>";
					        echo "<td></td>";
					        echo "<td>".$row[2]."</td>";
					        echo "<td>SALDO INICIAL</td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td>".number_format($row[3], 2, ".", ",")."</td>"; //number_format($c[2], 2, ".", ",")
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "</tr>";
					        $saldo = $row[3];

					        if ($_POST["T"] == "C") {
					        	if ($myrow[3] == 'C') {
					        		//Cobros
						            $cobro=mysqli_query($enlace, "select c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones, e.Nombre, e.RFC, nb.Nombre, b.NumCuenta, f.FolioFactura, f.FechaEmision, f.Concepto, a.Concepto from cobros as c inner join bancos as b on c.IdBancoEmp=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco inner join facturasaporta as f on c.IdFolioAporta=f.IdFolioAporta inner join empacadora as e on f.IdEmpacadora=e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion=a.IdTipoAportacion where IdCobro= '".$myrow[0]."'");
						            $c=mysqli_fetch_array($cobro);
						            $saldo = $saldo + $c[2];
						            $ingreso = $ingreso + $c[2];
						            echo "<tr bgcolor = '#F3F3F3'>";
						            echo "<td>PRODUCTOR</td>";
						            echo "<td>".$c[11]."</td>";
						            echo "<td>".$c[1]."</td>";
						            echo "<td>".$c[6]."</td>";
						            echo "<td>".$c[7]."</td>";
						            echo "<td>".$c[5]."</td>";
						            echo "<td></td>";
						            echo "<td>".$c[4]."</td>";
						            echo "<td></td>";
						            echo "<td>".number_format($c[2], 2, ".", ",")."</td>";
						            echo "<td>".number_format($saldo, 2, ".", ",")."</td>"; //Saldo
						            echo "<td>".$c[10]."</td>";
						            echo "<td>".$c[8]."</td>";
						            echo "<td>".$c[9]."</td>";
						            echo "<td></td>"; //Subtotal
						            echo "<td></td>"; //IVA
						            echo "<td>".number_format($c[2], 2, ".", ",")."</td>"; //Total
						            echo "<td>".$c[0]."</td>";
						            echo "<td>".$c[3]."</td>";
						            echo "</tr>";
					        	}
					        } else {
					        	if ($myrow[3] == 'P') {
					        		//Pagos
						            $pago=mysqli_query($enlace, "select A.Concepto, P.FechaPago, nb.Nombre, b.NumCuenta, Pr.RFC, F.Autorizada, Pr.Nombre, P.Monto, F.Concepto, F.Factura, F.FechaFactura, P.Referencias, P.Observaciones from pagos as P inner join facturasgastos as F on P.IdFolioGasto=F.IdFolioGasto inner join areas as A on F.IdArea=A.IdArea inner join proveedores as Pr on P.IdProveedor=Pr.IdProveedor inner join bancos as b on P.IdBanco=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where IdPago = '".$myrow[0]."'");
						            $p=mysqli_fetch_array($pago);
						            $saldo = $saldo - $p[7];
						            $egreso = $egreso + $p[7];
						            echo "<tr bgcolor = '#F3F3F3'>";
						            echo "<td>PROVEEDOR</td>";
						            echo "<td>".$p[0]."</td>";
						            echo "<td>".$p[1]."</td>";
						            echo "<td>".$p[2]."</td>";
						            echo "<td>".$p[3]."</td>";
						            echo "<td>".$p[4]."</td>";
						            echo "<td>".$p[5]."</td>";
						            echo "<td>".$p[6]."</td>";
						            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";//Monto
						            echo "<td></td>";
						            echo "<td>".number_format($saldo, 2, ".", ",")."</td>";//Saldo
						            echo "<td>".$p[8]."</td>";
						            echo "<td>".$p[9]."</td>";
						            echo "<td>".$p[10]."</td>";
						            echo "<td></td>";
						            echo "<td></td>";
						            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";
						            echo "<td>".$p[11]."</td>";
						            echo "<td>".$p[12]."</td>";
						            echo "</tr>";
					        	}
					        }
						} else {
							if ($_POST["T"] == "C") {
								if ($myrow[3] == 'C') {
									//Cobros
						            $cobro=mysqli_query($enlace, "select c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones, e.Nombre, e.RFC, nb.Nombre, b.NumCuenta, f.FolioFactura, f.FechaEmision, f.Concepto, a.Concepto from cobros as c inner join bancos as b on c.IdBancoEmp=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco inner join facturasaporta as f on c.IdFolioAporta=f.IdFolioAporta inner join empacadora as e on f.IdEmpacadora=e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion=a.IdTipoAportacion where IdCobro= '".$myrow[0]."'");
						            $c=mysqli_fetch_array($cobro);
						            $saldo = $saldo + $c[2];
						            $ingreso = $ingreso + $c[2];
						            echo "<tr bgcolor = '#F3F3F3'>";
						            echo "<td>PRODUCTOR</td>";
						            echo "<td>".$c[11]."</td>";
						            echo "<td>".$c[1]."</td>";
						            echo "<td>".$c[6]."</td>";
						            echo "<td>".$c[7]."</td>";
						            echo "<td>".$c[5]."</td>";
						            echo "<td></td>";
						            echo "<td>".$c[4]."</td>";
						            echo "<td></td>";
						            echo "<td>".number_format($c[2], 2, ".", ",")."</td>";
						            echo "<td>".number_format($saldo, 2, ".", ",")."</td>"; //Saldo
						            echo "<td>".$c[10]."</td>";
						            echo "<td>".$c[8]."</td>";
						            echo "<td>".$c[9]."</td>";
						            echo "<td></td>"; //Subtotal
						            echo "<td></td>"; //IVA
						            echo "<td>".number_format($c[2], 2, ".", ",")."</td>"; //Total
						            echo "<td>".$c[0]."</td>";
						            echo "<td>".$c[3]."</td>";
						            echo "</tr>";
								}
							} else {
								if ($myrow[3] == 'P') {
									//Pagos
						            $pago=mysqli_query($enlace, "select A.Concepto, P.FechaPago, nb.Nombre, b.NumCuenta, Pr.RFC, F.Autorizada, Pr.Nombre, P.Monto, F.Concepto, F.Factura, F.FechaFactura, P.Referencias, P.Observaciones from pagos as P inner join facturasgastos as F on P.IdFolioGasto=F.IdFolioGasto inner join areas as A on F.IdArea=A.IdArea inner join proveedores as Pr on P.IdProveedor=Pr.IdProveedor inner join bancos as b on P.IdBanco=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where IdPago = '".$myrow[0]."'");
						            $p=mysqli_fetch_array($pago);
						            $saldo = $saldo - $p[7];
						            $egreso = $egreso + $p[7];
						            echo "<tr bgcolor = '#F3F3F3'>";
						            echo "<td>PROVEEDOR</td>";
						            echo "<td>".$p[0]."</td>";
						            echo "<td>".$p[1]."</td>";
						            echo "<td>".$p[2]."</td>";
						            echo "<td>".$p[3]."</td>";
						            echo "<td>".$p[4]."</td>";
						            echo "<td>".$p[5]."</td>";
						            echo "<td>".$p[6]."</td>";
						            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";//Monto
						            echo "<td></td>";
						            echo "<td>".number_format($saldo, 2, ".", ",")."</td>";//Saldo
						            echo "<td>".$p[8]."</td>";
						            echo "<td>".$p[9]."</td>";
						            echo "<td>".$p[10]."</td>";
						            echo "<td></td>";
						            echo "<td></td>";
						            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";
						            echo "<td>".$p[11]."</td>";
						            echo "<td>".$p[12]."</td>";
						            echo "</tr>";
								}
							}
						}
					}
    			//Sin período y sin tipo
    			} else {
    				//Consultar la tabla aux
					$r=mysqli_query($enlace, "select IdFactura, IdBanco, Fecha, Tipo from aux order by IdBanco");
					while ($myrow=mysqli_fetch_array($r)) {
						if ($banco != $myrow[1]) {
							//Asignar banco
					        $banco = $myrow[1];
					        $b=mysqli_query($enlace, "select nb.Nombre, b.NumCuenta, b.Fecha, b.Saldo from bancos as b inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where b.IdBanco = '".$banco."'");
					        $row=mysqli_fetch_array($b);
					        echo "<tr bgcolor = '#F2E778'>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td>".$row[0]."</td>"; //Banco
					        echo "<td>".$row[1]."</td>";
					        echo "<td></td>";
					        echo "<td>".$row[2]."</td>";
					        echo "<td>SALDO INICIAL</td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td>".number_format($row[3], 2, ".", ",")."</td>"; //number_format($c[2], 2, ".", ",")
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "<td></td>";
					        echo "</tr>";
					        $saldo = $row[3];

					        //Cobros y pagos
				        	if ($myrow[3] == 'C') {
				        		//Cobros
					            $cobro=mysqli_query($enlace, "select c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones, e.Nombre, e.RFC, nb.Nombre, b.NumCuenta, f.FolioFactura, f.FechaEmision, f.Concepto, a.Concepto from cobros as c inner join bancos as b on c.IdBancoEmp=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco inner join facturasaporta as f on c.IdFolioAporta=f.IdFolioAporta inner join empacadora as e on f.IdEmpacadora=e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion=a.IdTipoAportacion where IdCobro= '".$myrow[0]."'");
					            $c=mysqli_fetch_array($cobro);
					            $saldo = $saldo + $c[2];
					            $ingreso = $ingreso + $c[2];
					            echo "<tr bgcolor = '#F3F3F3'>";
					            echo "<td>PRODUCTOR</td>";
					            echo "<td>".$c[11]."</td>";
					            echo "<td>".$c[1]."</td>";
					            echo "<td>".$c[6]."</td>";
					            echo "<td>".$c[7]."</td>";
					            echo "<td>".$c[5]."</td>";
					            echo "<td></td>";
					            echo "<td>".$c[4]."</td>";
					            echo "<td></td>";
					            echo "<td>".number_format($c[2], 2, ".", ",")."</td>";
					            echo "<td>".number_format($saldo, 2, ".", ",")."</td>"; //Saldo
					            echo "<td>".$c[10]."</td>";
					            echo "<td>".$c[8]."</td>";
					            echo "<td>".$c[9]."</td>";
					            echo "<td></td>"; //Subtotal
					            echo "<td></td>"; //IVA
					            echo "<td>".number_format($c[2], 2, ".", ",")."</td>"; //Total
					            echo "<td>".$c[0]."</td>";
					            echo "<td>".$c[3]."</td>";
					            echo "</tr>";
				        	} else {
				        		//Pagos
					            $pago=mysqli_query($enlace, "select A.Concepto, P.FechaPago, nb.Nombre, b.NumCuenta, Pr.RFC, F.Autorizada, Pr.Nombre, P.Monto, F.Concepto, F.Factura, F.FechaFactura, P.Referencias, P.Observaciones from pagos as P inner join facturasgastos as F on P.IdFolioGasto=F.IdFolioGasto inner join areas as A on F.IdArea=A.IdArea inner join proveedores as Pr on P.IdProveedor=Pr.IdProveedor inner join bancos as b on P.IdBanco=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where IdPago = '".$myrow[0]."'");
					            $p=mysqli_fetch_array($pago);
					            $saldo = $saldo - $p[7];
					            $egreso = $egreso + $p[7];
					            echo "<tr bgcolor = '#F3F3F3'>";
					            echo "<td>PROVEEDOR</td>";
					            echo "<td>".$p[0]."</td>";
					            echo "<td>".$p[1]."</td>";
					            echo "<td>".$p[2]."</td>";
					            echo "<td>".$p[3]."</td>";
					            echo "<td>".$p[4]."</td>";
					            echo "<td>".$p[5]."</td>";
					            echo "<td>".$p[6]."</td>";
					            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";//Monto
					            echo "<td></td>";
					            echo "<td>".number_format($saldo, 2, ".", ",")."</td>";//Saldo
					            echo "<td>".$p[8]."</td>";
					            echo "<td>".$p[9]."</td>";
					            echo "<td>".$p[10]."</td>";
					            echo "<td></td>";
					            echo "<td></td>";
					            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";
					            echo "<td>".$p[11]."</td>";
					            echo "<td>".$p[12]."</td>";
					            echo "</tr>";
				        	}
						} else {
							//Cobros y pagos
				        	if ($myrow[3] == 'C') {
				        		//Cobros
								$cobro=mysqli_query($enlace, "select c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones, e.Nombre, e.RFC, nb.Nombre, b.NumCuenta, f.FolioFactura, f.FechaEmision, f.Concepto, a.Concepto from cobros as c inner join bancos as b on c.IdBancoEmp=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco inner join facturasaporta as f on c.IdFolioAporta=f.IdFolioAporta inner join empacadora as e on f.IdEmpacadora=e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion=a.IdTipoAportacion where IdCobro= '".$myrow[0]."'");
								$c=mysqli_fetch_array($cobro);
								$saldo = $saldo + $c[2];
								$ingreso = $ingreso + $c[2];
					            echo "<tr bgcolor = '#F3F3F3'>";
					            echo "<td>PRODUCTOR</td>";
					            echo "<td>".$c[11]."</td>";
					            echo "<td>".$c[1]."</td>";
					            echo "<td>".$c[6]."</td>";
					            echo "<td>".$c[7]."</td>";
					            echo "<td>".$c[5]."</td>";
					            echo "<td></td>";
					            echo "<td>".$c[4]."</td>";
					            echo "<td></td>";
					            echo "<td>".number_format($c[2], 2, ".", ",")."</td>";
					            echo "<td>".number_format($saldo, 2, ".", ",")."</td>"; //Saldo
					            echo "<td>".$c[10]."</td>";
					            echo "<td>".$c[8]."</td>";
					            echo "<td>".$c[9]."</td>";
					            echo "<td></td>"; //Subtotal
					            echo "<td></td>"; //IVA
					            echo "<td>".number_format($c[2], 2, ".", ",")."</td>"; //Total
					            echo "<td>".$c[0]."</td>";
					            echo "<td>".$c[3]."</td>";
					            echo "</tr>";
				        	} else {
				        		//Pagos
					            $pago=mysqli_query($enlace, "select A.Concepto, P.FechaPago, nb.Nombre, b.NumCuenta, Pr.RFC, F.Autorizada, Pr.Nombre, P.Monto, F.Concepto, F.Factura, F.FechaFactura, P.Referencias, P.Observaciones from pagos as P inner join facturasgastos as F on P.IdFolioGasto=F.IdFolioGasto inner join areas as A on F.IdArea=A.IdArea inner join proveedores as Pr on P.IdProveedor=Pr.IdProveedor inner join bancos as b on P.IdBanco=b.IdBanco inner join nombresbancos as nb on b.IdNombreBanco=nb.IdNombreBanco where IdPago = '".$myrow[0]."'");
					            $p=mysqli_fetch_array($pago);
					            $saldo = $saldo - $p[7];
					            $egreso = $egreso + $p[7];
					            echo "<tr bgcolor = '#F3F3F3'>";
					            echo "<td>PROVEEDOR</td>";
					            echo "<td>".$p[0]."</td>";
					            echo "<td>".$p[1]."</td>";
					            echo "<td>".$p[2]."</td>";
					            echo "<td>".$p[3]."</td>";
					            echo "<td>".$p[4]."</td>";
					            echo "<td>".$p[5]."</td>";
					            echo "<td>".$p[6]."</td>";
					            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";//Monto
					            echo "<td></td>";
					            echo "<td>".number_format($saldo, 2, ".", ",")."</td>";//Saldo
					            echo "<td>".$p[8]."</td>";
					            echo "<td>".$p[9]."</td>";
					            echo "<td>".$p[10]."</td>";
					            echo "<td></td>";
					            echo "<td></td>";
					            echo "<td>".number_format($p[7], 2, ".", ",")."</td>";
					            echo "<td>".$p[11]."</td>";
					            echo "<td>".$p[12]."</td>";
					            echo "</tr>";
				        	}
						}
					}
    			}
    		}
    	}

    	echo "<tr>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th style='text-align: right'>TOTAL: </th>";
	    echo "<th style='text-align: right'>$".number_format($egreso, 2, ".", ",")."</th>";
	    echo "<th style='text-align: right'>$".number_format($ingreso, 2, ".", ",")."</th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";//Subtotal
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "<th></th>";
	    echo "</tr>";
	}
	
	if ($id == 'consultaProveedores'){
	    $arreglo = array();
	    $aux = array();
	    $x = 0;
	    
	    $r=mysqli_query($enlace,"select p.Nombre, p.RFC, p.Pais, p.Estado, p.Ciudad, p.Domicilio, p.CP, nb.Nombre as Banco, b.NumCuenta, b.Clabe, r.Concepto as Regimen, p.Saldo, p.Total, p.IdProveedor from proveedores As p inner join bancos as b on p.IdBanco = b.IdBanco inner join regimen as r on p.IdRegimen = r.IdRegimen inner join nombresbancos as nb on b.IdNombreBanco = nb.IdNombreBanco ORDER BY p.Nombre ASC");
	    
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		
		foreach ($datos as $valores){
		    foreach ($valores as $val) {
		        foreach ($val as $i => $value) {
		            $aux[$i] = $value;
		        }
		        
		        $folio = '"'.$aux["IdProveedor"].'"';
		        $nom = '"'.$aux["Nombre"].'"';
		        
		        //Constancia
		        if (file_exists("archivos/constancia/".$aux["IdProveedor"].".pdf")) {
		            $aux["constanciaPDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrCons(".$folio.");'></INPUT> <br> <br> <INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Subir PDF' TYPE='button' style = 'background-color: #318a3a; color: white;' onClick='folio = ".$folio."; subirConst(".$folio.", ".$nom.");'></INPUT>";
		        } else {
		            $aux["constanciaPDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrCons(".$folio.");' disabled></INPUT>  <br> <br> <INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Subir PDF' TYPE='button' style = 'background-color: #318a3a; color: white;' onClick='folio = ".$folio."; subirConst(".$folio.", ".$nom.");'></INPUT>";
		        }
		        
		        //Estado de cuenta
		        if (file_exists("archivos/cuentas/".$aux["IdProveedor"].".pdf")) {
		            $aux["edoCuentaPDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrEdo(".$folio.");'></INPUT>  <br> <br> <INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Subir PDF' TYPE='button' style = 'background-color: #318a3a; color: white;' onClick='folio = ".$folio."; subirEdo(".$folio.", ".$nom.");'></INPUT>";
		        } else {
		            $aux["edoCuentaPDF"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrEdo(".$folio.");' disabled></INPUT>  <br> <br> <INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Subir PDF' TYPE='button' style = 'background-color: #318a3a; color: white;' onClick='folio = ".$folio."; subirEdo(".$folio.", ".$nom.");'></INPUT>";
		        }
		        
		        $arreglo[$x] = $aux;
	    		$x = $x + 1;
		        
		    }
		}
	
		$datos['data'] = $arreglo;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'saldoProveedores') {
	    $arreglo = array();
	    $aux = array();
	    $x = 0;
	    
	    $r=mysqli_query($enlace,"select Nombre, Total, Saldo from proveedores ORDER BY Nombre ASC");
	    
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		
		foreach ($datos as $valores){
		    foreach ($valores as $val) {
		        foreach ($val as $i => $value) {
		            $aux[$i] = $value;
		        }
		        $arreglo[$x] = $aux;
	    		$x = $x + 1;
		    }
		}
	
		$datos['data'] = $arreglo;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'expGastos'){
		$datos [] = json_decode($_POST["datos"]);
		$cadena = "";
		
		$filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);
		
		$archivo = fopen('php://output', 'w');

		fputs($archivo, 'Factura,Proveedor,Área,Fecha,Solicitud,Autorizada,Cantidad,Concepto,Estatus,Autoriza,Mes Pago,Saldo,Observaciones,Cancelación,Motivo,Anotaciones'.PHP_EOL);

		foreach($datos as $gasto) {
			foreach($gasto as $valor) {
				$x = 0;
		    	foreach($valor as $val) {
		    		if ($x <= 16){
		    		    if ($x == 13){
			    			$x = $x + 1;
			    		} else {
			    		    $val = str_replace(",", ".", $val);
			    		    
			    		    $cadena = $cadena.$val.',';
			    		    $x = $x + 1;
			    		}
		    		}
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
		fclose($archivo); 
	}
	
	if ($id == 'impPuesto') {
		$r=mysqli_query($enlace,"select * from puestos ORDER BY Puesto ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) { 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
	
	if ($id == 'impAutorizador') {
		$r=mysqli_query($enlace,"select * from autoriza ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) { 
			echo "<option value='".$myrow[0]."'>".$myrow[2]."</option>";
		}
	}
	
	if ($id == 'autorizadorInfo') {
		$r=mysqli_query($enlace,"select P.IdPuesto, A.Activo from autoriza as A inner join puestos as P on A.IdPuesto = P.IdPuesto where IdAutoriza =  '".$_POST["idAutoriza"]."'"); 
		$datos = array();
		$resultado = $r->fetch_assoc();
		$datos['status'] = 'ok';
        $datos['result'] = $resultado;
		echo json_encode($datos);	
	}
	
	if ($id == 'expGastosP'){
		$datos [] = json_decode($_POST["datos"]);
		$cadena = "";
		
		$filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);
		
		$archivo = fopen('php://output', 'w');

		fputs($archivo, 'Factura,Proveedor,Área,Fecha,Solicitud,Cantidad,Concepto,Estatus,Autoriza,Mes Pago,Saldo,Observaciones'.PHP_EOL);

		foreach($datos as $gasto) {
			foreach($gasto as $valor) {
				$x = 0;
		    	foreach($valor as $val) {
		    		if ($x <= 11){
		    		    /*if ($x == 12){
			    			$x = $x + 1;
			    		} else {*/
			    		    $val = str_replace(",", ".", $val);
			    		    
			    		    $cadena = $cadena.$val.',';
			    		    $x = $x + 1;
			    		//}
		    		}
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
		fclose($archivo); 
	}
	
	if ($id == 'expGastosA'){
		$datos [] = json_decode($_POST["datos"]);
		$cadena = "";
		
		$filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);
		
		$archivo = fopen('php://output', 'w');

		fputs($archivo, 'Factura,Proveedor,Área,Fecha,Solicitud,Autorizada,Cantidad,Concepto,Estatus,Autoriza,Mes Pago,Saldo,Observaciones'.PHP_EOL);

		foreach($datos as $gasto) {
			foreach($gasto as $valor) {
				$x = 0;
		    	foreach($valor as $val) {
		    		if ($x <= 12){
		    		    /*if ($x == 12){
			    			$x = $x + 1;
			    		} else {*/
			    		    $val = str_replace(",", ".", $val);
			    		    
			    		    $cadena = $cadena.$val.',';
			    		    $x = $x + 1;
			    		//}
		    		}
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
		fclose($archivo); 
	}
	
	if ($id == 'expPagos'){
		$datos [] = json_decode($_POST["datos"]);
		$cadena = "";
		
		$filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);
		
		$archivo = fopen('php://output', 'w');

		fputs($archivo, 'Factura,Proveedor,Banco,N° Cuenta,CLABE,FechaFactura,Solicitud,Autorizada,Referencia,FechaPago,ModoPago,Cantidad,Observaciones'.PHP_EOL);

		foreach($datos as $gasto) {
			foreach($gasto as $valor) {
				$x = 0;
		    	foreach($valor as $val) {
		    		if ($x <= 13){
		    		    if ($x == 13){
			    			$x = $x + 1;
			    		} else {
			    		    $val = str_replace(",", ".", $val);
			    		    
			    		    $cadena = $cadena.$val.',';
			    		    $x = $x + 1;
			    		}
		    		}
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
		fclose($archivo); 
	}
	
	if ($id == 'expEdoCuentaP'){
		$datos [] = json_decode($_POST["datos"]);
		$cadena = "";
		
		$filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);
		
		$archivo = fopen('php://output', 'w');

		fputs($archivo, 'TIPO,REFERENCIA,FECHA,CONCEPTO,MODO PAGO,CARGOS,ABONOS,SALDO,OBSERVACIONES'.PHP_EOL);

        foreach($datos as $mov) {
			foreach($mov as $valor) {
		    	foreach((array)$valor as $val) {
			    	$val = str_replace(",", ".", $val);
			    	$cadena = $cadena.$val.',';
			    }
			    fputs($archivo, $cadena.PHP_EOL);
			    $cadena = "";
			}
			fputs($archivo, $cadena.PHP_EOL);
			$cadena = "";
				
		}
		fclose($archivo); 
	}
	
	if ($id == 'expEdoCuenta') {
	    $datos [] = (array) json_decode($_POST["datos"]);
		$cadena = "";
		
		$filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);
		
		$archivo = fopen('php://output', 'w');

		fputs($archivo, 'TIPO,RUBRO,FECHA,BANCO,CUENTA,RFC,AUTORIZACIÓN,DESCRIPCIÓN,EGRESO,INGRESO,SALDO,DETALLE,FACTURA,FECHAFACTURA,SUBTOTAL,IVA,TOTAL,REFERENCIAS,OBSERVACIONES'.PHP_EOL);

        foreach($datos as $mov) {
            
			foreach($mov as $valor) {
		    	foreach((array)$valor as $val) {
			    	$val = str_replace(",", ".", $val);
			    	$cadena = $cadena.$val.',';
			    }
			    fputs($archivo, $cadena.PHP_EOL);
			    $cadena = "";
			}
			fputs($archivo, $cadena.PHP_EOL);
			$cadena = "";
				
		}
		fclose($archivo); 
	}

	if ($id == 'impAñosT') {
		$r=mysqli_query($enlace,"select year(Fecha) from certificados ORDER BY Fecha ASC LIMIT 1"); 
		$myrow=mysqli_fetch_array($r);
		$anioI = intval(@$myrow[0]);

		$r=mysqli_query($enlace,"select year(Fecha) from certificados ORDER BY Fecha DESC LIMIT 1"); 
		$myrow=mysqli_fetch_array($r);
		$anioF = intval(@$myrow[0]);
		
		/////////////////////////////////////////////// facturas aporta ////////////////////////////////////

		$r=mysqli_query($enlace,"select year(FechaEmision) from facturasaporta where Estatus = 'Pagada' ORDER BY FechaEmision ASC LIMIT 1"); 
		$myrow=mysqli_fetch_array($r);
		$anioIAux = intval(@$myrow[0]);

		$r=mysqli_query($enlace,"select year(FechaEmision) from facturasaporta where Estatus = 'Pagada' ORDER BY FechaEmision DESC LIMIT 1"); 
		$myrow=mysqli_fetch_array($r);
		$anioFAux = intval(@$myrow[0]);
		
		if (($anioIAux < $anioI && $anioIAux != 0) || $anioI == 0){
		    $anioI = $anioIAux;
		}
		
		if ($anioFAux > $anioF){
		    $anioF = $anioFAux;
		}
		
		////////////////////////////////////////////// cobros //////////////////////////////////////////

		$r=mysqli_query($enlace,"select year(c.FechaCobro) from cobros as c inner join facturasaporta as f on c.IdFolioAporta = f.IdFolioAporta where f.Estatus = 'Pagada' ORDER BY c.FechaCobro ASC LIMIT 1"); 
		$myrow=mysqli_fetch_array($r);
		$anioIAux = intval(@$myrow[0]);

		$r=mysqli_query($enlace,"select year(c.FechaCobro) from cobros as c inner join facturasaporta as f on c.IdFolioAporta = f.IdFolioAporta where f.Estatus = 'Pagada' ORDER BY c.FechaCobro DESC LIMIT 1"); 
		$myrow=mysqli_fetch_array($r);
		$anioFAux = intval(@$myrow[0]);
		
		if (($anioIAux < $anioI && $anioIAux != 0) || $anioI == 0){
		    $anioI = $anioIAux;
		}
		
		if ($anioFAux > $anioF){
		    $anioF = $anioFAux;
		}

		/////////////////////////////////////////// facturas gastos //////////////////////////////////////

		$r=mysqli_query($enlace,"select year(FechaFactura) from facturasgastos where Estatus = 'Pagada' ORDER BY FechaFactura ASC LIMIT 1"); 
		$myrow=mysqli_fetch_array($r);
		$anioIAux = intval(@$myrow[0]);

		$r=mysqli_query($enlace,"select year(FechaFactura) from facturasgastos where Estatus = 'Pagada' ORDER BY FechaFactura DESC LIMIT 1"); 
		$myrow=mysqli_fetch_array($r);
		$anioFAux = intval(@$myrow[0]);
		
		if (($anioIAux < $anioI && $anioIAux != 0) || $anioI == 0){
		    $anioI = $anioIAux;
		}
		
		if ($anioFAux > $anioF){
		    $anioF = $anioFAux;
		}

		////////////////////////////////////////////// pagos ///////////////////////////////////////////////
		
		$r=mysqli_query($enlace,"select year(p.FechaPago) from pagos as p inner join facturasgastos as g on p.IdFolioGasto = g.IdFolioGasto where g.Estatus = 'Pagada' ORDER BY p.FechaPago ASC LIMIT 1"); 
		$myrow=mysqli_fetch_array($r);
		$anioIAux = intval(@$myrow[0]);

		$r=mysqli_query($enlace,"select year(p.FechaPago) from pagos as p inner join facturasgastos as g on p.IdFolioGasto = g.IdFolioGasto where g.Estatus = 'Pagada' ORDER BY p.FechaPago DESC LIMIT 1"); 
		$myrow=mysqli_fetch_array($r);
		$anioFAux = intval(@$myrow[0]);
		
		if (($anioIAux < $anioI && $anioIAux != 0) || $anioI == 0){
		    $anioI = $anioIAux;
		}
		
		if ($anioFAux > $anioF){
		    $anioF = $anioFAux;
		}

		/////////////////////////////////////////////// html /////////////////////////////////////////////

		echo "<option value='' selected>...</option>";
		if($anioI != $anioF){
			while ($anioI != ($anioF + 1)) { 
				echo "<option value='".$anioI."'>".$anioI."</option>";
				$anioI = $anioI + 1;
			}
		} else{
			if($anioI != 0){
				echo "<option value='".$anioI."'>".$anioI."</option>";
			}
		}
	}
	
	if ($id == 'conFactAporta') {
		$arreglo = array();
		$aux = array();
		$x = 0;
		$pdf = '"pdf"';
		$xml = '"xml"';
		$e = '"e"';
		$p = '"p"';
		if ($_POST["fechaI"] != "" && $_POST["fechaF"] != ""){
	     	$r=mysqli_query($enlace,"select e.IdEmpacadora, f.FolioFactura, e.Nombre as Empacadora, date_format(f.FechaEmision, '%Y/%m/%d') as FechaEmision, f.Estatus, format(f.SubTotal, 2) as SubTotal, format(f.Iva, 2) as Iva, format(f.Total, 2) as Total, format(f.Saldo, 2) as Saldo, a.Concepto as Aportacion, f.Concepto from facturasaporta As f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion = a.IdTipoAportacion where f.FechaEmision BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' ORDER BY f.FechaEmision DESC"); 
	    } else{
	     	$r=mysqli_query($enlace,"select e.IdEmpacadora, f.FolioFactura, e.Nombre as Empacadora, date_format(f.FechaEmision, '%Y/%m/%d') as FechaEmision, f.Estatus, format(f.SubTotal, 2) as SubTotal, format(f.Iva, 2) as Iva, format(f.Total, 2) as Total, format(f.Saldo, 2) as Saldo, a.Concepto as Aportacion, f.Concepto from facturasaporta As f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join tipoaportacion as a on f.IdTipoAportacion = a.IdTipoAportacion ORDER BY f.FechaEmision DESC"); 
	    }
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;

		/////////////////////////////////////////////// Imprime datos de cancelación

		foreach($datos as $valores) {
        	foreach($valores as $val) {
        		foreach($val as $i => $value) {
	    	    	$aux[$i] = $value;
	    		}

	    		$r=mysqli_query($enlace,"select date_format(ca.Fecha, '%Y/%m/%d'), ca.Justificacion from cancelacionaporta as ca inner join facturasaporta as f on f.IdFolioAporta = ca.IdFolioAporta where f.FolioFactura = '".$val["FolioFactura"]."'"); 
	    		$row=mysqli_fetch_array($r);
	    		if (@$row[0] != ""){
	    			$aux["FechaCan"] = $row[0];
	    			$aux["Justificacion"] = $row[1];
	    		} else{
	    			$aux["FechaCan"] = "";
	    			$aux["Justificacion"] = "";
	    		}
				
		        $arreglo[$x] = $aux;
	    		$x = $x + 1;
    	    }
		}

		$datos['data'] = $arreglo;

		////////////////////////////////////// Imprime los botones para abrir archivos y enviar correos /////////////////////

		array_splice($arreglo, 0, count($arreglo));
		array_splice($aux, 0, count($aux));
		$x = 0;
		
		foreach($datos as $valores) {
        	foreach($valores as $val) {
	    	    foreach($val as $i => $value) {
	    	        if ($i != "IdEmpacadora"){
	    	    	    $aux[$i] = $value;
        			} else{
        				$idEmpacadora = '"'.$value.'"';
        			}
	    		}
	    		$bPDF = 1;
	    		$bXML = 1;
	    		$bPendiente = 0;
	    		$folio = '"'.$aux["FolioFactura"].'"';
	    		if (file_exists("FacturasAporta/FacturasPDF/"."e".$aux["FolioFactura"].".pdf")) {
				    $aux["pdf"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrFac(".$pdf.", ".$e.");'></INPUT>";
				} else {
				    if (file_exists("FacturasAporta/FacturasPDF/"."p".$aux["FolioFactura"].".pdf")) {
				        $aux["pdf"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrFac(".$pdf.", ".$p.");'></INPUT>";
				        $bPendiente = 1;
				    } else {
				        $aux["pdf"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1 text-white' VALUE='Subir PDF' TYPE='button' onClick='folio = ".$folio."; subirPDF();' style = 'background-color: #14541b;'></INPUT>";
				        $bPDF = 0;
				    }
				}

				if (file_exists("FacturasAporta/FacturasXML/"."e".$aux["FolioFactura"].".xml")) {
					$aux["xml"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir XML' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrFac(".$xml.", ".$e.");'></INPUT>";
				} else {
				    if (file_exists("FacturasAporta/FacturasXML/"."p".$aux["FolioFactura"].".xml")) {
				        $aux["xml"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir XML' TYPE='button' style = 'background-color: #e9ecef;' onClick='folio = ".$folio."; abrFac(".$xml.", ".$p.");'></INPUT>";
				        $bPendiente = 1;
				    } else{
				        $aux["xml"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1 text-white' VALUE='Subir XML' TYPE='button' onClick='folio = ".$folio."; subirXML();' style = 'background-color: #14541b;'></INPUT>";
				        $bXML = 0;
				    }
				}

				if ($bPDF == 1 && $bXML == 1) {
				    if ($bPendiente == 1){
				        $aux["email"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1 text-white' VALUE='Envíar correo' TYPE='button' style = 'background-color: #60c438;' onClick='folio = ".$folio."; enviarCorreo(".$idEmpacadora.");'></INPUT>";
				    } else{
				        $aux["email"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1 text-white' VALUE='Envíar correo' TYPE='button' style = 'background-color: #000000;' onClick='folio = ".$folio."; enviarCorreo(".$idEmpacadora.");'></INPUT>";
				    }
				} else {
				    $aux["email"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Envíar correo' TYPE='button' style = 'background-color: #e9ecef;' disabled></INPUT>";
				}
	    		$arreglo[$x] = $aux;
	    		$x = $x + 1;
    	    }
		}

		$datos['data'] = $arreglo;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'conCobros') {
		$arreglo = array();
		$aux = array();
		$x = 0;
		$pdf = '"pdf"';
		$xml = '"xml"';
		$e = '"e"';
		$p = '"p"';
		if ($_POST["fechaI"] != "" && $_POST["fechaF"] != ""){
	     	$r=mysqli_query($enlace,"select e.IdEmpacadora, c.NumeroPDD, date_format(c.FechaCobro, '%Y/%m/%d') as FechaCobro, format(c.Monto, 2) as Monto, f.FolioFactura, e.Nombre as Empacadora, f.Estatus, format(f.Total, 2) as Total, format(f.Saldo, 2) as Saldo, t.Concepto as Aportacion, date_format(f.FechaEmision, '%Y/%m/%d') as FechaEmision, be.NumCuenta as NumCuentaEmp, nb.Nombre as BancoAs, b.NumCuenta as NumCuentaAs, c.Observaciones from facturasaporta As f inner join tipoaportacion as t on f.IdTipoAportacion = t.IdTipoAportacion inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join cobros as c on c.IdFolioAporta = f.IdFolioAporta inner join bancos as b on c.IdBancoAs = b.IdBanco inner join nombresbancos as nb on nb.IdNombreBanco = b.IdNombreBanco inner join bancos as be on c.IdBancoEmp = be.IdBanco where c.FechaCobro BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' ORDER BY c.FechaCobro DESC"); 
	    } else{
	     	$r=mysqli_query($enlace,"select e.IdEmpacadora, c.NumeroPDD, date_format(c.FechaCobro, '%Y/%m/%d') as FechaCobro, format(c.Monto, 2) as Monto, f.FolioFactura, e.Nombre as Empacadora, f.Estatus, format(f.Total, 2) as Total, format(f.Saldo, 2) as Saldo, t.Concepto as Aportacion, date_format(f.FechaEmision, '%Y/%m/%d') as FechaEmision, be.NumCuenta as NumCuentaEmp, nb.Nombre as BancoAs, b.NumCuenta as NumCuentaAs, c.Observaciones from facturasaporta As f inner join tipoaportacion as t on f.IdTipoAportacion = t.IdTipoAportacion inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join cobros as c on c.IdFolioAporta = f.IdFolioAporta inner join bancos as b on c.IdBancoAs = b.IdBanco inner join nombresbancos as nb on nb.IdNombreBanco = b.IdNombreBanco inner join bancos as be on c.IdBancoEmp = be.IdBanco"); 
	    }
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		
		///////////////////////////////////// Imprime la cuenta de la empacadora

		foreach($datos as $valores) {
        	foreach($valores as $val) {
        		foreach($val as $i => $value) {
        		    if ($i == 'FechaEmision'){
	    	    	    $aux[$i] = $value;
	    	    	    $r=mysqli_query($enlace,"select nb.Nombre from nombresbancos as nb inner join bancos as b on nb.IdNombreBanco = b.IdNombreBanco inner join cobros as c on c.IdBancoEmp = b.IdBanco where c.NumeroPDD = '".$val["NumeroPDD"]."'");
	                    $myrow=mysqli_fetch_array($r);
	                    $aux["BancoEmp"] = @$myrow[0];
	    	    	} else{
	    	    	    $aux[$i] = $value;
	    	    	}
	    		}
	    		
		        $arreglo[$x] = $aux;
	    		$x = $x + 1;
    	    }
		}

		$datos['data'] = $arreglo;

		////////////////////////////////////// Imprime los botones para abrir archivos y enviar correos /////////////////////
		
		array_splice($arreglo, 0, count($arreglo));
		array_splice($aux, 0, count($aux));
		$x = 0;
		
		foreach($datos as $valores) {
        	foreach($valores as $val) {
	    	    foreach($val as $i => $value) {
	    	    	if ($i != "IdEmpacadora"){
	    	            $aux[$i] = $value;
	    	    	} else{
	    	    		$idEmpacadora = '"'.$value.'"';
	    	    	}
	    		}
	    		$bPDF = 1;
	    		$bXML = 1;
	    		$bPendiente = 0;
	    		$folio = '"'.$aux["FolioFactura"].'"';
	    		$numPDD = '"'.$aux["NumeroPDD"].'"';
				
	    		if (file_exists("Cobros/CobrosPDF/"."e".$aux["NumeroPDD"].".pdf")) {
				    $aux["pdf"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='numeroPDD = ".$numPDD."; abrFac(".$pdf.", ".$e.");'></INPUT>";
				} else {
					if (file_exists("Cobros/CobrosPDF/"."p".$aux["NumeroPDD"].".pdf")) {
				        $aux["pdf"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir PDF' TYPE='button' style = 'background-color: #e9ecef;' onClick='numeroPDD = ".$numPDD."; abrFac(".$pdf.", ".$p.");'></INPUT>";
				        $bPendiente = 1;
				    } else {
				        $aux["pdf"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1 text-white' VALUE='Subir PDF' TYPE='button' onClick='numeroPDD = ".$numPDD."; folio = ".$folio."; subirPDF();' style = 'background-color: #14541b;'></INPUT>";
				        $bPDF = 0;
				    }
				}

				if (file_exists("Cobros/CobrosXML/e".$aux["NumeroPDD"].".xml")) {
					$aux["xml"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir XML' TYPE='button' style = 'background-color: #e9ecef;' onClick='numeroPDD = ".$numPDD."; abrFac(".$xml.", ".$e.");'></INPUT>";
				} else {
					if (file_exists("Cobros/CobrosXML/p".$aux["NumeroPDD"].".xml")) {
					    $aux["xml"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Abrir XML' TYPE='button' style = 'background-color: #e9ecef;' onClick='numeroPDD = ".$numPDD."; abrFac(".$xml.", ".$p.");'></INPUT>";
					    $bPendiente = 1;
				    } else {
				    	$aux["xml"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1 text-white' VALUE='Subir XML' TYPE='button' onClick='numeroPDD = ".$numPDD."; folio = ".$folio."; subirXML();' style = 'background-color: #14541b;'></INPUT>";
				    	$bXML = 0;
				    }
				}
				
				if ($bPDF == 1 && $bXML == 1) {
					if ($bPendiente == 1){
						$aux["email"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1 text-white' VALUE='Envíar correo' TYPE='button' style = 'background-color: #60c438;' onClick='numeroPDD = ".$numPDD."; folio = ".$folio."; enviarCorreo(".$idEmpacadora.");'></INPUT>";
					} else{
						$aux["email"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1 text-white' VALUE='Envíar correo' TYPE='button' style = 'background-color: #000000;' onClick='numeroPDD = ".$numPDD."; folio = ".$folio."; enviarCorreo(".$idEmpacadora.");'></INPUT>";
					} 
				} else {
				    $aux["email"] = "<INPUT class = 'form-control-lg btn col-12 rounded-1' VALUE='Envíar correo' TYPE='button' style = 'background-color: #e9ecef;' disabled></INPUT>";
				}
	    		$arreglo[$x] = $aux;
	    		$x = $x + 1;
    	    }
		}

		$datos['data'] = $arreglo;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'busquedaFacMod') {
		$bandera = 0;
		$r=mysqli_query($enlace,"select * from facturasaporta where FolioFactura = '".$_POST["folioMod"]."'"); 

		while ($myrow=mysqli_fetch_array($r)){ 
			$bandera = 1;
		}
		
		if ($bandera == 1){
			$r=mysqli_query($enlace,"select e.Nombre as Empacadora, f.* from facturasaporta as f inner join empacadora as e on e.IdEmpacadora = f.IdEmpacadora where FolioFactura = '".$_POST["folioMod"]."'"); 
			$datos = array();
			$resultado = $r->fetch_assoc();
			$datos['status'] = 'ok';
	        $datos['result'] = $resultado;
			echo json_encode($datos);
		} else{
		    echo "2";
		}
	}
	
	if ($id == 'conFactAportaCobros') {
		$r=mysqli_query($enlace,"select f.FolioFactura, date_format(f.FechaEmision, '%Y/%m/%d') as FechaEmision, format(f.Total, 2) as Total, format(f.Saldo, 2) as Saldo, t.Concepto as Aportacion, f.Concepto from facturasaporta as f inner join tipoaportacion as t on f.IdTipoAportacion = t.IdTipoAportacion where f.IdEmpacadora = '".$_POST["empacadora"]."' and Estatus = 'Pendiente'"); 
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'obtFacturasCobros') {
		$r=mysqli_query($enlace,"select FolioFactura from facturasaporta where IdEmpacadora = '".$_POST["idEmpacadora"]."' and Estatus = 'Pendiente' ORDER BY FechaEmision ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[0]."</option>";
		}
	}
	
	if ($id == 'rutaFacCobro'){
	    if (file_exists("FacturasAporta/FacturasPDF/e".$_POST["folio"].".pdf")) {
	        echo "../FacturasAporta/FacturasPDF/e".$_POST["folio"].".pdf";
	    }
	    if (file_exists("FacturasAporta/FacturasPDF/p".$_POST["folio"].".pdf")) {
	        echo "../FacturasAporta/FacturasPDF/p".$_POST["folio"].".pdf";
	    }
	}
	
	if ($id == 'conEmpacadoras'){
	    $arreglo = array();
		$aux = array();
		$x = 0;
	    $r=mysqli_query($enlace,"select e.IdEmpacadora, e.Nombre, e.Sader, m.Nombre as Municipio, e.CP, e.Direccion, e.Telefono, e.Correo, e.Facturacion, e.RFC, b.NumCuenta, b.Clabe, format(e.Saldo, 2) as Saldo, e.Activa from empacadora As e inner join bancos as b on e.IdBanco = b.IdBanco inner join municipio As m on e.IdMunicipio = m.IdMunicipio ORDER BY e.Nombre ASC");
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		
		foreach($datos as $valores) {
        	foreach($valores as $val) {
	    	    foreach($val as $i => $value) {
	    	        if ($i == 'Facturacion' || $i == 'Activa'){
	    	            if ($value == '1'){
	    	                $aux[$i] = 'Si';
	    	            } else{
	    	                $aux[$i] = 'No';
	    	            }
	    	        } else{
	    	        	if ($i == 'Clabe'){
	    	        		$aux[$i] = $value;
	    	        		$r=mysqli_query($enlace,"select r.Concepto as Regimen from empacadora As e inner join regimen as r on e.IdRegimen = r.IdRegimen where e.IdEmpacadora = '".$val["IdEmpacadora"]."'");
	    	        		$myrow=mysqli_fetch_array($r);
	                        $aux["Regimen"] = @$myrow[0];
	    	    	    } else{
	    	    	        if ($i == 'RFC'){
	    	    	            $aux[$i] = $value;
	    	    	            $r=mysqli_query($enlace,"select nb.Nombre from nombresbancos as nb inner join bancos as b on nb.IdNombreBanco = b.IdNombreBanco inner join empacadora as e on e.IdBanco = b.IdBanco where e.IdEmpacadora = '".$val["IdEmpacadora"]."'");
	                            $myrow=mysqli_fetch_array($r);
	                            $aux["Banco"] = @$myrow[0];
	    	    	        } else{
	    	    	            if ($i != 'IdEmpacadora'){
	    	    	    		    $aux[$i] = $value;
	    	    	    	    }
	    	    	        }
	    	    	    }
	    	        }
	    		}
		        $arreglo[$x] = $aux;
	    		$x = $x + 1;
    	    }
		}

		$datos['data'] = $arreglo;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'nomEmpacadora') {
		$r=mysqli_query($enlace,"select IdEmpacadora, Nombre from empacadora ORDER BY Nombre ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
	
	if ($id == 'repMesMEB') {
    	$anio = substr($_POST["fecha"], 0 ,4);
	    $mes = substr($_POST["fecha"], 5 ,2);
	    $emp = $_POST["empacadora"];
	    $valores = array();

		$r=mysqli_query($enlace,"select * from pais"); 
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[1] != "México"){
				$kilos = 0.0;
		        $b=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and Unidad = 'Kilogramos' and IdPais = ".$myrow[0]." and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$emp."'"); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($row[0])), 3, '.', "");
		        }
		        $b=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and Unidad = 'Toneladas' and IdPais = ".$myrow[0]." and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$emp."'"); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($row[0])*1000)), 3, '.', "");
		        }
		        if ($kilos != 0){
		            $valores[$myrow[1]] = round($kilos);
		        }
			}
		}
		arsort($valores);

		echo json_encode($valores);
	}

	if ($id == 'repMesEA') {
    	$anio = substr($_POST["fecha"], 0 ,4);
	    $mes = substr($_POST["fecha"], 5 ,2);
	    $emp = $_POST["empacadora"];
	    $valores = array();

		$r=mysqli_query($enlace,"select * from pais"); 
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[1] != "México"){
		        $b=mysqli_query($enlace,"select COUNT(IdCertificado) from certificados where IdPais = ".$myrow[0]." and YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$emp."'"); 
		        $row=mysqli_fetch_array($b);
		        if ($row[0] != 0){
		            $valores[$myrow[1]] = $row[0];
		        }
			}
		}
		arsort($valores);

		echo json_encode($valores);
	}
	
	if ($id == 'cuotas') {
		$r=mysqli_query($enlace,"select Cantidad, Fecha from cuotas ORDER BY Fecha DESC"); 
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<tr>";
			echo "<td align='right'>".number_format($myrow[0], 3, '.', "")."</td>";
			echo "<td align='center'>".$myrow[1]."</td>";
			echo "</tr>";
		}
	}
	
	if ($id == 'conCuotas') {
		$aux = array();
		$resultado = array();
		$total = 0;
		$totalCuotas = 0;
		$anio = substr($_POST["mes"], 0 ,4);
	    $mes = substr($_POST["mes"], 5 ,2);

	    if ($_POST["mes"] == ""){
	        $anio = date("Y");
	        $mes = date("m");
	    }

	    //////////////////////// Cálculo del mes de facturación

	    if ($mes == 12){
	        $anioFactura = $anio + 1;
	        $mesFactura = 1;
	    } else{
	    	$anioFactura = $anio;
	        $mesFactura = $mes + 1;
	    }

	    //////////////////////// Configuración de la busqueda

	    switch ($_POST["filtro"]){
	        case "": $r=mysqli_query($enlace,"select IdEmpacadora, Nombre from empacadora ORDER BY Nombre ASC");
	                 break;
	       
	       case "No": $r=mysqli_query($enlace,"select IdEmpacadora, Nombre from empacadora where Facturacion = '0' ORDER BY Nombre ASC");
	                 break;
	                 
	       case "Si": $r=mysqli_query($enlace,"select IdEmpacadora, Nombre from empacadora where Facturacion = '1' ORDER BY Nombre ASC");
	                 break;
	    }
		
		while ($myrow=mysqli_fetch_array($r)){ 
			/////////////////////////////////// Obtengo kilogramos exportados 

    		$kilogramos = obtKilogramosMen($anio, $mes, $myrow[0]);

    		/////////////////////////////////// Obtengo la cuota del mes

			$cuota = obtCuotaMen($anio, $mes, $myrow[0], $kilogramos);

	        ////////////////////// Obtención de folio factura
	        $b=mysqli_query($enlace,"select f.FolioFactura from facturasaporta as f inner join empacadora as e on f.IdEmpacadora = e.IdEmpacadora inner join tipoaportacion as ta on ta.IdTipoAportacion = f.IdTipoAportacion where YEAR(f.FechaEmision) = ".$anioFactura." and MONTH(f.FechaEmision) = ".$mesFactura." and ta.Concepto = 'Cuota' and (f.Estatus = 'Pagada' or f.Estatus = 'Pendiente') and f.IdEmpacadora = '".$myrow[0]."'");
	        $row=mysqli_fetch_array($b);

	        ///////////////////// Ingreso de valores al arreglo
	        $aux["Empaque"] = $myrow[1];
	        $aux["Cantidad"] = number_format($kilogramos, 2, '.', ",");
	        $aux["Aportacion"] = number_format($cuota["cuota"], 2, '.', ",");
	        $aux["Factura"] = @$row[0];
	        $resultado[] = $aux;
	        $total = number_format(($total + $kilogramos), 2, '.', "");
	        $totalCuotas = number_format(($totalCuotas + $cuota["cuota"]), 2, '.', "");
		}
		
		$aux["Empaque"] = "Total general";
	    $aux["Cantidad"] = number_format($total, 2, '.', ",");
	    $aux["Aportacion"] = number_format($totalCuotas, 2, '.', ",");
	    $aux["Factura"] = "";
	    $resultado[] = $aux;
		$datos['data'] = $resultado;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'expCuotas'){
        $datos [] = json_decode($_POST["datos"]);
        $cadena = "";
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Empaques,'.$_POST["mes"].',Aportación,Factura'.PHP_EOL);

        foreach($datos as $cuotas) {
		    foreach($cuotas as $valor) {
		    	$x = 0;
		    	foreach($valor as $val) {
		    		if ($x == 1 || $x == 2){
		    			$val = str_replace(",", "", $val);
		    		} else{
		    			$val = str_replace(",", ".", $val);
		    		}

		    		$cadena = $cadena.$val.',';
		    		$x = $x + 1;
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
        fclose($archivo);
    }
    
    if ($id == 'impTemporadas') {
    	$r=mysqli_query($enlace,"select Fecha from certificados where Estatus <> 'Cancelado' ORDER BY Fecha ASC LIMIT 1");
	    $myrow=mysqli_fetch_array($r);
	    $anioI = substr($myrow[0], 0 ,4);
	    $mesI = substr($myrow[0], 5 ,2);
	    $r=mysqli_query($enlace,"select Fecha from certificados where Estatus <> 'Cancelado' ORDER BY Fecha DESC LIMIT 1");
	    $myrow=mysqli_fetch_array($r);
	    $anioF = substr($myrow[0], 0 ,4);
	    $mesF = substr($myrow[0], 5 ,2);

	    if ($mesI < 6){
	    	$anioI = $anioI - 1;
	    }

	    if ($mesF > 5){
	    	$anioF = $anioF + 1;
	    }

	    echo "<option value='' selected>...</option>";
	    while (($anioI + 1) <= $anioF){
			echo "<option value='".$anioI." - ".($anioI + 1)."'>".$anioI." - ".($anioI + 1)."</option>";
		    $anioI = $anioI + 1;
		}
	}

	if ($id == 'repTemp') {
    	$anioI = $_POST["anioI"];
	    $anioF = $_POST["anioF"];
	    $meses = array("Jun/".substr($anioI, 2,2), "Jul/".substr($anioI, 2,2), "Ago/".substr($anioI, 2,2), "Sep/".substr($anioI, 2,2), "Oct/".substr($anioI, 2,2), "Nov/".substr($anioI, 2,2), "Dic/".substr($anioI, 2,2), "Ene/".substr($anioF, 2,2), "Feb/".substr($anioF, 2,2), "Mar/".substr($anioF, 2,2), "Abr/".substr($anioF, 2,2), "May/".substr($anioF, 2,2));
	    $fecha = array(6, 7, 8, 9, 10, 11, 12, 1, 2, 3, 4, 5);
	    $a = array();

	    for ($i = 0; $i < 12; $i++){
			$kilos = 0.0;
			if ($i == 7){
				$anioI = $anioF;
			}
	        $r=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional'"); 
	        while ($myrow=mysqli_fetch_array($r)) { 
	            $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($myrow[0])), 3, '.', "");
	        }
	        $r=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".$fecha[$i]." and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo') and Tipo = 'Internacional'"); 
	        while ($myrow=mysqli_fetch_array($r)) { 
	            $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($myrow[0])*1000)), 3, '.', "");
	        }
	        $a[$meses[$i]] = round($kilos);
		}
		echo json_encode($a);
	}
	
	if ($id == 'iniciarSesion'){
	    $r=mysqli_query($enlace,"select IdUsuario from usuarios where Correo = '".$_POST["usuario"]."'"); 
	    $myrow=mysqli_fetch_array($r);
	    if (@$myrow[0] != ""){
	    	$s=mysqli_query($enlace,"select IdUsuario from usuarios where Contrasena = MD5('".$_POST["contraseña"]."') and Correo = '".$_POST["usuario"]."'"); 
	        $row=mysqli_fetch_array($s);
	        if (@$row[0] != ""){
	    		echo 1;
	    	} else{
	    	    echo 2;
	    	}
	    } else{
	    	echo 3;
	    }
	}

	if ($id == 'obtUsuario'){
		$r=mysqli_query($enlace,"select u.IdUsuario, u.Nombre, t.Descripcion from usuarios as u inner join tipousuario as t on u.IdTipoUsuario = t.IdTipoUsuario where u.Correo = '".$_POST["usuario"]."'"); 
	    $datos = array();
		$resultado = $r->fetch_assoc();
		$datos['status'] = 'ok';
		$datos['result'] = $resultado;
		echo json_encode($datos);
	}
	
	if ($id == 'expEmpacadora'){
        $datos [] = json_decode($_POST["datos"]);
        $cadena = "";
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        // fputs($archivo, "\xEF\xBB\xBF");

        fputs($archivo, 'Empacadora,Registro SADER,Municipio,CP,Dirección,Teléfono,Email,Facturación,RFC,Banco,No. Cuenta,Clabe,Régimen,Saldo,Activa'.PHP_EOL);

        foreach($datos as $empacadoras) {
		    foreach($empacadoras as $valor) {
		    	$x = 0;
		    	foreach($valor as $val) {
		    		if ($x == 13){
		    			$val = str_replace(",", "", $val);
		    		} else{
		    			$val = str_replace(",", ".", $val);
		    		}

		    		$cadena = $cadena.$val.',';
		    		$x = $x + 1;
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
        fclose($archivo);
    }
    
    if ($id == 'repHistEmp') {
    	$anioI = $_POST["anioI"];
	    $anioF = $_POST["anioF"];
	    $anios = array();
	    $a = array();

	    while ($anioI <= $anioF){
			for ($i = 0; $i < 12; $i++){
				$kilos = 0.0;
		        $r=mysqli_query($enlace,'select c.Cantidad from certificados as c inner join empacadora as e on e.IdEmpacadora = c.IdEmpacadora where YEAR(c.Fecha) = '.$anioI.' and MONTH(c.Fecha) = '.($i + 1).' and c.Unidad = "Kilogramos" and (c.Estatus = "Original" or c.Estatus = "Reemplazo") and e.Nombre = "'.$_POST["empacadora"].'"'); 
		        while ($myrow=mysqli_fetch_array($r)) { 
		            $kilos = $kilos + doubleval($myrow[0]);
		        }
		        $r=mysqli_query($enlace,'select c.Cantidad from certificados as c inner join empacadora as e on e.IdEmpacadora = c.IdEmpacadora where YEAR(c.Fecha) = '.$anioI.' and MONTH(c.Fecha) = '.($i + 1).' and c.Unidad = "Toneladas" and (c.Estatus = "Original" or c.Estatus = "Reemplazo") and e.Nombre = "'.$_POST["empacadora"].'"'); 
		        while ($myrow=mysqli_fetch_array($r)) { 
		            $kilos = $kilos + (doubleval($myrow[0])*1000);
		        }
		        $a[$i] = $kilos;

			}
			$anios[$anioI] = $a;
		    $anioI = $anioI + 1;
		}
		echo json_encode($anios);
	}

	if ($id == 'repHistGen') {
    	$r=mysqli_query($enlace,"select Year(Fecha) from certificados ORDER BY Fecha ASC LIMIT 1");
	    $myrow=mysqli_fetch_array($r);
	    $anioI = $myrow[0];

	    $r=mysqli_query($enlace,"select Year(Fecha) from certificados ORDER BY Fecha DESC LIMIT 1");
	    $myrow=mysqli_fetch_array($r);
	    $anioF = $myrow[0];
	    $anios = array();
	    $a = array();

	    while ($anioI <= $anioF){
			for ($i = 0; $i < 12; $i++){
				$kilos = 0.0;
		        $r=mysqli_query($enlace,"select Cantidad from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".($i + 1)." and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($myrow=mysqli_fetch_array($r)) { 
		            $kilos = $kilos + doubleval($myrow[0]);
		        }
		        $r=mysqli_query($enlace,"select Cantidad from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".($i + 1)." and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($myrow=mysqli_fetch_array($r)) { 
		            $kilos = $kilos + (doubleval($myrow[0])*1000);
		        }
		        $a[$i] = $kilos;

			}
			$anios[$anioI] = $a;
		    $anioI = $anioI + 1;
		}
		echo json_encode($anios);
	}
	
	if ($id == 'exportarHist'){
        $cadena = "";
        $total = 0.0;

        if ($_POST["anioI"] != "" && $_POST["anioF"] != ""){
        	$anioI = $_POST["anioI"];
        	$anioF = $_POST["anioF"];
        } else{
        	$r=mysqli_query($enlace,"select year(Fecha) from certificados ORDER BY Fecha ASC LIMIT 1");
		    $myrow=mysqli_fetch_array($r);
		    $anioI = $myrow[0];
		    $r=mysqli_query($enlace,"select year(Fecha) from certificados ORDER BY Fecha DESC LIMIT 1");
		    $myrow=mysqli_fetch_array($r);
		    $anioF = $myrow[0];
        }
        
        if ($anioI == $anioF){
		    $titulo = 'Kilogramos exportados en el '.$anioI.".";
		} else{
		    $titulo = 'Kilogramos exportados de '.$anioI.' a '.$anioF.'.';
		}
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);
        $archivo = fopen('php://output', 'w');
        
        fputs($archivo, $titulo.PHP_EOL);
        fputs($archivo, 'Año,Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Septiembre,Octubre,Noviembre,Diciembre,Total Kg'.PHP_EOL);

	    while ($anioI <= $anioF){
	    	$cadena = $anioI.",";
	    	$total = 0.0;
			for ($i = 0; $i < 12; $i++){
				$kilos = 0.0;
		        $r=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".($i + 1)." and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($myrow=mysqli_fetch_array($r)) { 
		            $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($myrow[0])), 3, '.', "");
		        }
		        $r=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anioI." and MONTH(Fecha) = ".($i + 1)." and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($myrow=mysqli_fetch_array($r)) { 
		            $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($myrow[0])*1000)), 3, '.', "");
		        }
		        $cadena = $cadena.number_format($kilos, 2, '.', "").",";
		        $total = number_format((number_format($total, 3, '.', "") + $kilos), 3, '.', "");
			}
			$cadena = $cadena.number_format($total, 2, '.', "");
			fputs($archivo,  $cadena.PHP_EOL);
		    $anioI = $anioI + 1;
		}
		fclose($archivo);
    }
    
    if ($id == 'exportarEstMen'){
        $cadena = "";
        $total = 0.0;
        $anio = substr($_POST["fecha"], 0 ,4);
	    $mes = substr($_POST["fecha"], 5 ,2);
	    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        ////////////////////////////////////// Kilogramos ///////////////////////////////////////////

        fputs($archivo, 'Kilogramos exportados en el mes de '.$meses[$mes-1].' del año '.$anio.PHP_EOL);

        $r=mysqli_query($enlace,"select * from pais"); 
        while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[1] != "México"){
				$kilos = 0.0;
		        $b=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and Unidad = 'Kilogramos' and IdPais = ".$myrow[0]." and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($row[0])), 3, '.', "");
		        }
		        $b=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and Unidad = 'Toneladas' and IdPais = ".$myrow[0]." and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($row[0])*1000)), 3, '.', "");
		        }
		        $valores[$myrow[1]] = $kilos;
			}
		}
		arsort($valores);
		
		$cadena = "País,";
		foreach($valores as $clave => $valor) {
			if ($valor != 0){
				$cadena = $cadena.str_replace(",", ".", $clave).",";
			}
		}
		fputs($archivo, $cadena."Total".PHP_EOL);

		$cadena = "Kilogramos exportados,";
		foreach($valores as $clave => $valor) {
			if ($valor != 0){
				$total = number_format((number_format($total, 3, '.', "") + $valor), 3, '.', "");
				$cadena = $cadena.number_format($valor, 2, '.', "").",";
			}
		}
		fputs($archivo, $cadena.number_format($total, 2, '.', "").PHP_EOL);

		////////////////////////////////////////// Embarques //////////////////////////////////////////
		
		fputs($archivo, ' '.PHP_EOL);
		fputs($archivo, 'Embarques exportados en el mes de '.$meses[$mes-1].' del año '.$anio.PHP_EOL);

		$r=mysqli_query($enlace,"select * from pais"); 
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[1] != "México"){
		        $b=mysqli_query($enlace,"select COUNT(IdCertificado) from certificados where IdPais = ".$myrow[0]." and YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        $row=mysqli_fetch_array($b);
		        $valores[$myrow[1]] = $row[0];
			}
		}
		arsort($valores);

		$cadena = "País,";
		foreach($valores as $clave => $valor) {
			if ($valor != 0){
				$cadena = $cadena.str_replace(",", ".", $clave).",";
			}
		}
		fputs($archivo, $cadena."Total".PHP_EOL);

		$cadena = "Embarques exportados,";
		$total = 0.0;
		foreach($valores as $clave => $valor) {
			if ($valor != 0){
				$total = $total + $valor;
				$cadena = $cadena.$valor.",";
			}
		}
		fputs($archivo, $cadena.$total.PHP_EOL);
		fclose($archivo);
    }
    
    if ($id == 'exportarEstMenEmp'){
        $cadena = "";
        $total = 0.0;
        $anio = substr($_POST["fecha"], 0 ,4);
	    $mes = substr($_POST["fecha"], 5 ,2);
	    $emp = $_POST["empacadora"];
	    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	    $r=mysqli_query($enlace,"select Nombre from empacadora ORDER BY Nombre ASC"); 
		$myrow=mysqli_fetch_array($r);
		$nombreEmp = $myrow[0];
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        ////////////////////////////////////// Kilogramos ///////////////////////////////////////////

        fputs($archivo, 'Kilogramos exportados por el empaque '.str_replace(",", ".", $nombreEmp).' en el mes de '.$meses[$mes-1].' del año '.$anio.PHP_EOL);

        $r=mysqli_query($enlace,"select * from pais"); 
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[1] != "México"){
				$kilos = 0.0;
		        $b=mysqli_query($enlace,"select ROUND(Cantidad, 3) from certificados where YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and Unidad = 'Kilogramos' and IdPais = ".$myrow[0]." and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$emp."'"); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = number_format((number_format($kilos, 3, '.', "") + doubleval($row[0])), 3, '.', "");
		        }
		        $b=mysqli_query($enlace,"select ROUND(Cantidad, 4) from certificados where YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and Unidad = 'Toneladas' and IdPais = ".$myrow[0]." and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$emp."'"); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = number_format((number_format($kilos, 3, '.', "") + (doubleval($row[0])*1000)), 3, '.', "");
		        }
		        if ($kilos != 0){
		            $valores[$myrow[1]] = $kilos;
		        }
			}
		}
		arsort($valores);
		
		$cadena = "País,";
		foreach($valores as $clave => $valor) {
			if ($valor != 0){
				$cadena = $cadena.str_replace(",", ".", $clave).",";
			}
		}
		fputs($archivo, $cadena."Total".PHP_EOL);

		$cadena = "Kilogramos exportados,";
		foreach($valores as $clave => $valor) {
			if ($valor != 0){
				$total = number_format((number_format($total, 3, '.', "") + $valor), 3, '.', "");
				$cadena = $cadena.number_format($valor, 2, '.', "").",";
			}
		}
		fputs($archivo, $cadena.number_format($total, 2, '.', "").PHP_EOL);

		////////////////////////////////////////// Embarques //////////////////////////////////////////
		
		fputs($archivo, ' '.PHP_EOL);
		fputs($archivo, 'Embarques exportados por el empaque '.str_replace(",", ".", $nombreEmp).' en el mes de '.$meses[$mes-1].' del año '.$anio.PHP_EOL);

		$r=mysqli_query($enlace,"select * from pais"); 
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[1] != "México"){
		        $b=mysqli_query($enlace,"select COUNT(IdCertificado) from certificados where IdPais = ".$myrow[0]." and YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$emp."'"); 
		        $row=mysqli_fetch_array($b);
		        if ($row[0] != 0){
		            $valores[$myrow[1]] = $row[0];
		        }
			}
		}
		arsort($valores);

		$cadena = "País,";
		foreach($valores as $clave => $valor) {
			if ($valor != 0){
				$cadena = $cadena.str_replace(",", ".", $clave).",";
			}
		}
		fputs($archivo, $cadena."Total".PHP_EOL);

		$cadena = "Embarques exportados,";
		$total = 0.0;
		foreach($valores as $clave => $valor) {
			if ($valor != 0){
				$total = $total + $valor;
				$cadena = $cadena.$valor.",";
			}
		}
		fputs($archivo, $cadena.$total.PHP_EOL);
		fclose($archivo);
    }
    
    if ($id == 'exportarEstTemp'){
        $cadena = "";
        $total = 0.0;
        $meses = array("Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic", "Ene", "Feb", "Mar", "Abr", "May");
	    $fecha = array(6, 7, 8, 9, 10, 11, 12, 1, 2, 3, 4, 5);
	    $temI = $_POST["temI"];
        $temF = $_POST["temF"];
        $paises = array();

        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        ////////////////////////////////////// Temp 1 ///////////////////////////////////////////

        fputs($archivo, 'Temporada '.$temI.PHP_EOL);
        $cadena = "Destino,";
        $anioI = substr($temI, 2,2);
        $anioF = substr($temI, 9,2);

        for ($i = 0; $i < 12; $i++){
        	if ($i == 7){
                $anioI = $anioF;
            }
        	$cadena = $cadena.$meses[$i]."/".$anioI.",";
        }
        fputs($archivo, $cadena."Total".PHP_EOL);

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
	                $total = number_format((number_format($total, 3, '.', "") + $kilos), 3, '.', "");
	            }

	            if ($total != 0){
	                $paises[] = $myrow[1];
	            }
	        }
	    }
	    
	    asort($paises);

	    foreach($paises as $val){
	    	$cadena = str_replace(",", ".", $val).",";
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
                $total = number_format((number_format($total, 3, '.', "") + $kilos), 3, '.', "");
                $cadena = $cadena.number_format($kilos, 2, '.', "").",";
            }
            fputs($archivo, $cadena.number_format($total, 2, '.', "").PHP_EOL);
	    }

	    array_splice($paises, 0, count($paises));

	    $total = 0.0;
	    $tem1 = array();
	    $tem1[] = $temI;
	    $anioI = substr($temI, 0,4);
	    $anioF = substr($temI, 7,4);
	    $cadena = "Total general,";
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
	        $total = number_format((number_format($total, 3, '.', "") + $kilos), 3, '.', "");
	        $cadena = $cadena.number_format($kilos, 2, '.', "").",";
	        $tem1[] = $kilos;
	    }
	    fputs($archivo, $cadena.number_format($total, 2, '.', "").PHP_EOL);
	    $tem1[] = $total;

		fputs($archivo, " ".PHP_EOL);

		////////////////////////////////////// Temp 2 ///////////////////////////////////////////

        fputs($archivo, 'Temporada '.$temF.PHP_EOL);
        $cadena = "Destino,";
        $anioI = substr($temF, 2,2);
        $anioF = substr($temF, 9,2);

        for ($i = 0; $i < 12; $i++){
        	if ($i == 7){
                $anioI = $anioF;
            }
        	$cadena = $cadena.$meses[$i]."/".$anioI.",";
        }
        fputs($archivo, $cadena."Total".PHP_EOL);

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
	                $total = number_format((number_format($total, 3, '.', "") + $kilos), 3, '.', "");
	            }

	            if ($total != 0){
	                $paises[] = $myrow[1];
	            }
	        }
	    }
	    
	    asort($paises);

	    foreach($paises as $val){
	    	$cadena = str_replace(",", ".", $val).",";
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
                $total = number_format((number_format($total, 3, '.', "") + $kilos), 3, '.', "");
                $cadena = $cadena.number_format($kilos, 2, '.', "").",";
            }
            fputs($archivo, $cadena.number_format($total, 2, '.', "").PHP_EOL);
	    }

	    $total = 0.0;
	    $tem2 = array();
	    $tem2[] = $temF;
	    $anioI = substr($temF, 0,4);
	    $anioF = substr($temF, 7,4);
	    $cadena = "Total general,";
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
	        $total = number_format((number_format($total, 3, '.', "") + $kilos), 3, '.', "");
	        $cadena = $cadena.number_format($kilos, 2, '.', "").",";
	        $tem2[] = $kilos;
	    }
	    fputs($archivo, $cadena.number_format($total, 2, '.', "").PHP_EOL);
	    $tem2[] = $total;

		fputs($archivo, " ".PHP_EOL);

		///////////////////////////////////////////////// temporadas 1 y 2 //////////////////////////////////////////////////////

		fputs($archivo, 'Comparativos de las temporadas '.$temI." y ".$temF.PHP_EOL);

		$cadena = "Temporada,";
		for ($i = 0; $i < 12; $i++){
        	$cadena = $cadena.$meses[$i].",";
        }
        fputs($archivo, $cadena."Total".PHP_EOL);

		$data = array($tem1, $tem2);
	    foreach($data as $row){
	        $cadena = "";
	        $cadena = $cadena.$row[0].",";
	    	for ($i = 1; $i < 14; $i++){
	    		$cadena = $cadena.number_format($row[$i], 2, '.', "").",";
	    	}
	    	fputs($archivo, substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
	    }
		fclose($archivo);
    }
    
    if ($id == 'repCobros'){
	    $arreglo = array();
		$aux = array();
		$x = 0;
		if($_POST["fechaI"] != "" && $_POST["fechaF"] != "" && $_POST["empacadora"] == ""){
	        $r=mysqli_query($enlace,"select f.FolioFactura, e.Nombre as Empacadora, e.RFC, r.Concepto as Regimen, b.Nombre as Banco, b.NumCuenta, b.Clabe, f.FechaEmision, t.Concepto as Aportacion, f.Estatus, f.Subtotal, f.Iva, f.Total, f.Saldo, f.Concepto, c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones from facturasaporta as f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join bancos as b on e.IdBanco = b.IdBanco inner join regimen as r on e.IdRegimen = r.IdRegimen inner join tipoaportacion as t on t.IdTipoAportacion = f.IdTipoAportacion inner join cobros as c on f.IdFolioAporta = c.IdFolioAporta where c.FechaCobro BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."'");
	    } else{
			if ($_POST["fechaI"] != "" && $_POST["fechaF"] != "" && $_POST["empacadora"] != ""){
				$r=mysqli_query($enlace,"select f.FolioFactura, e.Nombre as Empacadora, e.RFC, r.Concepto as Regimen, b.Nombre as Banco, b.NumCuenta, b.Clabe, f.FechaEmision, t.Concepto as Aportacion, f.Estatus, f.Subtotal, f.Iva, f.Total, f.Saldo, f.Concepto, c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones from facturasaporta as f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join bancos as b on e.IdBanco = b.IdBanco inner join regimen as r on e.IdRegimen = r.IdRegimen inner join tipoaportacion as t on t.IdTipoAportacion = f.IdTipoAportacion inner join cobros as c on f.IdFolioAporta = c.IdFolioAporta where c.FechaCobro BETWEEN '".$_POST["fechaI"]."' AND '".$_POST["fechaF"]."' AND e.IdEmpacadora = '".$_POST["empacadora"]."'");
			} else{
				if (($_POST["fechaI"] == "" && $_POST["fechaF"] == "" && $_POST["empacadora"] == "") || ($_POST["fechaI"] != "" && $_POST["fechaF"] == "" && $_POST["empacadora"] == "") || ($_POST["fechaI"] == "" && $_POST["fechaF"] != "" && $_POST["empacadora"] == "")){
					$r=mysqli_query($enlace,"select f.FolioFactura, e.Nombre as Empacadora, e.RFC, r.Concepto as Regimen, b.Nombre as Banco, b.NumCuenta, b.Clabe, f.FechaEmision, t.Concepto as Aportacion, f.Estatus, f.Subtotal, f.Iva, f.Total, f.Saldo, f.Concepto, c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones from facturasaporta as f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join bancos as b on e.IdBanco = b.IdBanco inner join regimen as r on e.IdRegimen = r.IdRegimen inner join tipoaportacion as t on t.IdTipoAportacion = f.IdTipoAportacion inner join cobros as c on f.IdFolioAporta = c.IdFolioAporta");
				} else{
					$r=mysqli_query($enlace,"select f.FolioFactura, e.Nombre as Empacadora, e.RFC, r.Concepto as Regimen, b.Nombre as Banco, b.NumCuenta, b.Clabe, f.FechaEmision, t.Concepto as Aportacion, f.Estatus, f.Subtotal, f.Iva, f.Total, f.Saldo, f.Concepto, c.NumeroPDD, c.FechaCobro, c.Monto, c.Observaciones from facturasaporta as f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join bancos as b on e.IdBanco = b.IdBanco inner join regimen as r on e.IdRegimen = r.IdRegimen inner join tipoaportacion as t on t.IdTipoAportacion = f.IdTipoAportacion inner join cobros as c on f.IdFolioAporta = c.IdFolioAporta where e.IdEmpacadora = '".$_POST["empacadora"]."'");
				}
			}
		}
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'expRepCobros'){
        $datos [] = json_decode($_POST["datos"]);
        $cadena = "";
        $cabecera = json_decode($_POST["cabecera"]);
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');
        
        $x = 0;
        foreach($cabecera as $columna) {
            if ($cabecera[$x] != ""){
                $cadena = $cadena.$columna.',';
            }
            $x = $x+1;
		}
		fputs($archivo, $cadena.PHP_EOL);

		$cadena = "";
        foreach($datos as $cobros) {
		    foreach($cobros as $valor) {
		        $x = 0;
		    	foreach($valor as $val) {
		    		if ($cabecera[$x] != ""){
		    			$cadena = $cadena.$val.',';
		    		}
		    		$x = $x+1;
				}
				fputs($archivo,  $cadena.PHP_EOL);
				$cadena = "";
			}
		}
        fclose($archivo);
    }
    
    if ($id == 'obtEmpacadoraMovil') {
		$r=mysqli_query($enlace,'select e.*, m.Nombre as Municipio, b.NumCuenta, b.Clabe, format(e.Saldo, 2) as SaldoFormato from empacadora As e inner join bancos as b on e.IdBanco = b.IdBanco inner join municipio As m on e.IdMunicipio = m.IdMunicipio where e.Nombre = "'.$_POST["nombre"].'"');
		$resultado = $r->fetch_assoc(); 

		$r=mysqli_query($enlace,"select r.Concepto as Regimen from empacadora As e inner join regimen as r on e.IdRegimen = r.IdRegimen where e.IdEmpacadora = '".$resultado["IdEmpacadora"]."'");
	    $myrow=mysqli_fetch_array($r);
	    if (!isset($myrow[0])){
	        $resultado["Regimen"] = "";
	    } else{
	        $resultado["Regimen"] = $myrow[0];
	    }
	    
	    $r=mysqli_query($enlace,"select nb.Nombre from nombresbancos as nb inner join bancos as b on nb.IdNombreBanco = b.IdNombreBanco inner join empacadora as e on e.IdBanco = b.IdBanco where e.IdEmpacadora = '".$resultado["IdEmpacadora"]."'");
	    $myrow=mysqli_fetch_array($r);
	    $resultado["Banco"] = @$myrow[0];

		$datos = array();
		$datos['status'] = 'ok';
        $datos['result'] = $resultado;
		echo json_encode($datos);
	}
	
	if ($id == 'conProveedores'){
	    $r=mysqli_query($enlace,"select p.Nombre, p.RFC, p.Pais, p.Estado, p.Ciudad, p.Domicilio, p.CP, b.Nombre as Banco, b.NumCuenta, b.Clabe, r.Concepto as Regimen, p.Saldo, p.Total from proveedores As p inner join bancos as b on p.IdBanco = b.IdBanco inner join regimen as r on p.IdRegimen = r.IdRegimen ORDER BY p.Nombre ASC");
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}
	
	if ($id == 'obtProveedorMovil') {
		$r=mysqli_query($enlace,'select p.Nombre, p.RFC, p.Pais, p.Estado, p.Ciudad, p.Domicilio, p.CP, nb.Nombre as Banco, b.NumCuenta, b.Clabe, r.Concepto as Regimen, format(p.Saldo, 2) as Saldo, format(p.Total, 2) as Total, p.IdProveedor from proveedores As p inner join bancos as b on p.IdBanco = b.IdBanco inner join regimen as r on p.IdRegimen = r.IdRegimen inner join nombresbancos as nb on b.IdNombreBanco = nb.IdNombreBanco where p.Nombre = "'.$_POST["nombre"].'"');

		$datos = array();
		$resultado = $r->fetch_assoc();
		$datos['status'] = 'ok';
        $datos['result'] = $resultado;
		echo json_encode($datos);
	}
	
	if ($id == 'impAniosMovil') {
    	$r=mysqli_query($enlace,"select year(Fecha) from certificados ORDER BY Fecha ASC LIMIT 1");
	    $myrow=mysqli_fetch_array($r);
	    $anioI = $myrow[0];
	    $r=mysqli_query($enlace,"select year(Fecha) from certificados ORDER BY Fecha DESC LIMIT 1");
	    $myrow=mysqli_fetch_array($r);
	    $anioF = $myrow[0];
	    $arreglo = array();
	    $x = 0;
	    
	    while ($anioI <= $anioF){
			$arreglo[$x] = strval($anioI);
		    $anioI = $anioI + 1;
		    $x = $x + 1;
		}
		$datos['data'] = $arreglo;
		echo json_encode($datos);
	}
	
	if ($id == 'repMesHisMovil') {
    	$anio = substr($_POST["fecha"], 0 ,4);
	    $mes = substr($_POST["fecha"], 5 ,2);
	    $valores = array();
	    $paises = array();

		$r=mysqli_query($enlace,"select * from pais"); 
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[1] != "México"){
				$kilos = 0.0;
		        $b=mysqli_query($enlace,"select Cantidad from certificados where YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and Unidad = 'Kilogramos' and IdPais = ".$myrow[0]." and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = $kilos + doubleval($row[0]);
		        }
		        $b=mysqli_query($enlace,"select Cantidad from certificados where YEAR(Fecha) = ".$anio." and MONTH(Fecha) = ".$mes." and Unidad = 'Toneladas' and IdPais = ".$myrow[0]." and (Estatus = 'Original' or Estatus = 'Reemplazo')"); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = $kilos + (doubleval($row[0])*1000);
		        }
		        if ($kilos != 0){
		            $valores[$myrow[1]] = $kilos;
		        }
			}
		}
		arsort($valores);
		foreach($valores as $clave => $valor) {
			$paises[] = $clave;
		}
		
		if (count($paises) == 0){
		    $paises[] = "";
		}
		$llave["data"] = $paises;
		echo json_encode($llave);
	}
	
	if ($id == 'repMesEmpMovil') {
    	$anio = substr($_POST["fecha"], 0 ,4);
	    $mes = substr($_POST["fecha"], 5 ,2);
	    $emp = $_POST["empacadora"];
	    $valores = array();

		$r=mysqli_query($enlace,"select * from pais"); 
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[1] != "México"){
				$kilos = 0.0;
		        $b=mysqli_query($enlace,'select c.Cantidad from certificados as c inner join empacadora as e on e.IdEmpacadora = c.IdEmpacadora where YEAR(c.Fecha) = '.$anio.' and MONTH(c.Fecha) = '.$mes.' and c.Unidad = "Kilogramos" and c.IdPais = '.$myrow[0].' and (c.Estatus = "Original" or c.Estatus = "Reemplazo") and e.Nombre = "'.$emp.'"'); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = $kilos + doubleval($row[0]);
		        }
		        $b=mysqli_query($enlace,'select c.Cantidad from certificados as c inner join empacadora as e on e.IdEmpacadora = c.IdEmpacadora where YEAR(c.Fecha) = '.$anio.' and MONTH(c.Fecha) = '.$mes.' and c.Unidad = "Toneladas" and c.IdPais = '.$myrow[0].' and (c.Estatus = "Original" or c.Estatus = "Reemplazo") and e.Nombre = "'.$emp.'"'); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = $kilos + (doubleval($row[0])*1000);
		        }
		        if ($kilos != 0){
		            $valores[$myrow[1]] = $kilos;
		        }
			}
		}
		arsort($valores);

		echo json_encode($valores);
	}
	
	if ($id == 'mesEmpMov') {
    	$anio = substr($_POST["fecha"], 0 ,4);
	    $mes = substr($_POST["fecha"], 5 ,2);
	    $emp = $_POST["empacadora"];
	    $valores = array();
	    $paises = array();

		$r=mysqli_query($enlace,"select * from pais"); 
		while ($myrow=mysqli_fetch_array($r)){ 
			if ($myrow[1] != "México"){
				$kilos = 0.0;
		        $b=mysqli_query($enlace,'select c.Cantidad from certificados as c inner join empacadora as e on e.IdEmpacadora = c.IdEmpacadora where YEAR(c.Fecha) = '.$anio.' and MONTH(c.Fecha) = '.$mes.' and c.Unidad = "Kilogramos" and c.IdPais = '.$myrow[0].' and (c.Estatus = "Original" or c.Estatus = "Reemplazo") and e.Nombre = "'.$emp.'"'); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = $kilos + doubleval($row[0]);
		        }
		        $b=mysqli_query($enlace,'select c.Cantidad from certificados as c inner join empacadora as e on e.IdEmpacadora = c.IdEmpacadora where YEAR(c.Fecha) = '.$anio.' and MONTH(c.Fecha) = '.$mes.' and c.Unidad = "Toneladas" and c.IdPais = '.$myrow[0].' and (c.Estatus = "Original" or c.Estatus = "Reemplazo") and e.Nombre = "'.$emp.'"'); 
		        while ($row=mysqli_fetch_array($b)) { 
		            $kilos = $kilos + (doubleval($row[0])*1000);
		        }
		        if ($kilos != 0){
		            $valores[$myrow[1]] = $kilos;
		        }
			}
		}
		arsort($valores);
		foreach($valores as $clave => $valor) {
			$paises[] = $clave;
		}
		
		if (count($paises) == 0){
		    $paises[] = "";
		}
		
		$llave["data"] = $paises;
		echo json_encode($llave);
	}

    if ($id == 'autoriza') {
		$r=mysqli_query($enlace,"select A.Nombre, P.Puesto, A.FechaActivo from autoriza as A inner join puestos as P on A.IdPuesto = P.IdPuesto where A.Activo = 1 ORDER BY A.Nombre ASC"); 
		while ($myrow=mysqli_fetch_array($r)) {
			echo "<tr>";
			echo "<td>".$myrow[0]."</td>";
			echo "<td>".$myrow[1]."</td>";
			echo "<td>".$myrow[2]."</td>";
			echo "</tr>";
		}
	}
	
	if ($id == 'impAutoriza') {
		$r = mysqli_query($enlace, "select A.IdAutoriza, A.Nombre, P.Puesto from autoriza as A inner join puestos as P on A.IdPuesto = P.IdPuesto where A.Activo = 1 ORDER BY A.Nombre ASC");
		echo "<option value = '' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) {
			echo "<option value = '".$myrow[0]."'>".$myrow[1]." (".$myrow[2].")</option>";
		}
	}
	
	if ($id == 'conUsuarios'){
	    $r=mysqli_query($enlace,"select u.Nombre, u.Correo, t.Descripcion as TipoUsuario from usuarios as u inner join tipousuario as t on u.IdTipoUsuario = t.IdTipoUsuario");
	    $resultado = $r->fetch_all(MYSQLI_ASSOC);
		$datos['data'] = $resultado;
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}

	if ($id == 'impTipoUsuario') {
		$r=mysqli_query($enlace,"select * from tipousuario ORDER BY Descripcion ASC");
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)){ 
		    if ($myrow[1] != "Empaque"){
		        echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		    }
		}
	}
	
	if ($id == 'obtFacturaXml'){
        $xml = simplexml_load_file($_FILES['archivoXML']['tmp_name']);
        $ns = $xml->getNamespaces(true);
		$xml->registerXPathNamespace('cfdi', @$ns['cfdi']);
		$xml->registerXPathNamespace('t', @$ns['tfd']);
		$datos = Array();
		 
		foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
		      $datos["Folio"] = strval($cfdiComprobante['Folio']);
		      $datos["SubTotal"] = number_format(doubleval($cfdiComprobante['SubTotal']), 2, '.', ''); 
		      $datos["Total"] = number_format(doubleval($cfdiComprobante['Total']), 2, '.', ''); 
		      $datos["Iva"] = number_format((doubleval($cfdiComprobante['Total']) - doubleval($cfdiComprobante['SubTotal'])), 2, '.', '');
		} 
		
		foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){ 
		   $datos["Descripcion"] = str_replace('"', "'", substr(strval($Concepto['Descripcion']), 0 ,150)); 
		} 
		
		foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
		   $datos["Fecha"] = strval($tfd['FechaTimbrado']);
		} 
		
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    }
    
    if ($id == 'busquedaCFacAporta') {
		$bandera = 0;
		$r=mysqli_query($enlace,"select Estatus from facturasaporta where FolioFactura = '".$_POST["folio"]."'"); 

		while ($myrow=mysqli_fetch_array($r)){ 
			$bandera = 1;
		}
		if ($bandera == 1){
			$r=mysqli_query($enlace,"select c.NumeroPDD from cobros as c inner join facturasaporta as f on f.IdFolioAporta = c.IdFolioAporta where f.FolioFactura = '".$_POST["folio"]."' LIMIT 1");
			$myrow=mysqli_fetch_array($r); 

			if (@$myrow[0] == ""){
				$r=mysqli_query($enlace,"select e.Nombre as Empacadora, f.Estatus, date_format(f.FechaEmision, '%d/%m/%Y') as FechaEmision, f.Concepto, format(f.SubTotal, 2) as SubTotal, format(f.Total, 2) as Total, format(f.Iva, 2) as Iva, format(f.Saldo, 2) as Saldo, a.Concepto as Aportacion from facturasaporta As f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join tipoaportacion As a on f.IdTipoAportacion = a.IdTipoAportacion where f.FolioFactura = '".$_POST["folio"]."'"); 
				$datos = array();
				$resultado = $r->fetch_assoc();
				$datos['status'] = 'ok';
		        $datos['result'] = $resultado;
				echo json_encode($datos);
			} else{
				echo "3";
			}
		} else{
		    echo "2";
		}
	}
	
	if ($id == 'obtFacturaXmlCobros'){
        $xml = simplexml_load_file($_FILES['archivoXML']['tmp_name']);
        $ns = $xml->getNamespaces(true);
		$xml->registerXPathNamespace('cfdi', @$ns['cfdi']);
		$xml->registerXPathNamespace('t', @$ns['tfd']);
		$datos = Array();
		 
		foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
		    $datos["NumPDD"] = strval($cfdiComprobante['Folio']);
		} 
		
		foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//pago10:Pagos//pago10:Pago') as $Concepto){ 
		    $datos["Monto"] = strval($Concepto['Monto']); 
		} 

		foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//pago10:Pagos//pago10:Pago//pago10:DoctoRelacionado') as $Concepto){ 
		    $datos["Folio"] = strval($Concepto['Folio']); 
		} 
		
		foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
		    $datos["Fecha"] = strval($tfd['FechaTimbrado']);
		} 
		
		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    }
    
    if ($id == 'obtFacturaAporta') {	
		$r=mysqli_query($enlace,"select f.Estatus, date_format(f.FechaEmision, '%d/%m/%Y') as FechaEmision, f.Concepto, format(f.SubTotal, 2) as SubTotal, format(f.Total, 2) as Total, format(f.Iva, 2) as Iva, format(f.Saldo, 2) as Saldo, a.Concepto as Aportacion from facturasaporta As f inner join empacadora As e on f.IdEmpacadora = e.IdEmpacadora inner join tipoaportacion As a on f.IdTipoAportacion = a.IdTipoAportacion where f.FolioFactura = '".$_POST["folio"]."'"); 
		$datos = array();
		$resultado = $r->fetch_assoc();
		$datos['status'] = 'ok';
        $datos['result'] = $resultado;
		echo json_encode($datos);
	}

	function obtEstadoCuenta($empacadora, $fechaI, $fechaF){
		global $enlace;
		$aux = array();
		$contenedor = array();
		$indice = array();
		$arreglo = array();
		$x = 0;
		$j = 0;
		$saldoTotal = 0;
		$totalAbonos = 0;
		$totalCargos = 0;
		$abonosSuma = 0;
		$cargosSuma = 0;

        if ($empacadora == ""){
        	$b = mysqli_query($enlace,"select IdEmpacadora, Nombre from empacadora ORDER BY Nombre ASC");
        } else{
        	$b = mysqli_query($enlace,"select IdEmpacadora, Nombre from empacadora where IdEmpacadora = '".$empacadora."' ORDER BY Nombre ASC");
        }

    	$empacadoras = $b->fetch_all(MYSQLI_ASSOC);

    	///////////////////////////////////// Ciclo para cada empacadora ///////////////////////////////////

    	foreach($empacadoras as $val) {
    		array_splice($indice, 0, count($indice));
	    	array_splice($contenedor, 0, count($contenedor));
    		$j = 0;
		    $totalAbonos = 0;
		    $totalCargos = 0;

    		////////////////////////////////// Salto de renglón

    		if ($x != 0){
	    		$aux["Fecha"] = "";
	    		$aux["Tipo"] = "";
	    		$aux["Concepto"] = "<br>";
	    		$aux["Referencia"] = "";
	    		$aux["Cargos"] = "";
	    		$aux["Abonos"] = "";
	    		$aux["Saldo"] = "";
	    		$arreglo[$x] = $aux;
	    		$x = $x + 1;
	    	}

	    	///////////////////////////////// Imprimir empacadora

    		$aux["Fecha"] = "";
    		$aux["Tipo"] = "";
    		$aux["Concepto"] = $val["Nombre"];
    		$aux["Referencia"] = "";
    		$aux["Cargos"] = "";
    		$aux["Abonos"] = "Saldo inicial:";

    		///////////////////////////////////// Obtener el saldo antes de la fecha inicial

    		if ($fechaI != "" && $fechaF != ""){
	    		$r=mysqli_query($enlace,"select SUM(Total) from facturasaporta WHERE IdEmpacadora = '".$val["IdEmpacadora"]."' AND Estatus <> 'Cancelada' AND FechaEmision < '".$fechaI."'"); 
		        $myrow=mysqli_fetch_array($r);
		        $saldoTotal = $myrow[0];

		        $r=mysqli_query($enlace,"select SUM(c.Monto) from cobros as c inner join facturasaporta as f on f.IdFolioAporta = c.IdFolioAporta WHERE f.IdEmpacadora = '".$val["IdEmpacadora"]."' AND f.Estatus <> 'Cancelada' AND c.FechaCobro < '".$fechaI."'"); 
		        $myrow=mysqli_fetch_array($r);
	    		$saldoTotal = $saldoTotal - $myrow[0];
	    	} else{
	    		$saldoTotal = 0;
	    	}

    		$aux["Saldo"] = $saldoTotal;

    		$arreglo[$x] = $aux;
    		$x = $x + 1;

    		////////////////////////////////// Obtener facturas entre el periodo de tiempo seleccionado

    		if ($fechaI != "" && $fechaF != ""){
	     	    $r=mysqli_query($enlace,"select date_format(FechaEmision, '%Y/%m/%d') as FechaEmision, Estatus, Concepto, FolioFactura, Total from facturasaporta where FechaEmision BETWEEN '".$fechaI."' AND '".$fechaF."' AND IdEmpacadora = '".$val["IdEmpacadora"]."' ORDER BY FechaEmision ASC");
	        } else{
	     	    $r=mysqli_query($enlace,"select date_format(FechaEmision, '%Y/%m/%d') as FechaEmision, Estatus, Concepto, FolioFactura, Total from facturasaporta where IdEmpacadora = '".$val["IdEmpacadora"]."' ORDER BY FechaEmision ASC"); 
	        }
    		
    		$resultado = $r->fetch_all(MYSQLI_ASSOC);

    		foreach ($resultado as $facturas) {
    			$indice[$j] = $facturas["FechaEmision"];
        		$aux["Fecha"] = $facturas["FechaEmision"];
				$aux["Tipo"] = "F";
			    $concepto = substr($facturas["Concepto"], 0 ,45)."...";
				$total = $facturas["Total"];
				$aux["Concepto"] = $concepto;
				$aux["Referencia"] = "F-".$facturas["FolioFactura"];
				$aux["Cargos"] = number_format($total, 2, '.', "");
				$aux["Abonos"] = "";
				$aux["Saldo"] = "";

				$contenedor[$j] = $aux;
	    		$j = $j + 1;
    		}

    		////////////////////////////////// Obtener facturas canceladas

    		if ($fechaI != "" && $fechaF != ""){
	     	    $r=mysqli_query($enlace,"select date_format(can.Fecha, '%Y/%m/%d') as FechaEmision, f.Estatus, can.Justificacion as Concepto, f.FolioFactura, f.Total from facturasaporta as f inner join cancelacionaporta as can on can.IdFolioAporta = f.IdFolioAporta where can.Fecha BETWEEN '".$fechaI."' AND '".$fechaF."' AND f.IdEmpacadora = '".$val["IdEmpacadora"]."' AND f.Estatus = 'Cancelada' ORDER BY can.Fecha ASC");
	        } else{
	     	    $r=mysqli_query($enlace,"select date_format(can.Fecha, '%Y/%m/%d') as FechaEmision, f.Estatus, can.Justificacion as Concepto, f.FolioFactura, f.Total from facturasaporta as f inner join cancelacionaporta as can on can.IdFolioAporta = f.IdFolioAporta where f.IdEmpacadora = '".$val["IdEmpacadora"]."' AND f.Estatus = 'Cancelada' ORDER BY can.Fecha ASC"); 
	        }
    		
    		$resultado = $r->fetch_all(MYSQLI_ASSOC);

    		foreach ($resultado as $facturas) {
    			$indice[$j] = $facturas["FechaEmision"];
        		$aux["Fecha"] = $facturas["FechaEmision"];
				$aux["Tipo"] = "F";
				$concepto = substr($facturas["Concepto"], 0 ,45)."...";
				$total = "-".$facturas["Total"];
				$aux["Concepto"] = $concepto;
				$aux["Referencia"] = "F-".$facturas["FolioFactura"];
				$aux["Cargos"] = number_format($total, 2, '.', "");
				$aux["Abonos"] = "";
				$aux["Saldo"] = "";

				$contenedor[$j] = $aux;
	    		$j = $j + 1;
    		}

    		////////////////////////////////// Obtener cobros entre el periodo de tiempo seleccionado

    		if ($fechaI != "" && $fechaF != ""){
	     	    $r=mysqli_query($enlace,"select date_format(c.FechaCobro, '%Y/%m/%d') as FechaCobro, f.Estatus, f.Concepto, f.FolioFactura, c.Monto from cobros as c inner join facturasaporta as f on c.IdFolioAporta = f.IdFolioAporta where c.FechaCobro BETWEEN '".$fechaI."' AND '".$fechaF."' AND IdEmpacadora = '".$val["IdEmpacadora"]."' ORDER BY c.FechaCobro ASC");
	        } else{
	     	    $r=mysqli_query($enlace,"select date_format(c.FechaCobro, '%Y/%m/%d') as FechaCobro, f.Estatus, f.Concepto, f.FolioFactura, c.Monto from cobros as c inner join facturasaporta as f on c.IdFolioAporta = f.IdFolioAporta where IdEmpacadora = '".$val["IdEmpacadora"]."' ORDER BY c.FechaCobro ASC");
	        }

		    $resultado = $r->fetch_all(MYSQLI_ASSOC);

		    foreach($resultado as $cobros) {
		    	$indice[$j] = $cobros["FechaCobro"];
		    	$aux["Fecha"] = $cobros["FechaCobro"];
				$aux["Tipo"] = "C";
				$concepto = substr($cobros["Concepto"], 0 ,45)."...";
				$total = $cobros["Monto"];
				$aux["Concepto"] = $concepto;
				$aux["Referencia"] = "F-".$cobros["FolioFactura"];
				$aux["Cargos"] = "";
				$aux["Abonos"] = number_format($total, 2, '.', "");

				$contenedor[$j] = $aux;
	    		$j = $j + 1;
		    }

		    ////////////////////////////////// Obtener cobros cancelados

    		if ($fechaI != "" && $fechaF != ""){
	     	    $r=mysqli_query($enlace,"select date_format(c.FechaCobro, '%Y/%m/%d') as FechaCobro, f.Estatus, can.Justificacion as Concepto, f.FolioFactura, c.Monto from cobros as c inner join facturasaporta as f on c.IdFolioAporta = f.IdFolioAporta inner join cancelacionaporta as can on can.IdFolioAporta = f.IdFolioAporta where c.FechaCobro BETWEEN '".$fechaI."' AND '".$fechaF."' AND f.IdEmpacadora = '".$val["IdEmpacadora"]."' AND f.Estatus = 'Cancelada' ORDER BY c.FechaCobro ASC");
	        } else{
	     	    $r=mysqli_query($enlace,"select date_format(c.FechaCobro, '%Y/%m/%d') as FechaCobro, f.Estatus, can.Justificacion as Concepto, f.FolioFactura, c.Monto from cobros as c inner join facturasaporta as f on c.IdFolioAporta = f.IdFolioAporta inner join cancelacionaporta as can on can.IdFolioAporta = f.IdFolioAporta where f.IdEmpacadora = '".$val["IdEmpacadora"]."' AND f.Estatus = 'Cancelada' ORDER BY c.FechaCobro ASC");
	        }

		    $resultado = $r->fetch_all(MYSQLI_ASSOC);

		    foreach($resultado as $cobros) {
		    	$indice[$j] = $cobros["FechaCobro"];
		    	$aux["Fecha"] = $cobros["FechaCobro"];
				$aux["Tipo"] = "C";
				$concepto = substr($cobros["Concepto"], 0 ,45)."...";
				$total = "-".$cobros["Monto"];
				$aux["Concepto"] = $concepto;
				$aux["Referencia"] = "F-".$cobros["FolioFactura"];
				$aux["Cargos"] = "";
				$aux["Abonos"] = number_format($total, 2, '.', "");

				$contenedor[$j] = $aux;
	    		$j = $j + 1;
		    }

		    //////////////////////////////// Ordenar registros por fecha

		    asort($indice);

		    /////////////////////////////// alimentar el arreglo de retorno con los registros ordenados y calcular el saldo

	    	foreach($indice as $i => $value) {
	    		$aux = $contenedor[$i];
	    		if ($aux["Tipo"] == "F"){
	    			$saldoTotal = $saldoTotal + doubleval($aux["Cargos"]);
	    			$totalCargos = $totalCargos + doubleval($aux["Cargos"]);
	    		} else{
	    			$saldoTotal = $saldoTotal - doubleval($aux["Abonos"]);
	    			$totalAbonos = $totalAbonos + doubleval($aux["Abonos"]);
	    		}
	    		$aux["Saldo"] = number_format($saldoTotal, 2, '.', "");
	    		$arreglo[$x] = $aux;
	    		$x = $x + 1;
	    	}

	    	////////////////////////////////// Imprimir total

    		$aux["Fecha"] = "";
    		$aux["Tipo"] = "";
    		$aux["Concepto"] = "";
    		$aux["Referencia"] = "Total:";
    		$aux["Cargos"] = number_format($totalCargos, 2, '.', "");
    		$aux["Abonos"] = number_format($totalAbonos, 2, '.', "");
    		$aux["Saldo"] = number_format($saldoTotal, 2, '.', "");
    		$arreglo[$x] = $aux;
    		$x = $x + 1;

    		//////////////////////////////// Suma de valores

    		$cargosSuma = $cargosSuma + $totalCargos;
    		$abonosSuma = $abonosSuma + $totalAbonos;
    	}

    	//////////////////////////////////// Imprimir suma

    	if ($empacadora == ""){
    		$aux["Fecha"] = "";
    		$aux["Tipo"] = "";
    		$aux["Concepto"] = "<br>";
    		$aux["Referencia"] = "";
    		$aux["Cargos"] = "";
    		$aux["Abonos"] = "";
    		$aux["Saldo"] = "";
    		$arreglo[$x] = $aux;
    		$x = $x + 1;

    		$aux["Fecha"] = "";
    		$aux["Tipo"] = "";
    		$aux["Concepto"] = "";
    		$aux["Referencia"] = "Suma:";
    		$aux["Cargos"] = number_format($cargosSuma, 2, '.', "");
    		$aux["Abonos"] = number_format($abonosSuma, 2, '.', "");
    		$aux["Saldo"] = "";
    		$arreglo[$x] = $aux;
    	}

    	return $arreglo;
	}

	function formatoNumRepGen($arreglo){
		$nuevoArreglo = array();
		$aux = array();
		$x = 0;

		foreach($arreglo as $val) { 
			if ($val["Cargos"] != ""){ 
				$cargo = number_format($val["Cargos"], 2, '.', ",");
			} else{
				$cargo = $val["Cargos"];
			}
    		if ($val["Abonos"] != "" && is_numeric($val["Abonos"])){
    			$abono = number_format($val["Abonos"], 2, '.', ",");
    		} else{
    			$abono = $val["Abonos"];
    		}
    		if ($val["Saldo"] != ""){
    			$saldo = number_format($val["Saldo"], 2, '.', ",");
    		} else{
    			$saldo = $val["Saldo"];
    		}

			$aux["Fecha"] = $val["Fecha"];
    		$aux["Tipo"] = $val["Tipo"];
    		$aux["Concepto"] = $val["Concepto"];
    		$aux["Referencia"] = $val["Referencia"];
    		$aux["Cargos"] = $cargo;
    		$aux["Abonos"] = $abono;
    		$aux["Saldo"] = $saldo;
    		$nuevoArreglo[$x] = $aux;
    		$x = $x + 1;
		}

		return $nuevoArreglo;
	}

	if ($id == 'repIngresosGen') {
		foreach(formatoNumRepGen(obtEstadoCuenta($_POST["empacadora"], $_POST["fechaI"], $_POST["fechaF"])) as $val) { 
			echo "<tr>";
			foreach($val as $i => $valor){
				if ($i == "Cargos" || $i == "Abonos" || $i == "Saldo" || $valor == "Total:" || $valor == "Suma:"){
					echo "<td align='right'>".$valor."</td>";
				} else{
					echo "<td>".$valor."</td>";
				}
			}
			echo "</tr>";
		}
	}

	function obtRepSaldos($fecha, $tipo){
		global $enlace;
		$aux = array();
		$arreglo = array();
		$x = 0;
		$sumaCargos = 0;
		$sumaAbonos = 0;
		$sumaSaldo = 0;
		$sumaSaldoI = 0;

		if ($fecha != ""){
			$anio = substr($fecha, 0 ,4);
	        $mes = substr($fecha, 5 ,2);
		} else{
			$anio = date("Y");
	        $mes = date("m");
		}

		$b = mysqli_query($enlace,"select IdEmpacadora, Nombre from empacadora ORDER BY Nombre ASC");
    	$empacadoras = $b->fetch_all(MYSQLI_ASSOC);

    	///////////////////////////////////// Ciclo para cada empacadora ///////////////////////////////////

    	foreach($empacadoras as $val) {

    		/////////////////////////////// filtro por tipo de aportación

    		if ($tipo == ""){
    			$facturas = "";
    			$cobros = "";
    		} else{
    			$facturas = " AND IdTipoAportacion = '".$tipo."'";
    			$cobros = " AND f.IdTipoAportacion = '".$tipo."'";
    		}

    		///////////////////////////////////// Obtener el saldo antes de la fecha inicial

    		$r=mysqli_query($enlace,"select SUM(Total) from facturasaporta WHERE IdEmpacadora = '".$val["IdEmpacadora"]."' AND Estatus <> 'Cancelada' AND FechaEmision < '".$anio."-".$mes."-01'".$facturas); 
	        $myrow=mysqli_fetch_array($r);
	        $saldoTotal = $myrow[0];

	        $r=mysqli_query($enlace,"select SUM(c.Monto) from cobros as c inner join facturasaporta as f on f.IdFolioAporta = c.IdFolioAporta WHERE f.IdEmpacadora = '".$val["IdEmpacadora"]."' AND f.Estatus <> 'Cancelada' AND c.FechaCobro < '".$anio."-".$mes."-01'".$cobros); 
	        $myrow=mysqli_fetch_array($r);
    		$saldoTotal = $saldoTotal - $myrow[0];

    		//////////////////////////////// Obtener cargos

    		$r=mysqli_query($enlace,"select SUM(Total) from facturasaporta WHERE IdEmpacadora = '".$val["IdEmpacadora"]."' AND Estatus <> 'Cancelada' AND YEAR(FechaEmision) = '".$anio."' AND MONTH(FechaEmision) = '".$mes."'".$facturas); 
	        $myrow=mysqli_fetch_array($r);
	        $cargos = $myrow[0];

	        //////////////////////////////// Obtener abonos

	        $r=mysqli_query($enlace,"select SUM(c.Monto) from cobros as c inner join facturasaporta as f on f.IdFolioAporta = c.IdFolioAporta WHERE f.IdEmpacadora = '".$val["IdEmpacadora"]."' AND f.Estatus <> 'Cancelada' AND YEAR(c.FechaCobro) = '".$anio."' AND MONTH(c.FechaCobro) = '".$mes."'".$cobros); 
	        $myrow=mysqli_fetch_array($r);
    		$abonos = $myrow[0];

    		/////////////////////////////// Obtener saldo final

    		$saldoFinal = $saldoTotal + $cargos - $abonos;

    		////////////////////////////////// Imprimir fila

    		$aux["Empacadora"] = $val["Nombre"];
    		$aux["SaldoI"] = number_format($saldoTotal, 2, '.', "");
    		$aux["Cargos"] = number_format($cargos, 2, '.', "");
    		$aux["Abonos"] = number_format($abonos, 2, '.', "");
    		$aux["SaldoF"] = number_format($saldoFinal, 2, '.', "");
    		$arreglo[$x] = $aux;
    		$x = $x + 1;

	    	$sumaSaldoI = $sumaSaldoI + $saldoTotal;
	    	$sumaCargos = $sumaCargos + $cargos;
	    	$sumaAbonos = $sumaAbonos + $abonos;
	    	$sumaSaldo = $sumaSaldo + $saldoFinal;
    	}

    	///////////////////////////////// Imprimir totales

    	$aux["Empacadora"] = "Suma:";
		$aux["SaldoI"] = number_format($sumaSaldoI, 2, '.', "");
		$aux["Cargos"] = number_format($sumaCargos, 2, '.', "");
		$aux["Abonos"] = number_format($sumaAbonos, 2, '.', "");
		$aux["SaldoF"] = number_format($sumaSaldo, 2, '.', "");
		$arreglo[$x] = $aux;

		return $arreglo;
	}

	function formatoNumRepSal($arreglo){
		$nuevoArreglo = array();
		$aux = array();
		$x = 0;

		foreach($arreglo as $val) { 
			$aux["Empacadora"] = $val["Empacadora"];
			$aux["SaldoI"] = number_format($val["SaldoI"], 2, '.', ",");
			$aux["Cargos"] = number_format($val["Cargos"], 2, '.', ",");
			$aux["Abonos"] = number_format($val["Abonos"], 2, '.', ",");
			$aux["SaldoF"] = number_format($val["SaldoF"], 2, '.', ",");
			$nuevoArreglo[$x] = $aux;
    		$x = $x + 1;
		}

		return $nuevoArreglo;
	}

	if ($id == 'repIngresosSaldo') {
		foreach(formatoNumRepSal(obtRepSaldos($_POST["fecha"], $_POST["tipoAporta"])) as $val) { 
			echo "<tr>";
			foreach($val as $i => $valor){
				if ($i == "SaldoI" || $i == "Cargos" || $i == "Abonos" || $i == "SaldoF" || $valor == "Suma:"){
					echo "<td align='right'>".$valor."</td>";
				} else{
					echo "<td>".$valor."</td>";
				}
			}
			echo "</tr>";
		}
	}

	function obtRepEC($empacadora, $fechaI, $fechaF, $estatus){
		global $enlace;
		$aux = array();
		$arreglo = array();
		$x = 0;
		$cantidad = 0;
		$facturado = 0;
		$cantidadPagada = 0;
		$saldo = 0;
		$cantidadSuma = 0;
		$facturadoSuma = 0;
		$cantidadPagadaSuma = 0;
		$saldoSuma = 0;
		$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

		if ($empacadora == ""){
        	$b = mysqli_query($enlace,"select IdEmpacadora, Nombre from empacadora ORDER BY Nombre ASC");
        } else{
        	$b = mysqli_query($enlace,"select IdEmpacadora, Nombre from empacadora where IdEmpacadora = '".$empacadora."' ORDER BY Nombre ASC");
        }

    	$empacadoras = $b->fetch_all(MYSQLI_ASSOC);

    	///////////////////////////////////// Ciclo para cada empacadora ///////////////////////////////////

    	foreach($empacadoras as $val) {
			$cantidad = 0;
		    $facturado = 0;
		    $cantidadPagada = 0;
		    $saldo = 0;

    		/////////////////////////////// filtro por estatus

    		if ($estatus == ""){
    			$condicionEstatus = "AND f.Estatus <> 'Cancelada'";
    		} else{
    			$condicionEstatus = "AND f.Estatus = '".$estatus."'";
    		}

    		////////////////////////////////// Salto de renglón

    		if ($x != 0){
	    		$aux["Factura"] = "";
	    		$aux["Exportacion"] = "<br>";
	    		$aux["Kilogramos"] = "";
	    		$aux["Tasa"] = "";
	    		$aux["Cantidad"] = "";
	    		$aux["Facturado"] = "";
	    		$aux["FechaPago"] = "";
	    		$aux["CantidadPagada"] = "";
	    		$aux["Saldo"] = "";
	    		$aux["Estatus"] = "";
	    		$arreglo[$x] = $aux;
	    		$x = $x + 1;
	    	}

	    	///////////////////////////////// Imprimir empacadora

    		$aux["Factura"] = "";
    		$aux["Exportacion"] = "";
    		$aux["Kilogramos"] = "";
	    	$aux["Tasa"] = "";
    		$aux["Cantidad"] = "";
    		$aux["Facturado"] = "";
    		$aux["FechaPago"] = $val["Nombre"];
    		$aux["CantidadPagada"] = "";
    		$aux["Saldo"] = "";
    		$aux["Estatus"] = "";
    		$arreglo[$x] = $aux;
    		$x = $x + 1;

    		if ($fechaI != "" && $fechaF != ""){
	     	    $r=mysqli_query($enlace,"select f.FolioFactura, MONTH(f.FechaEmision - INTERVAL 1 MONTH) as MesAporta, Year(f.FechaEmision - INTERVAL 1 MONTH) as AnioAporta, f.Total, DAY(f.FechaEmision) as Dia, MONTH(f.FechaEmision) as Mes, Year(f.FechaEmision) as Anio, f.Saldo, f.Estatus from facturasaporta as f inner join tipoaportacion as t on f.IdTipoAportacion = t.IdTipoAportacion where t.Concepto = 'Cuota' AND f.FechaEmision BETWEEN '".$fechaI."' AND '".$fechaF."' AND f.IdEmpacadora = '".$val["IdEmpacadora"]."' ".$condicionEstatus." ORDER BY f.FechaEmision ASC");
	        } else{
	     	    // $r=mysqli_query($enlace,"select FolioFactura, MONTH(FechaEmision - INTERVAL 1 MONTH) as MesAporta, Year(FechaEmision - INTERVAL 1 MONTH) as AnioAporta, Total, DAY(FechaEmision) as Dia, MONTH(FechaEmision) as Mes, Year(FechaEmision) as Anio, Saldo, Estatus from facturasaporta where IdEmpacadora = '".$val["IdEmpacadora"]."' ".$condicionEstatus." ORDER BY FechaEmision ASC"); 
	     	    $r=mysqli_query($enlace,"select f.FolioFactura, MONTH(f.FechaEmision - INTERVAL 1 MONTH) as MesAporta, Year(f.FechaEmision - INTERVAL 1 MONTH) as AnioAporta, f.Total, DAY(f.FechaEmision) as Dia, MONTH(f.FechaEmision) as Mes, Year(f.FechaEmision) as Anio, f.Saldo, f.Estatus from facturasaporta as f inner join tipoaportacion as t on f.IdTipoAportacion = t.IdTipoAportacion where t.Concepto = 'Cuota' AND f.IdEmpacadora = '".$val["IdEmpacadora"]."' ".$condicionEstatus." ORDER BY f.FechaEmision ASC");
	        }
    		
    		$resultado = $r->fetch_all(MYSQLI_ASSOC);

    		foreach ($resultado as $facturas) {

    			/////////////////////////////////// Obtengo kilogramos exportados 

	    		$kilogramos = obtKilogramosMen($facturas["AnioAporta"], $facturas["MesAporta"], $val["IdEmpacadora"]);

	    		/////////////////////////////////// Obtengo la cuota del mes

				$cuota = obtCuotaMen($facturas["AnioAporta"], $facturas["MesAporta"], $val["IdEmpacadora"], $kilogramos);

				////////////////////////////////// lleno fila

    			$aux["Factura"] = $facturas["FolioFactura"];
	    		$aux["Exportacion"] = strtoupper($meses[$facturas["MesAporta"] - 1])." - ".$facturas["AnioAporta"];
	    		$aux["Kilogramos"] = $kilogramos;
	    		$aux["Tasa"] = $cuota["tasa"];
	    		$aux["Cantidad"] = $cuota["cuota"];
	    		$aux["Facturado"] = number_format($facturas["Total"], 2, '.', "");
	    		$aux["FechaPago"] = $facturas["Dia"]." de ".$meses[$facturas["Mes"] - 1]." de ".$facturas["Anio"];
	    		$aux["CantidadPagada"] = number_format(($facturas["Total"] - $facturas["Saldo"]), 2, '.', "");
	    		$aux["Saldo"] = number_format($facturas["Saldo"], 2, '.', "");
	    		$aux["Estatus"] = $facturas["Estatus"];
	    		$arreglo[$x] = $aux;
	    		$x = $x + 1;

	    		$cantidad = number_format(($cantidad + $cuota["cuota"]), 2, '.', "");
    		    $facturado = number_format(($facturado + $facturas["Total"]), 2, '.', "");
    		    $cantidadPagada = number_format($cantidadPagada + number_format(($facturas["Total"] - $facturas["Saldo"]), 2, '.', ""), 2, '.', "");
    		    $saldo = number_format(($saldo + $facturas["Saldo"]), 2, '.', "");
    		}

    		////////////////////////////////// imprimir el total

    		$aux["Factura"] = "";
    		$aux["Exportacion"] = "";
    		$aux["Kilogramos"] = "";
    		$aux["Tasa"] = "Total:";
    		$aux["Cantidad"] = $cantidad;
    		$aux["Facturado"] = $facturado;
    		$aux["FechaPago"] = "";
    		$aux["CantidadPagada"] = $cantidadPagada;
    		$aux["Saldo"] = $saldo;
    		$aux["Estatus"] = "";
    		$arreglo[$x] = $aux;
    		$x = $x + 1;

    		$cantidadSuma = number_format(($cantidadSuma + $cantidad), 2, '.', "");
    		$facturadoSuma = number_format(($facturadoSuma + $facturado), 2, '.', "");
    		$cantidadPagadaSuma = number_format(($cantidadPagadaSuma + $cantidadPagada), 2, '.', "");
    		$saldoSuma = number_format(($saldoSuma + $saldo), 2, '.', "");
    	}

    	if ($empacadora == ""){
    		$aux["Factura"] = "";
    		$aux["Exportacion"] = "<br>";
    		$aux["Kilogramos"] = "";
    		$aux["Tasa"] = "";
    		$aux["Cantidad"] = "";
    		$aux["Facturado"] = "";
    		$aux["FechaPago"] = "";
    		$aux["CantidadPagada"] = "";
    		$aux["Saldo"] = "";
    		$aux["Estatus"] = "";
    		$arreglo[$x] = $aux;
    		$x = $x + 1;

    		$aux["Factura"] = "";
    		$aux["Exportacion"] = "";
    		$aux["Kilogramos"] = "";
    		$aux["Tasa"] = "Suma:";
    		$aux["Cantidad"] = $cantidadSuma;
    		$aux["Facturado"] = $facturadoSuma;
    		$aux["FechaPago"] = "";
    		$aux["CantidadPagada"] = $cantidadPagadaSuma;
    		$aux["Saldo"] = $saldoSuma;
    		$aux["Estatus"] = "";
    		$arreglo[$x] = $aux;
    	}

    	return $arreglo;
	}

	function formatoNumRepEC($arreglo){
		$nuevoArreglo = array();
		$aux = array();
		$x = 0;

		foreach($arreglo as $val) { 
			if (is_numeric($val["Kilogramos"])){
				$kilogramos = number_format($val["Kilogramos"], 2, '.', ",");
			} else{
				$kilogramos = $val["Kilogramos"];
			}

			if ($val["Cantidad"] != ""){ 
    		    $cantidad = number_format($val["Cantidad"], 2, '.', ",");
    		    $facturado = number_format($val["Facturado"], 2, '.', ",");
    		    $cantidadPagada = number_format($val["CantidadPagada"], 2, '.', ",");
    		    $saldo = number_format($val["Saldo"], 2, '.', ",");
			} else{
    		    $cantidad = $val["Cantidad"];
    		    $facturado = $val["Facturado"];
    		    $cantidadPagada = $val["CantidadPagada"];
    		    $saldo = $val["Saldo"];
			}

			$aux["Factura"] = $val["Factura"];
    		$aux["Exportacion"] = $val["Exportacion"];
    		$aux["Kilogramos"] = $kilogramos;
    		$aux["Tasa"] = $val["Tasa"];
    		$aux["Cantidad"] = $cantidad;
    		$aux["Facturado"] = $facturado;
    		$aux["FechaPago"] = $val["FechaPago"];
    		$aux["CantidadPagada"] = $cantidadPagada;
    		$aux["Saldo"] = $saldo;
    		$aux["Estatus"] = $val["Estatus"];
			$nuevoArreglo[$x] = $aux;
    		$x = $x + 1;
		}

		return $nuevoArreglo;
	}

	if ($id == 'repIngresosEC') {
		foreach(formatoNumRepEC(obtRepEC($_POST["empacadora"], $_POST["fechaI"], $_POST["fechaF"], $_POST["estatus"])) as $val) { 
			echo "<tr>";
			foreach($val as $i => $valor){
				if ($i == "Kilogramos" || $i == "Cantidad" || $i == "Facturado" || $i == "CantidadPagada" || $i == "Saldo"){
					echo "<td align='right'>".$valor."</td>";
				} else{
					if ($i == "Factura"){
					    echo "<td align='center'>".$valor."</td>";
				    } else{
					    echo "<td>".$valor."</td>";
				    }
				}
			}
			echo "</tr>";
		}
	}
	
	if ($id == 'obtTerceria') {
		$r=mysqli_query($enlace,"select t.Nombre from tercerias as t inner join terceroespecialista as te on te.IdTerceria = t.IdTerceria where IdTerceroEspecialista = '".$_POST["TE"]."'");
		$resultado = $r->fetch_assoc(); 
		echo json_encode($resultado);
	}
	
	if ($id == 'expFactAporta'){
        $datos [] = json_decode($_POST["datos"]);
        $cadena = "";
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Folio,Empacadora,Fecha de emisión,Estatus,SubTotal,Iva,Total,Saldo,Tipo de aportación,Concepto,Fecha de cancelación,Justificación'.PHP_EOL);

        foreach($datos as $factura) {
		    foreach($factura as $valor) {
		    	$x = 0;
		    	foreach($valor as $val) {
		    		if ($x <= 11){
		    			if ($x == 4 || $x == 5 || $x == 6 || $x == 7 || $x == 9){
			    			$val = str_replace(",", "", $val);
			    		} else{
			    		    $val = str_replace(",", ".", $val);
			    		}

			    		$cadena = $cadena.$val.',';
			    		$x = $x + 1;
		    		}
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
        fclose($archivo);
    }
    
    if ($id == 'impPuertos') {
		$r=mysqli_query($enlace,"select IdRegulacion, Nombre from regulaciones ORDER BY Nombre ASC");
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
	
	if ($id == 'obtDatosPuertos') {	
		$r=mysqli_query($enlace,"select p.Nombre as Pais, est.Nombre as Estado, m.Nombre as Municipio from regulaciones as r inner join municipio As m on r.IdMunicipio = m.IdMunicipio inner join estado As est on m.IdEstado = est.IdEstado inner join pais As p on est.IdPais = p.IdPais where r.IdRegulacion = '".$_POST["puerto"]."'");
		$resultado = $r->fetch_assoc(); 
		echo json_encode($resultado);
	}
	
	if ($id == 'impCuentaMod') {
		$r=mysqli_query($enlace,"select IdBanco, NumCuenta from bancos where TipoBanco = 'A' ORDER BY NumCuenta ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
	
	if ($id == 'obtDatosCuenta') {	
		$r=mysqli_query($enlace,"select nb.Nombre as Banco, b.Clabe from bancos as b inner join nombresbancos as nb on nb.IdNombreBanco  = b.IdNombreBanco where b.IdBanco = '".$_POST["cuenta"]."'"); 
		$resultado = $r->fetch_assoc(); 
		echo json_encode($resultado);
	}
	
	function obtKilogramosMen($anio, $mes, $empacadora){
		global $enlace;

		if ($empacadora != ""){
			$consultaT = "select (ROUND(SUM(ROUND(Cantidad, 4)), 4)*1000) from certificados where YEAR(Fecha) = '".$anio."' and MONTH(Fecha) = '".$mes."' and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$empacadora."'";
			$consultaK = "select ROUND(SUM(ROUND(Cantidad, 3)), 3) from certificados where YEAR(Fecha) = '".$anio."' and MONTH(Fecha) = '".$mes."' and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$empacadora."'";
		} else{
			$consultaT = "select (ROUND(SUM(ROUND(Cantidad, 4)), 4)*1000) from certificados where YEAR(Fecha) = '".$anio."' and MONTH(Fecha) = '".$mes."' and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo')";
			$consultaK = "select ROUND(SUM(ROUND(Cantidad, 3)), 3) from certificados where YEAR(Fecha) = '".$anio."' and MONTH(Fecha) = '".$mes."' and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo')";
		}

		$r=mysqli_query($enlace, $consultaT);
	    $row=mysqli_fetch_array($r);
	    $toneladas = number_format(doubleval($row[0]), 2, '.', "");

	    $r=mysqli_query($enlace, $consultaK);
	    $row=mysqli_fetch_array($r);
	    $kilogramos = number_format((number_format(doubleval($row[0]), 2, '.', "") + $toneladas), 2, '.', "");
        return $kilogramos;
	}

	function obtCuotaMen($anio, $mes, $empacadora, $kilogramos){
		global $enlace;
	    $array = array();

		$r=mysqli_query($enlace,"select DAY(LAST_DAY('".$anio."-".$mes."-01'))"); 
		$myrow=mysqli_fetch_array($r);
		$dia = $myrow[0];

		$r=mysqli_query($enlace,"select Cantidad, Fecha from cuotas where Fecha <= '".$anio."-".$mes."-".$dia."' ORDER BY Fecha DESC"); 
		$myrow=mysqli_fetch_array($r);
		if (@$myrow[1] != ''){
			$anioC = substr($myrow[1], 0 ,4);
	        $mesC = substr($myrow[1], 5 ,2);
			if ($myrow[1] == ($anio."-".$mes."-01") || ($anioC.$mesC) != ($anio.$mes)){
				//////////////////////////// no hay fechas intermedias
				$array["cuota"] = number_format(($kilogramos * $myrow[0]), 2, '.', "");
				$array["tasa"] = $myrow[0];
                return $array;
			} else{
				$b = 0;
				$anioA = $anio;
				$mesA = $mes;
				$diaA = $dia;
				$cuota = 0;
				$tasa = "";

				$r=mysqli_query($enlace,"select Cantidad, Fecha, DATE(Fecha - INTERVAL 1 DAY) from cuotas where Fecha <= '".$anio."-".$mes."-".$dia."' ORDER BY Fecha DESC"); 
	            while ($row=mysqli_fetch_array($r)){
	            	$anioC = substr($row[1], 0 ,4);
                    $mesC = substr($row[1], 5 ,2);

                    ////////////////////////// verifico que la consulta sea sólo del mes consultado

                    if (($anioC.$mesC) != ($anio.$mes)){
	            		$fecha = $anio."-".$mes."-01";
	            	} else{
	            		$fecha = $row[1];
	            	}

                    ////////////////////////// calculo kilogramos por periodo de tiempo

					$res=mysqli_query($enlace, "select (ROUND(SUM(ROUND(Cantidad, 4)), 4)*1000) from certificados where Fecha BETWEEN '".$fecha."' and '".$anioA."-".$mesA."-".$diaA."' and Unidad = 'Toneladas' and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$empacadora."'");
				    $fila=mysqli_fetch_array($res);
				    $toneladas = number_format(doubleval($fila[0]), 2, '.', "");

				    $res=mysqli_query($enlace, "select ROUND(SUM(ROUND(Cantidad, 3)), 3) from certificados where Fecha BETWEEN '".$fecha."' and '".$anioA."-".$mesA."-".$diaA."' and Unidad = 'Kilogramos' and (Estatus = 'Original' or Estatus = 'Reemplazo') and IdEmpacadora = '".$empacadora."'");
				    $fila=mysqli_fetch_array($res);
				    $kilogramos = number_format((number_format(doubleval($fila[0]), 2, '.', "") + $toneladas), 2, '.', "");
                    
                    //////////////////////////// sumo la cuota y guardo la última tasa

                    $cuota = $cuota + number_format(($kilogramos * $row[0]), 2, '.', "");
                    $ultimaTasa = $row[0];

                    /////////////////////////// verifico si ya calculé todos los días del mes

	            	if ($row[1] == ($anio."-".$mes."-01") || ($anioC.$mesC) != ($anio.$mes)){
	            		$b = 1;
	            		break;
	            	}

	            	//////////////////// actualizo última fecha y obtengo tasa

                    $anioA = substr($row[2], 0, 4);
                    $mesA = substr($row[2], 5 ,2);
                    $diaA = substr($row[2], 8, 2);
                    $tasa = $tasa.$row[0].", ";
	            }

	            $tasa = substr($tasa, 0, strlen ($tasa) - 2)." y ".$ultimaTasa;

	            if ($b == 0){
	            	/////////////////////////// no se calcularon los primeros días porque no está registrada una cuota en esas fechas
		            $array["cuota"] = 0;
					$array["tasa"] = 0;
	                return $array;
	            } else{
	            	$array["cuota"] = $cuota;
					$array["tasa"] = $tasa;
	                return $array;
	            }
			}
		} else{
			$array["cuota"] = 0;
			$array["tasa"] = 0;
	        return $array;
		}
	}
	
	if ($id == 'expRepGenIng'){
        $cadena = "";
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prueba.csv');

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Fecha,Tipo,Concepto,Referencia,Cargos,Abonos,Saldo inicial/Saldo'.PHP_EOL);

        foreach(obtEstadoCuenta($_POST["empacadora"], $_POST["fechaI"], $_POST["fechaF"]) as $rep) {
	    	foreach($rep as $val) {
	    		if ($val == "<br>"){
	    			$val = "";
	    		}
	    		$val = str_replace(",", ".", $val);

	    		$cadena = $cadena.$val.',';
			}
			fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
			$cadena = "";
		}
        fclose($archivo);
    }
    
    if ($id == 'expRepResumenIng'){
        $cadena = "";
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prueba.csv');

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Empacadora,Saldo inicial,Cargos,Abonos,Saldo final'.PHP_EOL);

        foreach(obtRepSaldos($_POST["fecha"], $_POST["tipoAporta"]) as $rep) {
	    	foreach($rep as $val) {
	    		if ($val == "<br>"){
	    			$val = "";
	    		}
	    		$val = str_replace(",", ".", $val);

	    		$cadena = $cadena.$val.',';
			}
			fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
			$cadena = "";
		}
        fclose($archivo);
    }

    if ($id == 'expRepEC'){
        $cadena = "";
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prueba.csv');

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Factura,Exportación del mes,Kg. Total,Tasa,Cantidad x (Cvos/Kg),Facturado,Fecha de pago,Cantidad pagada,Saldo a cubrir,Estatus'.PHP_EOL);

        foreach(obtRepEC($_POST["empacadora"], $_POST["fechaI"], $_POST["fechaF"], $_POST["estatus"]) as $rep) {
	    	foreach($rep as $val) {
	    		if ($val == "<br>"){
	    			$val = "";
	    		}

	    		$val = str_replace(",", ".", $val);
	    		$cadena = $cadena.$val.',';
			}
			fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
			$cadena = "";
		}
        fclose($archivo);
    }
    
    if ($id == 'impGrupo') {
		$r=mysqli_query($enlace,"select IdGrupo, NombreGrupo from grupos ORDER BY NombreGrupo ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
	
	if ($id == 'impContinente') {
		$r=mysqli_query($enlace,"select IdContinente, NombreContinente from continentes ORDER BY NombreContinente ASC"); 
		echo "<option value='' selected>...</option>";
		while ($myrow=mysqli_fetch_array($r)) 
		{ 
			echo "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
		}
	}
	
	if ($id == 'expBancos'){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prueba.csv');

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Nombre'.PHP_EOL);
        
        $r=mysqli_query($enlace,"select Nombre from nombresbancos ORDER BY Nombre ASC"); 
        while ($myrow=mysqli_fetch_array($r)){ 
			$val = str_replace(",", ".", $myrow[0]);
			fputs($archivo,  $val.PHP_EOL);
		}

        fclose($archivo);
    }
    
    if ($id == 'expCuentasB'){
        $cadena = "";
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prueba.csv');

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Banco,Num. Cuenta,Clabe,Fecha,Saldo inicial, Saldo actual'.PHP_EOL);
		
		$r=mysqli_query($enlace,"select n.Nombre, b.NumCuenta, b.Clabe, b.Fecha, b.Saldo, b.IdBanco from bancos as b inner join nombresbancos as n on n.IdNombreBanco = b.IdNombreBanco where TipoBanco = 'A' ORDER BY n.Nombre, b.NumCuenta, b.Clabe ASC");
        while ($myrow=mysqli_fetch_array($r)){ 
            $x = 0;
			for($i = 0; $i < (count($myrow)/2); $i++) {
	    		if ($x == 4){
		            $val = str_replace(",", "", $myrow[$i]);
		    	} else{
		    		$val = str_replace(",", ".", $myrow[$i]);
		    	}
		    	
		    	if ($x == 5) {
		    	    $sumar = 0;
			        $p=mysqli_query($enlace, "select Monto from pagos where IdBancoO = '".$myrow[5]."'");
			        while ($pago=mysqli_fetch_array($p)) {
			            $sumar = $sumar + $pago[0];
			        }
		    	    $restar = 0;
			        $c=mysqli_query($enlace, "select Monto from cobros where IdBancoAs = '".$myrow[5]."'");
			        while ($cobro=mysqli_fetch_array($c)) {
			            $restar = $restar - $cobro[0];
			        }
			        $val = $myrow[4] + $sumar -$restar;
		    	}

		    	$cadena = $cadena.$val.',';
		    	$x = $x + 1;
			}
			
			fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
			$cadena = "";
		}
        fclose($archivo);
    }
    
    if ($id == 'expPaises'){
        $datos [] = json_decode($_POST["datos"]);
        $cadena = "";
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Continente,Grupo,País'.PHP_EOL);

        foreach($datos as $aux) {
		    foreach($aux as $valor) {
		    	foreach($valor as $val) {
		    		$val = str_replace(",", ".", $val);
		    		$cadena = $cadena.$val.',';
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
        fclose($archivo);
    }
    
    if ($id == 'expCatCuotas'){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prueba.csv');

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Cantidad,Fecha'.PHP_EOL);
        
        $cadena = "";
        $r=mysqli_query($enlace,"select Cantidad, Fecha from cuotas ORDER BY Fecha DESC"); 
        while ($myrow=mysqli_fetch_array($r)){ 
			for($i = 0; $i < (count($myrow)/2); $i++) {
		    	$cadena = $cadena.$myrow[$i].',';
			}
			
			fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
			$cadena = "";
		}

        fclose($archivo);
    }
    
    if ($id == 'expOficiales'){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prueba.csv');

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Oficial'.PHP_EOL);
        
        $r=mysqli_query($enlace,"select Nombre from expedidorcfi ORDER BY Nombre ASC");  
        while ($myrow=mysqli_fetch_array($r)){ 
			$val = str_replace(",", ".", $myrow[0]);
			fputs($archivo,  $val.PHP_EOL);
		}

        fclose($archivo);
    }
    
    if ($id == 'expEstados'){
        $datos [] = json_decode($_POST["datos"]);
        $cadena = "";
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'País,Estado'.PHP_EOL);

        foreach($datos as $aux) {
		    foreach($aux as $valor) {
		    	foreach($valor as $val) {
		    		$val = str_replace(",", ".", $val);
		    		$cadena = $cadena.$val.',';
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
        fclose($archivo);
    }
    
    if ($id == 'expMunicipios'){
        $datos [] = json_decode($_POST["datos"]);
        $cadena = "";
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'País,Estado,Municipio'.PHP_EOL);

        foreach($datos as $aux) {
		    foreach($aux as $valor) {
		    	foreach($valor as $val) {
		    		$val = str_replace(",", ".", $val);
		    		$cadena = $cadena.$val.',';
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
        fclose($archivo);
    }
    
    if ($id == 'expPuertos'){
        $datos [] = json_decode($_POST["datos"]);
        $cadena = "";
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'País,Estado,Municipio,Puerto de entrada'.PHP_EOL);

        foreach($datos as $aux) {
		    foreach($aux as $valor) {
		    	foreach($valor as $val) {
		    		$val = str_replace(",", ".", $val);
		    		$cadena = $cadena.$val.',';
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
        fclose($archivo);
    }
    
    if ($id == 'expRegimenes'){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prueba.csv');

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Régimen,Código'.PHP_EOL);
        
        $cadena = "";
        $r=mysqli_query($enlace,"select Concepto, Codigo from regimen ORDER BY Concepto ASC"); 
        while ($myrow=mysqli_fetch_array($r)){ 
			for($i = 0; $i < (count($myrow)/2); $i++) {
		    	$val = str_replace(",", ".", $myrow[$i]);
		    	$cadena = $cadena.$val.',';
			}
			fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
			$cadena = "";
		}

        fclose($archivo);
    }
    
    if ($id == 'expTercerias'){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prueba.csv');

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Tercería'.PHP_EOL);
        
        $r=mysqli_query($enlace,"select Nombre from tercerias ORDER BY Nombre ASC"); 
        while ($myrow=mysqli_fetch_array($r)){ 
			$val = str_replace(",", ".", $myrow[0]);
			fputs($archivo,  $val.PHP_EOL);
		}

        fclose($archivo);
    }
    
    if ($id == 'expTefs'){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prueba.csv');

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Nombre,Tercería'.PHP_EOL);
        
        $cadena = "";
        $r=mysqli_query($enlace,"select t.Nombre, ti.Nombre from terceroespecialista as t inner join tercerias as ti on ti.IdTerceria = t.IdTerceria ORDER BY t.Nombre ASC");
        while ($myrow=mysqli_fetch_array($r)){ 
			for($i = 0; $i < (count($myrow)/2); $i++) {
		    	$val = str_replace(",", ".", $myrow[$i]);
		    	$cadena = $cadena.$val.',';
			}
			fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
			$cadena = "";
		}

        fclose($archivo);
    }
    
    if ($id == 'expTipoAportaciones'){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prueba.csv');

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Tipo de aportación,Iva'.PHP_EOL);
        
        $cadena = "";
        $r=mysqli_query($enlace,"select Concepto, Iva from tipoaportacion ORDER BY Concepto ASC");
        while ($myrow=mysqli_fetch_array($r)){ 
			$val = str_replace(",", ".", $myrow[0]);
			if ($myrow[1] == 1){
			    $iva = "si";
			} else{
			    $iva = "No";
			}
			fputs($archivo,  $val.",".$iva.PHP_EOL);
		}

        fclose($archivo);
    }
    
    if ($id == 'expTransporte'){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prueba.csv');

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Transporte'.PHP_EOL);
        
        $cadena = "";
        $r=mysqli_query($enlace,"select Descripcion from transporte ORDER BY Descripcion ASC");
        while ($myrow=mysqli_fetch_array($r)){ 
			$val = str_replace(",", ".", $myrow[0]);
			fputs($archivo,  $val.PHP_EOL);
		}

        fclose($archivo);
    }
    
    if ($id == 'expUsuarios'){
        $datos [] = json_decode($_POST["datos"]);
        $cadena = "";
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Nombre,Correo,Tipo de usuario'.PHP_EOL);

        foreach($datos as $aux) {
		    foreach($aux as $valor) {
		    	foreach($valor as $val) {
		    		$val = str_replace(",", ".", $val);
		    		$cadena = $cadena.$val.',';
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
        fclose($archivo);
    }
    
    if ($id == 'expBitacora'){
        $datos [] = json_decode($_POST["datos"]);
        $cadena = "";
        
        $filename = "prueba.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $archivo = fopen('php://output', 'w');

        fputs($archivo, 'Fecha - Hora,Formulario,Usuario,Descripción,Mensaje'.PHP_EOL);

        foreach($datos as $aux) {
		    foreach($aux as $valor) {
		    	foreach($valor as $val) {
		    		$val = str_replace(",", ".", $val);
		    		$cadena = $cadena.$val.',';
				}
				fputs($archivo,  substr($cadena, 0, strlen ($cadena) - 1).PHP_EOL);
				$cadena = "";
			}
		}
        fclose($archivo);
    }
?>