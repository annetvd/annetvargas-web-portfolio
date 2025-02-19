<?php
    session_start();
    require "../funciones.php";
    $permisos = ["Administrador", "Auxiliar", "Estadística"];
    validarSesion($_SESSION["descripcion"], $permisos);

    $anio = date("Y");
    $mes = date("m");

    if($mes == 6){
    	$fecha = $anio."-05-01";
    } else{
    	if ($mes <= 5){
    		$fecha = ($anio - 1)."-06-01";
    	} else{
    		$fecha = $anio."-06-01";
    	}
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Certificados</title>
    <meta name charset="utf-8"/>
    <meta name="author" content="Annet Vargas Dueñas" />
    <meta name="viewport" content="width=device-width">

	<!-- Open Graph -->
    <meta property="og:title" content="Awococado: Business Web Application Demo" />
    <meta name="description" property="og:description" content="Awococado is a web application designed to optimize data capture, automate reporting, and provide business insights through statistical graphs and efficient document management." />
    <meta property="og:image" content="<?php echo $url_ogImage; ?>" />
    <meta property="og:site_name" content="annetvargas" />
    <meta property="og:url" content="https://<?php echo $hostName; ?>" />

    <!-- twitter card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Awococado: Business Web Application Demo">
    <meta name="twitter:description" content="Awococado is a web application designed to optimize data capture, automate reporting, and provide business insights through statistical graphs and efficient document management.">
    <meta name="twitter:image" content="<?php echo $url_ogImage; ?>">
    <meta property="og:url" content="https://<?php echo $hostName; ?>" />

	<!-- Docs styles -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"/>
	<link rel="stylesheet" href="../css/index.css"/>
	<!--------- dataTables ----------->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!------------ icono ------------>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

	<link rel="shortcut icon" href="..\Imagenes\icono.ico">
</head>
<body class="bg-light" onload="impTransporte(); impExpedidorCFI(); impTE(); impPais(); impMunicipioO(); impNombre();">
	<script>
		var valido = false;
		const dirScriptsPhp = '<?php echo $absolutePathAwScripts ?>';
		var nombreCsv = "";
		var municipiosO = [], municipiosORe = [], arregloVacio = [];
		const usuario = "<?php echo $_SESSION['nombre']; ?>";
		const tipoUsuario = "<?php echo $_SESSION['descripcion']; ?>";

		document.addEventListener("DOMContentLoaded", () => {
			setDateConsult();
			setTimeout(inicTablaCer, 1000);
		});

		function setDateConsult() {
			let fecha = new Date();
			let primerDia = new Date(fecha.getFullYear(), fecha.getMonth(), 1).toISOString().split("T")[0];
			let ultimoDia = new Date(fecha.getFullYear(), fecha.getMonth() + 1, 0).toISOString().split("T")[0];
			$('#fechaI').val(primerDia);
			$('#fechaF').val(ultimoDia);
		}

		function inicTablaCer() {
			var id = "conCertificados";
		    $('#tablaCertificados').DataTable({
		    	"ajax":{            
			        "url": dirScriptsPhp + "consultar.php", 
			        "method": 'POST',
			        "data": {
			        	id: id,
					    fechaI: function() { return $('#fechaI').val() },
					    fechaF: function() { return $('#fechaF').val() },
					    tipo: function() { return $('#TipoCons').val() }
					}
			    },
		    	"columns": [
					{ "data": "FolioCFI" },
					{ "data": "Empacadora" },
					{ "data": "Fecha" },
					{ "data": "Tipo" },
					{ "data": "ExpedidorCFI" },
					{ "data": "FolioRPV"},
					{ "data": "TE" },
					{ "data": "Terceria" },
					{ "data": "Producto" },
					{ "data": "Variedad" },
					{ "data": "Transporte" },
					{ "data": "Cantidad" },
					{ "data": "Unidad" },
					{ "data": "MunicipioO" },
					{ "data": "Pais" },
					{ "data": "Estado" },
					{ "data": "MunicipioD" },
					{ "data": "Regulacion" },
					{ "data": "Estatus" },
					{ "data": "NumeroCajas" },
					{ "data": "Referencia" },
					{ "data": "Observaciones" },
					{ "data": "Justificacion" },
					{ "data": "IdGrupo" },
					{ "data": "IdContinente" },
					{ "data": "NombreContinente" }
			    ],
			    "columnDefs": [
                    { className: "dt-right", "targets": [11, 19] },
                    { "visible": false, "targets": [23, 24, 25] }
                ],
                order: [[2, 'desc'], [0, 'desc']],
			    fixedHeader: {
                    header: true,
                    headerOffset: $('#barra').height() - 6
                },
                scrollX: true
		    })
		}

		function impTransporte(){
			var imprTransporte = "imprTransporte";
		    var transp = document.getElementById("transporte").value;
		    var transpM = document.getElementById("divCancelar").style.display;

			var parametros = {
				"id" : imprTransporte
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	if(transp == ""){
		            	$("#transporte").html(response);
		            } 
			        if (transpM == "none"){
	            	    $("#transporteRe").html(response);
	            	}
	            }
	        });
		}

		function impTE(){
		    var TE = document.getElementById("TE").value;
		    var TERe = document.getElementById("divCancelar").style.display;

			var parametros = {
				"id" : "impTE"
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	if(TE == ""){
		            	$("#TE").html(response);
		            } 
			        if (TERe == "none"){
	            	    $("#TERe").html(response);
	            	}
	            }
	        });
		}

		function impExpedidorCFI(){
			var expedidor = "impExpedidorCFI";
			var exp = document.getElementById("expedidorCFI").value; 
			var expM = document.getElementById("divCancelar").style.display;

			var parametros = {
				"id" : expedidor
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	if(exp == ""){
	            	    $("#expedidorCFI").html(response);
		            }
		            if (expM == "none"){
	            	    $("#expedidorCFIRe").html(response);
	            	}
	            }
	        });
		}

		function impMunicipioRR(estado, municipio, regulacion){
	        if ($("#" + estado).val() != ""){
		        var parametros = {
					"id" : "municipios",
					"idEstado" : $("#" + estado).val()
				}

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (response) {
		            	$("#" + municipio).html(response);
		            	$("#" + regulacion).html('<option value="" selected>...</option>');
		            }
		        });
		    } else{
		        $("#" + municipio + ", #" + regulacion).html('<option value="" selected>...</option>');
		    }
		}

		function impMunicipioO(){
			var mun = document.getElementById("municipioO").value; 
			var munpioM = document.getElementById("divCancelar").style.display;

			var parametros = {
				"id" : "municipiosO"
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	if(mun == ""){
	            	    $("#municipioO").html(response);
		            }
		            if (munpioM == "none"){
		            	$("#municipioORe").html(response);
	            	}
	            }
	        });
		}

		function impPais(){
			var pais = "impPais";
			var cPais = document.getElementById("pais").value; 
			var cPaisM = document.getElementById("divCancelar").style.display;

			var parametros = {
				"id" : pais
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	if(cPais == ""){
	            	    $("#pais").html(response);
		            }
		            if (cPaisM == "none"){
	            	    $("#paisRe").html(response);
	            	}
	            }
	        });
		}

		function impEstadoRR(pais, estado, municipio, regulacion){
		    if ($("#" + pais).val() != ""){
		        var parametros = {
					"id" : "impEstado",
					"pais" : $("#" + pais).val()
				}

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (response) {
		            	$("#" + estado).html(response);
		            	$("#" + municipio + ", #" + regulacion).html('<option value="" selected>...</option>');
		            }
		        });
		    } else{
		        $("#" + estado + ", #" + municipio + ", #" + regulacion).html('<option value="" selected>...</option>');
		    }
		}

		function impNombre(){
			var empacadoras = "empacadoras";
			var emp = document.getElementById("empacadoraRC").value; 
			var empRe = document.getElementById("divCancelar").style.display;

			var parametros = {
				"id" : empacadoras
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	if(emp == ""){
	            	    $("#empacadoraRC").html(response);
		            }
	            }
	        });

	        if (empRe == "none"){
		        document.getElementById('formularioRe').reset();	
                municipiosORe.splice(0, municipiosORe.length);
                $("#tMunicipiosORe").html(llenarTabla(municipiosORe));
		        document.getElementById('reemplazarB').disabled = true;
		        $("#regulacionRe").html('<option value="" selected>...</option>');
		        $("#estadoRe").html('<option value="" selected>...</option>');
		        $("#municipioDRe").html('<option value="" selected>...</option>');
	        }
		}

		function impRegulacionRR(mun, regulacion){
			if ($("#" + mun).val() != ""){
				var imprRegulacion = "imprRegulacion";
				var municipio = document.getElementById(mun).value;

				var parametros = {
					"id" :imprRegulacion,
					"municipio" : municipio
				}

				$.ajax({
					data: parametros,
					url: dirScriptsPhp + 'consultar.php',
					type: "post",
					success: function (response) {
						$("#" + regulacion).html(response);
					}
				});
			} else{
				$("#" + regulacion).html('<option value="" selected>...</option>');
			}
		}

		function impEmpacadoraR() {
			var obtDatosEmp = "obtDatosEmp";
			var empacadora = document.getElementById("empacadoraRC").value;
			var nomEmpa = document.getElementById("empacadoraRC").options[document.getElementById("empacadoraRC").selectedIndex].text;

			$("#folioCFI, #tipo, #expedidorCFI, #folioRPV, #terceria, #TE, #producto, #variedad, #municipioO, #cantidad, #unidad, #cajas, #transporte, #observaciones, #fecha, #pais, #estado, #municipioD, #regulacion").val('');
	        $("#regulacion").html('<option value="" selected>...</option>');
	        $("#estado").html('<option value="" selected>...</option>');
	        $("#municipioD").html('<option value="" selected>...</option>');

			if (nomEmpa == "..."){
		        document.getElementById('formularioR').reset();	
				document.getElementById("folioCFI").disabled = true;
				document.getElementById('tipo').disabled = true;
				document.getElementById('expedidorCFI').disabled = true;
				document.getElementById('folioRPV').disabled = true;
				document.getElementById('TE').disabled = true;
				document.getElementById('producto').disabled = true;
				document.getElementById('variedad').disabled = true;
				document.getElementById('municipioO').disabled = true;
				document.getElementById('cantidad').disabled = true;
				document.getElementById('unidad').disabled = true;
				document.getElementById('cajas').disabled = true;
				document.getElementById('transporte').disabled = true;
				document.getElementById('observaciones').disabled = true;
				document.getElementById('fecha').disabled = true;
				document.getElementById('pais').disabled = true;
				document.getElementById('estado').disabled = true;
				document.getElementById('municipioD').disabled = true;
				document.getElementById('regulacion').disabled = true;
			}else{
				var parametros = {
					"id" : obtDatosEmp,
					"empacadora" : empacadora
					
				}
				
				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            dataType: "json",
		            success:  function (response) {
		            	rellEmpR(response.result.RFC, response.result.Direccion, response.result.Correo, response.result.CP, response.result.Telefono, response.result.Municipio, response.result.IdEmpacadora);
		            }
		        });
			}
		}

		function rellEmpR(RFC, direc, corr, CP, tel, muni, idEmp){
			document.getElementById("RFCRC").value = RFC;
			document.getElementById("direccionRC").value = direc;
			document.getElementById("municipioRC").value = muni;
			document.getElementById("correoRC").value = corr;
			document.getElementById("CPRC").value = CP;
			document.getElementById("telefonoRC").value = tel;
			document.getElementById("idEmpacadoraRC").value = idEmp;

			document.getElementById("folioCFI").disabled = false;
			document.getElementById('tipo').disabled = false;
			document.getElementById('expedidorCFI').disabled = false;
			document.getElementById('folioRPV').disabled = false;
			document.getElementById('TE').disabled = false;
			document.getElementById('producto').disabled = false;
			document.getElementById('variedad').disabled = false;
			document.getElementById('municipioO').disabled = false;
			document.getElementById('cantidad').disabled = false;
			document.getElementById('unidad').disabled = false;
			document.getElementById('cajas').disabled = false;
			document.getElementById('transporte').disabled = false;
			document.getElementById('fecha').disabled = false;
			document.getElementById('pais').disabled = false;
			document.getElementById('estado').disabled = false;
			document.getElementById('municipioD').disabled = false;
			document.getElementById('regulacion').disabled = false;
			document.getElementById('observaciones').disabled = false;
		}

		function consultar() {
            if ($.fn.DataTable.isDataTable("#tablaCertificados")) {
                $.ajax({
	                success:  function () {
	                    $("#tablaCertificados").DataTable().ajax.reload(null, false);
	                }
	            });
            } else {
                setTimeout(consutar, 1000);
            }
		}

		function validar (){
			var formulario = document.getElementById('formularioR');
			valido = formulario.checkValidity();
		}

		function validarCan (){
			var formulario = document.getElementById('formularioCan');
			valido = formulario.checkValidity();
		}

		function validarRe (){
			var formulario = document.getElementById('formularioRe');
			valido = formulario.checkValidity();
		}

		function registrar (){
			var folioCFI = document.getElementById("folioCFI").value;
			var formData = new FormData();
			formData.append("id", "certificados");
			formData.append("folioCFI", folioCFI);
			formData.append("tipo", document.getElementById('tipo').value);
			formData.append("expedidorCFI", document.getElementById('expedidorCFI').value);
			formData.append("folioRPV", document.getElementById('folioRPV').value);
			formData.append("TE", document.getElementById('TE').value);
			formData.append("producto", document.getElementById('producto').value);
			formData.append("variedad", document.getElementById('variedad').value);
			formData.append("cantidad", document.getElementById('cantidad').value);
			formData.append("unidad", document.getElementById('unidad').value);
			formData.append("cajas", document.getElementById('cajas').value);
			formData.append("transporte", document.getElementById('transporte').value);
			formData.append("observaciones", document.getElementById('observaciones').value);
			formData.append("fecha", document.getElementById('fecha').value);
			formData.append("pais", document.getElementById('pais').value);
			formData.append("estado", document.getElementById('estado').value);
			formData.append("municipioD", document.getElementById('municipioD').value);
			formData.append("regulacion", document.getElementById('regulacion').value);
			formData.append("idEmpacadora", document.getElementById('idEmpacadoraRC').value);
			formData.append("municipioO", JSON.stringify(municipiosO));
			formData.append("usuario", usuario);

			$.ajax({
	            url: dirScriptsPhp + 'registrar.php',
	            type: 'POST',
			    data: formData,
			    processData: false, 
			    contentType: false,
	            success:  function (response) {
	                if(response[0] == "1"){
	            		$("#registro").html("El certificado con folio CFI <i>"+folioCFI+"</i> ha sido guardado correctamente");
	            	    $("#titulo").html("Registro exitoso");
	            	    document.getElementById('formularioR').reset();
		                impTransporte(); 
		                impExpedidorCFI(); 
		                impTE();
		                impMunicipioO();
		                impPais();  
		                impNombre();
		                inhabilitarR();
		                municipiosO.splice(0, municipiosO.length);
		                $("#tMunicipiosO").html(llenarTabla(municipiosO));
	            	} else {
	            		if(response[0] == "2"){
	            			$("#registro").html("No es posible registrar el certificado con folio CFI <i>"+folioCFI+"</i>, este ya existe");
	            	        $("#titulo").html("Folio existente");
	            		} else {
	            			$("#registro").html("El certificado con folio CFI <i>"+folioCFI+"</i> no se ha podido registrar");
	            	        $("#titulo").html("Ha ocurrido un error");
	            		}
	            	}
	                $("#abrirmodal").trigger("click");
	            }
	        });
	    }

	    function inhabilitarR(){
	    	document.getElementById("folioCFI").disabled = true;
			document.getElementById('tipo').disabled = true;
			document.getElementById('expedidorCFI').disabled = true;
			document.getElementById('folioRPV').disabled = true;
			document.getElementById('TE').disabled = true;
			document.getElementById('producto').disabled = true;
			document.getElementById('variedad').disabled = true;
			document.getElementById('municipioO').disabled = true;
			document.getElementById('cantidad').disabled = true;
			document.getElementById('unidad').disabled = true;
			document.getElementById('cajas').disabled = true;
			document.getElementById('transporte').disabled = true;
			document.getElementById('observaciones').disabled = true;
			document.getElementById('fecha').disabled = true;
			document.getElementById('pais').disabled = true;
			document.getElementById('estado').disabled = true;
			document.getElementById('municipioD').disabled = true;
			document.getElementById('regulacion').disabled = true;
	    }

		function confirmar(){
			if(valido == true ){
				if (municipiosO.length != 0){
					$.ajax({
			            success:  function () {
			            	$("#abrirmodalC").trigger("click");
			            }
			        });

			    } else{
					$("#municipioO").focus();
				}
			}
		}

		function confirmarC(){
			if(valido == true ){
				$.ajax({
		            success:  function () {
		            	$("#abrirmodalCan").trigger("click");
		            }
		        });
			}
		}

		function confirmarRe(){
			if(valido == true ){
				if (municipiosORe.length != 0){
					var folioCFI = document.getElementById("folioCFINRe").value;
					var busquedaRe = "busquedaRe";

					var parametros = {
						"id" : busquedaRe,
						"folioCFI" : folioCFI
					}

					$.ajax({
						data: parametros,
						url: dirScriptsPhp + 'consultar.php',
						type: "post",
				        dataType: "json",
						success: function (response) {
						    if ($("#estatusRe").val() == "Reemplazo" && !Number($("#folioCFINRe").val())){
						        $("#registro").html("Los certificados de reemplazo no pueden tener un folio de tipo modificación");
			            	    $("#titulo").html("El folio de reemplazo no puede contener letras");
			            	    $("#abrirmodal").trigger("click");
						    } else{
						        if(response == "2"){
								    if ($("#estatusRe").val() == "Original" && !(tipoUsuario == "Administrador" || tipoUsuario == "Estadística")){
								        $("#registro").html("Su tipo de usuario no tiene permiso para realizar modificaciones");
				            	        $("#titulo").html("Acción denegada");
				            	        $("#abrirmodal").trigger("click");
								    } else{
								        if ($("#estatusRe").val() == "Original"){
								            confirmarM(folioCFI);
								        } else{
								            $("#abrirmodalRe").trigger("click");
								        }
								    }
				            	} else {
				            	    $("#registro").html("El certificado con folio CFI <i>"+folioCFI+"</i> ya está registrado");
				            	    $("#titulo").html("Acción denegada");
				            	    $("#abrirmodal").trigger("click");
				            	}
						    }
						}
					})
				} else{
					$("#municipioORe").focus();
				}
			}
		}
		
		function confirmarM(folio){
		    var parametros = {
				"id" : "confirmarRe",
				"folioCFI" : folio
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	                if(response == "2"){
	                    $("#registro").html("Actualmente, el certificado original con folio CFI <i>"+folio.substring(0, folio.length - 1)+"</i> ya llegó al limite de modificaciones permitidas");
				        $("#titulo").html("Acción denegada");
				        $("#abrirmodal").trigger("click");
	                } else{
	                    $("#abrirmodalRe").trigger("click");
	                }
	            }
	        });
		}

		function limpiarCan(){
			var folioCFI = document.getElementById("folioCFIC").value;
            document.getElementById('formularioCan').reset();
            $("#tMunicipiosOC").html(llenarTabla(arregloVacio));
			document.getElementById("cancelarB").disabled = true;
			document.getElementById("justificacionC").disabled = true;
            document.getElementById("folioCFIC").value = folioCFI;
		}

		function buscarC(){
			if (valido == true){
				var folioCFI = document.getElementById("folioCFIC").value;
				var busquedaC = "busquedaC";
	            document.getElementById('formularioCan').reset();
	            $("#tMunicipiosOC").html(llenarTabla(arregloVacio));
				document.getElementById("cancelarB").disabled = true;
				document.getElementById("justificacionC").disabled = true;
	            document.getElementById("folioCFIC").value = folioCFI;

				var parametros = {
					"id" :busquedaC,
					"folioCFI" : folioCFI
				}

				$.ajax({
					data: parametros,
					url: dirScriptsPhp + 'consultar.php',
					type: "post",
			        dataType: "json",
					success: function (response) {
						if(response == "2"){
		            		$("#registro").html("El certificado con folio CFI <i>"+folioCFI+"</i> no está registrado");
		            	    $("#titulo").html("Folio inexistente");
		            	    $("#abrirmodal").trigger("click");
		            	} else {
		            		if (response.result.Estatus == "Cancelado"){
		            			$("#registro").html("El certificado con folio CFI <i>"+folioCFI+"</i> actualmente ya está cancelado");
		            	        $("#titulo").html("Acción denegada");
		            	        $("#abrirmodal").trigger("click");
		            		} else{
		            			if (response.result.Estatus == "Reemplazo"){
			            			$("#registro").html("El certificado con folio CFI <i>"+folioCFI+"</i> actualmente es un certificado de reempazo");
			            	        $("#titulo").html("Acción denegada");
			            	        $("#abrirmodal").trigger("click");
			            		} else{
			            			rellenarC(response.result.Empacadora, response.result.Tipo, response.result.FolioRPV, response.result.ExpedidorCFI, response.result.TE, response.result.Terceria, response.result.Producto, response.result.Variedad, response.result.Cantidad, response.result.NumeroCajas, response.result.Unidad, response.result.Estatus, response.result.Fecha, response.result.Pais, response.result.Estado, response.result.MunicipioD, response.result.Regulacion, response.result.Transporte, response.result.Observaciones, response.result.Municipios);
			            		}
		            		} 
		            	}
					}
				})
			}
		}

		function rellenarC(emp, tipo, RPV, eCFI, TE, ter, prod, vardd, cant, cajas, unid, estt, fech, pais, est, mpioD, reg, transp, obs, mpioO){
			var arreglo = [];

			document.getElementById("empacadoraC").value = emp;
			document.getElementById("tipoC").value = tipo;
			document.getElementById("folioRPVC").value = RPV;
			document.getElementById("expedidorCFIC").value = eCFI;
			document.getElementById("terceriaC").value = ter;
			document.getElementById("TEC").value = TE;
			document.getElementById("productoC").value = prod;
			document.getElementById("variedadC").value = vardd;
			document.getElementById("cantidadC").value = cant;
			document.getElementById("cajasC").value = cajas;
			document.getElementById("unidadC").value = unid;
			document.getElementById("estatusC").value = estt;
			document.getElementById("fechaC").value = fech;
			document.getElementById("paisC").value = pais;
			document.getElementById("regulacionC").value = reg;
			document.getElementById("estadoC").value = est;
			document.getElementById("municipioDC").value = mpioD;
			document.getElementById("observacionesC").value = obs;
			document.getElementById("transporteC").value = transp;
			document.getElementById("cancelarB").disabled = false;
			document.getElementById("justificacionC").disabled = false;

            for (var x = 0; x < mpioO.length; x++){
            	Object.entries(mpioO[x]).forEach(([key, value]) => {
					arreglo[x] = [x, value];
				});
            }

			$("#tMunicipiosOC").html(llenarTabla(arreglo));
		}

		function cancelarE(){
			var folioCFI = document.getElementById("folioCFIC").value;
			var modEstatusCan = "modEstatusCan";

			var parametros = {
				"id" : modEstatusCan,
				"folioCFI" : folioCFI,
				"justificacion" : $("#justificacionC").val(),
				"usuario" : usuario
			}

			$.ajax({
				data: parametros,
				url: dirScriptsPhp + 'registrar.php',
				type: "post",
				success: function (response) {
					if(response[0] == "1"){
	            		$("#registro").html("El certificado con folio CFI <i>"+folioCFI+"</i> ha sido cancelado correctamente");
	            	    $("#titulo").html("Cancelación exitosa");
	            	} else {
	            	    $("#registro").html("El certificado con folio CFI <i>"+folioCFI+"</i> no se ha podido cancelar");
	            	    $("#titulo").html("Ha ocurrido un error");
	            	}
	                $("#abrirmodal").trigger("click");
	                document.getElementById('formularioCan').reset();
                    $("#tMunicipiosOC").html(llenarTabla(arregloVacio));
	                document.getElementById("cancelarB").disabled = true;
	                document.getElementById("justificacionC").disabled = true;
				}
			})
		}

		function cancelar(){
			var folioCFI = document.getElementById("folioCFIRe").value;
            document.getElementById('formularioRe').reset();
            municipiosORe.splice(0, municipiosORe.length);
            $("#tMunicipiosORe").html(llenarTabla(municipiosORe));
            document.getElementById("folioCFIRe").value = folioCFI;
            document.getElementById("folioCFIRe").disabled = false;

            document.getElementById("folioCFINRe").disabled = true;
			document.getElementById('tipoRe').disabled = true;
			document.getElementById('expedidorCFIRe').disabled = true;
			document.getElementById('folioRPVRe').disabled = true;
			document.getElementById('TERe').disabled = true;
			document.getElementById('productoRe').disabled = true;
			document.getElementById('variedadRe').disabled = true;
			document.getElementById('municipioORe').disabled = true;
			document.getElementById('cantidadRe').disabled = true;
			document.getElementById('unidadRe').disabled = true;
			document.getElementById('cajasRe').disabled = true;
			document.getElementById('transporteRe').disabled = true;
			document.getElementById('fechaRe').disabled = true;
			document.getElementById('paisRe').disabled = true;
			document.getElementById('estadoRe').disabled = true;
			document.getElementById('municipioDRe').disabled = true;
			document.getElementById('regulacionRe').disabled = true;
			document.getElementById('observacionesRe').disabled = true;
			document.getElementById('justificacionRe').disabled = true;
			document.getElementById('agregarBRe').disabled = true;
			document.getElementById('quitarBRe').disabled = true;
		    document.getElementById('estatusRe').disabled = true;
	
			document.getElementById("buscarBR").disabled = false;
			document.getElementById("reemplazarB").disabled = true;
			document.getElementById("guardarB").disabled = true;

			document.getElementById("divReemplazar").style.display = "inline";
			document.getElementById("divCancelar").style.display = "none";

			$("#regulacionRe").html('<option value="" selected>...</option>');
			$("#estadoRe").html('<option value="" selected>...</option>');
			$("#municipioDRe").html('<option value="" selected>...</option>');
		}

		function buscarRe(){
			if (valido == true){
				var folioCFI = document.getElementById("folioCFIRe").value;
				var busquedaRe = "busquedaRe";
	            document.getElementById('formularioRe').reset();
				impTransporte(); 
	            impExpedidorCFI(); 
	            impTE();
	            impMunicipioO(); 
	            impPais(); 
	            impNombre();
	            $("#regulacionRe").html('<option value="" selected>...</option>');
	            $("#estadoRe").html('<option value="" selected>...</option>');
	            $("#municipioDRe").html('<option value="" selected>...</option>');
	            municipiosORe.splice(0, municipiosORe.length);
	            $("#tMunicipiosORe").html(llenarTabla(municipiosORe));
	            document.getElementById("folioCFIRe").value = folioCFI;

				var parametros = {
					"id" : busquedaRe,
					"folioCFI" : folioCFI
				}

				$.ajax({
					data: parametros,
					url: dirScriptsPhp + 'consultar.php',
					type: "post",
			        dataType: "json",
					success: function (response) {
						if(response == "2"){
		            		$("#registro").html("El certificado con folio CFI <i>"+folioCFI+"</i> no está registrado");
		            	    $("#titulo").html("Folio inexistente");
		            	    $("#abrirmodal").trigger("click");
		            	} else {
		            	    if(response == "3"){
			            		$("#registro").html("Actualmente, el certificado original con folio CFI <i>"+folioCFI.substring(0, folioCFI.length - 1)+"</i> ya llegó al limite de modificaciones permitidas");
			            	    $("#titulo").html("Acción denegada");
			            	    $("#abrirmodal").trigger("click");
			            	} else {
			            	    if(response == "4"){
				            		$("#registro").html("El certificado con folio CFI <i>"+folioCFI+"</i> está cancelado");
    			            	    $("#titulo").html("Acción denegada");
	    		            	    $("#abrirmodal").trigger("click");
		    	            	} else {
			                		if (response.result.Estatus == "Cancelado"){
			                			$("#registro").html("El certificado con folio CFI <i>"+folioCFI+"</i> está cancelado");
			                	        $("#titulo").html("Acción denegada");
			                	        $("#abrirmodal").trigger("click");
			            	    	} else{
			            		    	rellenarRe(response.result.Empacadora, response.result.Tipo, response.result.FolioRPV, response.result.IdExpedidorCFI, response.result.IdTerceroEspecialista, response.result.Terceria, response.result.Producto, response.result.Variedad, response.result.Cantidad, response.result.NumeroCajas, response.result.Unidad, response.result.Estatus, response.result.Fecha, response.result.IdPais, response.result.IdEstado, response.result.IdMunicipio, response.result.IdRegulacion, response.result.IdTransporte, response.result.Referencia, response.result.Observaciones, response.result.Municipios);
			            	    	} 
			            	    }
			            	}
		            	}
					}
				})
			}
		}

		function rellenarRe(emp, tipo, RPV, eCFI, TE, ter, prod, vardd, cant, cajas, unid, estt, fech, pais, est, mpioD, reg, transp, ref, obs, mpioO){
			document.getElementById("empacadoraRe").value = emp;
			document.getElementById("tipoRe").value = tipo;
			document.getElementById("folioRPVRe").value = RPV;
			document.getElementById("expedidorCFIRe").value = eCFI;
			document.getElementById("terceriaRe").value = ter;
			document.getElementById("TERe").value = TE;
			document.getElementById("productoRe").value = prod;
			document.getElementById("variedadRe").value = vardd;
			document.getElementById("cantidadRe").value = cant;
			document.getElementById("cajasRe").value = cajas;
			document.getElementById("unidadRe").value = unid;
			document.getElementById("estatusRe").value = estt;
			document.getElementById("paisRe").value = pais;
			imprimirRe(mpioD, reg, "imprRegulacionRe", "municipio", "reg", "regulacionRe");
			imprimirRe(pais, est, "impEstadoRe", "pais", "estado", "estadoRe");
			imprimirRe(est, mpioD, "impMunicipioRe", "estado", "municipio", "municipioDRe");
			document.getElementById("observacionesRe").value = obs;
			document.getElementById("transporteRe").value = transp;
			document.getElementById("referenciaRe").value = ref;
			document.getElementById("reemplazarB").disabled = false;

			////////////////////////////////// fecha

			var anio = fech.substring(0, 4);
		    var mes = fech.substring(5, 7);

		    if(mes == '06'){
		    	fecha = anio + "-05-01";
		    } else{
		    	if (mes <= '05'){
		    		fecha = (anio - 1) + "-06-01";
		    	} else{
		    		fecha = anio + "-06-01";
		    	}
		    }

		    $("#fechaRe").attr("min", fecha);
			document.getElementById("fechaRe").value = fech;

			//////////////////////////////// municipios

            var arreglo = [];
			for (var x = 0; x < mpioO.length; x++){
            	Object.entries(mpioO[x]).forEach(([key, value]) => {
					arreglo.push(value);
				});

				municipiosORe.push([arreglo[0], arreglo[1]]);
		        arreglo.splice(0, arreglo.length);
            }

			$("#tMunicipiosORe").html(llenarTabla(municipiosORe));
		}

		function imprimirRe(origen, comparativo, id, identificador1, identificador2, elemento){
			var formData = new FormData();
			formData.append("id", id);
			formData.append(identificador1 , origen);
			formData.append(identificador2, comparativo);

			$.ajax({
				url: dirScriptsPhp + 'consultar.php',
			    type: "POST",
			    data: formData,
			    processData: false, 
			    contentType: false,  
				success: function (response) {
					$("#" + elemento).html(response);
				}
			});
		}

		function reemplazar(){
			document.getElementById("folioCFINRe").disabled = false;
			document.getElementById('tipoRe').disabled = false;
			document.getElementById('expedidorCFIRe').disabled = false;
			document.getElementById('folioRPVRe').disabled = false;
			document.getElementById('TERe').disabled = false;
			document.getElementById('productoRe').disabled = false;
			document.getElementById('variedadRe').disabled = false;
			document.getElementById('municipioORe').disabled = false;
			document.getElementById('cantidadRe').disabled = false;
			document.getElementById('unidadRe').disabled = false;
			document.getElementById('cajasRe').disabled = false;
			document.getElementById('transporteRe').disabled = false;
			document.getElementById('fechaRe').disabled = false;
			document.getElementById('paisRe').disabled = false;
			document.getElementById('estadoRe').disabled = false;
			document.getElementById('municipioDRe').disabled = false;
			document.getElementById('regulacionRe').disabled = false;
			document.getElementById('referenciaRe').value = document.getElementById("folioCFIRe").value;
			document.getElementById('observacionesRe').disabled = false;
			document.getElementById('justificacionRe').disabled = false;
			document.getElementById('agregarBRe').disabled = false;
			document.getElementById('quitarBRe').disabled = false;
		    document.getElementById('estatusRe').value = 'Reemplazo';
	
			document.getElementById("guardarB").disabled = false;
			document.getElementById("buscarBR").disabled = true;
			document.getElementById("folioCFIRe").disabled = true;
			document.getElementById("reemplazarB").disabled = false;

			document.getElementById("divReemplazar").style.display = "none";
			document.getElementById("divCancelar").style.display = "inline";
		}

		function guardar(){
			if(valido == true ){
				var CFI = document.getElementById("folioCFIRe").value;
				var CFIN = document.getElementById("folioCFINRe").value;

				var formData = new FormData();
				formData.append("id", "reemplazarC");
			    formData.append("folioCFIV", CFI);
			    formData.append("folioCFIN", CFIN);
			    formData.append("tipo", $("#tipoRe").val());
			    formData.append("folioRPV", $("#folioRPVRe").val());
			    formData.append("expedidorCFI", $("#expedidorCFIRe").val());
			    formData.append("TE", $("#TERe").val());
			    formData.append("producto", $("#productoRe").val());
			    formData.append("variedad", $("#variedadRe").val());
			    formData.append("cantidad", $("#cantidadRe").val());
			    formData.append("cajas", $("#cajasRe").val());
			    formData.append("unidad", $("#unidadRe").val());
			    formData.append("fecha", $("#fechaRe").val());
			    formData.append("pais", $("#paisRe").val());
			    formData.append("estado", $("#estadoRe").val());
			    formData.append("municipioD", $("#municipioDRe").val());
			    formData.append("regulacion", $("#regulacionRe").val());
			    formData.append("transporte", $("#transporteRe").val());
			    formData.append("referencia", $("#referenciaRe").val());
			    formData.append("observaciones", $("#observacionesRe").val());
			    formData.append("justificacion", $("#justificacionRe").val());
			    formData.append("municipioO", JSON.stringify(municipiosORe));
			    formData.append("usuario", usuario);
			    formData.append("estatus", $("#estatusRe").val());

				$.ajax({
		            url: dirScriptsPhp + 'registrar.php',
		            type: 'post',
			        data: formData,
			        processData: false, 
			        contentType: false,
		            success:  function (response) {
		            	if(response[0] == "1"){
		            		$("#registro").html("El certificado con folio CFI <i>"+CFI+"</i> han sido reemplazado por el certificado con folio CFI <i>"+CFIN+"</i> correctamente.");
		            	    $("#titulo").html("Reemplazo exitoso");
		            	    deshabilitarRe();
		            	} else {
		            		$("#registro").html("No se pudieron guardar los cambios.");
		            	    $("#titulo").html("Ha ocurrido un error");
		            	}
		            	$("#abrirmodal").trigger("click");
		            }
		        });
			}
		}

		function limpiarRe(){
			var folioCFI = document.getElementById("folioCFIRe").value;
            document.getElementById('formularioRe').reset();
            municipiosORe.splice(0, municipiosORe.length);
            $("#tMunicipiosORe").html(llenarTabla(municipiosORe));
            $("#regulacionRe").html('<option value="" selected>...</option>');
            $("#estadoRe").html('<option value="" selected>...</option>');
            $("#municipioDRe").html('<option value="" selected>...</option>');
			document.getElementById("reemplazarB").disabled = true;
            document.getElementById("folioCFIRe").value = folioCFI;
		}
		
		function deshabilitarRe(){
		    limpiarRe();
		    document.getElementById("folioCFIRe").value = "";
            document.getElementById("folioCFIRe").disabled = false;

            document.getElementById("folioCFINRe").disabled = true;
			document.getElementById('tipoRe').disabled = true;
			document.getElementById('expedidorCFIRe').disabled = true;
			document.getElementById('folioRPVRe').disabled = true;
			document.getElementById('TERe').disabled = true;
			document.getElementById('productoRe').disabled = true;
			document.getElementById('variedadRe').disabled = true;
			document.getElementById('municipioORe').disabled = true;
			document.getElementById('cantidadRe').disabled = true;
			document.getElementById('unidadRe').disabled = true;
			document.getElementById('cajasRe').disabled = true;
			document.getElementById('transporteRe').disabled = true;
			document.getElementById('fechaRe').disabled = true;
			document.getElementById('paisRe').disabled = true;
			document.getElementById('estadoRe').disabled = true;
			document.getElementById('municipioDRe').disabled = true;
			document.getElementById('regulacionRe').disabled = true;
			document.getElementById('observacionesRe').disabled = true;
			document.getElementById('justificacionRe').disabled = true;
			document.getElementById('agregarBRe').disabled = true;
			document.getElementById('quitarBRe').disabled = true;
		    document.getElementById('estatusRe').disabled = true;
	
			document.getElementById("buscarBR").disabled = false;
			document.getElementById("reemplazarB").disabled = true;
			document.getElementById("guardarB").disabled = true;

			document.getElementById("divReemplazar").style.display = "inline";
			document.getElementById("divCancelar").style.display = "none";
		}

		function exportarTabla(){
			document.getElementById("nombreDes").value = "";
			$("#abrirmodalDes").trigger("click");
		}

		function descargarCSV(){
			nombreCsv = document.getElementById("nombreDes").value;

			if (nombreCsv != ""){
				var expCertificado = "expCertificado";
				var tabla = $("#tablaCertificados").DataTable().rows({ filter : 'applied'}).data();
				var arreglo = [];

	            $.each( tabla, function( key, value ) {
				    arreglo[key] = value;
				});

				var parametros = {
				    "id" : expCertificado,
				    "datos" : JSON.stringify(arreglo)
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (data) {
			            var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
		            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "'+nombreCsv+'.csv" target="_blank">descargar</a>');
		            	$('#divDes a')[0].click();
		            }
		        });
			} else{
				$("#registro").html("No es posible descargar el archivo, no le ha asignado ningun nombre.");
		        $("#titulo").html("Acción denegada");
		        $("#abrirmodal").trigger("click");
			}
		}

		function agregar(elemento, tabla, aux){
			if ($("#" + elemento).val() != ""){
				var bandera = false;
				for (var x = 0; x < aux.length; x++){
					if (aux[x][0] == $("#" + elemento).val()){
						bandera = true;
					}
				}

				if (bandera == false){
					aux.push([$("#" + elemento).val(), document.getElementById(elemento).options[document.getElementById(elemento).selectedIndex].text]);
				    $("#" + tabla).html(llenarTabla(aux));
				} else{
					$("#registro").html("El municipio seleccionado ya está registrado en la tabla");
		            $("#titulo").html("Municipio repetido");
		            $("#abrirmodal").trigger("click");
				}
			}

			return aux;
		}

		function llenarTabla(aux){
			var cadena = "";
			for(var x = 0; x < aux.length; x++){
				cadena = cadena + "<tr><td>" + aux[x][1] + "</td></tr>";
			}

			if (aux.length < 3){
				for(var x = aux.length; x < 3; x++){
					cadena = cadena + "<tr><td>&nbsp;</td></tr>";
				}
			}

			return cadena;
		}

		function quitar(elemento, tabla, aux){
			aux.pop();
			$("#" + tabla).html(llenarTabla(aux));

			return aux;
		}

		function obtTerceria(TE, terceria){
			if ($("#" + TE).val() != ""){
				var parametros = {
					"id" : "obtTerceria",
					"TE" : $("#"+TE).val()
				}
				
				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            dataType: "json",
		            success:  function (response) {
		            	$("#"+terceria).val(response.Nombre);
		            }
		        });
			} else{
				$("#"+terceria).val("");
			}
		}

		function impDecimales(unidad, cantidad){
			if ($("#"+unidad).val() == "Kilogramos"){
				$("#"+cantidad).attr("title", "Sólo se permiten valores numéricos con un máximo de 3 decimales");
				$("#"+cantidad).attr("step", "0.001");
				$("#"+cantidad).attr("min", "0.001");
			} 

			if ($("#"+unidad).val() == "Toneladas"){
				$("#"+cantidad).attr("title", "Sólo se permiten valores numéricos con un máximo de 4 decimales");
				$("#"+cantidad).attr("step", "0.0001");
				$("#"+cantidad).attr("min", "0.0001");
			}
		}
		
		function validarEstatus(){
		    if (Number($("#folioCFINRe").val())){
		        $("#estatusRe").val("Reemplazo");
		    } else{
		        var num = "";
		        if (Number($("#folioCFIRe").val())){
		            num = $("#folioCFIRe").val();
		        } else{
		            num = $("#folioCFIRe").val().substring(0, $("#folioCFIRe").val().length -1);
		        }
		        
		        if ($("#folioCFINRe").val().substring(0, $("#folioCFINRe").val().length -1) === num){
		            $("#estatusRe").val("Original");
		        } else{
		            $("#estatusRe").val("Reemplazo");
		        }
		    }
		}
	</script>

	<hearder>
		<div style="box-shadow: 0px 2px 10px rgba(0,0,0,.115);">
			<!-------------------------------------- Usuario ---------------------------------------------->
	        <div class="card col-12 text-white border-0" id="usuario">
	        	<iframe style="height: 75px;" src= "..\Imagenes\CabeceraFormulario.html"></iframe>
				<div class="card-img-overlay m-0 p-0">
				    <div class="container-fluid">
		        		<div class="col-12 row px-4 text-white align-items-center">
		        			<img src = "..\Imagenes\usuario.png" style="height: 45px; width: auto;" class="my-3 px-3">
		            	    <span class="col-9 col-md-10 col-lg-11"><strong>Hola, <?php echo $_SESSION['nombre'];?></strong></span>
		        		</div>
			        </div>
				</div>
			</div>

	        <!------------------------------------- Navegador----------------------------------------------->
	        <nav id ="barra">
	            <div class="navbar navbar-expand-lg navbar-light px-3 bg-light py-0" style="min-height: 75px;">
	                <div class="container-fluid">
	                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="btnNav">
	                        <span class="navbar-toggler-icon"></span>
	                    </button>

	                    <div class="collapse navbar-collapse" id="navbarNav">
	                        <ul class="navbar-nav">
	                            <?php echo impMenu($_SESSION['descripcion'], 'Certificados', 'certificados');?>
	                        </ul>
	                    </div>
	                    <div class="col-lg-3 col-md-4 col-7 px-3 text-end" id="imgLogo">
	                	    <img src = "..\Imagenes\Logo2.png" class = "img-fluid" style="max-height: 68px;">
	            		</div>
	                </div>
	            </div>
	        </nav>
	    </div>
    </hearder>

    <main>
		<div class = "container-fluid">
			<div class="row py-5 justify-content-center">
				<div class = "col-12" style="max-width: 1100px;">
	                <!-- -----------------------------------------tabs----------------------------------------- -->
	                <span class="rounded-top nav tag-background position-relative" style="z-index: 3;"></ul>
					    <ul class="nav nav-tabs cambioColor">
		                	<li class="nav-item active rounded-top" style="background-color: #19221f;">
		                        <a href="#registrar" class="nav-link active" role="tab" data-toggle="tab" onClick="impTransporte(); impExpedidorCFI(); impPais(); impNombre(); impMunicipioO(); impTE();"><strong>Registrar</strong></a>
	    	                </li>
	
		 	                   <li class="nav-item rounded-top" style="background-color: #19221f;">
	        	                <a href="#consulta" class="nav-link" role="tab" data-toggle="tab" onClick="consultar();"><strong>Consultar certificados</strong></a>
	            	        </li>

	                	    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                    	    <a href="#cancelar" class="nav-link" role="tab" data-toggle="tab"><strong>Cancelar</strong></a>
		                    </li>

	    	                <li class="nav-item rounded-top" style="background-color: #19221f;">
	        	                <a href="#reemplazar" class="nav-link" role="tab" data-toggle="tab" onClick = "impTransporte(); impExpedidorCFI(); impMunicipioO(); impPais(); impNombre(); impTE();"><strong>Reemplazar</strong></a>
	            	        </li>
	                    </ul>
					</span>

	                <div class="tab-content bg-white border border-top-0 rounded-3 text-justify" style="box-shadow: 0px 0px 10px #c6c6c6;">
                        <!-- --------------------------------------------Registrar-------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane in active" id="registrar">
	                        <div class="px-5">
	                        	<!---------------------------------- formulario ---------------------------------->
	                        	<FORM id = "formularioR" NAME="formularioR" method = 'POST' action = '#' target ="request">
									<div class="card border-0">
									    <div class="text-center col-md-12 col-12 mt-5">
				                            <h2><strong>Registrar certificado</strong></h2>
				                        </div>
									    <div class="card-body row gy-2 p-4 px-lg-5 px-2 px-md-3">
									    	<!------------------------------- Apartado de empacadora -------------------------------->
									        <div class="row col-12 col-md-6 m-0 p-0 gy-1">
										        <div class="col-12">
										        	<label class=" form-label">Empacadora</label>
										        	<Select id = "empacadoraRC" class = "form-select form-select-sm col-12" name='empacadoraRC' onChange="impEmpacadoraR();" required></Select>
										        	<INPUT id = "idEmpacadoraRC" class = "form-control form-control-sm" TYPE="hidden" NAME="idEmpacadoraRC" disabled></INPUT>
										        </div>
											    <div class="col-12">
											        <label class=" form-label">Dirección </label><textarea id = "direccionRC" NAME="direccionRC" class = "form-control form-control-sm" style="height: 98px; resize: none;" disabled></textarea>
											    </div>
											</div>
											<!------------------------------ segunda columna ---------------------------->
											<div class="row col-12 col-md-6 m-0 p-0 gy-1">
											    <div class="col-12">
											        <label class=" form-label col-12">Email </label><INPUT id = "correoRC" class = "form-control form-control-sm col-12" type = 'text' NAME="correoRC" disabled></INPUT>
											    </div>
											    <div class="col-12">
											        <label class=" form-label">Municipio </label><INPUT id = "municipioRC" class = "form-control form-control-sm" TYPE="text" NAME="municipioRC" disabled></INPUT>
											    </div>
											    <div class="col-3">
											        <label class="form-label col-12">CP </label><INPUT id = "CPRC" class = "form-control form-control-sm" TYPE="text" NAME="CPRC" disabled></INPUT>
											    </div>
										        <div class="col-5">
										        	<label class="form-label">RFC </label><INPUT id = "RFCRC" class = "form-control form-control-sm col-12" TYPE="text" NAME="RFCRC" disabled></INPUT>
										        </div>
											    <div class="col-4">
											        <label class=" form-label">Teléfono </label><INPUT id = "telefonoRC" class = "form-control form-control-sm" type='text' NAME="telefonoRC" disabled></INPUT>
											    </div>
											</div>
											<div class="row col-12 m-0 p-0 gy-1 mt-4">
									            <hr/>
							                </div>
							                <!------------------------------- Primera columna -------------------------------->
                                            <div class="row col-12 col-md-6 m-0 p-0 gy-1">
                                            	<div class="col-6">
										        	<label class=" form-label">Folio CFI</label><INPUT id = "folioCFI" class = "form-control form-control-sm" TYPE="text" NAME="folioCFI" autocomplete="off" required title="Sólo se permiten números enteros" pattern='[0-9]+' maxlength='15' disabled></INPUT>
										        </div>
											    <div class="col-6">
											        <label class=" form-label">Fecha de expedición de CFI</label><input id = "fecha" class = "form-control form-control-sm col-12" type = 'date' min = '<?php echo $fecha; ?>' name = 'fecha' required disabled></input>
											    </div>
										        <div class="col-12">
										        	<label class=" form-label">Oficial</label>
										        	<Select id = "expedidorCFI" class = "form-select form-select-sm col-12" name='expedidorCFI' required disabled></Select>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Folio RPV</label><INPUT id = "folioRPV" class = "form-control form-control-sm" TYPE="text" NAME="folioRPV" autocomplete="off" required title="Sólo se permiten números, letras en mayusculas y guiones" pattern='[A-Z0-9\-]+' maxlength='40' disabled></INPUT>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Tercero especialista</label>
										        	<Select id = "TE" class = "form-select form-select-sm col-12" name='TE' required disabled onChange = "obtTerceria('TE', 'terceria');"></Select>
										        </div>
										        <div class="col-6">
										        	<label class=" form-label">Tercería</label><INPUT id = "terceria" class = "form-control form-control-sm" TYPE="text" NAME="terceria" required disabled></INPUT>
										        </div>
										        <div class="col-6">
										        	<label class=" form-label">Tipo</label>
										        	<Select id = "tipo" class = "form-select form-select-sm col-12" name='tipo' required disabled>
										        		<option value="" selected>...</option>
														<option value='Internacional'>Internacional</option>
														<option value='Nacional'>Nacional</option>
										        	</Select>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Municipio de origen</label>
										        	<Select id = "municipioO" class = "form-select form-select-sm col-12" name='municipioO' disabled></Select>
										        </div>
										        <div class = "col-6">
										        	<label class=" form-label"></label>
										        	<INPUT id = "agregarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Agregar" TYPE="button" name = "agregarB" onClick="municipiosO = agregar('municipioO', 'tMunicipiosO', municipiosO);" style = "background-color: #19221f;"></INPUT>
										        </div>
										        <div class = "col-6">
										        	<label class=" form-label"></label>
										        	<INPUT id = "quitarB" class = "form-control-lg btn col-12 rounded-1" VALUE="Quitar" TYPE="button" name = "quitarB" onClick="municipiosO = quitar('municipioO', 'tMunicipiosO', municipiosO);" style = "background-color: #e9ecef;"></INPUT>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label"></label>
												    <div style="overflow: auto; height: 153px;" class="col-12">
										            	<table class="form-control-sm table table-bordered mt-0 mb-0 fontTabla" id = "tablaM">
													        <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
													            <th>Municipios</th>
													        </tr>
													        <tbody id="tMunicipiosO">
													        	<tr><td>&nbsp;</td></tr>
													        	<tr><td>&nbsp;</td></tr>
													        	<tr><td>&nbsp;</td></tr>
					                                        </tbody>
													    </table>
											        </div>
											    </div>
											</div>
											<!------------------------------ segunda columna ---------------------------->
										    <div class="row col-12 col-md-6 m-0 p-0 gy-1">
											    <div class="col-6">
											        <label class=" form-label">No. de cajas </label><INPUT id = "cajas" class = "form-control form-control-sm" type='text' NAME="cajas" autocomplete="off" title="Sólo se permiten números enteros" pattern='[0-9]+' disabled></INPUT>
											    </div>
										        <div class="col-6">
										        	<label class=" form-label">Transporte</label>
										        	<Select id = "transporte" class = "form-select form-select-sm col-12" name='transporte' disabled></Select>
										        </div>
										        <div class="col-6">
											        <label class=" form-label">Cantidad</label><INPUT id = "cantidad" NAME="cantidad" class = "form-control form-control-sm" type="number" step="0.001" min = "0.001" required title="Sólo se permiten valores numéricos con un máximo de 3 decimales" autocomplete="off" disabled></INPUT>
											    </div>
											    <div class="col-6">
										        	<label class=" form-label">Unidad de medida</label>
										        	<Select id = "unidad" class = "form-select form-select-sm col-12" name='unidad' required disabled onChange = "impDecimales('unidad', 'cantidad');">
										        		<option value="" selected>...</option>
														<option value='Kilogramos'>Kilogramos</option>
														<option value='Toneladas'>Toneladas</option>
										        	</Select>
										        </div>
										        <div class="col-6">
										        	<label class=" form-label">Producto</label><INPUT id = "producto" class = "form-control form-control-sm col-12" TYPE="text" maxlength='30' NAME="producto" required disabled pattern = "[^\u{0022}]*" title="No se permiten comillas dobles"></INPUT>
										        </div>
										        <div class="col-6">
										        	<label class=" form-label">Variedad</label>
										        	<Select id = "variedad" class = "form-select form-select-sm col-12" name='variedad' disabled>
										        		<option value="" selected>...</option>
														<option value='Hass'>Hass</option>
														<option value='Méndez'>Méndez</option>
										        	</Select>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">País de destino</label>
										        	<Select id = "pais" class = "form-select form-select-sm col-12" name='pais' required disabled onChange = "impEstadoRR('pais', 'estado', 'municipioD', 'regulacion');"></Select>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Estado de destino</label>
										        	<Select id = "estado" class = "form-select form-select-sm col-12" name='estado' required disabled onChange = "impMunicipioRR('estado', 'municipioD', 'regulacion');">
										        		<option value="" selected>...</option>
										        	</Select>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Municipio de destino</label>
										        	<Select id = "municipioD" class = "form-select form-select-sm col-12" name='municipioD' disabled onChange = "impRegulacionRR('municipioD', 'regulacion');">
										        		<option value="" selected>...</option>
										        	</Select>
										        </div>
											    <div class="col-12">
											        <label class=" form-label">Puerto de entrada</label>
											        <Select id = "regulacion" class = "form-select form-select-sm col-12" name='regulacion' disabled>
										        		<option value="" selected>...</option>
													</Select>
											    </div>
											    <div class="col-12">
											        <label class=" form-label">Observaciones</label><textarea style="height: 95px; resize: none;" id = "observaciones" class="form-control form-control-sm" maxlength='100' name='observaciones' autocomplete="off" disabled pattern = "[^\u{0022}]*" title="No se permiten comillas dobles"></textarea>
											    </div>
											    <div class="col-0 col-md-12 col-lg-12 mt-0 mt-md-5 mt-lg-5 mb-0 mb-md-1 mb-lg-1">
											    </div>
											</div>
									    </div>
									    <div class="row px-lg-5 px-2 px-md-3">
										    <div class="row col-12 m-0 p-0 gy-1">
										        <hr class="mb-1">
								            </div>
								        </div>
									    <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3">
									        <!-- ---------------------------------boton--------------------------------- -->
									        <div class="row overflow-hidden mb-5 justify-content-center">
										    	<div class="col-lg-6 col-md-6 col-12">
													<INPUT id = "registrarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Registrar" TYPE="submit" name = "registrarB" onClick="validar(); confirmar();" style = "background-color: #7eca28;"></INPUT>
												</div>
										        <iframe name ="request" style="display: none;"></iframe>
										    </div>
									    </div>
									</div>
								</FORM>
	                        </div>
	                    </div>

	                    <!------------------------------------------ modal, notificación -------------------------------------->
	                    <div class="container">
			            	<INPUT id = "abrirmodal" data-toggle="modal" data-target="#dialogo1" VALUE="abrirmodal" TYPE="button" style = "display: none;"></INPUT>

			            	<div id="dialogo1" class="modal fade" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
							    <div class="modal-dialog modal-md modal-dialog-top">
							        <div class="modal-content">
								        <!-- cabecera del diálogo -->
								        <div class="modal-header">
								            <h5 class="modal-title" id="titulo"></h5>
								            <button type="button" class="close border-0" data-dismiss="modal">X</button>
								        </div>
								    
								        <!-- cuerpo del diálogo -->
								        <div class="modal-body" style="min-height: 80px;">
								            <p><span id = "registro"></span></p>
									    </div> 
							        </div>
							    </div>
						    </div> 

						    <INPUT id = "abrirmodalC" data-toggle="modal" data-target="#confirmacion" VALUE="abrirmodalC" TYPE="button" style = "display: none;"></INPUT>

						    <div id="confirmacion" class="modal fade" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
							    <div class="modal-dialog modal-md modal-dialog-top">
								    <div class="modal-content">
								        <div class="modal-header">
								            <h5 class="modal-title">Confirmar registro</h5>
								            <button type="button" class="close border-0" data-dismiss="modal">X</button>
								        </div>
								        <div class="modal-body">
								            <p>He verificado que los datos son correctos.</p>
								        </div>
								        <div class="modal-footer">
								            <button type="button" class="btn text-white" style = "background-color: #19221f;" data-dismiss="modal">Cancelar</button>
								            <button id = "confirmarB" type="button" class="btn text-white" name = "confirmarB" onClick="registrar();" style = "background-color: #318a3a;" data-dismiss="modal">Registrar</button>
								        </div>
								    </div>
							    </div>
							</div>

							<INPUT id = "abrirmodalCan" data-toggle="modal" data-target="#caneclacion" VALUE="abrirmodalCan" TYPE="button" style = "display: none;"></INPUT>

						    <div id="caneclacion" class="modal fade" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
							    <div class="modal-dialog modal-md modal-dialog-top">
								    <div class="modal-content">
								        <div class="modal-header">
								            <h5 class="modal-title">Confirmar cancelación</h5>
								            <button type="button" class="close border-0" data-dismiss="modal">X</button>
								        </div>
								        <div class="modal-body">
								            <p>Confirmo que deseo cancelar este certificado.</p>
								        </div>
								        <div class="modal-footer">
								            <button type="button" class="btn text-white" style = "background-color: #19221f;" data-dismiss="modal">No cancelar</button>
								            <button id = "confCanB" type="button" class="btn text-white" name = "confCanB" onClick="cancelarE();" style = "background-color: #318a3a;" data-dismiss="modal">Cancelar</button>
								        </div>
								    </div>
							    </div>
							</div>

							<INPUT id = "abrirmodalRe" data-toggle="modal" data-target="#reemplazo" VALUE="abrirmodalRe" TYPE="button" style = "display: none;"></INPUT>

						    <div id="reemplazo" class="modal fade" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
							    <div class="modal-dialog modal-md modal-dialog-top">
								    <div class="modal-content">
								        <div class="modal-header">
								            <h5 class="modal-title">Confirmar reemplazo</h5>
								            <button type="button" class="close border-0" data-dismiss="modal">X</button>
								        </div>
								        <div class="modal-body">
								            <p>Confirmo que deseo reemplazar este certificado.</p>
								        </div>
								        <div class="modal-footer">
								            <button type="button" class="btn text-white" style = "background-color: #19221f;" data-dismiss="modal">Cancelar</button>
								            <button id = "confReB" type="button" class="btn text-white" name = "confReB" onClick="guardar();" style = "background-color: #318a3a;" data-dismiss="modal">Reemplazar</button>
								        </div>
								    </div>
							    </div>
							</div>

							<INPUT id = "abrirmodalDes" data-toggle="modal" data-target="#descarga" VALUE="abrirmodalDes" TYPE="button" style = "display: none;"></INPUT>

						    <div id="descarga" class="modal fade" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
							    <div class="modal-dialog modal-md modal-dialog-top">
								    <div class="modal-content">
								        <div class="modal-header">
								            <h5 class="modal-title">Guardar como</h5>
								            <button type="button" class="close border-0" data-dismiss="modal">X</button>
								        </div>
								        <div class="modal-body">
								            <p>Por favor ingrese el nombre del archivo EXCEL a descargar</p>
								            <div class="input-group input-group-sm mb-2">
									            <INPUT id = "nombreDes" class = "form-control form-control-sm" TYPE="text" NAME="nombreDes" autocomplete="off"></INPUT>
									            <a class="input-group-text" href = "../Ayuda/DescargarCSV.html" target="_blank" title="Problemas al abrir el archivo descargado"><i class="bi bi-question-lg" style = "color: #318a3a; font-size: 16px;"></i></a>
									        </div>
								        </div>
								        <div class="modal-footer">
								            <button type="button" class="btn text-white" style = "background-color: #19221f;" data-dismiss="modal">Cancelar</button>
								            <button id = "confDes" type="button" class="btn text-white" name = "confDes" onClick="descargarCSV();" style = "background-color: #318a3a;" data-dismiss="modal">Descargar</button>
								        </div>
								    </div>
							    </div>
							</div>
						</div>

	                    <!-- ----------------------------------------Consultar----------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="consulta">
	                        <div class="px-lg-5 px-2 px-md-3">
	                        	<FORM id = "formularioC" NAME="formularioC" method = 'POST' action = '#' target ="request">
									<div class="card border-0 mb-4 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Consultar certificados</strong></h2>
				                        </div>
				                        <!---------------------------------------- periodo -------------------------------------------->
				                        <div class="row m-0 p-0 gy-1 mt-3 mb-0">
				                        	<div class="row col-12 m-0 p-0 gy-1 mb-2">
											    <div class="col-6 col-md-3 col-lg-3">
											        <label class=" form-label">Fecha inicial</label><input id = "fechaI" class = "form-control form-control-sm col-12" type = 'date' name = 'fechaI' onChange = "consultar();"></input>
											    </div>
											    <div class="col-6 col-md-3 col-lg-3">
											        <label class=" form-label">Fecha final</label><input id = "fechaF" class = "form-control form-control-sm col-12" type = 'date' name = 'fechaF' onChange = "consultar();"></input>
											    </div>
											    <div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label">Tipo</label>
										        	<Select id = "TipoCons" class = "form-select form-select-sm col-12" name='TipoCons' onChange="consultar();">
										        		<option value="" selected>Ambos</option>
														<option value='Internacional'>Internacional</option>
														<option value='Nacional'>Nacional</option>
										        	</Select>
										        </div>
										        <div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label"></label>
										        	<INPUT id = "exportarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar tabla" TYPE="button" name = "exportarB" onClick="exportarTabla();" style = "background-color: #60c438;"></INPUT>
										        </div>
											</div>

										    <div class="row col-12 m-0 p-0 gy-1 mt-4 px-2">
										        <hr/>
								            </div>
				                        </div>
										<!------------------------------------- tabla ------------------------------------------>
										<div class="px-2">
				                            <div class="col-12 mt-0 mb-3 pt-3 pb-0">
				                                <div id="divDes" style="display: none;"></div>	
				                            	<table id="tablaCertificados" class="table table-bordered display" style="width: 3400px;">
									                <thead>
									                    <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
									                        <th>Folio CFI</th>
									                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Empacadora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
									                        <th>Fecha&nbsp;expedición de CFI</th>
									                        <th>Tipo</th>
									                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Oficial&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
									                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Folio&nbsp;RPV&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
									                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tercero&nbsp;especialista&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
									                        <th>Tercería</th>
									                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Producto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
									                        <th>Variedad</th>
									                        <th>Transporte</th>
									                        <th>Cantidad</th>
									                        <th>Uni. Medida</th>
									                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mpio.&nbsp;Origen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
									                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;País&nbsp;destino&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
									                        <th>Estado&nbsp;destino</th>
									                        <th>Mpio.&nbsp;Destino</th>
									                        <th>Puerto&nbsp;de&nbsp;entrada</th>
									                        <th>Estatus</th>
									                        <th>No. cajas</th>
									                        <th>Referencia</th>
									                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Observaciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
									                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Justificación&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
									                    </tr>
									                </thead>
									                <tbody id="idTBody">
									                </tbody>
									            </table>
									        </div>
									    </div> 
								    </div>
								</FORM>
	                        </div>
	                    </div>

	                    <!-- --------------------------------------------Cancelar-------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="cancelar">
	                        <div class="px-5">
	                        	<!---------------------------------- formulario ---------------------------------->
	                        	<FORM id = "formularioCan" NAME="formularioCan" method = 'POST' action = '#' target ="request">
									<div class="card border-0">
									    <div class="text-center col-md-12 col-12 mt-5">
				                            <h2><strong>Cancelar certificado</strong></h2>
				                        </div>
									    <div class="card-body row gy-2 p-4 px-lg-5 px-2 px-md-3">
									        <!------------------------------- Apartado de busqueda -------------------------------->
									        <div class="row col-12 m-0 p-0 gy-1">
										        <div class="col-6 col-lg-3 col-md-4">
										        	<label class=" form-label">Folio CFI</label><INPUT id = "folioCFIC" class = "form-control form-control-sm" TYPE="text" NAME="folioCFIC" autocomplete="off" required title='Sólo se permiten números enteros y una letra opcional al final del folio' pattern='[0-9]+[A-Za-z]?' maxlength='16' onkeydown = "limpiarCan();"></INPUT>
										        </div>
										        <div class="col-lg-3 col-md-3 col-6">
										        	<div style="height: 27px;"></div>
													<INPUT id = "buscarBC" class = "form-control-lg btn btn-sm col-12 rounded-1 text-white" VALUE="Buscar" TYPE="submit" name = "buscarBC" onClick="validarCan(); buscarC();" style = "background-color: #318a3a;"></INPUT>
												</div>
												<div class="row col-12 m-0 p-0 gy-1 mt-4 px-2">
										            <hr/>
								                </div>
											</div>
							                <!------------------------------- Apartado de certificado -------------------------------->
                                            <div class="row col-12 col-md-6 m-0 p-0 gy-1">
										        <div class="col-12">
										        	<label class=" form-label">Empacadora</label><INPUT id = "empacadoraC" class = "form-control form-control-sm" TYPE="text" NAME="empacadoraC" disabled></INPUT>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Oficial</label><INPUT id = "expedidorCFIC" class = "form-control form-control-sm" TYPE="text" NAME="expedidorCFIC" disabled></INPUT>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Folio RPV</label><INPUT id = "folioRPVC" class = "form-control form-control-sm" TYPE="text" NAME="folioRPVC" disabled></INPUT>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Tercero especialista</label><INPUT id = "TEC" class = "form-control form-control-sm" TYPE="text" NAME="TEC" disabled></INPUT>
										        </div>
										        <div class="col-6">
										        	<label class=" form-label">Tercería</label><INPUT id = "terceriaC" class = "form-control form-control-sm" TYPE="text" NAME="terceriaC" disabled></INPUT>
										        </div>
											    <div class="col-6">
											        <label class=" form-label">Fecha de expedición de CFI</label><INPUT id = "fechaC" class = "form-control form-control-sm" TYPE="text" NAME="fechaC" disabled></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">No. de cajas </label><INPUT id = "cajasC" class = "form-control form-control-sm" TYPE="text" NAME="cajasC" disabled></INPUT>
											    </div>
										        <div class="col-6">
										        	<label class=" form-label">Transporte</label><INPUT id = "transporteC" class = "form-control form-control-sm" TYPE="text" NAME="transporteC" disabled></INPUT>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label"></label>
												    <div style="overflow: auto; height: 153px;" class="col-12">
										            	<table class="form-control-sm table table-bordered mt-0 mb-0 fontTabla" id = "tablaMC">
													        <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
													            <th>Municipios</th>
													        </tr>
													        <tbody id="tMunicipiosOC">
													        	<tr><td>&nbsp;</td></tr>
													        	<tr><td>&nbsp;</td></tr>
													        	<tr><td>&nbsp;</td></tr>
					                                        </tbody>
													    </table>
											        </div>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Estatus </label><INPUT id = "estatusC" class = "form-control form-control-sm" TYPE="text" NAME="estatusC" disabled></INPUT>
											    </div>
										        <div class="col-6">
										        	<label class=" form-label">Tipo</label><INPUT id = "tipoC" class = "form-control form-control-sm" TYPE="text" NAME="tipoC" disabled></INPUT>
										        </div>
											</div>
											<!------------------------------ segunda columna ---------------------------->
										    <div class="row col-12 col-md-6 m-0 p-0 gy-1">
										        <div class="col-6">
											        <label class=" form-label">Cantidad</label><INPUT id = "cantidadC" class = "form-control form-control-sm" TYPE="text" NAME="cantidadC" disabled></INPUT>
											    </div>
											    <div class="col-6">
										        	<label class=" form-label">Unidad de medida</label><INPUT id = "unidadC" class = "form-control form-control-sm" TYPE="text" NAME="unidadC" disabled></INPUT>
										        </div>
										        <div class="col-6">
										        	<label class=" form-label">Producto</label><INPUT id = "productoC" class = "form-control form-control-sm" TYPE="text" NAME="productoC" disabled></INPUT>
										        </div>
										        <div class="col-6">
										        	<label class=" form-label">Variedad</label><INPUT id = "variedadC" class = "form-control form-control-sm" TYPE="text" NAME="variedadC" disabled></INPUT>
										        </div>
										        <div class = "col-12">
										        	<label class="form-label">País de destino</label>
										        	<INPUT id = "paisC" class = "form-control form-control-sm" TYPE="text" NAME="paisC" disabled></INPUT>
										        </div>	
										        <div class="col-12">
										        	<label class=" form-label">Estado de destino</label><INPUT id = "estadoC" class = "form-control form-control-sm" TYPE="text" NAME="estadoC" disabled></INPUT>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Municipio de destino</label><INPUT id = "municipioDC" class = "form-control form-control-sm" TYPE="text" NAME="municipioDC" disabled></INPUT>
										        </div>
											    <div class="col-12">
											        <label class=" form-label">Puerto de entrada</label><INPUT id = "regulacionC" class = "form-control form-control-sm" TYPE="text" NAME="regulacionC" disabled></INPUT>
											    </div>
											    <div class="col-12">
											        <label class=" form-label">Observaciones</label><textarea style="height: 98px; resize: none;" id = "observacionesC" class="form-control form-control-sm" name='observacionesC' disabled></textarea>
											    </div>
											    <div class="col-0 col-md-12 col-lg-12 mt-0 mt-md-5 mt-lg-5 mb-0 mb-md-5 mb-lg-5 pt-0 pt-md-3 pt-lg-3">
											    </div>
											</div>
									    </div>
									    <div class="row px-lg-5 px-2 px-md-3">
										    <div class="row col-12 m-0 p-0 gy-1 px-2">
										        <hr class="mb-1">
								            </div>
								        </div>
								        <!------------------------------ justificación ---------------------------->
								        <div class="card-body row gy-2 p-4 px-lg-5 px-2 px-md-3 justify-content-center">
										    <div class="row col-12 col-md-8 m-0 p-0 gy-1">
										    	<div class="col-12">
											        <label class=" form-label">Justificación</label><textarea style="height: 98px; resize: none;" id = "justificacionC" class="form-control form-control-sm" name='justificacionC' disabled required maxlength='255' autocomplete="off" pattern = "[^\u{0022}]*" title="No se permiten comillas dobles"></textarea>
											    </div>
										    </div>
										</div>
								        <div class="row px-lg-5 px-2 px-md-3">
										    <div class="row col-12 m-0 p-0 gy-1 px-2">
										        <hr class="mb-1">
								            </div>
								        </div>
									    <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3">
									        <!-- ---------------------------------botones--------------------------------- -->
									        <div class="row overflow-hidden mb-5 justify-content-center">
									        	<div class="col-6">
													<INPUT id = "cancelarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Cancelar" TYPE="submit" name = "cancelarB" onClick="validarCan(); confirmarC();" style = "background-color: #7eca28;" disabled></INPUT>
												</div>
										    </div>
									    </div>
									</div>
								</FORM>
	                        </div>
	                    </div>

	                    <!-- --------------------------------------------Reemplazar-------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="reemplazar">
	                        <div class="px-5">
	                        	<!---------------------------------- formulario ---------------------------------->
	                        	<FORM id = "formularioRe" NAME="formularioRe" method = 'POST' action = '#' target ="request">
									<div class="card border-0">
									    <div class="text-center col-md-12 col-12 mt-5">
				                            <h2><strong>Reemplazar certificado</strong></h2>
				                        </div>
									    <div class="card-body row gy-2 p-4 px-lg-5 px-2 px-md-3">
									        <!------------------------------- Apartado de busqueda -------------------------------->
									        <div class="row col-12 m-0 p-0 gy-1">
										        <div class="col-6 col-lg-3 col-md-4">
										        	<label class=" form-label">Folio CFI</label><INPUT id = "folioCFIRe" class = "form-control form-control-sm" TYPE="text" NAME="folioCFIRe" autocomplete="off" required title='Sólo se permiten números enteros y una letra opcional al final del folio' pattern='[0-9]+[A-Za-z]?' maxlength='16' onkeydown = "limpiarRe();"></INPUT>
										        </div>
										        <div class="col-lg-3 col-md-3 col-6">
										        	<div style="height: 27px;"></div>
													<INPUT id = "buscarBR" class = "form-control-lg btn btn-sm col-12 rounded-1 text-white" VALUE="Buscar" TYPE="submit" name = "buscarBR" onClick="validarRe(); buscarRe();" style = "background-color: #318a3a;"></INPUT>
												</div>
												<div class="row col-12 m-0 p-0 gy-1 mt-4 px-2">
										            <hr/>
								                </div>
											</div>
							                <!------------------------------- Primera columna -------------------------------->
                                            <div class="row col-12 col-md-6 m-0 p-0 gy-1">
                                            	<div class="col-12">
										        	<label class=" form-label">Empacadora</label><INPUT id = "empacadoraRe" class = "form-control form-control-sm" TYPE="text" NAME="empacadoraRe" disabled></INPUT>
										        </div>
                                            	<div class="col-6">
										        	<label class=" form-label">Folio CFI nuevo</label><INPUT id = "folioCFINRe" class = "form-control form-control-sm" TYPE="text" NAME="folioCFINRe" autocomplete="off" required title='Sólo se permiten números enteros y una letra opcional al final del folio' pattern='[0-9]+[A-Za-z]?' maxlength='16' oninput = "validarEstatus();" disabled></INPUT>
										        </div>
											    <div class="col-6">
											        <label class=" form-label">Fecha de expedición de CFI</label><input id = "fechaRe" class = "form-control form-control-sm col-12" type = 'date' min = '2016-01-01' name = 'fechaRe' required disabled></input>
											    </div>
										        <div class="col-12">
										        	<label class=" form-label">Oficial</label>
										        	<Select id = "expedidorCFIRe" class = "form-select form-select-sm col-12" name='expedidorCFIRe' required disabled></Select>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Folio RPV</label><INPUT id = "folioRPVRe" class = "form-control form-control-sm" TYPE="text" NAME="folioRPVRe" autocomplete="off" required title="Sólo se permiten números, letras en mayusculas y guiones" pattern='[A-Z0-9\-]+' maxlength='40' disabled></INPUT>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Tercero especialista</label>
										        	<Select id = "TERe" class = "form-select form-select-sm col-12" name='TERe' required disabled onChange = "obtTerceria('TERe', 'terceriaRe');"></Select>
										        </div>
										        <div class="col-6">
										        	<label class=" form-label">Tercería</label><INPUT id = "terceriaRe" class = "form-control form-control-sm" TYPE="text" NAME="terceriaRe" required disabled></INPUT>
										        </div>
										        <div class="col-6">
										        	<label class=" form-label">Tipo</label>
										        	<Select id = "tipoRe" class = "form-select form-select-sm col-12" name='tipoRe' required disabled>
										        		<option value="" selected>...</option>
														<option value='Internacional'>Internacional</option>
														<option value='Nacional'>Nacional</option>
										        	</Select>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Municipio de origen</label>
										        	<Select id = "municipioORe" class = "form-select form-select-sm col-12" name='municipioORe' disabled></Select>
										        </div>
										        <div class = "col-6">
										        	<label class=" form-label"></label>
										        	<INPUT id = "agregarBRe" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Agregar" TYPE="button" name = "agregarBRe" onClick="municipiosORe = agregar('municipioORe', 'tMunicipiosORe', municipiosORe);" style = "background-color: #19221f;" disabled></INPUT>
										        </div>
										        <div class = "col-6">
										        	<label class=" form-label"></label>
										        	<INPUT id = "quitarBRe" class = "form-control-lg btn col-12 rounded-1" VALUE="Quitar" TYPE="button" name = "quitarBRe" onClick="municipiosORe = quitar('municipioORe', 'tMunicipiosORe', municipiosORe);" style = "background-color: #e9ecef;" disabled></INPUT>
										        </div>
											    <div class="col-12">
										        	<label class=" form-label"></label>
												    <div style="overflow: auto; height: 153px;" class="col-12">
										            	<table class="form-control-sm table table-bordered mt-0 mb-0 fontTabla" id = "tablaMRe">
													        <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
													            <th>Municipios</th>
													        </tr>
													        <tbody id="tMunicipiosORe">
													        	<tr><td>&nbsp;</td></tr>
													        	<tr><td>&nbsp;</td></tr>
													        	<tr><td>&nbsp;</td></tr>
					                                        </tbody>
													    </table>
											        </div>
											    </div>
											</div>
											<!------------------------------ segunda columna ---------------------------->
										    <div class="row col-12 col-md-6 m-0 p-0 gy-1">
											    <div class="col-6">
											        <label class=" form-label">No. de cajas </label><INPUT id = "cajasRe" class = "form-control form-control-sm" type='text' NAME="cajasRe" autocomplete="off" title="Sólo se permiten números enteros" pattern='[0-9]+' disabled></INPUT>
											    </div>
										        <div class="col-6">
										        	<label class=" form-label">Transporte</label>
										        	<Select id = "transporteRe" class = "form-select form-select-sm col-12" name='transporteRe' disabled></Select>
										        </div>
										        <div class="col-6">
											        <label class=" form-label">Cantidad</label><INPUT id = "cantidadRe" NAME="cantidadRe" class = "form-control form-control-sm" type="number" step="0.001" min = "0.001" required title="Sólo se permiten valores numéricos con un máximo de 3 decimales" autocomplete="off" disabled></INPUT>
											    </div>
											    <div class="col-6">
										        	<label class=" form-label">Unidad de medida</label>
										        	<Select id = "unidadRe" class = "form-select form-select-sm col-12" name='unidadRe' disabled required onChange = "impDecimales('unidadRe', 'cantidadRe');">
										        		<option value="" selected>...</option>
														<option value='Kilogramos'>Kilogramos</option>
														<option value='Toneladas'>Toneladas</option>
										        	</Select>
										        </div>
										        <div class="col-6">
										        	<label class=" form-label">Producto</label><INPUT id = "productoRe" class = "form-control form-control-sm col-12" TYPE="text" maxlength='30' NAME="productoRe" required disabled pattern = "[^\u{0022}]*" title="No se permiten comillas dobles"></INPUT>
										        </div>
										        <div class="col-6">
										        	<label class=" form-label">Variedad</label>
										        	<Select id = "variedadRe" class = "form-select form-select-sm col-12" name='variedadRe' disabled>
										        		<option value="" selected>...</option>
														<option value='Hass'>Hass</option>
														<option value='Méndez'>Méndez</option>
													</Select>
										        </div>
										        <div class = "col-12">
										        	<label class="form-label">País de destino</label>
										        	<select id="paisRe" class="form-select form-select-sm col-12" name="paisRe" required disabled onChange = "impEstadoRR('paisRe', 'estadoRe', 'municipioDRe', 'regulacionRe');"></select>
										        </div>	
										        <div class="col-12">
										        	<label class=" form-label">Estado de destino</label>
										        	<Select id = "estadoRe" class = "form-select form-select-sm col-12" name='estadoRe' disabled required onChange = "impMunicipioRR('estadoRe', 'municipioDRe', 'regulacionRe')">
										        		<option value="" selected>...</option>
										        	</Select>
										        </div>
										        <div class="col-12">
										        	<label class=" form-label">Municipio de destino</label>
										        	<Select id = "municipioDRe" class = "form-select form-select-sm col-12" name='municipioDRe' disabled onChange = "impRegulacionRR('municipioDRe', 'regulacionRe');">
										        		<option value="" selected>...</option>
										        	</Select>
										        </div>
											    <div class="col-12">
											        <label class=" form-label">Puerto de entrada</label>
											        <Select id = "regulacionRe" class = "form-select form-select-sm col-12" name='regulacionRe' disabled>
										        		<option value="" selected>...</option>
													</Select>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Estatus </label>
											        <Select id = "estatusRe" class = "form-control form-control-sm col-12" name='estatusRe' required disabled>
										        		<option value="" selected></option>
										        		<option value="Original">Original</option>
										        		<option value="Reemplazo">Reemplazo</option>
										        		<option value="Cancelado">Cancelado</option>
													</Select>
											    </div>
										        <div class="col-6">
										        	<label class=" form-label">Referencia</label><INPUT id = "referenciaRe" class = "form-control form-control-sm col-12" TYPE="text" NAME="referenciaRe" title="Sólo se permiten números enteros" pattern='[0-9]+' maxlength='12' autocomplete="off" disabled></INPUT>
										        </div>
											    <div class="col-12">
											        <label class=" form-label">Observaciones</label><textarea style="height: 95px; resize: none;" id = "observacionesRe" class="form-control form-control-sm" maxlength='100' name='observacionesRe' autocomplete="off" disabled pattern = "[^\u{0022}]*" title="No se permiten comillas dobles"></textarea>
											    </div>
										        <div class="col-0 col-md-12 col-lg-12 mt-0 mt-md-5 mt-lg-5 mb-0 mb-md-1 mb-lg-1">
											    </div>
											</div>
									    </div>
									    <div class="row px-lg-5 px-2 px-md-3">
										    <div class="row col-12 m-0 p-0 gy-1 px-2">
										        <hr class="mb-1">
								            </div>
								        </div>
								        <!------------------------------ justificación ---------------------------->
								        <div class="card-body row gy-2 p-4 px-lg-5 px-2 px-md-3 justify-content-center">
										    <div class="row col-12 col-md-8 m-0 p-0 gy-1">
										    	<div class="col-12">
											        <label class=" form-label">Justificación</label><textarea style="height: 98px; resize: none;" id = "justificacionRe" class="form-control form-control-sm" name='justificacionRe' disabled required maxlength='255' autocomplete="off" pattern = "[^\u{0022}]*" title="No se permiten comillas dobles"></textarea>
											    </div>
										    </div>
										</div>
								        <div class="row px-lg-5 px-2 px-md-3">
										    <div class="row col-12 m-0 p-0 gy-1 px-2">
										        <hr class="mb-1">
								            </div>
								        </div>
									    <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3">
									        <!-- ---------------------------------botones--------------------------------- -->
									        <div class="row overflow-hidden mb-5">
									        	<div class="col-6" id="divCancelar" style="display: none;">
													<INPUT id = "cancelarBRe" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Cancelar" TYPE="button" name = "cancelarBRe" onClick="cancelar();" style = "background-color: #7eca28;"></INPUT>
												</div>
										    	<div class="col-6" id="divReemplazar">
													<INPUT id = "reemplazarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Reemplazar" TYPE="button" name = "reemplazarB" onClick="reemplazar();" style = "background-color: #7eca28;" disabled></INPUT>
												</div>
												<div class="col-6">
										            <INPUT id = "guardarB"  class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Guardar cambios" TYPE="submit" name = "guardarB" onClick="validarRe(); confirmarRe();" style = "background-color: #7eca28;" disabled></INPUT>
										        </div>
										    </div>
									    </div>
									</div>
								</FORM>
	                        </div>
	                    </div>
				    </div>
			    </div>
		    </div>
	    </div>
    </main>

	<footer>
	    <?php    
		    impPie();
	    ?>
    </footer>

    <!-- jquery -->
    <script src = "../../libraries/jquery.min.3.6.0.js"></script>
    <!-- jquery data tables -->
    <script src="../../libraries/jquery.dataTables.min.1.11.3.js"></script>
    <!-- data tables de bootstrap -->
    <script src="../../libraries/dataTables.bootstrap5.min.1.11.3.js"></script>
    <!-- tabs -->
    <script src = "../../libraries/tabs.bootstrap.js"></script>
    <!-- para el menú sticky -->
	<script src = "../app.js"></script>
    <!-- bootstrap -->
    <script src = "../../libraries/bootstrap.min.js"></script>
    <!--header DataTable-->
    <script src = "../../libraries/dataTables.fixedHeader.min.3.3.1.js"></script>

</body>
</html>