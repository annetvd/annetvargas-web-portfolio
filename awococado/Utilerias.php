<?php
    session_start();
    require "funciones.php";
    $permisos = ["Administrador"];
    validarSesion($_SESSION["descripcion"], $permisos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Utilerías</title>
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
	<!--------- dataTables ----------->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">

	<link rel="shortcut icon" href="Imagenes\icono.ico">
</head>
<body class="bg-light" onload = "cargarResp();">
	<script>
		var valido = false;
		const dirScriptsPhp = '<?php echo $absolutePathAwScripts ?>';
		const usuario = "<?php echo $_SESSION['nombre']; ?>";

		document.addEventListener("DOMContentLoaded", () => {
			inicTablaBit();
		});
		
		function inicTablaBit() {
			var id = "conBitacora";
		    $('#tablaBitacora').DataTable({
		    	"ajax":{            
			        "url": dirScriptsPhp + "consultar.php", 
			        "method": 'POST',
			        "data": {
			        	id: id
					}
			    },
			    "columns": [
					{ "data": "FechaHora" },
					{ "data": "Formulario" },
					{ "data": "Usuario" },
					{ "data": "Descripcion"},
					{ "data": "Mensaje" }
			    ],
                order: [[0, 'desc']],
			    fixedHeader: {
                    header: true,
                    headerOffset: $('#barra').height() - 6
                },
                scrollX: true
		    })
		}

		function consultarBit() {
			if ($.fn.DataTable.isDataTable("#tablaBitacora")) {
                $.ajax({
	                success:  function () {
	                    $("#tablaBitacora").DataTable().ajax.reload(null, false);
	                }
	            });
            } else {
                setTimeout(consutar, 1000);
            }
		}

		function validarMod (){
			var formulario = document.getElementById('formularioMod');
			valido = formulario.checkValidity();
		}

		function validarH (){
			var formulario = document.getElementById('formularioH');
			valido = formulario.checkValidity();
		}

		function respaldar(){
			if (valido == true){
				var nombre = document.getElementById("nombreResp").value;
				var respaldo = "respaldo";

				var parametros = {
					"id" : respaldo,
					"nombre" : nombre
				}

				$.ajax({
					data: parametros,
					url: dirScriptsPhp + 'registrar.php',
					type: "post",
					success: function (response) {
		            	$("#cerrarBResp").click();
						if(response[0] == "0"){
		            		$("#registro").html("La base de datos ha sido respaldada exitosamente");
		            	    $("#titulo").html("Respaldo exitoso");
		            	    $("#abrirmodal").trigger("click");
		            	} else {
		            	    $("#registro").html("No se ha podido respaldar la base de datos");
		            	    $("#titulo").html("Ha ocurrido un error");
		            	    $("#abrirmodal").trigger("click");
		            	}
		            	cargarResp();
					}
				})
			}
		}

		function cargarResp(){
			var cargRespaldo = "cargRespaldo";

			var parametros = {
				"id" : cargRespaldo
			}

			$.ajax({
				data: parametros,
				url: dirScriptsPhp + 'consultar.php',
				type: "post",
				success: function (response) {
	            	$("#divArchivos").html(response);
				}
			})
		}

		function impArchivos(){
			var impArchivos = "impArchivos";

			var parametros = {
				"id" : impArchivos
			}

			$.ajax({
				data: parametros,
				url: dirScriptsPhp + 'consultar.php',
				type: "post",
				success: function (response) {
	            	$("#archivoSql").html(response);
				}
			})
		}

		function validarModRest (){
			var formulario = document.getElementById('formularioModRest');
			valido = formulario.checkValidity();
		}

		function restaurar(){
			if (valido == true){
				var nombre = document.getElementById("archivoSql").value;
				var restaurar = "restaurar";

				var parametros = {
					"id" : restaurar,
					"nombre" : nombre
				}

				$.ajax({
					data: parametros,
					url: dirScriptsPhp + 'registrar.php',
					type: "post",
					success: function (response) {
		            	$("#cerrarBRest").click();
						if(response[0] == "0"){
		            		$("#registro").html("La base de datos ha sido restaurada exitosamente");
		            	    $("#titulo").html("Restauración exitosa");
		            	    $("#abrirmodal").trigger("click");
		            	} else {
		            	    $("#registro").html("No se ha podido restaurar la base de datos");
		            	    $("#titulo").html("Ha ocurrido un error");
		            	    $("#abrirmodal").trigger("click");
		            	}
					}
				})
			}
		}

		function confirmar(){
			if(valido == true ){
				$("#bodyConf").html("Confirmo que deseo realizar el traspaso histórico del año "+document.getElementById("añoH").value);
				$("#abrirmodalC").trigger("click");
			}
		}

		function impAños(){
			var impAñosT = "impAñosT";

			var parametros = {
				"id" : impAñosT
			}

			$.ajax({
				data: parametros,
				url: dirScriptsPhp + 'consultar.php',
				type: "post",
				success: function (response) {
	            	$("#añoH").html(response);
				}
			})
		}

		function traspasar(){
			var traspasarH = "traspasarH";
			var año = document.getElementById("añoH").value;

			var parametros = {
				"id" : traspasarH,
				"año" : año
			}

			$.ajax({
				data: parametros,
				url: dirScriptsPhp + 'registrar.php',
				type: "post",
				success: function (response) {
	            	if(response[0] == "1"){
	            		$("#registro").html("La base de datos ha sido traspasada a históricos exitosamente");
	            	    $("#titulo").html("Traspaso exitoso");
	            	    $("#abrirmodal").trigger("click");
	            	    impAños();
	            	} else {
	            	    $("#registro").html("No se ha podido traspasar la base de datos a históricos");
	            	    $("#titulo").html("Ha ocurrido un error");
	            	    $("#abrirmodal").trigger("click");
	            	}
				}
			})
		}
		
		function exportarTabla(){
	    	var date = Date.now();
            var hoy = new Date(date);
            hoy = formatoFecha(hoy.getDate()) + '-' + formatoFecha(hoy.getMonth() + 1) + '-' + hoy.getFullYear() + " " + formatoFecha(hoy.getHours()) + '.' + formatoFecha(hoy.getMinutes()) + '.' + formatoFecha(hoy.getSeconds());

	    	var tabla = $("#tablaBitacora").DataTable().rows({ filter : 'applied'}).data();
			var arreglo = [];

            $.each( tabla, function( key, value ) {
			    arreglo[key] = value;
			});

			var parametros = {
			    "id" : "expBitacora",
			    "datos" : JSON.stringify(arreglo)
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (data) {
		            var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
	            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "Bitácora de errores '+ hoy +'.csv" target="_blank">descargar</a>');
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
	                            <?php echo impMenu($_SESSION['descripcion'], 'Utilerias', 'principal');?>
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
				<div class = "col-12" style="max-width: 1100px;">
	                <!-- -----------------------------------------tabs----------------------------------------- -->
	                <ul class="nav nav-tabs cambioColor">
	                     <li class="nav-item rounded-top active" style="background-color: #19221f;">
	                        <a href="#bitacora" class="nav-link active" role="tab" data-toggle="tab" onClick="consultarBit();"><strong>Bitácora</strong></a>
	                    </li>
	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#backupResp" class="nav-link" role="tab" data-toggle="tab" onClick="cargarResp();"><strong>Respaldar y restaurar</strong></a>
	                    </li>
	                </ul>

	                <div class="tab-content bg-white border border-top-0 rounded-3 text-justify" style="box-shadow: 0px 0px 10px #c6c6c6;">
	                     <!------------------------------------------Consultar----------------------------------------- -->
	                     <div role="tabpanel" class="tab-pane active" id="bitacora">
	                        <div class="px-lg-5 px-2 px-md-3">
	                        	<FORM id = "formularioU" NAME="formularioU" method = 'POST' action = '#' target ="request">
									<div class="card border-0 mb-4 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Bitácora de errores</strong></h2>
				                        </div>
										<!------------------------------------- tabla ------------------------------------------>
										<div class="px-2 mt-3">
				                            <div class="col-12 mt-0 mb-3 pt-3 pb-0">
				                            	<table id="tablaBitacora" class="table table-bordered display" style="width: 1600px;">
									                <thead>
									                    <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
									                        <th>Fecha&nbsp;y&nbsp;hora</th>
									                        <th>Formulario</th>
									                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
									                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Descripción&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
									                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mensaje&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
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
				    				            <div id="divDes" style="display: none;"></div>
				                            	<div class="row col-12 mt-3 m-0 px-0 pb-1">
						    				        <div class="col-6 px-1 col-md-3">
							    			        	<INPUT id = "exportarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar tabla" TYPE="button" name = "exportarB" onClick="exportarTabla();" style = "background-color: #60c438;"></INPUT>
								    		        </div>
									    		</div>
				                            </div>
									    </div> 
								    </div>
								</FORM>
	                        </div>
	                    </div>

	                    <!-- -------------------------------copia de seguridad y respaldo--------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="backupResp">
	                        <div class="px-lg-5 px-2 px-md-3">
	                        	<FORM id = "formularioBR" NAME="formularioBR" method = 'POST' action = '#' target ="request">
									<div class="card border-0 mb-4 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Respaldar y restaurar la base de datos</strong></h2>
				                        </div>
			                            <!------------------------------- Apartado de busqueda -------------------------------->
								        <div class="row col-12 col-md-8 col-lg-6 m-0 p-0 gy-1 mt-4">
			                                <div class="col-6">
												<INPUT id = "respaldarB" class = "form-control-lg btn btn-sm col-12 rounded-1 text-white" VALUE="Respaldar" TYPE="button" name = "respaldarB" data-toggle="modal" data-target="#respaldarMod" style = "background-color: #318a3a;" onClick="document.getElementById('nombreResp').value = '';"></INPUT>
											</div>
											<div class="col-6">
												<INPUT id = "restaurarB" class = "form-control-lg btn btn-sm col-12 rounded-1 text-white" VALUE="Restaurar" TYPE="submit" name = "recuperarB" data-toggle="modal" data-target="#restaurarMod" onClick="impArchivos();" style = "background-color: #318a3a;"></INPUT>
											</div>
										</div>
										<!------------------------------------- tabla ------------------------------------------>
										<div class="px-2 mt-5">
				                            <div class="col-12 mt-0 mb-3 pt-3 pb-4 bg-light row p-0 m-0 rounded-3" style="overflow: auto; height: 400px;" id="divArchivos">
											</div>
									    </div> 
								    </div>
								</FORM>
	                        </div>
	                    </div>

	                    <!-- ---------------------------------------- traspaso a históricos ----------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="historicos">
	                        <div class="px-lg-5 px-2 px-md-3">
	                        	<FORM id = "formularioH" NAME="formularioH" method = 'POST' action = '#' target ="request">
									<div class="card border-0 mb-4 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Traspaso a históricos</strong></h2>
				                        </div>
										<!------------------------------------- cuadro gris ------------------------------------------>
										<div class="px-2 mt-2">
				                            <div class="col-12 pt-3 pb-4 row justify-content-center p-0 m-0">
				                            	<!------------------------------- Apartado de busqueda -------------------------------->
										        <div class="row col-12 col-md-6 col-lg-5 m-0 p-0 px-4">
										        	<div class="card border-0 bg-light">
													    <div class="card-body row p-4 px-5 mt-4">
													        <!--------------------------- Primera columna --------------------------->
													        <div class="col-12">
																<label class=" form-label">Año</label>
														        <Select id = "añoH" class = "form-select form-select-sm col-12" name='añoH' required></Select>
															</div>
													    </div>
													    <!-- ------------------------------boton------------------------------ -->
													    <div class="text-muted bg-light gy-2 p-4 px-5 mb-4 pt-0">
													    	<div class="col-12 mb-3">
																<INPUT id = "traspasarB" class = "form-control-lg btn btn-sm col-12 rounded-1 text-white" VALUE="Traspasar" TYPE="submit" name = "traspasarB" data-toggle="modal" data-target="#traspasarMod" onClick="validarH(); confirmar();" style = "background-color: #318a3a;"></INPUT>
															</div>
													    </div>
													</div>
												</div>
											</div>
									    </div> 
								    </div>
								</FORM>
	                        </div>
	                    </div>

	                    <!------------------------------------------ modal, notificación -------------------------------------->
	                    <div class="container">
	                    	<FORM id = "formularioMod" NAME="formularioMod" method = 'POST' action = '#' target ="request">
		                        <div id="respaldarMod" class="modal fade" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
								    <div class="modal-dialog modal-md modal-dialog-top">
									    <div class="modal-content">
									        <div class="modal-header">
									            <h5 class="modal-title">Guardar como</h5>
									            <button type="button" class="close border-0" data-dismiss="modal">X</button>
									        </div>
									        <div class="modal-body">
									            <p>Por favor ingrese el nombre del archivo de respaldo</p>
									            <INPUT id = "nombreResp" class = "form-control form-control-sm col-12 mt-3" TYPE="text" NAME="nombreResp" required pattern='[A-Z0-9a-z\-.,_]+' autocomplete="off" title="Sólo se permiten números, letras y los caracteres . , - _" maxlength='30'></INPUT>
									        </div>
									        <div class="modal-footer">
									            <input type="button" class="btn text-white" style = "background-color: #19221f;" data-dismiss="modal" id="cerrarBResp" value="Cancelar"></input>
									            <input id = "confResp" type="submit" class="btn text-white" name = "confResp" onClick="validarMod(); respaldar();" style = "background-color: #318a3a;" value="Guardar"></input>
									        </div>
									    </div>
								    </div>
								</div>
							</FORM>
							<iframe name ="request" style="display: none;"></iframe>

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

						    <FORM id = "formularioModRest" NAME="formularioModRest" method = 'POST' action = '#' target ="request">
		                        <div id="restaurarMod" class="modal fade" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
								    <div class="modal-dialog modal-md modal-dialog-top">
									    <div class="modal-content">
									        <div class="modal-header">
									            <h5 class="modal-title">Restaurar la base de datos</h5>
									            <button type="button" class="close border-0" data-dismiss="modal">X</button>
									        </div>
									        <div class="modal-body">
									            <p>Archivo sql</p>
									            <Select id = "archivoSql" class = "form-select form-select-sm col-12" name='archivoSql' required></Select>
									        </div>
									        <div class="modal-footer">
									            <input type="button" class="btn text-white" style = "background-color: #19221f;" data-dismiss="modal" id="cerrarBRest" value="Cancelar"></input>
									            <input id = "confResp" type="submit" class="btn text-white" name = "confResp" onClick="validarModRest(); restaurar();" style = "background-color: #318a3a;" value="Restaurar"></input>
									        </div>
									    </div>
								    </div>
								</div>
							</FORM>

							<INPUT id = "abrirmodalC" data-toggle="modal" data-target="#confirmacion" VALUE="abrirmodalC" TYPE="button" style = "display: none;"></INPUT>

						    <div id="confirmacion" class="modal fade" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
							    <div class="modal-dialog modal-md modal-dialog-top">
								    <div class="modal-content">
								        <div class="modal-header">
								            <h5 class="modal-title">Confirmar traspaso a históricos</h5>
								            <button type="button" class="close border-0" data-dismiss="modal">X</button>
								        </div>
								        <div class="modal-body">
								            <p id="bodyConf"></p>
								        </div>
								        <div class="modal-footer">
								            <button type="button" class="btn text-white" style = "background-color: #19221f;" data-dismiss="modal">Cancelar</button>
								            <button id = "confirmarB" type="button" class="btn text-white" name = "confirmarB" onClick="traspasar();" style = "background-color: #318a3a;" data-dismiss="modal">Traspasar</button>
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
    <!-- jquery data tables -->
    <script src="../libraries/jquery.dataTables.min.1.11.3.js"></script>
    <!-- data tables de bootstrap -->
    <script src="../libraries/dataTables.bootstrap5.min.1.11.3.js"></script>
    <!-- tabs -->
    <script src = "../libraries/tabs.bootstrap.js"></script>
    <!-- para el menú sticky -->
	<script src = "app.js"></script>
    <!-- bootstrap -->
    <script src = "../libraries/bootstrap.min.js"></script>
    <!--header DataTable-->
    <script src = "../libraries/dataTables.fixedHeader.min.3.3.1.js"></script>

</body>
</html>