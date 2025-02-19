<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    include(__DIR__ . '/../core/variables.php');

	if(!isset($_SESSION['descripcion'])) $_SESSION['descripcion'] = null;

    function loginVacio($correo, $password){
		if (strlen(trim($correo)) < 1 || strlen(trim($password)) < 1) {
			return true;
		} else {
			return false;
		}
	}

	function login($correo, $password){
		global $enlace;
	    if (existeEmail($correo)){
	    	$stmt = $enlace->prepare("SELECT u.IdUsuario, u.Nombre, t.Descripcion from usuarios as u inner join tipousuario as t on u.IdTipoUsuario = t.IdTipoUsuario WHERE u.Correo = '".$correo."' and u.Contrasena = MD5('".$password."') LIMIT 1");
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($idUsuario, $nombre, $descripcion);
			$stmt->fetch();
			$rows = $stmt->num_rows;
		
			if ($rows > 0) {
				$_SESSION['idUsuario'] = $idUsuario;
				$_SESSION['nombre'] = $nombre;
				$_SESSION['descripcion'] = $descripcion;
				if ($descripcion == 'Empaque'){
					header("location: Certificados\RepCertificados.php");
				} else{
					header("location: menu.php");
				}
			}
			else{
				$errors = "La contraseña es incorrecta";
			}
		}
		else{
			$errors = "El usuario no existe";
		}
		return $errors;
	}

	function existeEmail($email){
		global $enlace;
		$r=mysqli_query($enlace,"select IdUsuario from usuarios where Correo = '".$email."' LIMIT 1"); 
	    $myrow=mysqli_fetch_array($r);
	    if (@$myrow[0] != ""){
			return true;
		}else{
			return false;
		}
	}

	function getValor($campo, $filtro, $valor){
		global $enlace;
		$stmt = $enlace->prepare("SELECT $campo FROM usuarios WHERE $filtro = '$valor' LIMIT 1");
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;

		if ($num > 0){
			$stmt->bind_result($c);
			$stmt->fetch();
			return $c;
		}else{
			return null;
		}
	}

	function generateTokenPassword($idUsuario){
		global $enlace;

		//$token = generateCode();
		$token = bin2hex(random_bytes(25));

		$stmt = $enlace->prepare("UPDATE usuarios SET CodigoPassword = '$token', SolicitudPassword = 1 WHERE IdUsuario = '$idUsuario'");
		//$stmt->bind_param('ss', $token, $idUsuario);
		$stmt->execute();
		$stmt->close();

		return $token;
	}

	function sendEmail($email, $nombre, $codigo, $idUsuario, $urlTem, $mensaje, $boton, $seguridad){
		require __DIR__ . "/../vendor/autoload.php";
        
        global $correoAwococado;
        global $ContrasenaCorreo;
		global $hostName;
		global $absolutePathAwScripts;

		$template = file_get_contents($urlTem);
        $template = str_replace("nombre_usuario", $nombre, $template);
        $template = str_replace("action_url_1", $absolutePathAwScripts.'Login/cambiarContrasena.php?idUsuario='.$idUsuario.'&token='.$codigo, $template);
        $template = str_replace("year", date('Y'), $template);
        $template = str_replace("operating_system", getOS(), $template);
        $template = str_replace("browser_name", getBrowser(), $template);
        $template = str_replace("mensaje", $mensaje, $template);
        $template = str_replace("boton", $boton, $template);
		$template = str_replace("host_name", $hostName, $template);
        
        if ($seguridad == true){
            $template = str_replace("inicio_comentarios", " ", $template);
            $template = str_replace("final_comentarios", " ", $template);
        } else{
            $template = str_replace("inicio_comentarios", "<!-- ", $template);
            $template = str_replace("final_comentarios", " -->", $template);
        }

		$mail = new PHPMailer(true);
		$mail->CharSet = "UTF-8";
		$mail->SMTPAuth = true;
		$mail->SMTPSecure= 'tls';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->Username = $correoAwococado;
		$mail->Password = $ContrasenaCorreo;

		$mail->setFrom($correoAwococado, 'AWOCOCADO');
		$mail->addAddress($email, $nombre);

		$mail->isHTML(true);
		$mail->Subject = $boton.' - AWOCOCADO';
		$mail->Body = $template;

		///////////////////// Demo email ///////////////////////
		
		if (demoEmail($email, $nombre, $template) == 4){
			return false;
		}

		//////////////////// Password email ////////////////////

		if ($mail->send()){
			return true;
		}else{
			return false;
		}
	}

	function demoEmail($to, $toName, $htmlContent){
		require __DIR__ . "/../vendor/autoload.php";
		global $correoAwococado, $ContrasenaCorreo, $correoDemo;
		$appName = 'AWOCOCADO';
		$message = "<br><br>
            <p>El siguiente correo fue enviado a la dirección <strong>$to</strong> correspondiente a $toName, el ".date("d/m/Y H:i")."</p>
            <br><hr style='border: 2px solid gray;'><br>"
			.$htmlContent;

		$mail = new PHPMailer(true);
		$mail->CharSet = "UTF-8";
		$mail->SMTPAuth = true;
		$mail->SMTPSecure= 'tls';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->Username = $correoAwococado;
		$mail->Password = $ContrasenaCorreo;

		$mail->setFrom($correoAwococado, $appName);
		$mail->addAddress($correoDemo, "Annet");

		$mail->isHTML(true);
		$mail->Subject = "Demo email";
		$mail->Body = $message;

		if ($mail->send()){
			return "1";
		}else{
			return "4";
		}
	}

	function demoFooter(){
		global $hostName;
		global $absolutePathAwScripts;

		$template = file_get_contents($absolutePathAwScripts."templates/emailFooter.php");
		return str_replace("host_name", $hostName, $template);
	}

	function isEmail($email){
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
		}else{
			return false;
		}
	}
	
	function getOS(){
		$user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform  = "Unknown OS Platform";

        $os_array = array(
			  '/windows nt 10/i'      =>  'Windows 10',
	          '/windows nt 6.3/i'     =>  'Windows 8.1',
	          '/windows nt 6.2/i'     =>  'Windows 8',
	          '/windows nt 6.1/i'     =>  'Windows 7',
	          '/windows nt 6.0/i'     =>  'Windows Vista',
	          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
	          '/windows nt 5.1/i'     =>  'Windows XP',
	          '/windows xp/i'         =>  'Windows XP',
	          '/windows nt 5.0/i'     =>  'Windows 2000',
	          '/windows me/i'         =>  'Windows ME',
	          '/win98/i'              =>  'Windows 98',
	          '/win95/i'              =>  'Windows 95',
	          '/win16/i'              =>  'Windows 3.11',
	          '/macintosh|mac os x/i' =>  'Mac OS X',
	          '/mac_powerpc/i'        =>  'Mac OS 9',
	          '/linux/i'              =>  'Linux',
	          '/ubuntu/i'             =>  'Ubuntu',
	          '/iphone/i'             =>  'iPhone',
	          '/ipod/i'               =>  'iPod',
	          '/ipad/i'               =>  'iPad',
	          '/android/i'            =>  'Android',
	          '/blackberry/i'         =>  'BlackBerry',
	          '/webos/i'              =>  'Mobile'
	    );
		foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
	}

	function getBrowser(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        $browser        = "Unknown Browser";

        $browser_array = array(
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }
        return $browser;
    }
    
    function checkTokenPass($idUsuario, $codigo){
		global $enlace;

		$stmt = $enlace->prepare("SELECT SolicitudPassword from usuarios WHERE IdUsuario = '$idUsuario' AND CodigoPassword = '$codigo' LIMIT 1");
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;

		if ($num > 0){
			$stmt->bind_result($solicitud);
			$stmt->fetch();
			if ($solicitud == 1){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function validaPassword($pa1, $pa2){
		if (strcmp($pa1, $pa2) !== 0){
			return false;
		} else{
			return true;
		}
	}
	
	function cambiaPassword($password, $user_id, $token){
		global $enlace;
		
		$r=mysqli_query($enlace,"select CodigoPassword from usuarios where IdUsuario = '$user_id' LIMIT 1"); 
	    $myrow=mysqli_fetch_array($r);
	    if (@$myrow[0] == $token){
            $stmt = $enlace->prepare("UPDATE usuarios SET Contrasena= MD5('$password'), CodigoPassword= '', SolicitudPassword = 0 WHERE IdUsuario = '$user_id' AND CodigoPassword = '$token'");

			if ($stmt->execute()){
				return 1;
			} else{
				return 2;
			}
        } else{
        	return 3;
        }
	}

	function impEmp() {
		if ($_SESSION['descripcion'] == 'Empaque'){
			echo " ";
		} else {
			echo 'impNombre();';
		}
	}

	function impComboEmp() {
	    global $enlace;
	    
		if ($_SESSION['descripcion'] == 'Empaque'){
			$r=mysqli_query($enlace,"select IdEmpacadora from empacadora where IdUsuario = '".$_SESSION['idUsuario']."'"); 
	        $row=mysqli_fetch_array($r);

			echo '<div class="col-12 col-md-5 col-lg-5" style = "display: none;">
	        	<label class=" form-label">Empacadora</label>
	        	<Select id = "empacadoraME" class = "form-select form-select-sm col-12" name="empacadoraME" onChange="actualizarME();" required>
	        	    <option value="'.$row[0].'" selected>'.$_SESSION['nombre'].'</option>
	        	</Select>
	        </div>';
		} else {
			echo '<div class="col-12 col-md-5 col-lg-5">
	        	<label class=" form-label">Empacadora</label>
	        	<Select id = "empacadoraME" class = "form-select form-select-sm col-12" name="empacadoraME" onChange="actualizarME();" required></Select>
	        </div>';
		}
	}

    
    function impMenu($tipoUsuario, $formulario, $carpeta){
    	$menu = array();

    	switch ($tipoUsuario) {
    		///////////////////////////////////////////// contabilidad ////////////////////////////////////////////////////
			case "Contabilidad":
			    //// public
			    if ($carpeta == 'public'){
			    	$menu['1'] = '<li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item py-2" href="Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item py-2" href="CuentasBancarias.php">Cuentas bancarias</a></li>';
	                        $menu['Cuotas'] = '<li><a class="dropdown-item py-2" href="Cuotas.php">Cuotas</a></li>';
	                        $menu['Empacadoras'] = '<li><a class="dropdown-item py-2" href="Empacadoras.php">Empacadoras</a></li>';
	                        $menu['Regimen'] = '<li><a class="dropdown-item py-2" href="Regimen.php">Regímenes</a></li>';
	                        $menu['TipoAportaciones'] = '<li><a class="dropdown-item py-2" href="TipoAportaciones.php">Tipo de aportaciones</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Ingresos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['FacturasAporta'] = '<li><a class="dropdown-item py-2" href="FacturasAporta\FacturasAporta.php">Facturas empacadoras</a></li>';
	                        $menu['CobrosAportaciones'] = '<li><a class="dropdown-item py-2" href="Cobros\CobrosAportaciones.php">Cobros a empacadoras</a></li>';
	                        $menu['ReportesIngresos'] = '<li><a class="dropdown-item py-2" href="Ingresos\ReportesIngresos.php">Reportes de ingresos</a></li>';

	                    $menu['3'] = '</ul>
	                </li>';

	                $menu['RepAportaciones'] = '<li class="nav-item">
	                    <a class="nav-link px-3 text-dark" href="Aportaciones\RepAportaciones.php">Reporte de aportaciones</a>
	                </li>';

	                $menu['5'] = '<li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Login/salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// principal
			    if ($carpeta == 'principal'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="menu.php">Menú principal</a>
	                </li>

			    	<li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item py-2" href="Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item py-2" href="CuentasBancarias.php">Cuentas bancarias</a></li>';
	                        $menu['Cuotas'] = '<li><a class="dropdown-item py-2" href="Cuotas.php">Cuotas</a></li>';
	                        $menu['Empacadoras'] = '<li><a class="dropdown-item py-2" href="Empacadoras.php">Empacadoras</a></li>';
	                        $menu['Regimen'] = '<li><a class="dropdown-item py-2" href="Regimen.php">Regímenes</a></li>';
	                        $menu['TipoAportaciones'] = '<li><a class="dropdown-item py-2" href="TipoAportaciones.php">Tipo de aportaciones</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Ingresos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['FacturasAporta'] = '<li><a class="dropdown-item py-2" href="FacturasAporta\FacturasAporta.php">Facturas empacadoras</a></li>';
	                        $menu['CobrosAportaciones'] = '<li><a class="dropdown-item py-2" href="Cobros\CobrosAportaciones.php">Cobros a empacadoras</a></li>';
	                        $menu['ReportesIngresos'] = '<li><a class="dropdown-item py-2" href="Ingresos\ReportesIngresos.php">Reportes de ingresos</a></li>';

	                    $menu['3'] = '</ul>
	                </li>';

	                $menu['RepAportaciones'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="Aportaciones\RepAportaciones.php">Reporte de aportaciones</a>
	                </li>';

	                $menu['5'] = '<li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Login/salir.php">Cerrar sesión</a>
                    </li>';
			    }
			    
			    ///// cobros
			    if ($carpeta == 'cobros'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item py-2" href="..\Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item py-2" href="..\CuentasBancarias.php">Cuentas bancarias</a></li>';
	                        $menu['Cuotas'] = '<li><a class="dropdown-item py-2" href="..\Cuotas.php">Cuotas</a></li>';
	                        $menu['Empacadoras'] = '<li><a class="dropdown-item py-2" href="..\Empacadoras.php">Empacadoras</a></li>';
	                        $menu['Regimen'] = '<li><a class="dropdown-item py-2" href="..\Regimen.php">Regímenes</a></li>';
	                        $menu['TipoAportaciones'] = '<li><a class="dropdown-item py-2" href="..\TipoAportaciones.php">Tipo de aportaciones</a></li>';

	                        $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Ingresos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['FacturasAporta'] = '<li><a class="dropdown-item py-2" href="..\FacturasAporta\FacturasAporta.php">Facturas empacadoras</a></li>';
	                        $menu['CobrosAportaciones'] = '<li><a class="dropdown-item py-2" href="CobrosAportaciones.php">Cobros a empacadoras</a></li>';
	                        $menu['ReportesIngresos'] = '<li><a class="dropdown-item py-2" href="..\Ingresos\ReportesIngresos.php">Reportes de ingresos</a></li>';

	                    $menu['3'] = '</ul>
	                </li>';

	                $menu['RepAportaciones'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\Aportaciones\RepAportaciones.php">Reporte de aportaciones</a>
	                </li>';

	                $menu['5'] = '<li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// facturas aporta
			    if ($carpeta == 'facturasAporta'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item py-2" href="..\Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item py-2" href="..\CuentasBancarias.php">Cuentas bancarias</a></li>';
	                        $menu['Cuotas'] = '<li><a class="dropdown-item py-2" href="..\Cuotas.php">Cuotas</a></li>';
	                        $menu['Empacadoras'] = '<li><a class="dropdown-item py-2" href="..\Empacadoras.php">Empacadoras</a></li>';
	                        $menu['Regimen'] = '<li><a class="dropdown-item py-2" href="..\Regimen.php">Regímenes</a></li>';
	                        $menu['TipoAportaciones'] = '<li><a class="dropdown-item py-2" href="..\TipoAportaciones.php">Tipo de aportaciones</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Ingresos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['FacturasAporta'] = '<li><a class="dropdown-item py-2" href="FacturasAporta.php">Facturas empacadoras</a></li>';
	                        $menu['CobrosAportaciones'] = '<li><a class="dropdown-item py-2" href="..\Cobros\CobrosAportaciones.php">Cobros a empacadoras</a></li>';
	                        $menu['ReportesIngresos'] = '<li><a class="dropdown-item py-2" href="..\Ingresos\ReportesIngresos.php">Reportes de ingresos</a></li>';

	                    $menu['3'] = '</ul>
	                </li>';

	                $menu['RepAportaciones'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\Aportaciones\RepAportaciones.php">Reporte de aportaciones</a>
	                </li>';

	                    $menu['5'] = '<li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// aportaciones
			    if ($carpeta == 'aportaciones'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item py-2" href="..\Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item py-2" href="..\CuentasBancarias.php">Cuentas bancarias</a></li>';
	                        $menu['Cuotas'] = '<li><a class="dropdown-item py-2" href="..\Cuotas.php">Cuotas</a></li>';
	                        $menu['Empacadoras'] = '<li><a class="dropdown-item py-2" href="..\Empacadoras.php">Empacadoras</a></li>';
	                        $menu['Regimen'] = '<li><a class="dropdown-item py-2" href="..\Regimen.php">Regímenes</a></li>';
	                        $menu['TipoAportaciones'] = '<li><a class="dropdown-item py-2" href="..\TipoAportaciones.php">Tipo de aportaciones</a></li>';

	                     $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Ingresos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['FacturasAporta'] = '<li><a class="dropdown-item py-2" href="..\FacturasAporta\FacturasAporta.php">Facturas empacadoras</a></li>';
	                        $menu['CobrosAportaciones'] = '<li><a class="dropdown-item py-2" href="..\Cobros\CobrosAportaciones.php">Cobros a empacadoras</a></li>';
	                        $menu['ReportesIngresos'] = '<li><a class="dropdown-item py-2" href="..\Ingresos\ReportesIngresos.php">Reportes de ingresos</a></li>';

	                    $menu['3'] = '</ul>
	                </li>';

	                $menu['RepAportaciones'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="RepAportaciones.php">Reporte de aportaciones</a>
	                </li>';

	                $menu['5'] = '<li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// ingresos
			    if ($carpeta == 'ingresos'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item py-2" href="..\Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item py-2" href="..\CuentasBancarias.php">Cuentas bancarias</a></li>';
	                        $menu['Cuotas'] = '<li><a class="dropdown-item py-2" href="..\Cuotas.php">Cuotas</a></li>';
	                        $menu['Empacadoras'] = '<li><a class="dropdown-item py-2" href="..\Empacadoras.php">Empacadoras</a></li>';
	                        $menu['Regimen'] = '<li><a class="dropdown-item py-2" href="..\Regimen.php">Regímenes</a></li>';
	                        $menu['TipoAportaciones'] = '<li><a class="dropdown-item py-2" href="..\TipoAportaciones.php">Tipo de aportaciones</a></li>';

	                        $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Ingresos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['FacturasAporta'] = '<li><a class="dropdown-item py-2" href="..\FacturasAporta\FacturasAporta.php">Facturas empacadoras</a></li>';
	                        $menu['CobrosAportaciones'] = '<li><a class="dropdown-item py-2" href="..\Cobros\CobrosAportaciones.php">Cobros a empacadoras</a></li>';
	                        $menu['ReportesIngresos'] = '<li><a class="dropdown-item py-2" href="ReportesIngresos.php">Reportes de ingresos</a></li>';

	                    $menu['3'] = '</ul>
	                </li>';

	                $menu['RepAportaciones'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\Aportaciones\RepAportaciones.php">Reporte de aportaciones</a>
	                </li>';

	                $menu['5'] = '<li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }
			    break;

			    ////////////////////////////////////////// administrador ////////////////////////////////////////

			case "Administrador":
			    ///// public
			    if ($carpeta == 'public'){
			    	$menu['1'] = '<li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item" href="Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item" href="CuentasBancarias.php">Cuentas bancarias</a></li>';
                            $menu['Cuotas'] = '<li><a class="dropdown-item" href="Cuotas.php">Cuotas</a></li>';
                            $menu['Empacadoras'] = '<li><a class="dropdown-item" href="Empacadoras.php">Empacadoras</a></li>';
                            $menu['Estados'] = '<li><a class="dropdown-item" href="Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item" href="Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item" href="Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item" href="Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item" href="Puertos.php">Puertos de entrada</a></li>';
                            $menu['Regimen'] = '<li><a class="dropdown-item" href="Regimen.php">Regímenes</a></li>';
                            $menu['Tercerias'] = '<li><a class="dropdown-item" href="Tercerias.php">Tercerías</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item" href="TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            $menu['TipoAportaciones'] = '<li><a class="dropdown-item" href="TipoAportaciones.php">Tipo de aportaciones</a></li>';
                            $menu['Transporte'] = '<li><a class="dropdown-item" href="Transporte.php">Transportes</a></li>';
                            $menu['Usuarios'] = '<li><a class="dropdown-item" href="Usuarios.php">Usuarios</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Movimientos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Certificados'] = '<li><a class="dropdown-item" href="Certificados\Certificados.php">Certificados</a></li>';
                            $menu['CobrosAportaciones'] = '<li><a class="dropdown-item" href="Cobros\CobrosAportaciones.php">Cobros a empacadoras</a></li>';
                            $menu['FacturasAporta'] = '<li><a class="dropdown-item" href="FacturasAporta\FacturasAporta.php">Facturas empacadoras</a></li>';

	                    $menu['3'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Reportes</button>
	                    <ul class="dropdown-menu">';


                            $menu['RepAportaciones'] = '<li><a class="dropdown-item" href="Aportaciones\RepAportaciones.php">Aportaciones</a></li>';
	                        $menu['RepCertificados'] = '<li><a class="dropdown-item" href="Certificados\RepCertificados.php">Certificados</a></li>';
                            $menu['ReportesIngresos'] = '<li><a class="dropdown-item" href="Ingresos\ReportesIngresos.php">Ingresos</a></li>';

	                    $menu['4'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link px-3 text-dark" href="Utilerias.php">Utilerías</a>
	                </li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Login/salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// principal
			    if ($carpeta == 'principal'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item" href="Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item" href="CuentasBancarias.php">Cuentas bancarias</a></li>';
                            $menu['Cuotas'] = '<li><a class="dropdown-item" href="Cuotas.php">Cuotas</a></li>';
                            $menu['Empacadoras'] = '<li><a class="dropdown-item" href="Empacadoras.php">Empacadoras</a></li>';
                            $menu['Estados'] = '<li><a class="dropdown-item" href="Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item" href="Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item" href="Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item" href="Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item" href="Puertos.php">Puertos de entrada</a></li>';
                            $menu['Regimen'] = '<li><a class="dropdown-item" href="Regimen.php">Regímenes</a></li>';
                            $menu['Tercerias'] = '<li><a class="dropdown-item" href="Tercerias.php">Tercerías</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item" href="TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            $menu['TipoAportaciones'] = '<li><a class="dropdown-item" href="TipoAportaciones.php">Tipo de aportaciones</a></li>';
                            $menu['Transporte'] = '<li><a class="dropdown-item" href="Transporte.php">Transportes</a></li>';
                            $menu['Usuarios'] = '<li><a class="dropdown-item" href="Usuarios.php">Usuarios</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Movimientos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Certificados'] = '<li><a class="dropdown-item" href="Certificados\Certificados.php">Certificados</a></li>';
                            $menu['CobrosAportaciones'] = '<li><a class="dropdown-item" href="Cobros\CobrosAportaciones.php">Cobros a empacadoras</a></li>';
                            $menu['FacturasAporta'] = '<li><a class="dropdown-item" href="FacturasAporta\FacturasAporta.php">Facturas empacadoras</a></li>';

	                    $menu['3'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Reportes</button>
	                    <ul class="dropdown-menu">';

                            $menu['RepAportaciones'] = '<li><a class="dropdown-item" href="Aportaciones\RepAportaciones.php">Aportaciones</a></li>';
	                        $menu['RepCertificados'] = '<li><a class="dropdown-item" href="Certificados\RepCertificados.php">Certificados</a></li>';
                            $menu['ReportesIngresos'] = '<li><a class="dropdown-item" href="Ingresos\ReportesIngresos.php">Ingresos</a></li>';

	                    $menu['4'] = '</ul>
	                </li>';
	                $menu['Utilerias'] = '<li class="nav-item">
	                    <a class="nav-link px-3 text-dark" href="Utilerias.php">Utilerías</a>
	                </li>';
	                $menu['5'] = '<li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Login/salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// cobros
			    if ($carpeta == 'cobros'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item" href="..\Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item" href="..\CuentasBancarias.php">Cuentas bancarias</a></li>';
                            $menu['Cuotas'] = '<li><a class="dropdown-item" href="..\Cuotas.php">Cuotas</a></li>';
                            $menu['Empacadoras'] = '<li><a class="dropdown-item" href="..\Empacadoras.php">Empacadoras</a></li>';
                            $menu['Estados'] = '<li><a class="dropdown-item" href="..\Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item" href="..\Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item" href="..\Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item" href="..\Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item" href="..\Puertos.php">Puertos de entrada</a></li>';
                            $menu['Regimen'] = '<li><a class="dropdown-item" href="..\Regimen.php">Regímenes</a></li>';
                            $menu['Tercerias'] = '<li><a class="dropdown-item" href="..\Tercerias.php">Tercerías</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item" href="..\TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            $menu['TipoAportaciones'] = '<li><a class="dropdown-item" href="..\TipoAportaciones.php">Tipo de aportaciones</a></li>';
                            $menu['Transporte'] = '<li><a class="dropdown-item" href="..\Transporte.php">Transportes</a></li>';
                            $menu['Usuarios'] = '<li><a class="dropdown-item" href="..\Usuarios.php">Usuarios</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Movimientos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Certificados'] = '<li><a class="dropdown-item" href="..\Certificados\Certificados.php">Certificados</a></li>';
                            $menu['CobrosAportaciones'] = '<li><a class="dropdown-item" href="CobrosAportaciones.php">Cobros a empacadoras</a></li>';
                            $menu['FacturasAporta'] = '<li><a class="dropdown-item" href="..\FacturasAporta\FacturasAporta.php">Facturas empacadoras</a></li>';

	                    $menu['3'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Reportes</button>
	                    <ul class="dropdown-menu">';

                            $menu['RepAportaciones'] = '<li><a class="dropdown-item" href="..\Aportaciones\RepAportaciones.php">Aportaciones</a></li>';
	                        $menu['RepCertificados'] = '<li><a class="dropdown-item" href="..\Certificados\RepCertificados.php">Certificados</a></li>';
                            $menu['ReportesIngresos'] = '<li><a class="dropdown-item" href="..\Ingresos\ReportesIngresos.php">Ingresos</a></li>';

	                    $menu['4'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link px-3 text-dark" href="..\Utilerias.php">Utilerías</a>
	                </li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// facturas aporta
			    if ($carpeta == 'facturasAporta'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item" href="..\Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item" href="..\CuentasBancarias.php">Cuentas bancarias</a></li>';
                            $menu['Cuotas'] = '<li><a class="dropdown-item" href="..\Cuotas.php">Cuotas</a></li>';
                            $menu['Empacadoras'] = '<li><a class="dropdown-item" href="..\Empacadoras.php">Empacadoras</a></li>';
                            $menu['Estados'] = '<li><a class="dropdown-item" href="..\Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item" href="..\Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item" href="..\Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item" href="..\Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item" href="..\Puertos.php">Puertos de entrada</a></li>';
                            $menu['Regimen'] = '<li><a class="dropdown-item" href="..\Regimen.php">Regímenes</a></li>';
                            $menu['Tercerias'] = '<li><a class="dropdown-item" href="..\Tercerias.php">Tercerías</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item" href="..\TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            $menu['TipoAportaciones'] = '<li><a class="dropdown-item" href="..\TipoAportaciones.php">Tipo de aportaciones</a></li>';
                            $menu['Transporte'] = '<li><a class="dropdown-item" href="..\Transporte.php">Transportes</a></li>';
                            $menu['Usuarios'] = '<li><a class="dropdown-item" href="..\Usuarios.php">Usuarios</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Movimientos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Certificados'] = '<li><a class="dropdown-item" href="..\Certificados\Certificados.php">Certificados</a></li>';
                            $menu['CobrosAportaciones'] = '<li><a class="dropdown-item" href="..\Cobros\CobrosAportaciones.php">Cobros a empacadoras</a></li>';
                            $menu['FacturasAporta'] = '<li><a class="dropdown-item" href="FacturasAporta.php">Facturas empacadoras</a></li>';

	                    $menu['3'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Reportes</button>
	                    <ul class="dropdown-menu">';

                            $menu['RepAportaciones'] = '<li><a class="dropdown-item" href="..\Aportaciones\RepAportaciones.php">Aportaciones</a></li>';
	                        $menu['RepCertificados'] = '<li><a class="dropdown-item" href="..\Certificados\RepCertificados.php">Certificados</a></li>';
                            $menu['ReportesIngresos'] = '<li><a class="dropdown-item" href="..\Ingresos\ReportesIngresos.php">Ingresos</a></li>';

	                    $menu['4'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link px-3 text-dark" href="..\Utilerias.php">Utilerías</a>
	                </li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// certificados
			    if ($carpeta == 'certificados'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item" href="..\Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item" href="..\CuentasBancarias.php">Cuentas bancarias</a></li>';
                            $menu['Cuotas'] = '<li><a class="dropdown-item" href="..\Cuotas.php">Cuotas</a></li>';
                            $menu['Empacadoras'] = '<li><a class="dropdown-item" href="..\Empacadoras.php">Empacadoras</a></li>';
                            $menu['Estados'] = '<li><a class="dropdown-item" href="..\Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item" href="..\Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item" href="..\Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item" href="..\Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item" href="..\Puertos.php">Puertos de entrada</a></li>';
                            $menu['Regimen'] = '<li><a class="dropdown-item" href="..\Regimen.php">Regímenes</a></li>';
                            $menu['Tercerias'] = '<li><a class="dropdown-item" href="..\Tercerias.php">Tercerías</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item" href="..\TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            $menu['TipoAportaciones'] = '<li><a class="dropdown-item" href="..\TipoAportaciones.php">Tipo de aportaciones</a></li>';
                            $menu['Transporte'] = '<li><a class="dropdown-item" href="..\Transporte.php">Transportes</a></li>';
                            $menu['Usuarios'] = '<li><a class="dropdown-item" href="..\Usuarios.php">Usuarios</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Movimientos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Certificados'] = '<li><a class="dropdown-item" href="Certificados.php">Certificados</a></li>';
                            $menu['CobrosAportaciones'] = '<li><a class="dropdown-item" href="..\Cobros\CobrosAportaciones.php">Cobros a empacadoras</a></li>';
                            $menu['FacturasAporta'] = '<li><a class="dropdown-item" href="..\FacturasAporta\FacturasAporta.php">Facturas empacadoras</a></li>';

	                    $menu['3'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Reportes</button>
	                    <ul class="dropdown-menu">';

                            $menu['RepAportaciones'] = '<li><a class="dropdown-item" href="..\Aportaciones\RepAportaciones.php">Aportaciones</a></li>';
	                        $menu['RepCertificados'] = '<li><a class="dropdown-item" href="RepCertificados.php">Certificados</a></li>';
                            $menu['ReportesIngresos'] = '<li><a class="dropdown-item" href="..\Ingresos\ReportesIngresos.php">Ingresos</a></li>';

	                    $menu['4'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link px-3 text-dark" href="..\Utilerias.php">Utilerías</a>
	                </li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// aportaciones
			    if ($carpeta == 'aportaciones'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item" href="..\Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item" href="..\CuentasBancarias.php">Cuentas bancarias</a></li>';
                            $menu['Cuotas'] = '<li><a class="dropdown-item" href="..\Cuotas.php">Cuotas</a></li>';
                            $menu['Empacadoras'] = '<li><a class="dropdown-item" href="..\Empacadoras.php">Empacadoras</a></li>';
                            $menu['Estados'] = '<li><a class="dropdown-item" href="..\Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item" href="..\Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item" href="..\Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item" href="..\Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item" href="..\Puertos.php">Puertos de entrada</a></li>';
                            $menu['Regimen'] = '<li><a class="dropdown-item" href="..\Regimen.php">Regímenes</a></li>';
                            $menu['Tercerias'] = '<li><a class="dropdown-item" href="..\Tercerias.php">Tercerías</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item" href="..\TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            $menu['TipoAportaciones'] = '<li><a class="dropdown-item" href="..\TipoAportaciones.php">Tipo de aportaciones</a></li>';
                            $menu['Transporte'] = '<li><a class="dropdown-item" href="..\Transporte.php">Transportes</a></li>';
                            $menu['Usuarios'] = '<li><a class="dropdown-item" href="..\Usuarios.php">Usuarios</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Movimientos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Certificados'] = '<li><a class="dropdown-item" href="..\Certificados\Certificados.php">Certificados</a></li>';
                            $menu['CobrosAportaciones'] = '<li><a class="dropdown-item" href="..\Cobros\CobrosAportaciones.php">Cobros a empacadoras</a></li>';
                            $menu['FacturasAporta'] = '<li><a class="dropdown-item" href="..\FacturasAporta\FacturasAporta.php">Facturas empacadoras</a></li>';

	                    $menu['3'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Reportes</button>
	                    <ul class="dropdown-menu">';

                            $menu['RepAportaciones'] = '<li><a class="dropdown-item" href="RepAportaciones.php">Aportaciones</a></li>';
	                        $menu['RepCertificados'] = '<li><a class="dropdown-item" href="..\Certificados\RepCertificados.php">Certificados</a></li>';
                            $menu['ReportesIngresos'] = '<li><a class="dropdown-item" href="..\Ingresos\ReportesIngresos.php">Ingresos</a></li>';

	                    $menu['4'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link px-3 text-dark" href="..\Utilerias.php">Utilerías</a>
	                </li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// ingresos
			    if ($carpeta == 'ingresos'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Bancos'] = '<li><a class="dropdown-item" href="..\Bancos.php">Bancos</a></li>';
	                        $menu['CuentasBancarias'] = '<li><a class="dropdown-item" href="..\CuentasBancarias.php">Cuentas bancarias</a></li>';
                            $menu['Cuotas'] = '<li><a class="dropdown-item" href="..\Cuotas.php">Cuotas</a></li>';
                            $menu['Empacadoras'] = '<li><a class="dropdown-item" href="..\Empacadoras.php">Empacadoras</a></li>';
                            $menu['Estados'] = '<li><a class="dropdown-item" href="..\Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item" href="..\Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item" href="..\Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item" href="..\Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item" href="..\Puertos.php">Puertos de entrada</a></li>';
                            $menu['Regimen'] = '<li><a class="dropdown-item" href="..\Regimen.php">Regímenes</a></li>';
                            $menu['Tercerias'] = '<li><a class="dropdown-item" href="..\Tercerias.php">Tercerías</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item" href="..\TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            $menu['TipoAportaciones'] = '<li><a class="dropdown-item" href="..\TipoAportaciones.php">Tipo de aportaciones</a></li>';
                            $menu['Transporte'] = '<li><a class="dropdown-item" href="..\Transporte.php">Transportes</a></li>';
                            $menu['Usuarios'] = '<li><a class="dropdown-item" href="..\Usuarios.php">Usuarios</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Movimientos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Certificados'] = '<li><a class="dropdown-item" href="..\Certificados\Certificados.php">Certificados</a></li>';
                            $menu['CobrosAportaciones'] = '<li><a class="dropdown-item" href="..\Cobros\CobrosAportaciones.php">Cobros a empacadoras</a></li>';
                            $menu['FacturasAporta'] = '<li><a class="dropdown-item" href="..\FacturasAporta\FacturasAporta.php">Facturas empacadoras</a></li>';

	                    $menu['3'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Reportes</button>
	                    <ul class="dropdown-menu">';

                            $menu['RepAportaciones'] = '<li><a class="dropdown-item" href="..\Aportaciones\RepAportaciones.php">Aportaciones</a></li>';
	                        $menu['RepCertificados'] = '<li><a class="dropdown-item" href="..\Certificados\RepCertificados.php">Certificados</a></li>';
                            $menu['ReportesIngresos'] = '<li><a class="dropdown-item" href="ReportesIngresos.php">Ingresos</a></li>';

	                    $menu['4'] = '</ul>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link px-3 text-dark" href="..\Utilerias.php">Utilerías</a>
	                </li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }
			    break;

			    ////////////////////////////////////////// estadística ////////////////////////////////////////

			case "Estadística":
			    /////public
			    if ($carpeta == 'public'){
			    	$menu['1'] = '<li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Cuotas'] = '<li><a class="dropdown-item py-2" href="Cuotas.php">Cuotas</a></li>';
                            $menu['Empacadoras'] = '<li><a class="dropdown-item py-2" href="Empacadoras.php">Empacadoras</a></li>';
                            $menu['Estados'] = '<li><a class="dropdown-item py-2" href="Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item py-2" href="Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item py-2" href="Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item py-2" href="Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item py-2" href="Puertos.php">Puertos de entrada</a></li>';
                            $menu['Tercerias'] = '<li><a class="dropdown-item py-2" href="Tercerias.php">Tercerías</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item py-2" href="TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            $menu['Transporte'] = '<li><a class="dropdown-item py-2" href="Transporte.php">Transportes</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">';

	                        $menu['Certificados'] = '<li><a class="nav-link px-3 text-dark" href="Certificados\Certificados.php">Certificados</a></li>';

	                $menu['3'] = '</li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Reportes</button>
	                    <ul class="dropdown-menu">';

                            $menu['RepAportaciones'] = '<li><a class="dropdown-item py-2" href="Aportaciones\RepAportaciones.php">Aportaciones</a></li>';
	                        $menu['RepCertificados'] = '<li><a class="dropdown-item py-2" href="Certificados\RepCertificados.php">Certificados</a></li>';

	                    $menu['4'] = '</ul>
	                </li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Login/salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    /////principal
			    if ($carpeta == 'principal'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Cuotas'] = '<li><a class="dropdown-item py-2" href="Cuotas.php">Cuotas</a></li>';
                            $menu['Empacadoras'] = '<li><a class="dropdown-item py-2" href="Empacadoras.php">Empacadoras</a></li>';
                            $menu['Estados'] = '<li><a class="dropdown-item py-2" href="Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item py-2" href="Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item py-2" href="Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item py-2" href="Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item py-2" href="Puertos.php">Puertos de entrada</a></li>';
                            $menu['Tercerias'] = '<li><a class="dropdown-item py-2" href="Tercerias.php">Tercerías</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item py-2" href="TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            $menu['Transporte'] = '<li><a class="dropdown-item py-2" href="Transporte.php">Transportes</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">';

	                        $menu['Certificados'] = '<li><a class="nav-link px-3 text-dark" href="Certificados\Certificados.php">Certificados</a></li>';

	                $menu['3'] = '</li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Reportes</button>
	                    <ul class="dropdown-menu">';

                            $menu['RepAportaciones'] = '<li><a class="dropdown-item py-2" href="Aportaciones\RepAportaciones.php">Aportaciones</a></li>';
	                        $menu['RepCertificados'] = '<li><a class="dropdown-item py-2" href="Certificados\RepCertificados.php">Certificados</a></li>';

	                    $menu['4'] = '</ul>
	                </li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Login/salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// certificados
			    if ($carpeta == 'certificados'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Cuotas'] = '<li><a class="dropdown-item py-2" href="..\Cuotas.php">Cuotas</a></li>';
                            $menu['Empacadoras'] = '<li><a class="dropdown-item py-2" href="..\Empacadoras.php">Empacadoras</a></li>';
                            $menu['Estados'] = '<li><a class="dropdown-item py-2" href="..\Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item py-2" href="..\Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item py-2" href="..\Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item py-2" href="..\Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item py-2" href="..\Puertos.php">Puertos de entrada</a></li>';
                            $menu['Tercerias'] = '<li><a class="dropdown-item py-2" href="..\Tercerias.php">Tercerías</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item py-2" href="..\TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            $menu['Transporte'] = '<li><a class="dropdown-item py-2" href="..\Transporte.php">Transportes</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">';

	                        $menu['Certificados'] = '<li><a class="nav-link px-3 text-dark" href="Certificados.php">Certificados</a></li>';

	                $menu['3'] = '</li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Reportes</button>
	                    <ul class="dropdown-menu">';

                            $menu['RepAportaciones'] = '<li><a class="dropdown-item py-2" href="..\Aportaciones\RepAportaciones.php">Aportaciones</a></li>';
	                        $menu['RepCertificados'] = '<li><a class="dropdown-item py-2" href="RepCertificados.php">Certificados</a></li>';

	                    $menu['4'] = '</ul>
	                </li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// aportaciones
			    if ($carpeta == 'aportaciones'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Cuotas'] = '<li><a class="dropdown-item py-2" href="..\Cuotas.php">Cuotas</a></li>';
                            $menu['Empacadoras'] = '<li><a class="dropdown-item py-2" href="..\Empacadoras.php">Empacadoras</a></li>';
                            $menu['Estados'] = '<li><a class="dropdown-item py-2" href="..\Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item py-2" href="..\Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item py-2" href="..\Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item py-2" href="..\Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item py-2" href="..\Puertos.php">Puertos de entrada</a></li>';
                            $menu['Tercerias'] = '<li><a class="dropdown-item py-2" href="..\Tercerias.php">Tercerías</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item py-2" href="..\TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            $menu['Transporte'] = '<li><a class="dropdown-item py-2" href="..\Transporte.php">Transportes</a></li>';

	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">';

	                        $menu['Certificados'] = '<li><a class="nav-link px-3 text-dark" href="..\Certificados\Certificados.php">Certificados</a></li>';

	                $menu['3'] = '</li>
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Reportes</button>
	                    <ul class="dropdown-menu">';

                            $menu['RepAportaciones'] = '<li><a class="dropdown-item py-2" href="RepAportaciones.php">Aportaciones</a></li>';
	                        $menu['RepCertificados'] = '<li><a class="dropdown-item py-2" href="..\Certificados\RepCertificados.php">Certificados</a></li>';

	                    $menu['4'] = '</ul>
	                </li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }
			    break;

			    ////////////////////////////////////////// auxiliar ////////////////////////////////////////

			case "Auxiliar":
			    /////public
			    if ($carpeta == 'public'){
			    	$menu['1'] = '<li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Estados'] = '<li><a class="dropdown-item py-2" href="Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item py-2" href="Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item py-2" href="Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item py-2" href="Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item py-2" href="Puertos.php">Puertos de entrada</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item py-2" href="TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            
	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">';

	                        $menu['Certificados'] = '<li><a class="nav-link px-3 text-dark" href="Certificados\Certificados.php">Certificados</a></li>';

	                $menu['3'] = '</li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Login/salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// principal
			    if ($carpeta == 'principal'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Estados'] = '<li><a class="dropdown-item py-2" href="Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item py-2" href="Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item py-2" href="Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item py-2" href="Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item py-2" href="Puertos.php">Puertos de entrada</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item py-2" href="TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            
	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">';

	                        $menu['Certificados'] = '<li><a class="nav-link px-3 text-dark" href="Certificados\Certificados.php">Certificados</a></li>';

	                $menu['3'] = '</li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="Login/salir.php">Cerrar sesión</a>
                    </li>';
			    }

			    ///// certificados
			    if ($carpeta == 'certificados'){
			    	$menu['1'] = '<li class="nav-item">
	                    <a class="nav-link text-dark px-3" href="..\menu.php">Menú principal</a>
	                </li>
	                
	                <li class="nav-item">
	                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Catálogos</button>
	                    <ul class="dropdown-menu">';

	                        $menu['Estados'] = '<li><a class="dropdown-item py-2" href="..\Estados.php">Estados</a></li>';
                            $menu['Municipio'] = '<li><a class="dropdown-item py-2" href="..\Municipio.php">Municipios</a></li>';
                            $menu['Oficiales'] = '<li><a class="dropdown-item py-2" href="..\Oficiales.php">Oficiales</a></li>';
                            $menu['Pais'] = '<li><a class="dropdown-item py-2" href="..\Pais.php">Países</a></li>';
                            $menu['Puertos'] = '<li><a class="dropdown-item py-2" href="..\Puertos.php">Puertos de entrada</a></li>';
                            $menu['TercerosEspecialistas'] = '<li><a class="dropdown-item py-2" href="..\TercerosEspecialistas.php">Terceros especialistas</a></li>';
                            
	                    $menu['2'] = '</ul>
	                </li>
	                <li class="nav-item">';

	                        $menu['Certificados'] = '<li><a class="nav-link px-3 text-dark" href="Certificados.php">Certificados</a></li>';

	                $menu['3'] = '</li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }
			    break;

			    ////////////////////////////////////////// empaque ////////////////////////////////////////

			case "Empaque":
			    /////public
			    if ($carpeta == 'certificados'){
			    	$menu['1'] = '</li>
	                <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Ayuda.php" target = "_blank">Ayuda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-dark" href="..\Login\salir.php">Cerrar sesión</a>
                    </li>';
			    }
			    break;
		}

		$html = "";
		foreach($menu as $llave => $valor){
			if ($llave != $formulario){
				$html = $html.$valor;
			}
		}

		return $html;
    }
    
    function validarSesion($tipoU, $permisos){
		global $hostName;
    	if (!isset($_SESSION["idUsuario"])){
			header("location: http://$hostName/awococado/");
    	} else{
    		$b = false;
    		foreach($permisos as $valor){
    			if (mb_strtolower($tipoU) == mb_strtolower($valor)){
    				$b = true;
    			}
    		}

    		if ($b == false){
    		    if ($tipoU == "Empaque"){
					header("location: http://$hostName/awococado/Certificados/RepCertificados.php");
    		    } else{
					header("location: http://$hostName/awococado/menu.php");
    		    }
    		}
    	}
    }

	function impPie(){
		$dir = substr(getcwd(), -9);
		if ($dir == "awococado"){
			$url = "Imagenes/Pie.png";
			$urlP = "templates/footer.php";
		} else{
			$url = "../Imagenes/Pie.png";
			$urlP = "../templates/footer.php";
		}
		$anio = date("Y"); 

		$plantilla = file_get_contents($urlP);
		$plantilla = str_replace("url", $url, $plantilla);
		$plantilla = str_replace("anio", $anio, $plantilla);
		echo $plantilla;
	}
?>