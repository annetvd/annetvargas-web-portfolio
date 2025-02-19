<?php
    session_start();
    require "funciones.php";
    $permisos = ["Administrador", "Contabilidad"];
    validarSesion($_SESSION["descripcion"], $permisos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Regímenes</title>
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

	<link rel="shortcut icon" href="Imagenes\icono.ico">
</head>
<body class="bg-light">
	<script>
		const tabla = 'regimen';
		var valido = false;
		const dirScriptsPhp = '<?php echo $absolutePathAwScripts ?>';
		const usuario = "<?php echo $_SESSION['nombre']; ?>";

		function consultar() {
			var parametros = {
				"id" : tabla
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

		function registrar (){
		    if(valido == true ){
			    var parametros = {
				    "id" : tabla,
				    "codigo" : document.getElementById('codigo').value,
				    "regimen" : document.getElementById('regimen').value,
				    "usuario" : usuario
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'registrar.php',
		            type: 'post',
		            success:  function (response) {
		                if (response[0] == "1"){
		            		$("#registro").html("El régimen <i>" + $('#regimen').val() + "</i> ha sido registrado correctamente.");
			            	$("#titulo").html("Registro exitoso");
			                $("#codigo, #regimen").val('');
		            	} else{
		            		if (response[0] == "2"){
			            		$("#registro").html("No es posible registrar el régimen <i>"+$('#regimen').val()+"</i>, el código ingresado ya existe.");
			            		$("#titulo").html("Código existente");
			            	} else{
			            		if (response[0] == "4"){
			            		    $("#registro").html("No es posible registrar el régimen <i>"+$('#regimen').val()+"</i>, este ya existe.");
			            		    $("#titulo").html("Régimen existente");
			            		} else{
			            			$("#registro").html("No fue posible registrar el régimen <i>"+$('#regimen').val()+"</i>.");
			                        $("#titulo").html("Ha ocurrido un error");
			            		}
			            	}
		            	}        
		            	$("#abrirmodal").trigger("click");
		            },
		            error: function (){
		            	$("#registro").html("No fue posible registrar el régimen <i>"+$('#regimen').val()+"</i>.");
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
				"id" : "expRegimenes"
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (data) {
	                var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
	            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "Regímenes '+ hoy +'.csv" target="_blank">descargar</a>');
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
	                            <?php echo impMenu($_SESSION['descripcion'], 'Regimen', 'principal');?>
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
				<div class = "col-12" style="max-width: 560px;" id = "tabs">
	                <!-- -----------------------------------------tabs----------------------------------------- -->
	                <ul class="nav nav-tabs cambioColor">
	                    <li class="nav-item active rounded-top" style="background-color: #19221f;">
	                        <a href="#registrar" class="nav-link active" role="tab" data-toggle="tab" onClick = "$('#tabs').css('max-width', 560);"><strong>Registrar</strong></a>
	                    </li>

	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#consultaGen" class="nav-link" role="tab" data-toggle="tab" onClick="consultar(); $('#tabs').css('max-width', 790);"><strong>Consulta general</strong></a>
	                    </li>
	                </ul>

	                <div class="tab-content bg-white border border-top-0 rounded-3 text-justify" style="box-shadow: 0px 0px 10px #c6c6c6;">
	                	<!-- --------------------------------------------Registrar-------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane in active" id="registrar">
	                        <div class="px-5">
	                        	<!---------------------------------- formulario ---------------------------------->
	                        	<FORM id = "formulario" NAME="INSERTAR" method = 'POST' action = '#' target ="request">
									<div class="card border-0">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2 class="mt-4 mb-3"><strong>Registrar régimen</strong></h2>
				                        </div>
									    <div class="card-body row gy-2 p-4 px-5">
									        <!------------------------------- Primera columna -------------------------------->
									        <div class="row col-12 m-0 p-0 gy-1 mt-1">
										        <div class="col-12">
										        	<label class=" form-label">Régimen</label><textarea id = "regimen" class = "form-control form-control-sm" maxlength='255' NAME="regimen" required autocomplete="off" style="height: 118px; resize: none;" pattern = "[^\u{0022}]*" title="No se permiten comillas dobles"></textarea>
										        </div>
										        <div class="col-md-6 col-lg-6 col-8">
										        	<label class=" form-label">Código</label><INPUT id = "codigo" class = "form-control form-control-sm col-12" TYPE="text" maxlength='11' NAME="codigo" required autocomplete="off" title="Sólo se permiten números enteros" pattern='[0-9]+'></INPUT>
										        </div>
										    </div>
									    </div>
									    <div class="row col-12 m-0 p-0 px-5 mt-2">
									        <hr/>
							            </div>
									    <!-- ---------------------------------boton--------------------------------- -->
									    <div class="text-muted bg-white gy-2 p-4 pt-3 px-5">
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

	                    <!-- --------------------------------------------Consultar--------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="consultaGen">
	                        <div class="px-5">
	                        	<FORM id = "formulario" NAME="INSERTAR" method = 'POST' action = '#' target ="request">
									<div class="card border-0 mb-4 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Consulta general de regímenes</strong></h2>
				                        </div>
			                            <div style="overflow: auto; height: 500px;" class="col-12 mt-4 mb-3">
							            	<table class="form-control-sm table table-bordered mt-0 mb-0 fontTabla" id = "tabla" style="width: 610px;">
										        <thead>
											        <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
											            <th>Régimen</th>
											            <th>Código</th>
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
										        <div class="col-6 px-1 col-md-5">
										        	<INPUT id = "exportarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar tabla" TYPE="button" name = "exportarB" onClick="exportarTabla();" style = "background-color: #60c438;"></INPUT>
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
    <script src = "../libraries/jquery.min.3.6.0.js"></script>
    <!-- tabs -->
    <script src = "../libraries/tabs.bootstrap.js"></script>
    <!-- para el menú sticky -->
	<script src = "app.js"></script>
    <!-- bootstrap -->
    <script src = "../libraries/bootstrap.min.js"></script>

</body>
</html>