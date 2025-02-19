<?php
    session_start();
    require "funciones.php";
    $permisos = ["Administrador", "Contabilidad"];
    validarSesion($_SESSION["descripcion"], $permisos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Cuentas bancarias</title>
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
	<link rel="stylesheet" href="css/index.css"/>
	<!-- select con búsqueda -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

	<link rel="shortcut icon" href="Imagenes\icono.ico">
</head>
<body class="bg-light" onload="inicializarSelect(); impNombresBancos();">
	<script>
		var valido = false;
		const dirScriptsPhp = '<?php echo $absolutePathAwScripts ?>';
		const usuario = "<?php echo $_SESSION['nombre']; ?>";

		function inicializarSelect(){
			$('#idCuentaM, #banco').select2( {
                theme: 'bootstrap-5'
            } );
		}

		function impNombresBancos(){
			if ($("#banco").val() == ""){
				var parametros = {
					"id" : "impNombresBancos",
				}
				
				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (response) {
		            	$("#banco").html(response);
		            }
		        });
			}
		}

		function consultar() {
			var parametros = {
				"id" : "cuentasBancarias"
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	                $("#idTBody").html(response);
	            }
	        });
		}

		function validar (){
			var formulario = document.getElementById('formulario');
			valido = formulario.checkValidity();
		}

		function validarM (){
			var formulario = document.getElementById('formularioM');
			valido = formulario.checkValidity();
		}

		function registrar (){
		    if(valido == true ){
		    	var cuenta = document.getElementById("cuenta").value;
				
			    var parametros = {
				    "id" : "cuentasBancarias",
				    "banco" : $("#banco").val(),
				    "cuenta" : cuenta,
				    "clabe" : $("#clabe").val(),
				    "saldo": document.getElementById("saldo").value,
				    "usuario" : usuario		    
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'registrar.php',
		            type: 'post',
		            success:  function (response) {
		            	if (response[0] == "1"){
		            		$("#registro").html("La cuenta bancaria con número de cuenta <i>" + cuenta.toUpperCase() + "</i> ha sido registrada correctamente.");
			            	$("#titulo").html("Registro exitoso");
			                $("#banco, #cuenta, #clabe, #saldo").val('');
			                impNombresBancos();
		            	} else{
		            		if (response[0] == "2"){
			            		$("#registro").html("No es posible registrar esta cuenta bancaria, el número de cuenta <i>"+cuenta.toUpperCase()+"</i> ya está registrado.");
			            		$("#titulo").html("Número de cuenta existente");
			            	} else{
			            		if (response[0] == "3"){
				            		$("#registro").html("No es posible registrar esta cuenta bancaria, la clabe ingresada ya está registrada.");
				            		$("#titulo").html("Clabe existente");
				            	} else{
				            		$("#registro").html("No fue posible registrar la cuenta bancaria con número de cuenta <i>"+ cuenta.toUpperCase() +"</i>.");
		                            $("#titulo").html("Ha ocurrido un error");
				            	}
			            	}
		            	}        
		            	$("#abrirmodal").trigger("click");
		            },
		            error: function (){
		            	$("#registro").html("No fue posible registrar la cuenta bancaria con número de cuenta <i>"+ cuenta.toUpperCase() +"</i>.");
		                $("#titulo").html("Ha ocurrido un error");
		                $("#abrirmodal").trigger("click");
		            }
		        });
			}
	    }

	    function impCuenta(){
	        var bandera = document.getElementById("divCancelar").style.display;
			if (bandera == "none"){
		        document.getElementById("modificarB").disabled = true;
		        document.getElementById('formularioM').reset();
		        $("#idCuentaM").trigger("change");

				var parametros = {
					"id" : "impCuentaMod"
				}

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (response) {
		            	$("#idCuentaM").html(response);
		            }
		        });
			}
		}

		function obtCuenta(){
			if ($("#idCuentaM").val() != ""){
				var parametros = {
					"id" : "obtDatosCuenta",
					"cuenta" : $("#idCuentaM").val()
				}
				
				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            dataType: "json",
		            success:  function (response) {
		            	$("#bancoM").val(response.Banco);
		            	$("#clabeM").val(response.Clabe);
		            }
		        });
			} else{
				$("#bancoM, #clabeM").val("");
			}
		}

		function imprimir(){
			obtCuenta();

			if ($("#idCuentaM").val() == ""){
				document.getElementById("modificarB").disabled = true;
			} else{
				document.getElementById("modificarB").disabled = false;
			}
		}

		function modificar(){
			document.getElementById("guardarB").disabled = false;
			document.getElementById("modificarB").disabled = false;
			document.getElementById("clabeM").disabled = false;

			document.getElementById("divModificar").style.display = "none";
			document.getElementById("divCancelar").style.display = "inline";
			document.getElementById("divIdCuenta").style.display = "none";
			document.getElementById("divCuenta").style.display = "inline";

			var cuenta = document.getElementById("idCuentaM").options[document.getElementById("idCuentaM").selectedIndex].text;
			$("#cuentaM").val(cuenta);
		}

		function cancelar(){
			document.getElementById("guardarB").disabled = true;
			document.getElementById("modificarB").disabled = true;
			document.getElementById("clabeM").disabled = true;

			document.getElementById("divModificar").style.display = "inline";
			document.getElementById("divCancelar").style.display = "none";
			document.getElementById("divIdCuenta").style.display = "inline";
			document.getElementById("divCuenta").style.display = "none";

			document.getElementById('formularioM').reset();
		    impCuenta();
		}

		function guardar(){
			if(valido == true){
				var cuentaV = document.getElementById("idCuentaM").options[document.getElementById("idCuentaM").selectedIndex].text;
				var cuenta = document.getElementById("cuentaM").value;

				var parametros = {
				    "id" : "modCuentaBancaria",
				    "idBanco" : $("#idCuentaM").val(),
				    "cuenta" : cuenta,
				    "clabe" : $("#clabeM").val(),
				    "usuario" : usuario
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'registrar.php',
		            type: 'post',
		            success:  function (response) {
		                if (response[0] == "1"){
		            		$("#registro").html("La cuenta seleccionada se ha modificado exitosamente.");
			            	$("#titulo").html("Modificación exitosa");
			                cancelar();
		            	} else{
		            		if (response[0] == "2"){
			            		$("#registro").html("No es posible modificar esta cuenta bancaria, el número de cuenta <i>"+cuenta.toUpperCase()+"</i> ya está registrado.");
			            		$("#titulo").html("Número de cuenta existente");
			            	} else{
			            		if (response[0] == "3"){
				            		$("#registro").html("No es posible registrar esta cuenta bancaria, la clabe ingresada ya está registrada.");
				            		$("#titulo").html("Clabe existente");
				            	} else{
				            		$("#registro").html("No fue posible modificar la cuenta bancaria con número de cuenta <i>"+ cuentaV.toUpperCase() +"</i>.");
				                    $("#titulo").html("Ha ocurrido un error");
				            	}
			            	}
		            	}        
		            	$("#abrirmodal").trigger("click");
		            },
		            error: function (){
		            	$("#registro").html("No fue posible modificar la cuenta bancaria con número de cuenta <i>"+ cuentaV.toUpperCase() +"</i>.");
				        $("#titulo").html("Ha ocurrido un error");
		                $("#abrirmodal").trigger("click");
		            }
		        });
			}
		}
		
		function exportarTabla(){
	    	var date = Date.now();
            var hoy = new Date(date);
            hoy = formatoFecha(hoy.getDate()) + '-' + formatoFecha(hoy.getMonth() + 1) + '-' + hoy.getFullYear() + " " + formatoFecha(hoy.getHours()) + '.' + formatoFecha(hoy.getMinutes()) + '.' + formatoFecha(hoy.getSeconds());

	    	var parametros = {
				"id" : "expCuentasB"
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (data) {
	                var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
	            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "Cuentas bancarias '+ hoy +'.csv" target="_blank">descargar</a>');
	            	$('#divDes a')[0].click();
	            }
	        });
	    }
	    
	    function formatoFecha(num){
	    	num = "0" + num;
	    	return num.substring(num.length - 2);
	    }
	</script>

	<hearder>
		<div style="box-shadow: 0px 2px 10px rgba(0,0,0,.115);">
			<!-------------------------------------- Usuario ---------------------------------------------->
	        <div class="card col-12 text-white border-0" id="usuario">
	        	<iframe style="height: 75px;" src= "Imagenes\CabeceraFormulario.html"></iframe>
				<div class="card-img-overlay m-0 p-0">
				    <div class="container-fluid">
		        		<div class="col-12 row px-4 text-white align-items-center">
		        			<img src = "Imagenes\usuario.png" style="height: 45px; width: auto;" class="my-3 px-3">
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
	                            <?php echo impMenu($_SESSION['descripcion'], 'CuentasBancarias', 'principal');?>
	                        </ul>
	                    </div>
	                    <div class="col-lg-3 col-md-4 col-7 px-3 text-end" id="imgLogo">
	                	    <img src = "Imagenes\Logo2.png" class = "img-fluid" style="max-height: 68px;">
	            		</div>
	                </div>
	            </div>
	        </nav>
	    </div>
    </hearder>

    <main>
		<div class = "container-fluid">
			<div class="row py-5 justify-content-center">
				<div class = "col-12" style="max-width: 760px;" id = "tabs">
	                <!-- -----------------------------------------tabs----------------------------------------- -->
	                <ul class="nav nav-tabs cambioColor">
	                    <li class="nav-item active rounded-top" style="background-color: #19221f;">
	                        <a href="#registrar" class="nav-link active" role="tab" data-toggle="tab" onClick = "impNombresBancos(); $('#tabs').css('max-width', 760);"><strong>Registrar</strong></a>
	                    </li>

	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#consultaGen" class="nav-link" role="tab" data-toggle="tab" onClick="consultar(); $('#tabs').css('max-width', 900);"><strong>Consulta general</strong></a>
	                    </li>	     

	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#modificar" class="nav-link" role="tab" data-toggle="tab" onClick="$('#tabs').css('max-width', 760); impCuenta();"><strong>Modificar</strong></a>
	                    </li>               
	                </ul>

	                <div class="tab-content bg-white border border-top-0 rounded-3 text-justify" style="box-shadow: 0px 0px 10px #c6c6c6;">
	                	<!-- --------------------------------------------Registrar-------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane in active" id="registrar">
	                        <div class="px-5">
	                        	<!---------------------------------- formulario ---------------------------------->
	                        	<FORM id = "formulario" NAME="formulario" method = 'POST' action = '#' target ="request">
									<div class="card border-0">
									    <div class="text-center col-md-12 col-12 mt-5">
				                            <h2><strong>Registrar cuenta bancaria</strong></h2>
				                        </div>
									    <div class="card-body row gy-2 p-4 px-5">
									        <!------------------------------- Primera columna -------------------------------->
									        <div class="row col-12 m-0 p-0 mt-2 justify-content-center">
									        	<div class="row col-12 col-md-6 gy-1 m-0 p-0">
									        		<div class="col-12">
											        	<label class=" form-label">Número de cuenta</label><INPUT id = "cuenta" class = "form-control form-control-sm col-12" TYPE="text" maxlength='30' NAME="cuenta" required autocomplete="off" title="Sólo se permiten caracteres alfanuméricos" pattern='[0-9A-Za-z]+'></INPUT>
											        </div>
											        <div class="col-12">
											        	<label class=" form-label">Clabe</label><INPUT id = "clabe" class = "form-control form-control-sm col-12" TYPE="text" maxlength='25' minlength='18' NAME="clabe" required autocomplete="off" title="Sólo se permiten números" pattern='[0-9]+'></INPUT>
											        </div>
	                                            </div>
	                                            <div class="row col-12 col-md-6 gy-1 m-0 p-0">
											        <div class="col-12">
											        	<label class=" form-label">Banco</label>
											        	<Select id = "banco" class = "form-select form-select-sm col-12 select2-single" name='banco' required style="width: 100%">
											        		<option value='' selected>...</option>
											        	</Select>
	                                                </div>
	                                                <div class="col-12">
    											    	<label class=" form-label">Saldo Inicial</label><INPUT id = "saldo" class = "form-control form-control-sm" TYPE="text" NAME="saldo" required title="Este campo es para una cantidad decimal" pattern='[0-9]+\.[0-9]+' autocomplete="off"></INPUT>
    											    </div>
	                                            </div>
											</div>
									    </div>
									    <div class="row col-12 m-0 p-0 px-5 mt-2">
									        <hr/>
							            </div>
									    <div class="text-muted bg-white gy-2 p-4 pt-3 px-5">
									        <!-- ---------------------------------boton--------------------------------- -->
									        <div class="row overflow-hidden mb-5">
										    	<div class="col-12">
													<INPUT id = "registrarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Registrar" TYPE="submit" name = "registrarB" onClick="validar(); registrar();" style = "background-color: #7eca28;"></INPUT>
												</div>
										        <iframe name ="request" style="display: none;"></iframe>
										    </div>
									    </div>
									</div>
								</FORM>
	                        </div>
	                    </div>

	                    <!-- --------------------------------------------Consultar--------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="consultaGen">
	                        <div class="px-5">
	                        	<FORM id = "formularioC" NAME="formularioC" method = 'POST' action = '#' target ="request">
									<div class="card border-0 mb-4 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Consulta general de cuentas bancarias</strong></h2>
				                        </div>
			                            <div style="overflow: auto; height: 500px;" class="col-12 mt-4 mb-3">
			                                <div id="divDes" style="display: none;"></div>
							            	<table class="form-control-sm table table-bordered mt-0 mb-0 fontTabla" id = "tabla" style="width: 730px;">
										        <thead>
													<tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
											            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Banco&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>	
											            <th>Num. Cuenta</th>
											            <th>Clabe</th>	
											            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
											            <th>Saldo inicial</th>
											            <th>Saldo Actual</th>
											        </tr>
											    </thead>
										        <tbody id="idTBody">
		                                      
		                                        </tbody>
										    </table>
								        </div>
								        
								        <!------------------------------- exportar tabla -------------------------------->
				                        <div class="row m-0 p-0 mb-3">
				                            <div class="row col-12 m-0 p-0 mt-3">
										        <hr/>
								            </div>
				                        	<div class="row col-12 mt-3 m-0 px-0 pb-1">
										        <div class="col-6 col-md-4 px-1">
										        	<INPUT id = "exportarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar tabla" TYPE="button" name = "exportarB" onClick="exportarTabla();" style = "background-color: #60c438;"></INPUT>
										        </div>
											</div>
				                        </div>
								    </div>
								</FORM>
	                        </div>
	                    </div>

	                    <!-- --------------------------------------------Modificar-------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="modificar">
	                        <div class="px-5">
	                        	<!---------------------------------- formulario ---------------------------------->
	                        	<FORM id = "formularioM" NAME="formularioM" method = 'POST' action = '#' target ="request">
									<div class="card border-0">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2 class="mt-4 mb-3"><strong>Modificar cuenta bancaria</strong></h2>
				                        </div>
									    <div class="card-body row gy-2 p-4 px-5">
									        <!------------------------------- Primera columna -------------------------------->
									        <div class="row col-12 m-0 p-0 gy-1">
	                                            <div class="row col-12 col-md-6 gy-1 m-0 p-0">
									        		<div class="col-12" id = "divIdCuenta">
											        	<label class="form-label">Número de cuenta</label>
											        	<Select id = "idCuentaM" class = "form-select form-select-sm col-12 select2-single" name='idCuentaM' required onChange = "imprimir();" style="width: 100%">
											        		<option value='' selected>...</option>
											        	</Select>
											        </div>
										        	<div class="col-12" style="display: none;" id = "divCuenta">
											        	<label class=" form-label">Número de cuenta</label><INPUT id = "cuentaM" class = "form-control form-control-sm col-12" TYPE="text" maxlength='30' NAME="cuentaM" required autocomplete="off" title="Sólo se permiten caracteres alfanuméricos" pattern='[0-9A-Za-z]+'></INPUT>
											        </div>
	                                                <div class="col-12">
											        	<label class=" form-label">Clabe</label><INPUT id = "clabeM" class = "form-control form-control-sm col-12" TYPE="text" maxlength='25' minlength='18' NAME="clabeM" required autocomplete="off" title="Sólo se permiten números" pattern='[0-9]+' disabled></INPUT>
											        </div>
	                                            </div>
	                                            <div class="row col-12 col-md-6 gy-1 m-0 p-0">
											        <div class="col-12">
											        	<label class=" form-label">Banco</label><INPUT id = "bancoM" class = "form-control form-control-sm col-12" TYPE="text" NAME="bancoM" required disabled></INPUT>
	                                                </div>
	                                            </div>
										    </div>
									    </div>
									    <div class="row col-12 m-0 p-0 px-5 mt-2">
									        <hr/>
							            </div>
									    <!-- ---------------------------------boton--------------------------------- -->
									    <div class="text-muted bg-white gy-2 p-4 pt-3 px-5">
										    <div class="row overflow-hidden mb-5">
									        	<div class="col-12 col-md-6 mb-3 mb-md-0" id="divCancelar" style="display: none;">
													<INPUT id = "cancelarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Cancelar" TYPE="button" name = "cancelarB" onClick="cancelar();" style = "background-color: #7eca28;"></INPUT>
												</div>
										    	<div class="col-12 col-md-6 mb-3 mb-md-0" id="divModificar">
													<INPUT id = "modificarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Modificar" TYPE="button" name = "modificarB" onClick="modificar();" style = "background-color: #7eca28;" disabled></INPUT>
												</div>
												<div class="col-12 col-md-6">
										            <INPUT id = "guardarB"  class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Guardar cambios" TYPE="submit" name = "guardarB" onClick="validarM(); guardar();" style = "background-color: #7eca28;" disabled></INPUT>
										        </div>
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
    <script src = "../libraries/jquery.min.3.6.0.js"></script>
    <!-- tabs -->
    <script src = "../libraries/tabs.bootstrap.js"></script>
    <!-- para el menú sticky -->
	<script src = "app.js"></script>
    <!-- bootstrap -->
    <script src = "../libraries/bootstrap.min.js"></script>
    <!-- select2 -->
    <script src="../libraries/select2.full.min.4.0.13.js"></script>

</body>
</html>