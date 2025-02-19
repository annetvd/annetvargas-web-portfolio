<?php
    session_start();
    require "../funciones.php";
    $permisos = ["Administrador", "Contabilidad", "Estadística"];
    validarSesion($_SESSION["descripcion"], $permisos);
    
    $tipoUsuario = $_SESSION['descripcion'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Reporte de aportaciones</title>
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

	<link rel="shortcut icon" href="..\Imagenes\icono.ico">
</head>
<body class="bg-light">
	<script>
		const dirScriptsPhp = '<?php echo $absolutePathAwScripts ?>';
	    var meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];

		document.addEventListener("DOMContentLoaded", () => {
			inicTabla();
		});
		
		function inicTabla() {
			var id = "conCuotas";
		    $('#tablaCuotas').DataTable({
		    	"ajax":{            
			        "url": dirScriptsPhp + "consultar.php", 
			        "method": 'POST',
			        "data": {
			        	id: id,
					    mes: function() { return $('#fecha').val() },
					    filtro: function() { return $('#filtro').val() }
					}
			    },
		    	"columns": [
					{ "data": "Empaque" },
					{ "data": "Cantidad" },
					{ "data": "Aportacion" },
					{ "data": "Factura" }
			    ],
			    "columnDefs": [
                    { className: "dt-right", "targets": [1, 2] }
                ],
			    fixedHeader: {
                    header: true,
                    headerOffset: $('#barra').height() - 6
                },
                scrollX: true
		    });
		    
		    var mes = $("#fecha").val();
		    
		    if (mes == ""){
				mes = new Date();
				mes = mes.getFullYear() + "-" + (mes.getMonth() + 1);
			}
			
			var año = mes.substring(0, 4);
	        var aux = mes.substring(5, 7);
			$("#mes").html("Kg " + meses[parseInt(aux,10) - 1] + " " + año);
		}

		function consultar() {
		    var mes = $("#fecha").val();
		    
		    if (mes == ""){
				mes = new Date();
				mes = mes.getFullYear() + "-" + (mes.getMonth() + 1);
			}
			
			var año = mes.substring(0, 4);
	        var aux = mes.substring(5, 7);
			$("#mes").html("Kg " + meses[parseInt(aux,10) - 1] + " " + año);
			
			if ($.fn.DataTable.isDataTable("#tablaCuotas")) {
                $.ajax({
	                success:  function () {
	                    $("#tablaCuotas").DataTable().ajax.reload(null, false);
	                }
	            });
            } else {
                setTimeout(consutar, 1000);
            }
		}

		function exportarTabla(){
			document.getElementById("nombreDes").value = "";
			$("#abrirmodalDes").trigger("click");
		}

		function descargarCSV(){
			var date = Date.now();
            var hoy = new Date(date);
			hoy = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear() + " " + hoy.getHours() + '.' + hoy.getMinutes() + '.' + hoy.getSeconds();
			// nombreCsv = document.getElementById("nombreDes").value;

			// if (nombreCsv != ""){
				var expCuotas = "expCuotas";
				var tabla = $("#tablaCuotas").DataTable().rows({ filter : 'applied'}).data();
				var arreglo = [];

	            $.each( tabla, function( key, value ) {
				    arreglo[key] = value;
				});

				var parametros = {
				    "id" : expCuotas,
				    "mes" : $("#mes").html(),
				    "datos" : JSON.stringify(arreglo)
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (data) {
			            var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
		            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "Aportaciones ' + $("#mes").html().substring(2, 11) + ' ' + hoy +'.csv" target="_blank">descargar</a>');
		            	$('#divDes a')[0].click();
		            }
		        });
			// } else{
			// 	$("#registro").html("No es posible descargar el archivo, no le ha asignado ningun nombre.");
		 //        $("#titulo").html("Acción denegada");
		 //        $("#abrirmodal").trigger("click");
			// }
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
	                            <?php echo impMenu($_SESSION['descripcion'], 'RepAportaciones', 'aportaciones');?>
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
				<div class = "col-12 pt-3" style="max-width: 1100px;">
	                <!-- -----------------------------------------tabs----------------------------------------- -->
	                <ul class="nav nav-tabs cambioColor mt-4">
	                	<li class="nav-item active rounded-top" style="background-color: #19221f;">
	                        <!--<a href="#cuotasM" class="nav-link active" role="tab" data-toggle="tab" onClick=""><strong>Cuotas mensuales</strong></a>-->
	                    </li>
	                </ul>

	                <div class="tab-content bg-white border border-top-0 rounded-3 text-justify" style="box-shadow: 0px 0px 10px #c6c6c6;">
	                	<!-- ----------------------------------------Consultar----------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane active" id="cuotasM">
	                        <div class="px-lg-5 px-2 px-md-3">
	                        	<FORM id = "formularioC" NAME="formularioC" method = 'POST' action = '#' target ="request">
									<div class="card border-0 mb-4 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Consultar aportaciones mensuales</strong></h2>
				                        </div>
				                        <!---------------------------------------- periodo -------------------------------------------->
				                        <div class="row m-0 p-0 gy-1 mt-3 mb-0">
				                        	<div class="row col-12 m-0 p-0 gy-1 mb-2">
				                        	    <div class="col-12 col-md-6 col-lg-3" <?php if (!($tipoUsuario == "Administrador" || $tipoUsuario == "Contabilidad")){ echo "Style='display: none;'"; }?>>
										        	<label class=" form-label">Empaques</label>
										        	<Select id = "filtro" class = "form-select form-select-sm col-12" name='filtro' onChange = "consultar();">
										        		<option value="" selected>Todos</option>
														<option value='No'>No requieren factura</option>
														<option value='Si'>Requieren factura</option>
										        	</Select>
										        </div>
											    <div class="col-12 col-md-6 col-lg-3">
											        <label class=" form-label">Mes</label><input id = "fecha" class = "form-select form-select-sm col-12" name='fecha' onChange = "consultar();" type = 'month'></input>
											    </div>
										        <div class="col-6 col-md-6 col-lg-3">
										        	<label class=" form-label"></label>
										        	<INPUT id = "exportarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar tabla" TYPE="button" name = "exportarB" onClick="descargarCSV();" style = "background-color: #60c438;"></INPUT>
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
				                            	<table id="tablaCuotas" class="table table-bordered display" style = "width: 100%">
									                <thead>
									                    <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
									                        <th>Empaque</th>
									                        <th id = "mes"></th>
									                        <th>Aportación</th>
									                        <th>Factura</th>
									                    </tr>
									                </thead>
									                <tbody id="idTBody">
									                </tbody>
									            </table>
									        </div>
									        
									        <iframe name ="request" style="display: none;"></iframe>
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
								            <INPUT id = "nombreDes" class = "form-control form-control-sm col-12 mt-3" TYPE="text" NAME="nombreDes" autocomplete="off"></INPUT>
								        </div>
								        <div class="modal-footer">
								            <button type="button" class="btn text-white" style = "background-color: #19221f;" data-dismiss="modal">Cancelar</button>
								            <button id = "confDes" type="button" class="btn text-white" name = "confDes" onClick="descargarCSV();" style = "background-color: #318a3a;" data-dismiss="modal">Descargar</button>
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