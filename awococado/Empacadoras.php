<?php
    session_start();
    require "funciones.php";
    $permisos = ["Administrador", "Contabilidad", "Estadística"];
    validarSesion($_SESSION["descripcion"], $permisos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Empacadoras</title>
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
    <!-- select con búsqueda -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

	<link rel="shortcut icon" href="Imagenes\icono.ico">
</head>
<body class="bg-light" onload="impMunicipio(); impRegimen(); inicializarSelect(); impNombresBancos();">
	<script>
		const tabla = 'empacadora';
		const usuario = "<?php echo $_SESSION['nombre']; ?>";
		var valido = false;
		const dirScriptsPhp = '<?php echo $absolutePathAwScripts ?>';

		function inicializarSelect(){
			$('#municipio, #banco, #regimen, #idEmpacadoraM, #municipioM, #bancoM, #regimenM').select2( {
                theme: 'bootstrap-5'
            } );
		}

		document.addEventListener("DOMContentLoaded", () => {
			inicTabla();
		});
		
		function inicTabla() {
			var id = "conEmpacadoras";
		    $('#tablaEmp').DataTable({
		    	"ajax":{           
			        "url": dirScriptsPhp + "consultar.php", 
			        "method": 'POST',
			        "data": {
			        	id: id
					}
			    },
		    	"columns": [
					{ "data": "Nombre" },
					{ "data": "Sader" },
					{ "data": "Municipio"},
					{ "data": "CP" },
					{ "data": "Direccion" },
					{ "data": "Telefono" },
					{ "data": "Correo" },
					{ "data": "Facturacion" },
					{ "data": "RFC" },
					{ "data": "Banco" },
					{ "data": "NumCuenta" },
					{ "data": "Clabe" },
					{ "data": "Regimen" },
					{ "data": "Saldo" },
					{ "data": "Activa" }
			    ],
			    "columnDefs": [
                    { className: "dt-right", "targets": [12] }
                ],
			    fixedHeader: {
                    header: true,
                    headerOffset: $('#barra').height() - 6
                },
                scrollX: true
		    })
		}

		function impNombresBancos(){
			if ($("#banco").val() == "" || $("#bancoM").val() == ""){
			    var bancoM = document.getElementById("divCancelar").style.display;

				var parametros = {
					"id" : "impNombresBancos",
				}
				
				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (response) {
		            	if ($("#banco").val() == ""){
		            		$("#banco").html(response);
		            	}
		            	if (bancoM == "none"){
	            	        $("#bancoM").html(response);
		            	}
		            }
		        });
			}
		}

		function impMunicipio(){
			if ($("#municipio").val() == "" || $("#municipioM").val() == ""){
				var municipios = "municipiosO";
				var mun = document.getElementById("municipio").value; 
				var munM = document.getElementById("divCancelar").style.display;

				var parametros = {
					"id" : municipios
				}

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (response) {
		            	if(mun == ""){
		            	    $("#municipio").html(response);
			            }
			            if (munM == "none"){
		            	    $("#municipioM").html(response);
		            	}
		            }
		        });
			}
		}
		
		function impRegimen(){
			if ($("#regimen").val() == "" || $("#regimenM").val() == ""){
				var impRegimen = "impRegimen";
				var reg = document.getElementById("regimen").value; 
				var regM = document.getElementById("divCancelar").style.display;

				var parametros = {
					"id" : impRegimen
				}

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (response) {
		            	if(reg == ""){
		            	    $("#regimen").html(response);
			            }
			            if (regM == "none"){
		            	    $("#regimenM").html(response);
		            	}
		            }
		        });
			}
		}

		function impNombre(){
			var bandera = document.getElementById("divCancelar").style.display;
			if (bandera == "none"){
				var idEmpacadora = "empacadoras";
				var parametros = {
					"id" : idEmpacadora
				}

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (response) {
		            	$("#idEmpacadoraM").html(response);
		            }
		        });

		        document.getElementById('formularioM').reset();
		        document.getElementById("modificarB").disabled = true;
		        $('#municipioM, #bancoM, #regimenM').trigger("change");
			}
		}

		function consultar() {
			if ($.fn.DataTable.isDataTable("#tablaEmp")) {
                $.ajax({
	                success:  function () {
	                    $("#tablaEmp").DataTable().ajax.reload(null, false);
	                }
	            });
            } else {
                setTimeout(consutar, 1000);
            }
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
		    	var nombre = document.getElementById("nombre").value;
		    	
		    	if (document.getElementById('factSi').checked == true){
		    	    var facturacion = 1;
		    	} else{
		    	    var facturacion = 0;
		    	}

		    	if (document.getElementById('actSi').checked == true){
		    	    var activacion = 1;
		    	} else{
		    	    var activacion = 0;
		    	}

			    var parametros = {
				    "id" : tabla,
				    "nombre" : nombre,
				    "RFC" : document.getElementById('RFC').value,
				    "CP" : document.getElementById('CP').value,
				    "direccion" : document.getElementById('direccion').value,
				    "correo" : document.getElementById('correo').value,
				    "sader" : document.getElementById('sader').value,
				    "telefono" : document.getElementById('telefono').value,
				    "municipio" : document.getElementById('municipio').value,
				    "banco" : document.getElementById('banco').value,
				    "cuenta" : document.getElementById('cuenta').value,
				    "clabe" : document.getElementById('clabe').value,
				    "regimen" : document.getElementById('regimen').value,
				    "activacion" : activacion,
				    "facturacion" : facturacion,
				    "usuario" : usuario
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'registrar.php',
		            type: 'post',
		            success:  function (response) {
		                if (response[0] == "1"){
		            		$("#registro").html("La empacadora <i>" + nombre + "</i> ha sido registrada correctamente.");
			            	$("#titulo").html("Registro exitoso");
			                document.getElementById('formulario').reset();
			                $('#municipio, #banco, #regimen').trigger("change");
			                impMunicipio();
			                impRegimen();
			                impNombresBancos();
		            	} else{
		            		if (response[0] == "2"){
			            		$("#registro").html("No es posible registrar a la empacadora <i>"+nombre+"</i> esta ya existe.");
		            		    $("#titulo").html("Empacadora existente");
			            	} else{
			            		if (response[0] == "4"){
			            			$("#registro").html("No es posible registrar a la empacadora <i>"+nombre+"</i> esta ya está registrada en la tabla de usuarios.");
			            		    $("#titulo").html("Usuario existente");
			            		} else{
			            			if (response[0] == "5"){
			            				$("#registro").html("No es posible registrar a la empacadora <i>"+nombre+"</i> el correo ingresado ya está registrado en la tabla de usuarios.");
			            		        $("#titulo").html("Correo existente");
			            			} else{
			            				if (response[0] == "6"){
				            				$("#registro").html("No es posible registrar a la empacadora <i>"+nombre+"</i> el RFC ingresado ya ha sido registrado en otra empacadora.");
				            		        $("#titulo").html("RFC existente");
				            			} else{
				            				if (response[0] == "7"){
					            				$("#registro").html("No es posible registrar a la empacadora <i>"+nombre+"</i> el número de cuenta ingresado ya ha sido registrado.");
					            		        $("#titulo").html("Número de cuenta existente");
					            			} else{
					            				if (response[0] == "8"){
						            				$("#registro").html("No es posible registrar a la empacadora <i>"+nombre+"</i> la clabe ingresada ya ha sido registrada.");
						            		        $("#titulo").html("Clabe existente");
						            			} else{
						            				$("#registro").html("No fue posible registrar a la empacadora <i>"+nombre+"</i>.");
						            		        $("#titulo").html("Ha ocurrido un error");
						            			}
					            			}
				            			}
			            			}
			            		}
			            	}   
		            	}        
		            	$("#abrirmodal").trigger("click");
		            },
		            error: function (){
		            	$("#registro").html("No fue posible registrar a la empacadora <i>"+nombre+"</i>.");
				        $("#titulo").html("Ha ocurrido un error");
		                $("#abrirmodal").trigger("click");
		            }
		        });
			}
	    }

	    function imprimir() {
			var obtEmpacadora = "obtEmpacadora";
			var idEmpacadora = document.getElementById("idEmpacadoraM").value;
			var nomEmpa = document.getElementById("idEmpacadoraM").options[document.getElementById("idEmpacadoraM").selectedIndex].text;

			if (nomEmpa == "..."){
				document.getElementById('formularioM').reset();
				$('#municipioM, #bancoM, #regimenM').val("");
				$('#municipioM, #bancoM, #regimenM').trigger("change");
				document.getElementById("modificarB").disabled = true;
			}else{
				var parametros = {
					"id" : obtEmpacadora,
					"idEmpacadora" : idEmpacadora
				}

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            dataType: "json",
		            success:  function (response) {
		            	rellenar(response.result.RFC, response.result.Nombre, response.result.Direccion, response.result.Activa, response.result.Correo, response.result.Sader, response.result.CP, response.result.Telefono, response.result.IdMunicipio, response.result.Facturacion, response.result.Banco, response.result.NumCuenta, response.result.Clabe, response.result.IdRegimen);
		            }
		        });
			}
		} 

		async function rellenar(RFC, nom, dir, act, email, sad, CP, tel, mun, fact, ban, cuenta, clabe, reg){
			if (reg == 0){
				reg = "";
			}
			if (ban == 0){
				ban = "";
			}
			document.getElementById("RFCM").value = RFC;
			document.getElementById("nombreM").value = nom;
			document.getElementById("direccionM").value = dir;
			document.getElementById("correoM").value = email;
			document.getElementById("saderM").value = sad;
			document.getElementById("CPM").value = CP;
			document.getElementById("telefonoM").value = tel;
			document.getElementById("municipioM").value = mun;
			document.getElementById("bancoM").value = ban;
			document.getElementById("cuentaM").value = cuenta;
			document.getElementById("clabeM").value = clabe;
			document.getElementById("regimenM").value = reg;	
			document.getElementById("modificarB").disabled = false;

			////////////////////////// facturación ///////////////////////////
			
			if (fact == "1"){
				document.getElementById("factSiM").checked = true;
			} else{
				document.getElementById("factNoM").checked = true;
			}

			////////////////////////// activación ///////////////////////////
			if (act == "1"){
				document.getElementById("actSiM").checked = true;
			} else{
				document.getElementById("actNoM").checked = true;
			}

			$('#municipioM, #bancoM, #regimenM').trigger("change");
		}

		function modificar(){
			document.getElementById("direccionM").disabled = false;
			document.getElementById("correoM").disabled = false;
			document.getElementById("saderM").disabled = false;
			document.getElementById("CPM").disabled = false;
			document.getElementById("telefonoM").disabled = false;
			document.getElementById("municipioM").disabled = false;
			document.getElementById("bancoM").disabled = false;	
			document.getElementById("cuentaM").disabled = false;
			document.getElementById("clabeM").disabled = false;
			document.getElementById("regimenM").disabled = false;
			document.getElementById("facturacionM").style.background = "#ffffff";
			document.getElementById("activacionM").style.background = "#ffffff";
			document.getElementById("factSiM").disabled = false;
			document.getElementById("factNoM").disabled = false;
			document.getElementById("actSiM").disabled = false;
			document.getElementById("actNoM").disabled = false;

			document.getElementById("guardarB").disabled = false;
			document.getElementById("modificarB").disabled = false;

			document.getElementById("divModificar").style.display = "none";
			document.getElementById("divCancelar").style.display = "inline";
			document.getElementById("divIdEmpacadora").style.display = "none";
			document.getElementById("divEmpacadora").style.display = "inline";

			//////////////////// RFC 
			if ($("#RFCM").val() == ""){
				document.getElementById("RFCM").disabled = false;
			}
		}

		function guardar(){
			if(valido == true ){
				var nombre = document.getElementById("nombreM").value;

		    	if (document.getElementById('factSiM').checked == true){
		    	    var facturacion = 1;
		    	} else{
		    	    var facturacion = 0;
		    	}

		    	if (document.getElementById('actSiM').checked == true){
		    	    var activacion = 1;
		    	} else{
		    	    var activacion = 0;
		    	}

			    var parametros = {
				    "id" : "modificarEmpacadora",
				    "idEmpacadora" : document.getElementById("idEmpacadoraM").value,
				    "nombre" : nombre,
				    "CP" : document.getElementById('CPM').value,
				    "direccion" : document.getElementById('direccionM').value,
				    "correo" : document.getElementById('correoM').value,
				    "sader" : document.getElementById('saderM').value,
				    "telefono" : document.getElementById('telefonoM').value,
				    "municipio" : document.getElementById('municipioM').value,
				    "banco" : document.getElementById('bancoM').value,
				    "cuenta" : document.getElementById('cuentaM').value,
				    "clabe" : document.getElementById('clabeM').value,
				    "regimen" : document.getElementById('regimenM').value,
				    "RFC" : document.getElementById('RFCM').value,
				    "activacion" : activacion,
				    "facturacion" : facturacion,
				    "usuario" : usuario
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'registrar.php',
		            type: 'post',
		            success:  function (response) {
		                if (response[0] == "1"){
		            		$("#registro").html("El registro a nombre de la empacadora <i>" + nombre + "</i> ha sido modificado correctamente.");
			            	$("#titulo").html("Modificación exitosa");
			                cancelar();
		            	} else{
		            		if (response[0] == "3"){
			            		$("#registro").html("No es posible modificar el registro a nombre de la empacadora <i>"+nombre+"</i> el RFC ingresado ya ha sido registrado en otra empacadora.");
				                $("#titulo").html("RFC existente");
			            	} else{
			            		if (response[0] == "4"){
				            		$("#registro").html("No es posible modificar el registro a nombre de la empacadora <i>"+nombre+"</i> el número de cuenta ingresado ya ha sido registrado.");
					                $("#titulo").html("Número de cuenta existente");
				            	} else{
				            		if (response[0] == "5"){
					            		$("#registro").html("No es posible modificar el registro a nombre de la empacadora <i>"+nombre+"</i> la clabe ingresada ya ha sido registrada.");
						                $("#titulo").html("Clabe existente");
					            	} else{
					            		if (response[0] == "6"){
						            		$("#registro").html("No es posible modificar el registro a nombre de la empacadora <i>"+nombre+"</i> el correo ingresado ya está registrado en la tabla de usuarios.");
							                $("#titulo").html("Correo existente");
						            	} else{
						            		if (response[0] == "7"){
							            		$("#registro").html("No es posible modificar el registro a nombre de la empacadora <i>"+nombre+"</i> el nombre ingresado ya está registrado en otra empacadora.");
							                    $("#titulo").html("Empacadora existente");
							            	} else{
							            		$("#registro").html("No fue posible modificar el registro a nombre de la empacadora <i>"+nombre+"</i>.");
								                $("#titulo").html("Ha ocurrido un error");
							            	}
						            	}
					            	}
				            	}
			            	}  
		            	}        
		            	$("#abrirmodal").trigger("click");
		            },
		            error: function (){
		            	$("#registro").html("No fue posible modificar el registro a nombre de la empacadora <i>"+nombre+"</i>.");
			            $("#titulo").html("Ha ocurrido un error");
		                $("#abrirmodal").trigger("click");
		            }
		        });
			}
		}

		function cancelar(){
	        document.getElementById("direccionM").disabled = true;
			document.getElementById("RFCM").disabled = true;
			document.getElementById("correoM").disabled = true;
			document.getElementById("saderM").disabled = true;
			document.getElementById("CPM").disabled = true;
			document.getElementById("telefonoM").disabled = true;
			document.getElementById("municipioM").disabled = true;
			document.getElementById("bancoM").disabled = true;	
			document.getElementById("cuentaM").disabled = true;
			document.getElementById("clabeM").disabled = true;
			document.getElementById("regimenM").disabled = true;
			document.getElementById("facturacionM").style.background = "#e9ecef";
			document.getElementById("activacionM").style.background = "#e9ecef";
			document.getElementById("factSiM").disabled = true;
			document.getElementById("factNoM").disabled = true;
			document.getElementById("actSiM").disabled = true;
			document.getElementById("actNoM").disabled = true;

			document.getElementById("guardarB").disabled = true;
			document.getElementById("modificarB").disabled = true;

			document.getElementById("divModificar").style.display = "inline";
			document.getElementById("divCancelar").style.display = "none";
			document.getElementById("divIdEmpacadora").style.display = "inline";
			document.getElementById("divEmpacadora").style.display = "none";

			document.getElementById('formularioM').reset();
			$('#idEmpacadoraM').trigger("change");
		    impNombre();
		    impMunicipio();
			impRegimen();
			impNombresBancos();
		}

		function exportarTabla(){
			var date = Date.now();
            var hoy = new Date(date);
            hoy = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear() + " " + hoy.getHours() + '.' + hoy.getMinutes() + '.' + hoy.getSeconds();
			var tabla = $("#tablaEmp").DataTable().rows({ filter : 'applied'}).data();
			var arreglo = [];

            $.each( tabla, function( key, value ) {
			    arreglo[key] = value;
			});

			var parametros = {
			    "id" : "expEmpacadora",
			    "datos" : JSON.stringify(arreglo)
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (data) {
		            var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
	            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "Empacadoras '+ hoy +'.csv" target="_blank">descargar</a>');
	            	$('#divDes a')[0].click();
	            }
	        });
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
	                            <?php echo impMenu($_SESSION['descripcion'], 'Empacadoras', 'principal');?>
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
	                    <li class="nav-item active rounded-top" style="background-color: #19221f;">
	                        <a href="#registrar" class="nav-link active" role="tab" data-toggle="tab" onClick="impMunicipio(); impRegimen(); impNombresBancos();"><strong>Registrar</strong></a>
	                    </li>

	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#consultaGen" class="nav-link" role="tab" data-toggle="tab" onClick="consultar();"><strong>Consulta general</strong></a>
	                    </li>

	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#modificar" class="nav-link" role="tab" data-toggle="tab" onClick = "impNombre(); impMunicipio(); impRegimen(); impNombresBancos();"><strong>Modificar</strong></a>
	                    </li>
	                </ul>

	                <div class="tab-content bg-white border border-top-0 rounded-3 text-justify" style="box-shadow: 0px 0px 10px #c6c6c6;">
	                	<!-- --------------------------------------------Registrar-------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane in active" id="registrar">
	                        <div class="px-5">
	                        	<!---------------------------------- formulario ---------------------------------->
	                        	<FORM id = "formulario" NAME="INSERTAR" method = 'POST' action = '#' target ="request">
									<div class="card border-0">
									    <div class="text-center col-md-12 col-12 mt-5">
				                            <h2><strong>Registrar empacadora</strong></h2>
				                        </div>
									    <div class="card-body row gy-2 p-4 px-lg-5 px-2 px-md-3">
									        <!------------------------------- Primera columna -------------------------------->
									        <div class="row col-12 col-md-6 m-0 p-0 gy-1">
										        <div class="col-12">
										        	<label class=" form-label">Nombre</label><INPUT id = "nombre" class = "form-control form-control-sm col-12" TYPE="text" maxlength='100' NAME="nombre" pattern = "[^\u{0022}]*" title="No se permiten comillas dobles" required autocomplete="off"></INPUT>
										        </div>
											    <div class="col-6">
											        <label class=" form-label">Registro SADER</label><INPUT id = "sader" class = "form-control form-control-sm" type='text' maxlength='20' NAME="sader" autocomplete="off" required pattern = "[^a-z\u{0022}]*" title="No se permiten comillas dobles ni letras minúsculas, escriba en mayúsculas"></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Activa</label><div class = "form-control form-control-sm text-center">
											        	<div class="form-check-sm form-check-inline">
												        	<input class="form-check-input" type="radio" name="activacion" id="actSi" value = "1" checked>
	                                                        <label class="form-check-label" for="actSi">Si</label>
	                                                    </div>
	                                                    <div class="form-check-sm form-check-inline">
												        	<input class="form-check-input" type="radio" name="activacion" id="actNo" value = "0">
	                                                        <label class="form-check-label" for="actNo">No</label>
	                                                    </div>
											        </div>
											    </div>
											    <div class="col-8">
											        <label class=" form-label">Municipio</label>
											        <Select id = "municipio" class = "form-select form-select-sm col-12 select2-single" name='municipio' required style="width: 100%">
											        	<option value='' selected>...</option>
											        </Select>
											    </div>
											    <div class="col-4">
											        <label class="form-label col-12">CP</label><INPUT id = "CP" class = "form-control form-control-sm" TYPE="text" maxlength='5' NAME="CP" required title="Sólo se permiten números" pattern='[0-9]+' minlength='5' autocomplete="off"></INPUT>
											    </div>
											    <div class="col-12">
											        <label class=" form-label">Dirección</label><textarea id = "direccion" class = "form-control form-control-sm" maxlength='255' NAME="direccion" pattern = "[^\u{0022}]*" title="No se permiten comillas dobles" required autocomplete="off" style="height: 100px; resize: none;"></textarea>
											    </div>
											    <div class="col-12">
											        <label class=" form-label col-12">Email</label><INPUT id = "correo" class = "form-control form-control-sm col-12" type = 'text' maxlength='50' NAME="correo" required autocomplete="off" pattern="[A-Za-z0-9\._%+\-\(\)\[\]!$&'\*\/=\?\^`\{\}\|:;,~ñÑ#]+@[a-z0-9\.\-]+\.[a-z]{2,}$" title="No se permiten caracteres fuera de: _%+-()[]!$&'*/=?^`{}|:;,~#. Verifica que la dirección esté bien escrita."></INPUT>
											    </div>
											</div>
											<!------------------------------- Segunda columna -------------------------------->
										    <div class="row col-12 col-md-6 m-0 p-0 gy-1">
											    <div class="col-6">
											        <label class=" form-label">Teléfono</label><INPUT id = "telefono" class = "form-control form-control-sm" type='tel' maxlength='10' minlength='10' NAME="telefono" autocomplete="off" required title="Sólo se permiten números" pattern='[0-9]+'></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Facturación</label><div class = "form-control form-control-sm text-center">
											        	<div class="form-check-sm form-check-inline">
												        	<input class="form-check-input" type="radio" name="facturacion" id="factSi" value = "1" checked>
	                                                        <label class="form-check-label" for="factSi">Si</label>
	                                                    </div>
	                                                    <div class="form-check-sm form-check-inline">
												        	<input class="form-check-input" type="radio" name="facturacion" id="factNo" value = "0">
	                                                        <label class="form-check-label" for="factNo">No</label>
	                                                    </div>
											        </div>
											    </div>
											    <div class="col-12">
										        	<label class=" form-label">Banco</label>
										        	<Select id = "banco" class = "form-select form-select-sm col-12 select2-single" name='banco' style="width: 100%">
										        		<option value='' selected>...</option>
										        	</Select>
                                                </div>
											    <div class="col-12">
											        <label class=" form-label">No. Cuenta</label><INPUT id = "cuenta" class = "form-control form-control-sm" type='text' maxlength='30' NAME="cuenta" autocomplete="off" title="Sólo se permiten caracteres alfanuméricos" pattern='[0-9A-Za-z]+'></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Clabe</label><INPUT id = "clabe" class = "form-control form-control-sm" type='text' maxlength='25' minlength='18' NAME="clabe" autocomplete="off" title="Sólo se permiten números" pattern='[0-9]+'></INPUT>
											    </div>
										        <div class="col-6">
										        	<label class="form-label">RFC</label><INPUT id = "RFC" class = "form-control form-control-sm col-12" TYPE="text" maxlength='13' NAME="RFC" minlength='10' autocomplete="off" pattern = "[^\u{0022}]*" title="No se permiten comillas dobles"></INPUT>
										        </div>
											    <div class="col-12">
											        <label class=" form-label">Regimen</label>
											        <Select id = "regimen" class = "form-select form-select-sm col-12 select2-single" name='regimen' style="width: 100%">
											        	<option value='' selected>...</option>
											        </Select>
											    </div>
											    <div class="col-0 col-md-12 mt-0 mt-md-4 mb-0 mb-md-4"><div class="mt-0 mt-md-3"></div>
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
	                        <div class="px-lg-5 px-2 px-md-3">
	                        	<FORM id = "formulario" NAME="INSERTAR" method = 'POST' action = '#' target ="request">
									<div class="card border-0 mb-4 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Consulta general de empacadoras</strong></h2>
				                        </div>
				                        
				                        <!------------------------------------- tabla ------------------------------------------>
				                        <div class="px-2 mt-4">
									        <div class="col-12 mt-0 mb-1 pt-3 pb-2">
					                            <div id="divDes" style="display: none;"></div>	
									            <table id="tablaEmp" class="table table-bordered display" style="width: 1850px;">
										            <thead>
										                <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
										                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Empacadora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
												            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registro&nbsp;SADER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
												            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Municipio&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
												            <th>CP</th>
												            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dirección&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
												            <th>Teléfono</th>
												            <th>Email</th>
												            <th>Facturación</th>
												            <th>RFC</th>
												            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Banco&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
												            <th>No. Cuenta</th>
												            <th>Clabe</th>
												            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Régimen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
												            <th>Saldo</th>
												            <th>Activa</th>
											            </tr>
											        </thead>
											        <tbody id="idTBody">
											        </tbody>
											    </table>
										    </div> 
									    </div>
									    <!------------------------------- exportar tabla -------------------------------->
				                        <div class="row m-0 p-0 mb-3 pb-2">
				                            <div class="row col-12 m-0 p-0 gy-1 mt-3 px-2">
										        <hr/>
								            </div>
				                        	<div class="row col-12 m-0 p-0 px-3 pt-2">
										        <div class="col-12 col-md-4 col-lg-4 row">
										        	<label class=" form-label"></label>
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
									    <div class="text-center col-md-12 col-12 mt-5">
				                            <h2><strong>Modificar empacadora</strong></h2>
				                        </div>
									    <div class="card-body row gy-2 p-4 px-lg-5 px-2 px-md-3">
									        <!------------------------------- Primera columna -------------------------------->
									        <div class="row col-12 col-md-6 m-0 p-0 gy-1">
									        	<div class="col-12" id = "divIdEmpacadora">
										        	<label class=" form-label">Empacadora</label>
										        	<Select id = "idEmpacadoraM" class = "form-select form-select-sm col-12 select2-single" name='idEmpacadoraM' required onChange = "imprimir();" style="width: 100%">
										        		<option value='' selected>...</option>
										        	</Select>
										        </div>
									        	<div class="col-12" style="display: none;" id = "divEmpacadora">
										        	<label class=" form-label">Empacadora</label><INPUT id = "nombreM" class = "form-control form-control-sm col-12" TYPE="text" maxlength='100' NAME="nombreM" pattern = "[^\u{0022}]*" title="No se permiten comillas dobles" required autocomplete="off" disabled></INPUT>
										        </div>
											    <div class="col-6">
											        <label class=" form-label">Registro SADER</label><INPUT id = "saderM" class = "form-control form-control-sm" type='text' maxlength='20' NAME="saderM" autocomplete="off" required pattern = "[^a-z\u{0022}]*" title="No se permiten comillas dobles ni letras minúsculas, escriba en mayúsculas" disabled></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Activa</label><div style = 'background-color: #e9ecef;' class = "form-control form-control-sm text-center" id = "activacionM">
											        	<div class="form-check-sm form-check-inline">
												        	<input class="form-check-input" type="radio" name="activacionM" id="actSiM" value = "1" disabled>
	                                                        <label class="form-check-label" for="actSiM">Si</label>
	                                                    </div>
	                                                    <div class="form-check-sm form-check-inline">
												        	<input class="form-check-input" type="radio" name="activacionM" id="actNoM" value = "0" disabled>
	                                                        <label class="form-check-label" for="actNoM">No</label>
	                                                    </div>
											        </div>
											    </div>
											    <div class="col-8">
											        <label class=" form-label">Municipio</label>
											        <Select id = "municipioM" class = "form-select form-select-sm col-12 select2-single" name='municipioM' required disabled style="width: 100%">
											        	<option value='' selected>...</option>
											        </Select>
											    </div>
											    <div class="col-4">
											        <label class="form-label col-12">CP</label><INPUT id = "CPM" class = "form-control form-control-sm" TYPE="text" maxlength='5' NAME="CPM" required title="Sólo se permiten números" pattern='[0-9]+' minlength='5' autocomplete="off" disabled></INPUT>
											    </div>
											    <div class="col-12">
											        <label class=" form-label">Dirección</label><textarea id = "direccionM" class = "form-control form-control-sm" maxlength='255' NAME="direccionM" pattern = "[^\u{0022}]*" title="No se permiten comillas dobles" required autocomplete="off" style="height: 100px; resize: none;" disabled></textarea>
											    </div>
											    <div class="col-12">
											        <label class=" form-label col-12">Email</label><INPUT id = "correoM" class = "form-control form-control-sm col-12" type = 'text' maxlength='50' NAME="correoM" required autocomplete="off" pattern="[A-Za-z0-9\._%+\-\(\)\[\]!$&'\*\/=\?\^`\{\}\|:;,~ñÑ#]+@[a-z0-9\.\-]+\.[a-z]{2,}$" disabled title="No se permiten caracteres fuera de: _%+-()[]!$&'*/=?^`{}|:;,~#. Verifica que la dirección esté bien escrita."></INPUT>
											    </div>
											</div>
											<!------------------------------- Segunda columna -------------------------------->
										    <div class="row col-12 col-md-6 m-0 p-0 gy-1">
											    <div class="col-6">
											        <label class=" form-label">Teléfono</label><INPUT id = "telefonoM" class = "form-control form-control-sm" type='tel' maxlength='10' minlength='10' NAME="telefonoM" autocomplete="off" required title="Sólo se permiten números" pattern='[0-9]+' disabled></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Facturación</label><div class = "form-control form-control-sm text-center" style = 'background-color: #e9ecef;' id = "facturacionM">
											        	<div class="form-check-sm form-check-inline">
												        	<input class="form-check-input" type="radio" name="facturacionM" id="factSiM" value = "1" disabled>
	                                                        <label class="form-check-label" for="factSiM">Si</label>
	                                                    </div>
	                                                    <div class="form-check-sm form-check-inline">
												        	<input class="form-check-input" type="radio" name="facturacionM" id="factNoM" value = "0" disabled>
	                                                        <label class="form-check-label" for="factNoM">No</label>
	                                                    </div>
											        </div>
											    </div>
											    <div class="col-12">
										        	<label class=" form-label">Banco</label>
										        	<Select id = "bancoM" class = "form-select form-select-sm col-12 select2-single" name='bancoM' disabled style="width: 100%">
										        		<option value='' selected>...</option>
										        	</Select>
                                                </div>
											    <div class="col-12">
											        <label class=" form-label">No. Cuenta</label><INPUT id = "cuentaM" class = "form-control form-control-sm" type='text' maxlength='30' NAME="cuentaM" autocomplete="off" title="Sólo se permiten caracteres alfanuméricos" pattern='[0-9A-Za-z]+' disabled></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Clabe</label><INPUT id = "clabeM" class = "form-control form-control-sm" type='text' maxlength='25' minlength='18' NAME="clabeM" autocomplete="off" title="Sólo se permiten números" pattern='[0-9]+' disabled></INPUT>
											    </div>
										        <div class="col-6">
										        	<label class="form-label">RFC</label><INPUT id = "RFCM" class = "form-control form-control-sm col-12" TYPE="text" NAME="RFCM" maxlength='13' minlength='10' autocomplete="off" disabled pattern = "[^\u{0022}]*" title="No se permiten comillas dobles"></INPUT>
										        </div>
											    <div class="col-12">
											        <label class=" form-label">Regimen</label>
											        <Select id = "regimenM" class = "form-select form-select-sm col-12 select2-single" name='regimenM' disabled style="width: 100%">
											        	<option value='' selected>...</option>
											        </Select>
											    </div>
											    <div class="col-0 col-md-12 mt-0 mt-md-4 mb-0 mb-md-4"><div class="mt-0 mt-md-3"></div>
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
									        <div class="row overflow-hidden mb-5">
									        	<div class="col-6" id="divCancelar" style="display: none;">
													<INPUT id = "cancelarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Cancelar" TYPE="button" name = "cancelarB" onClick="cancelar();" style = "background-color: #7eca28;"></INPUT>
												</div>
										    	<div class="col-6" id="divModificar">
													<INPUT id = "modificarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Modificar" TYPE="submit" name = "modificarB" onClick="modificar();" style = "background-color: #7eca28;" disabled></INPUT>
												</div>
												<div class="col-6">
										            <INPUT id = "guardarB"  class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Guardar cambios" TYPE="submit" name = "guardarB" onClick="validarM(); guardar();" style = "background-color: #7eca28;" disabled></INPUT>
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
    <!-- select2 -->
    <script src="../libraries/select2.full.min.4.0.13.js"></script>
    <!--header DataTable-->
    <script src = "../libraries/dataTables.fixedHeader.min.3.3.1.js"></script>

</body>
</html>