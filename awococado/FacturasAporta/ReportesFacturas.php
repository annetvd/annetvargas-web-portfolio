<?php
    session_start();
    require "../funciones.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Reportes Facturas</title>
    <meta name charset="utf-8"/>
    <meta name = "autor" content = ""/>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"/>

	<link rel="shortcut icon" href="..\Imagenes\icono.ico">

	<style type="text/css">
		.cambioColor a {
		    color: white;
		}

		.cambioColor a:hover {
		    color: #f5ffd5;
		}

		.header{
            position: fixed;
            width: 100%;
            z-index: 1000;
            top: 0;
            box-shadow: 0px 2px 10px rgba(0,0,0,.115);
        }

        .espacio{
        	margin-bottom: 75px;
        }
	</style>
</head>
<body class="bg-light"onload=" impNombre();">
	<script>
		const tabla = 'bancos';
		var valido = false;

        function impNombre(){
			var empacadoras = "empacadoras";
			var mun = document.getElementById("empacadora").value; 
		

			var parametros = {
				"id" : empacadoras
			}

			$.ajax({
				data: parametros,
	            url: '/consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	$("#empacadora").html(response);
	            }
	        });
		}

		function validar (){
			var formulario = document.getElementById('formulario');
			valido = formulario.checkValidity();
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
	                            <?php echo impMenu($_SESSION['descripcion'], 'ReportesFacturas', 'facturasAporta');?>
	                        </ul>
	                    </div>
	                    <div class="col-lg-3 col-md-4 col-7 px-3 text-end" id="imgLogo">
	                	    <img src = "..\Imagenes\Logo.png" class = "img-fluid" style="max-height: 68px;">
	            		</div>
	                </div>
	            </div>
	        </nav>
	    </div>
    </hearder>

    <main>
		<div class = "container-fluid">
			<div class="row py-5 justify-content-center">
				<div class = "col-12" style="max-width: 800px;">
	                <!-- -----------------------------------------tabs----------------------------------------- -->
	                <ul class="nav nav-tabs cambioColor">
	                    <li class="nav-item active rounded-top" style="background-color: #19221f;">
	                        <a href="#registrar" class="nav-link active" role="tab" data-toggle="tab" onClick=""><strong>FACTURAS POR PERIODO</strong></a>
	                    </li>

	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#consultaGen" class="nav-link" role="tab" data-toggle="tab" onClick="impNombre();"><strong>FACTURAS POR EMPACADORA</strong></a>
	                    </li>
						<li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#modificar" class="nav-link" role="tab" data-toggle="tab" onClick="impNombre();"><strong>FACTURAS POR ESTATUS</strong></a>
	                    </li>

	                    
	                </ul>

	                <div class="tab-content bg-white border border-top-0 rounded-3 text-justify" style="box-shadow: 0px 0px 10px #c6c6c6;">
	                	<!-- --------------------------------------------Registrar-------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane in active" id="registrar">
	                        <div class="px-5">
	                        	<!---------------------------------- formulario ---------------------------------->
	                        	<FORM id = "formulario" NAME="INSERTAR" method = 'POST' action = 'ReporteFacturas.php' target ="_Black">
									<div class="card border-0">
									    <div class="text-center col-md-12 col-12 mt-5">
				                            <h2><strong>REPORTE POR PERIODO</strong></h2>
				                        </div>
									    <div class="card-body row gy-2 p-4 px-5">
									        <!------------------------------- Primera columna -------------------------------->
									        <div class="row m-0 p-0 gy-1 mt-3 mb-0">
                                                <div class="row col-12 m-0 p-0 gy-1 mb-2">
                                                <div class="col-6 col-md-3 col-lg-3">
                                                        <label class=" form-label">Fecha inicial</label><input id = "fechaI" class = "form-control form-control-sm col-12" type = 'date' name = 'fechaI' onChange = "consultar();"></input>
                                                    </div>
                                                    <div class="col-6 col-md-3 col-lg-3">
                                                        <label class=" form-label">Fecha final</label><input id = "fechaF" class = "form-control form-control-sm col-12" type = 'date' name = 'fechaF' onChange = "consultar();"></input>
                                                    </div>
                                                    
                                                </div>
                                            </div>
											<!------------------------------- Segunda columna -------------------------------->
										    <div class="row col-12 col-md-6 m-0 p-0 gy-1">
                                            </div>
									    </div>
									    <div class="card-footer text-muted bg-white gy-2 p-4 px-5">
									        <!-- ---------------------------------boton--------------------------------- -->
									        <div class="row overflow-hidden mb-5">
										    	<div class="col-7">
													<INPUT id = "Imprimir" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Imprimir" TYPE="submit" name = "Imprimir"  style = "background-color: #7eca28;"></INPUT>
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
							    <div class="modal-dialog modal-sm modal-dialog-top">
							        <div class="modal-content">
								        <!-- cabecera del diálogo -->
								        <div class="modal-header">
								            <h5 class="modal-title" id="titulo"></h5>
								            <button type="button" class="close border-0" data-dismiss="modal">X</button>
								        </div>
								    
								        <!-- cuerpo del diálogo -->
								        <div class="modal-body" style="height: 120px;">
								            <p>El registro a nombre de "<span id = "registro"></span>" ha sido guardado correctamente.</p>
									    </div> 
							        </div>
							    </div>
						    </div> 
						</div>

	                    <!-- --------------------------------------------Consultar--------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="consultaGen">
	                        <div class="px-5">
	                        	<FORM id = "formulario" NAME="INSERTAR" method = 'POST' action = 'ReporteFacturasN.php' target ="_Black">
									<div class="card border-0 mb-4 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>FACTURAS POR EMPACADORA</strong></h2>
				                        </div>
			                            <div class="row col-12 col-md-6 m-0 p-0 gy-1">
                                            <div class="col-12">
                                                <label class=" form-label">Empacadora</label>
                                                <Select id = "empacadora" class = "form-select form-select-sm col-12" name='empacadora'></Select>
                                            </div>
                                            <div class="row col-12 m-0 p-0 gy-1 mt-4">
									            <hr/>
											</div>   
                                            <div class="row overflow-hidden mb-5">
										    	<div class="col-7">
													<INPUT id = "Imprimir1" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Imprimir" TYPE="submit" name = "Imprimir1"  style = "background-color: #7eca28;"></INPUT>
												</div>
										        <iframe name ="request" style="display: none;"></iframe>
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
	                        	<FORM id = "formulario" NAME="INSERTAR" method = 'POST' action = 'ReporteFacturasE.php' target ="_Black">
									<div class="card border-0 mb-4 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>FACTURAS POR ESTATUS</strong></h2>
				                        </div>
			                            <div class="row col-12 col-md-6 m-0 p-0 gy-1">
                                            <div class="col-12">
                                                <label class=" form-label">Empacadora</label>
                                                <Select id = "estatus" class = "form-select form-select-sm col-12" name='estatus'>
													<option value="...">...</option>
													<option value="Pendiente">Pendiente</option>
													<option value="Pagada">Pagadas</option>
												</Select>
                                            </div>
                                            <div class="row col-12 m-0 p-0 gy-1 mt-4">
									            <hr/>
											</div>   
                                            <div class="row overflow-hidden mb-5">
										    	<div class="col-7">
													<INPUT id = "Imprimir1" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Imprimir" TYPE="submit" name = "Imprimir1"  style = "background-color: #7eca28;"></INPUT>
												</div>
										        <iframe name ="request" style="display: none;"></iframe>
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
	
</body>
</html>