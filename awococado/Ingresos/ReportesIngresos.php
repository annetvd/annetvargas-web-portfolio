<?php
    session_start();
    require "../funciones.php";
    $permisos = ["Administrador", "Contabilidad"];
    validarSesion($_SESSION["descripcion"], $permisos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Reportes de ingresos</title>
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
	<!-- select con búsqueda -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

	<link rel="shortcut icon" href="..\Imagenes\icono.ico">
</head>
<body class="bg-light"onload=" impNombre(); consRepGen(); impTipoAporta(); inicializarSelect();">
	<script>
		const dirScriptsPhp = '<?php echo $absolutePathAwScripts ?>';
		
		function inicializarSelect(){
			$('#empacadoraG, #empacadoraEC').select2( {
                theme: 'bootstrap-5'
            } );
		}

		function consRepGen(){
			var parametros = {
				"id" : "repIngresosGen",
				"fechaI" : $('#fechaIG').val(),
				"fechaF" : $('#fechaFG').val(),
				"empacadora" : $('#empacadoraG').val()
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	$("#idTBodyG").html(response);
	            }
	        });

	        impNombreRepG();
		}
		
		function impNombreRepG(){
			var empacadora = document.getElementById("empacadoraG").options[document.getElementById("empacadoraG").selectedIndex].text;
			var fechaI = $("#fechaIG").val().substring(8, 10) + "-" + $("#fechaIG").val().substring(5, 7) + "-" + $("#fechaIG").val().substring(0, 4);
			var fechaF = $("#fechaFG").val().substring(8, 10) + "-" + $("#fechaFG").val().substring(5, 7) + "-" + $("#fechaFG").val().substring(0, 4);
			var date = Date.now();
            var hoy = new Date(date);
            var mesD = "0" + (hoy.getMonth() + 1);
            mesD = mesD.substring(mesD.length - 2);
            hoy = hoy.getDate() + '-' + mesD + '-' + hoy.getFullYear();

			if ($("#fechaIG").val() != "" && $("#fechaFG").val() != "" && $("#empacadoraG").val() == ""){
				$("#tituloG").val("Reporte de ingresos " + fechaI + " al " + fechaF);
			} else{
				if ($("#fechaIG").val() != "" && $("#fechaFG").val() != "" && $("#empacadoraG").val() != ""){
					$("#tituloG").val("Reporte de ingresos, " + empacadora + " " + fechaI + " al " + fechaF);
				} else{
					if (($("#fechaIG").val() == "" && $("#fechaFG").val() == "" && $("#empacadoraG").val() == "") ||
						($("#fechaIG").val() != "" && $("#fechaFG").val() == "" && $("#empacadoraG").val() == "") ||
						($("#fechaIG").val() == "" && $("#fechaFG").val() != "" && $("#empacadoraG").val() == "")){
						$("#tituloG").val("Reporte de ingresos " + hoy);
					} else{
						$("#tituloG").val("Reporte de ingresos, " + empacadora + " " + hoy);
					}
				}
			}
		}

		function impNombre(){
			if ($("#empacadoraG").val() == "" || $("#empacadoraEC").val() == ""){
				var parametros = {
					"id" : "empacadoras"
				}

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (response) {
		            	if ($("#empacadoraG").val() == ""){
		            		$("#empacadoraG").html(response);
		            	}
		            	if ($("#empacadoraEC").val() == ""){
		            		$("#empacadoraEC").html(response);
		            	}
		            }
		        });
			}
		}

		function impTipoAporta(){
			if ($("#aportacionS").val() == ""){
				var parametros = {
					"id" : "tipoAport"
				}

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (response) {
		            	$("#aportacionS").html(response);
		            }
		        });
			}
		}

		function consRepSaldos(){
			var parametros = {
				"id" : "repIngresosSaldo",
				"fecha" : $('#mesS').val(),
				"tipoAporta" : $('#aportacionS').val()
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	$("#idTBodyS").html(response);
	            }
	        });

	        impNombreRepR();
		}

		function impNombreRepR(){
			if ($("#mesS").val() == ""){
				var date = Date.now();
                var hoy = new Date(date);
                var mesD = "0" + (hoy.getMonth() + 1);
                mesD = mesD.substring(mesD.length - 2);
				var mes = mesD + "-" + hoy.getFullYear();
			} else{
				var mes = $("#mesS").val().substring(5, 7) + "-" + $("#mesS").val().substring(0, 4);
			}
			
			var tipo = document.getElementById("aportacionS").options[document.getElementById("aportacionS").selectedIndex].text;

			if ($("#mesS").val() != "" && $("#aportacionS").val() == ""){
				$("#tituloR").val("Resumen de ingresos " + mes);
			} else{
				if ($("#mesS").val() != "" && $("#aportacionS").val() != ""){
					$("#tituloR").val("Resumen de ingresos " + mes + ", fact. de tipo " + tipo);
				} else{
					if ($("#mesS").val() == "" && $("#aportacionS").val() != ""){
						$("#tituloR").val("Resumen de ingresos " + mes + ", fact. de tipo " + tipo);
					} else{
						$("#tituloR").val("Resumen de ingresos " + mes);
					}
				}
			}
		}

		function consRepEC(){
			var parametros = {
				"id" : "repIngresosEC",
				"fechaI" : $('#fechaIEC').val(),
				"fechaF" : $('#fechaFEC').val(),
				"empacadora" : $('#empacadoraEC').val(),
				"estatus" : $('#estatusEC').val()
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	$("#idTBodyEC").html(response);
	            }
	        });

	        impNombreRepEC();
		}

		function impNombreRepEC(){
			var empacadora = document.getElementById("empacadoraEC").options[document.getElementById("empacadoraEC").selectedIndex].text;
			var fechaI = $("#fechaIEC").val().substring(8, 10) + "-" + $("#fechaIEC").val().substring(5, 7) + "-" + $("#fechaIEC").val().substring(0, 4);
			var fechaF = $("#fechaFEC").val().substring(8, 10) + "-" + $("#fechaFEC").val().substring(5, 7) + "-" + $("#fechaFEC").val().substring(0, 4);
			var estatus = document.getElementById("estatusEC").options[document.getElementById("estatusEC").selectedIndex].text;
			var date = Date.now();
            var hoy = new Date(date);
            var mesD = "0" + (hoy.getMonth() + 1);
            mesD = mesD.substring(mesD.length - 2);
            hoy = hoy.getDate() + '-' + mesD + '-' + hoy.getFullYear();

			if ($("#fechaIEC").val() != "" && $("#fechaFEC").val() != "" && $("#empacadoraEC").val() == "" && $("#estatusEC").val() == ""){
				$("#tituloEC").val("Estados de cuenta " + fechaI + " al " + fechaF);
			} else{
				if ($("#fechaIEC").val() != "" && $("#fechaFEC").val() != "" && $("#empacadoraEC").val() != "" && $("#estatusEC").val() != ""){
					$("#tituloEC").val("Estado de cuenta, " + empacadora + " " + fechaI + " al " + fechaF + ", fact. estatus - " + estatus);
				} else{
					if (($("#fechaIEC").val() == "" && $("#fechaFEC").val() == "" && $("#empacadoraEC").val() != "" && $("#estatusEC").val() == "") || 
	                    ($("#fechaIEC").val() != "" && $("#fechaFEC").val() == "" && $("#empacadoraEC").val() != "" && $("#estatusEC").val() == "") || 
	                    ($("#fechaIEC").val() == "" && $("#fechaFEC").val() != "" && $("#empacadoraEC").val() != "" && $("#estatusEC").val() == "")){

						$("#tituloEC").val("Estado de cuenta, " + empacadora + " " + hoy);
					} else{
	                    if (($("#fechaIEC").val() == "" && $("#fechaFEC").val() == "" && $("#empacadoraEC").val() == "" && $("#estatusEC").val() != "") || 
	                    	($("#fechaIEC").val() != "" && $("#fechaFEC").val() == "" && $("#empacadoraEC").val() == "" && $("#estatusEC").val() != "") || 
	                    	($("#fechaIEC").val() == "" && $("#fechaFEC").val() != "" && $("#empacadoraEC").val() == "" && $("#estatusEC").val() != "")){

							$("#tituloEC").val("Estados de cuenta, fact. estatus - " + estatus + " " + hoy);
			            } else{
			            	if ($("#fechaIEC").val() != "" && $("#fechaFEC").val() != "" && $("#empacadoraEC").val() != "" && $("#estatusEC").val() == ""){
				                $("#tituloEC").val("Estado de cuenta, " + empacadora + " " + fechaI + " al " + fechaF);
			            	} else{
			            		if ($("#fechaIEC").val() != "" && $("#fechaFEC").val() != "" && $("#empacadoraEC").val() == "" && $("#estatusEC").val() != ""){
				                    $("#tituloEC").val("Estados de cuenta " + fechaI + " al " + fechaF + ", fact. estatus - " + estatus);
			            		} else{
			            			if (($("#fechaIEC").val() != "" && $("#fechaFEC").val() == "" && $("#empacadoraEC").val() != "" && $("#estatusEC").val() != "") || 
			            				($("#fechaIEC").val() == "" && $("#fechaFEC").val() != "" && $("#empacadoraEC").val() != "" && $("#estatusEC").val() != "") || 
			            				($("#fechaIEC").val() == "" && $("#fechaFEC").val() == "" && $("#empacadoraEC").val() != "" && $("#estatusEC").val() != "")){
					                    $("#tituloEC").val("Estado de cuenta, " + empacadora + ", fact. estatus - " + estatus + " " + hoy);
				            		} else{
				            			$("#tituloEC").val("Estados de cuenta " + hoy);
				            		}
			            		}
			            	}
			            }
				    }
				}
			}
		}

		function expRepGenIng(){
			var parametros = {
			    "id" : "expRepGenIng",
				"fechaI" : $('#fechaIG').val(),
				"fechaF" : $('#fechaFG').val(),
				"empacadora" : $('#empacadoraG').val()
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (data) {
		            var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
	            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "'+ $("#tituloG").val() +'.csv" target="_blank">descargar</a>');
	            	$('#divDes a')[0].click();
	            }
	        });
		}

		function expRepResumenIng(){
			var parametros = {
			    "id" : "expRepResumenIng",
				"fecha" : $('#mesS').val(),
				"tipoAporta" : $('#aportacionS').val()
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (data) {
		            var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
	            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "'+ $("#tituloR").val() +'.csv" target="_blank">descargar</a>');
	            	$('#divDes a')[0].click();
	            }
	        });
		}

		function expRepEC(){
			var parametros = {
			    "id" : "expRepEC",
				"fechaI" : $('#fechaIEC').val(),
				"fechaF" : $('#fechaFEC').val(),
				"empacadora" : $('#empacadoraEC').val(),
				"estatus" : $('#estatusEC').val()
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (data) {
		            var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
	            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "'+ $("#tituloEC").val() +'.csv" target="_blank">descargar</a>');
	            	$('#divDes a')[0].click();
	            }
	        });
		}

		function enviarG(){
			if ($('#empacadoraG').val() != ""){
				var nombre = document.getElementById("empacadoraG").options[document.getElementById("empacadoraG").selectedIndex].text;

				var parametros = {
					"id" : "cadena",
				    "empacadoraG" : $('#empacadoraG').val(),
					"fechaIG" : $('#fechaIG').val(),
					"fechaFG" : $('#fechaFG').val()
			    }

				$.ajax({
					data: parametros,
		            url: 'ReporteIG.php',
		            type: 'post',
		            success:  function (response) {
		            	if (response[0] == "1"){
		            		$("#registro").html("Se ha enviado el reporte de ingresos a la empacadora <i>" + nombre + "</i> exitosamente.");
	                        $("#titulo").html("Reporte enviado");
		            	} else{
		            		$("#registro").html("Algo salió mal al enviar el reporte, inténtelo de nuevo.");
	                        $("#titulo").html("Ha ocurrido un error");
		            	}
			            $("#abrirmodal").trigger("click");
		            }, 
		            error: function () {
		            	$("#registro").html("Algo salió mal al enviar el reporte, inténtelo de nuevo.");
	                    $("#titulo").html("Ha ocurrido un error");
			            $("#abrirmodal").trigger("click");
		            }
		        });
			} else{
				$("#registro").html("Seleccione una empacadora.");
	            $("#titulo").html("Acción denegada");
			    $("#abrirmodal").trigger("click");
			}
		}

		function enviarEC(){
			if ($('#empacadoraEC').val() != ""){
				var nombre = document.getElementById("empacadoraEC").options[document.getElementById("empacadoraEC").selectedIndex].text;

				var parametros = {
					"id" : "cadena",
				    "empacadoraEC" : $('#empacadoraEC').val(),
					"fechaIEC" : $('#fechaIEC').val(),
					"fechaFEC" : $('#fechaFEC').val(),
					"estatusEC" : $('#estatusEC').val()
			    }

				$.ajax({
					data: parametros,
		            url: 'ReporteIEC.php',
		            type: 'post',
		            success:  function (response) {
		            	if (response[0] == "1"){
		            		$("#registro").html("Se ha enviado el estado de cuenta a la empacadora <i>" + nombre + "</i> exitosamente.");
	                        $("#titulo").html("Reporte enviado");
		            	} else{
		            		$("#registro").html("Algo salió mal al enviar el reporte, inténtelo de nuevo.");
	                        $("#titulo").html("Ha ocurrido un error");
		            	}
			            $("#abrirmodal").trigger("click");
		            }, 
		            error: function () {
		            	$("#registro").html("Algo salió mal al enviar el reporte, inténtelo de nuevo.");
	                    $("#titulo").html("Ha ocurrido un error");
			            $("#abrirmodal").trigger("click");
		            }
		        });
			} else{
				$("#registro").html("Seleccione una empacadora.");
	            $("#titulo").html("Acción denegada");
			    $("#abrirmodal").trigger("click");
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
	                            <?php echo impMenu($_SESSION['descripcion'], 'ReportesIngresos', 'ingresos');?>
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
				<div class = "col-12" style="max-width: 1000px;">
	                <!-- -----------------------------------------tabs----------------------------------------- -->
	                <ul class="nav nav-tabs cambioColor">
	                	<li class="nav-item active rounded-top" style="background-color: #19221f;">
	                        <a href="#reporte1" class="nav-link active" role="tab" data-toggle="tab" onClick="consRepGen(); impNombre();"><strong>Reporte de ingresos general</strong></a>
	                    </li>
	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#reporte2" class="nav-link" role="tab" data-toggle="tab" onClick="consRepSaldos(); impTipoAporta();"><strong>Resumen de reporte de ingresos</strong></a>
	                    </li>
	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#reporte3" class="nav-link" role="tab" data-toggle="tab" onClick="consRepEC(); impNombre();"><strong>Estados de cuenta</strong></a>
	                    </li>
	                </ul>

	                <div class="tab-content bg-white border border-top-0 rounded-3 text-justify" style="box-shadow: 0px 0px 10px #c6c6c6;">
	                	<!-- ----------------------------------------Reporte 1----------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane active" id="reporte1">
	                        <div class="px-lg-5 px-2 px-md-3">
	                        	<FORM id = "formularioG" NAME="formularioG" method = 'POST' action = 'ReporteIG.php' target="_blank">
									<div class="card border-0 mb-3 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Reporte de ingresos general</strong></h2>
				                        </div>
							            <div class="row p-4 px-1 pt-3 mb-2 justify-content-center">
							            	<div class="row col-12 gy-1">
							            		<iframe name ="request" style="display: none;"></iframe>
							            		<input id = "tituloG" type = 'hidden' name = 'tituloG' value = "Reporte de ingresos general"></input>

                                                <div class="col-6 col-md-3">
                                                	<label class=" form-label">Fecha inicial</label><input id = "fechaIG" class = "form-control form-control-sm col-12" type = 'date' name = 'fechaIG' onChange = "consRepGen();"></input>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                	<label class=" form-label">Fecha final</label><input id = "fechaFG" class = "form-control form-control-sm col-12" type = 'date' name = 'fechaFG' onChange = "consRepGen();"></input>
                                                </div>
                                                <div class="col-12 col-md-6">
	                                                <label class=" form-label">Empacadora</label>
	                                                <Select id = 'empacadoraG' name = "empacadoraG" class = "form-select form-select-sm select2-single" onChange = "consRepGen();" style="width: 100%">
	                                                	<option value="" selected>...</option>
	                                                </Select>
	                                            </div> 
                                                <div class="col-12 mt-1 row m-0 p-0">
	                                                <div class="col-6 col-md-3 mt-3">
											        	<INPUT id = "exportarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar a Excel" TYPE="button" name = "exportarB" onClick="expRepGenIng();" style = "background-color: #60c438;"></INPUT>
											        </div>
										            <div class="col-6 col-md-3 mt-3">
														<INPUT id = "pdfB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Generar reporte" TYPE="submit" name = "pdfB"  style = "background-color: #000000;"></INPUT>
													</div>
										            <div class="col-6 col-md-3 mt-3">
														<INPUT id = "envioCorreoB" class = "form-control-lg btn col-12 rounded-1" VALUE="Envíar correo" TYPE="button" name = "envioCorreoB"  style = "background-color: #e9ecef;" onClick="enviarG();"></INPUT>
													</div>
												</div>
										    </div>
							            </div>
							            <div class="row col-12 m-0 p-0 gy-1">
									        <hr>
							            </div>
										<!------------------------------------- tabla ------------------------------------------>
										<div class="p-4 px-md-3 px-2 pt-3">
				                            <div class="row align-items-start col-12 m-0 p-0 pb-0 ms-0" style="overflow: auto; height: 540px;">
				                                <div id="divDes" style="display: none;"></div>	
				                            	<table id="tablaG" class="form-control-sm table table-bordered mt-0 mb-0 fontTabla col ms-auto" style="width: 811px;">
				                            	    <thead>
	    							                    <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
		    						                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
			    					                        <th>Tipo</th>
				    				                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Concepto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
					    			                        <th>Referencia</th>
						    		                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							    	                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Abonos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								                            <th>Saldo&nbsp;inicial/<br>Saldo</th>
								                        </tr>
								                    </thead>
								                        
									                <tbody id="idTBodyG">
									                </tbody>
									            </table>
									        </div>
									    </div> 
								    </div>
								</FORM>
	                        </div>
	                    </div>

	                	<!-- ----------------------------------------Reporte 2----------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="reporte2">
	                        <div class="px-lg-5 px-2 px-md-3">
	                        	<FORM id = "formularioS" NAME="formularioS" method = 'POST' action = 'ReporteIR.php' target="_blank">
									<div class="card border-0 mb-3 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Resumen de reporte de ingresos</strong></h2>
				                        </div>
							            <div class="row p-4 px-1 pt-3 mb-2 justify-content-center">
							            	<div class="row col-12 gy-1">
							            		<input id = "tituloR" type = 'hidden' name = 'tituloR' value = "Resumen de reporte de ingresos"></input>

                                                <div class="col-6 col-md-3">
                                                	<label class=" form-label">Fecha inicial</label><input id = "mesS" class = "form-control form-control-sm col-12" type = 'month' name = 'mesS' onChange = "consRepSaldos();"></input>
                                                </div>
                                                <div class="col-6 col-md-3">
	                                                <label class=" form-label">Tipo de aportación</label>
	                                                <Select id = 'aportacionS' name = "aportacionS" class = "form-select form-select-sm col-12" onChange = "consRepSaldos();">
	                                                	<option value="" selected>...</option>
	                                                </Select>
	                                            </div> 
                                                <div class="col-6 col-md-3">
                                                	<label class=" form-label"></label>
										        	<INPUT id = "exportarBS" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar a Excel" TYPE="button" name = "exportarBS" onClick="expRepResumenIng();" style = "background-color: #60c438;"></INPUT>
										        </div>
									            <div class="col-6 col-md-3">
									            	<label class=" form-label"></label>
													<INPUT id = "pdfBS" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Generar reporte" TYPE="submit" name = "pdfBS"  style = "background-color: #000000;"></INPUT>
												</div>
										    </div>
							            </div>
							            <div class="row col-12 m-0 p-0 gy-1">
									        <hr>
							            </div>
										<!------------------------------------- tabla ------------------------------------------>
										<div class="p-4 px-md-3 px-2 pt-3">
				                            <div class="row align-items-start col-12 m-0 p-0 pb-0 ms-0" style="overflow: auto; height: 540px;">
				                                <div id="divDes" style="display: none;"></div>	
				                            	<table id="tablaS" class="form-control-sm table table-bordered mt-0 mb-0 fontTabla col ms-auto" style="width: 797px;">
				                            	    <thead>
	    							                    <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
		    						                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Empacadora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
			    					                        <th>Saldo inicial</th>
				    				                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
					    			                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Abonos&nbsp;&nbsp;&nbsp;&nbsp;</th>
						    		                        <th>Saldo final</th>
							    	                    </tr>
								                    </thead>
								                        
									                <tbody id="idTBodyS">
									                </tbody>
									            </table>
									        </div>
									    </div> 
								    </div>
								</FORM>
	                        </div>
	                    </div>

	                    <!-- ----------------------------------------Reporte 3----------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="reporte3">
	                        <div class="px-lg-5 px-2 px-md-3">
	                        	<FORM id = "formularioEC" NAME="formularioEC" method = 'POST' action = 'ReporteIEC.php' target="_blank">
									<div class="card border-0 mb-3 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Estados de cuenta</strong></h2>
				                        </div>
							            <div class="row p-4 px-1 pt-3 mb-2 justify-content-center">
							            	<div class="row col-12 gy-1">
							            		<input id = "tituloEC" type = 'hidden' name = 'tituloEC' value = "Estados de cuenta"></input>

                                                <div class="col-6 col-md-3">
                                                	<label class=" form-label">Fecha inicial</label><input id = "fechaIEC" class = "form-control form-control-sm col-12" type = 'date' name = 'fechaIEC' onChange = "consRepEC();"></input>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                	<label class=" form-label">Fecha final</label><input id = "fechaFEC" class = "form-control form-control-sm col-12" type = 'date' name = 'fechaFEC' onChange = "consRepEC();"></input>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-6">
	                                                <label class=" form-label">Empacadora</label>
	                                                <Select id = 'empacadoraEC' name = "empacadoraEC" class = "form-select form-select-sm col-12 select2-single" onChange = "consRepEC();" style="width: 100%">
	                                                	<option value="" selected>...</option>
	                                                </Select>
	                                            </div> 
                                                <div class="col-12 mt-1 row m-0 p-0">
                                                	<div class="col-6 col-md-3">
		                                                <label class=" form-label">Estatus</label>
		                                                <Select id = 'estatusEC' name = "estatusEC" class = "form-select form-select-sm col-12" onChange = "consRepEC();">
		                                                	<option value="" selected>...</option>
		                                                	<option value="Pendiente">Pendiente</option>
		                                                	<option value="Pagada">Pagada</option>
		                                                </Select>
		                                            </div> 
	                                                <div class="col-6 col-md-3 mt-3">
											        	<INPUT id = "exportarBEC" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar a Excel" TYPE="button" name = "exportarBEC" onClick="expRepEC();" style = "background-color: #60c438;"></INPUT>
											        </div>
										            <div class="col-6 col-md-3 mt-3">
														<INPUT id = "pdfBEC" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Generar reporte" TYPE="submit" name = "pdfBEC"  style = "background-color: #000000;"></INPUT>
													</div>
										            <div class="col-6 col-md-3 mt-3">
														<INPUT id = "envioCorreoBEC" class = "form-control-lg btn col-12 rounded-1" VALUE="Envíar correo" TYPE="button" name = "envioCorreoBEC" onClick="enviarEC();" style = "background-color: #e9ecef;"></INPUT>
													</div>
												</div>
										    </div>
							            </div>
							            <div class="row col-12 m-0 p-0 gy-1">
									        <hr>
							            </div>
										<!------------------------------------- tabla ------------------------------------------>
										<div class="p-4 px-md-3 px-2 pt-3">
				                            <div class="row align-items-start col-12 m-0 p-0 pb-0 ms-0" style="overflow: auto; height: 540px;">
				                                <div id="divDes" style="display: none;"></div>	
				                            	<table id="tablaEC" class="form-control-sm table table-bordered mt-0 mb-0 fontTabla col ms-auto" style="width: 811px;">
				                            	    <thead>
    								                    <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
	    							                    	<th>Factura</th>
		    						                    	<th>Exportación&nbsp;del&nbsp;mes</th>
			    					                    	<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kg.&nbsp;Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
				    				                    	<th>Tasa</th>
					    			                    	<th>&nbsp;&nbsp;&nbsp;Cantidad&nbsp;x&nbsp;&nbsp;&nbsp; (Cvos/Kg)</th>
						    		                    	<th>Facturado</th>
							    	                    	<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha&nbsp;de&nbsp;pago&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								                        	<th>Cantidad pagada</th>
								                        	<th>Saldo&nbsp;a cubrir</th>
								                        	<th>Estatus</th>
								                        </tr>
								                    </thead>
								                        
									                <tbody id="idTBodyEC">
									                </tbody>
									            </table>
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
    <!-- tabs -->
    <script src = "../../libraries/tabs.bootstrap.js"></script>
    <!-- para el menú sticky -->
	<script src = "../app.js"></script>
    <!-- bootstrap -->
    <script src = "../../libraries/bootstrap.min.js"></script>
    <!-- select2 -->
    <script src="../../libraries/select2.full.min.4.0.13.js"></script>
	
</body>
</html>