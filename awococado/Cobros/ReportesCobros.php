<?php
    session_start();
    require "../funciones.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Reportes de cobros</title>
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

	<style type="text/css">
        input[type="checkbox"]:checked {
            background: #60c438;
            border-color: #60c438;
        }
	</style>
</head>
<body class="bg-light"onload=" impNombre();">
	<script>
		const tabla = 'bancos';
		var valido = false;
		const dirScriptsPhp = '<?php echo $absolutePathAwScripts ?>';
		var elementosFC = [['','Folio'], ['','Empacadora'], ['rfc','RFC'], ['regimen','Régimen'], ['banco','Banco'], ['cuenta','Número de cuenta'], ['clabe','Clabe'], ['fechaF','Fecha factura'], ['aportacion','Tipo aportación'], ['estatus','Estatus factura'], ['subtotal','Subtotal'], ['iva','Iva'], ['total','Total'], ['saldo','Saldo'], ['concepto','Concepto factura'], ['','Número PDD'], ['fechaC','Fecha cobro'], ['monto','Monto'], ['observaciones','Observaciones']];

		document.addEventListener("DOMContentLoaded", () => {
			inicTabla();
		});

		function inicTabla() {
			var id = "repCobros";
		    $('#tablaCobros').DataTable({
		    	"ajax":{           
			        "url": dirScriptsPhp + "consultar.php", 
			        "method": 'POST',
			        "data": {
			        	id: id,
			        	fechaI: function() { return $('#fechaI').val() },
			        	fechaF: function() { return $('#fechaFin').val() },
			        	empacadora: function() { return $('#empacadora').val() }
					}
			    },
		    	"columns": [
					{ "data": "FolioFactura" },
					{ "data": "Empacadora" },
					{ "data": "RFC" },
					{ "data": "Regimen" },
					{ "data": "Banco"},
					{ "data": "NumCuenta" },
					{ "data": "Clabe" },
					{ "data": "FechaEmision" },
					{ "data": "Aportacion" },
					{ "data": "Estatus" },
					{ "data": "Subtotal" },
					{ "data": "Iva" },
					{ "data": "Total" },
					{ "data": "Saldo" },
					{ "data": "Concepto" },
					{ "data": "NumeroPDD" },
					{ "data": "FechaCobro" },
					{ "data": "Monto" },
					{ "data": "Observaciones" }
			    ]
		    })
		}

        function impNombre(){
			var empacadoras = "empacadoras";
			var mun = document.getElementById("empacadora").value; 
		

			var parametros = {
				"id" : empacadoras
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	$("#empacadora").html(response);
	            }
	        });
		}

		function actualizarTablaFC(){
			for (var i = 0; i<elementosFC.length; i++){
		    	if (elementosFC[i][0] == ""){
		    		$("#tablaCobros").DataTable().column(i).visible(true);
		    	} else{
		    		if (document.getElementById(elementosFC[i][0]).checked == false){
		    			$("#tablaCobros").DataTable().column(i).visible(false);
		    		} else{
		    			$("#tablaCobros").DataTable().column(i).visible(true);
		    		}
		    	}
		    }
		    contEmpacadora();
		}
		
		function consultar(){
			if ($.fn.DataTable.isDataTable("#tablaCobros")) {
                $.ajax({
	                success:  function () {
	                    $("#tablaCobros").DataTable().ajax.reload(null, false);
	                }
	            });
            } else {
                setTimeout(consutar, 1000);
            }

		    if ($("#fechaI").val() != "" && $("#fechaFin").val() != "" && $("#empacadora").val() == ""){
				$("#tituloR").val("Reporte de cobros del " + $("#fechaI").val().substring(8, 10) + "-" + $("#fechaI").val().substring(5, 7) + "-" + $("#fechaI").val().substring(0, 4) + " al " + $("#fechaFin").val().substring(8, 10) + "-" + $("#fechaFin").val().substring(5, 7) + "-" + $("#fechaFin").val().substring(0, 4));
			} else{
				if ($("#fechaI").val() != "" && $("#fechaFin").val() != "" && $("#empacadora").val() != ""){
					$("#tituloR").val("Reporte de cobros de la empacadora " + document.getElementById("empacadora").options[document.getElementById("empacadora").selectedIndex].text + " del " + $("#fechaI").val().substring(8, 10) + "-" + $("#fechaI").val().substring(5, 7) + "-" + $("#fechaI").val().substring(0, 4) + " al " + $("#fechaFin").val().substring(8, 10) + "-" + $("#fechaFin").val().substring(5, 7) + "-" + $("#fechaFin").val().substring(0, 4));
				} else{
					if (($("#fechaI").val() == "" && $("#fechaFin").val() == "" && $("#empacadora").val() == "") ||
						($("#fechaI").val() != "" && $("#fechaFin").val() == "" && $("#empacadora").val() == "") ||
						($("#fechaI").val() == "" && $("#fechaFin").val() != "" && $("#empacadora").val() == "")){
						$("#tituloR").val("Reporte de cobros general");
					} else{
						$("#tituloR").val("Cobros de la empacadora " + document.getElementById("empacadora").options[document.getElementById("empacadora").selectedIndex].text);
					}
				}
			}
		}

		function contEmpacadora(){
			if ($("#empacadora").val() != ""){
				$("#tablaCobros").DataTable().column(1).visible(false);
				for (var i = 2; i<= 6; i++){
		    	    $("#tablaCobros").DataTable().column(i).visible(false);
		    	    document.getElementById(elementosFC[i][0]).checked = false;
		    	}
			} else{
				$("#tablaCobros").DataTable().column(1).visible(true);
			}
		}

		function contChecksEmp(elemento){
			if (document.getElementById(elemento).checked == true){
				$("#empacadora").val("");
			}
			consultar();
			contEmpacadora();
		}

		function exportarTabla(){
			var nombre, expRepCobros = "expRepCobros";
			var tabla = $("#tablaCobros").DataTable().rows({ filter : 'applied'}).data();
			var arreglo = [], cabecera = [];
			var date = Date.now();
            var hoy = new Date(date);
            hoy = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear() + " " + hoy.getHours() + '.' + hoy.getMinutes() + '.' + hoy.getSeconds();

			if ($("#fechaI").val() != "" && $("#fechaFin").val() != "" && $("#empacadora").val() == ""){
				nombre = "Cobros del " + $("#fechaI").val().substring(8, 10) + "-" + $("#fechaI").val().substring(5, 7) + "-" + $("#fechaI").val().substring(0, 4) + " al " + $("#fechaFin").val().substring(8, 10) + "-" + $("#fechaFin").val().substring(5, 7) + "-" + $("#fechaFin").val().substring(0, 4) + " " + hoy;
			} else{
				if ($("#fechaI").val() != "" && $("#fechaFin").val() != "" && $("#empacadora").val() != ""){
					nombre = "Cobros de la empacadora " + document.getElementById("empacadora").options[document.getElementById("empacadora").selectedIndex].text + " del " + $("#fechaI").val().substring(8, 10) + "-" + $("#fechaI").val().substring(5, 7) + "-" + $("#fechaI").val().substring(0, 4) + " al " + $("#fechaFin").val().substring(8, 10) + "-" + $("#fechaFin").val().substring(5, 7) + "-" + $("#fechaFin").val().substring(0, 4) + " " + hoy;
				} else{
					if (($("#fechaI").val() == "" && $("#fechaFin").val() == "" && $("#empacadora").val() == "") ||
						($("#fechaI").val() != "" && $("#fechaFin").val() == "" && $("#empacadora").val() == "") ||
						($("#fechaI").val() == "" && $("#fechaFin").val() != "" && $("#empacadora").val() == "")){
						nombre = "Cobros " + hoy;
					} else{
						nombre = "Cobros de la empacadora " + document.getElementById("empacadora").options[document.getElementById("empacadora").selectedIndex].text + " " + hoy;
					}
				}
			}

			for (var i = 0; i<elementosFC.length; i++){
		    	if ($("#tablaCobros").DataTable().column(i).visible()){
		    		cabecera.push(elementosFC[i][1]);
		    	} else {
		    		cabecera.push("");
		    	}
		    }

            $.each( tabla, function( key, value ) {
			    arreglo[key] = value;
			});

			var parametros = {
			    "id" : expRepCobros,
			    "cabecera" : JSON.stringify(cabecera),
			    "datos" : JSON.stringify(arreglo)
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (data) {
		            var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
	            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "'+nombre+'.csv" target="_blank">descargar</a>');
	            	$('#divDes a')[0].click();
	            }
	        });
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
	                            <?php echo impMenu($_SESSION['descripcion'], 'ReportesCobros', 'cobros');?>
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
				<div class = "col-12 pt-3" style="max-width: 1000px;">
	                <!-- -----------------------------------------tabs----------------------------------------- -->
	                <ul class="nav nav-tabs cambioColor mt-4">
	                	<!-- <li class="nav-item active rounded-top" style="background-color: #19221f;">
	                        <a href="#facturasCobros" class="nav-link active" role="tab" data-toggle="tab" onClick="consultar();"><strong>Consulta general</strong></a>
	                    </li>
	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#registrar" class="nav-link" role="tab" data-toggle="tab" onClick=""><strong>Cobros por periodo</strong></a>
	                    </li>

	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#consultaGen" class="nav-link" role="tab" data-toggle="tab" onClick="impNombre();"><strong>Cobros por empacadora</strong></a>
	                    </li> -->
	                </ul>

	                <div class="tab-content bg-white border border-top-0 rounded-3 text-justify" style="box-shadow: 0px 0px 10px #c6c6c6;">
	                	<!-- ----------------------------------------Consultar----------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane active" id="facturasCobros">
	                        <div class="px-lg-5 px-2 px-md-3">
	                        	<FORM id = "formularioFC" NAME="formularioFC" method = 'POST' action = 'ReporteCobros.php' target="_blank">
									<div class="card border-0 mb-3 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Reportes de cobros</strong></h2>
				                        </div>
				                        <div class="card-body row gy-1 p-4 px-lg-4 px-2 pb-0">
									        <!------------------------------- Empacadora -------------------------------->
									        <h5 class = "text-center">Empacadoras</h5>
									        <div class="row col-12 m-0 p-0 gy-1 justify-content-center">
										        <div class="px-1 mt-1 row">
										        	<div class="col-12 mt-2 mb-3 pt-3 pb-4 bg-light rounded-3 row p-0 m-0 justify-content-center" style="background: linear-gradient(25deg, #f8f9fa, #f2f2f2, #f8f9fa);">
										        		<div class="row col-12 col-md-6 col-lg-4 align-content-start gy-1 p-0 m-0 ps-4 pe-4 pe-md-2">
										        			<div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
													            <label class="form-label col-11">RFC</label><INPUT id = "rfc" class = "form-check-input" TYPE="checkbox" NAME="rfc" checked onChange = "contChecksEmp('rfc'); actualizarTablaFC();"></INPUT>
													        </div>
													        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
													            <label class="form-label col-11">Régimen</label><INPUT id = "regimen" class = "form-check-input" TYPE="checkbox" NAME="regimen" checked onChange = "contChecksEmp('regimen'); actualizarTablaFC();"></INPUT>
													        </div>
													    </div>
													    <div class="row col-12 col-md-6 col-lg-4 align-content-start gy-1 p-0 m-0 ps-4 pe-4 ps-md-2 pe-md-4 pe-lg-2">
													        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
													            <label class="form-label col-11">Banco</label><INPUT id = "banco" class = "form-check-input" TYPE="checkbox" NAME="banco" checked onChange = "contChecksEmp('banco'); actualizarTablaFC();"></INPUT>
													        </div>
													        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
													            <label class="form-label col-11">Número de cuenta</label><INPUT id = "cuenta" class = "form-check-input" TYPE="checkbox" NAME="cuenta" checked onChange = "contChecksEmp('cuenta'); actualizarTablaFC();"></INPUT>
													        </div>
													    </div>
													    <div class="row col-12 col-lg-4 align-content-start gy-1 p-0 m-0 ps-4 pe-4 ps-lg-2 ps-md-4 pe-md-4 gx-md-2 gx-3">
													    	<div class="col-12 col-md-6 col-lg-12 pe-0 pe-md-2 pe-lg-0 mx-0 px-0">
														        <div class="col-lg-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
														            <label class="form-label col-11">Clabe</label><INPUT id = "clabe" class = "form-check-input" TYPE="checkbox" NAME="clabe" checked onChange = "contChecksEmp('clabe'); actualizarTablaFC();"></INPUT>
														        </div>
														    </div>
													    </div>
													</div>
										        </div>
										    </div>

										    <!----------------------------------------- facturas -------------------------------------->
										    <h5 class = "text-center">Facturas</h5>
									        <div class="row col-12 m-0 p-0 gy-1 justify-content-center">
										        <div class="px-1 mt-1 row">
										        	<div class="col-12 mt-2 mb-3 pt-3 pb-4 bg-light rounded-3 row p-0 m-0 justify-content-center" style="background: linear-gradient(25deg, #f8f9fa, #f2f2f2, #f8f9fa);">
										        		<div class="row col-12 col-md-6 col-lg-4 align-content-start gy-1 p-0 m-0 ps-4 pe-4 pe-md-2">
													        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
													            <label class="form-label col-11">Fecha</label><INPUT id = "fechaF" class = "form-check-input" TYPE="checkbox" NAME="fechaF" checked onChange = "actualizarTablaFC();"></INPUT>
													        </div>
													        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
													            <label class="form-label col-11">Tipo de aportación</label><INPUT id = "aportacion" class = "form-check-input" TYPE="checkbox" NAME="aportacion" checked onChange = "actualizarTablaFC();"></INPUT>
													        </div>
													        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
													            <label class="form-label col-11">Concepto</label><INPUT id = "concepto" class = "form-check-input" TYPE="checkbox" NAME="concepto" checked onChange = "actualizarTablaFC();"></INPUT>
													        </div>
													    </div>
													    <div class="row col-12 col-md-6 col-lg-4 align-content-start gy-1 p-0 m-0 ps-4 pe-4 ps-md-2 pe-md-4 pe-lg-2">
													        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
													            <label class="form-label col-11">Estatus</label><INPUT id = "estatus" class = "form-check-input" TYPE="checkbox" NAME="estatus" checked onChange = "actualizarTablaFC();"></INPUT>
													        </div>
										        		    <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
													            <label class="form-label col-11">Subtotal</label><INPUT id = "subtotal" class = "form-check-input" TYPE="checkbox" NAME="subtotal" checked onChange = "actualizarTablaFC();"></INPUT>
													        </div>
													        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
													            <label class="form-label col-11">Iva</label><INPUT id = "iva" class = "form-check-input" TYPE="checkbox" NAME="iva" checked onChange = "actualizarTablaFC();"></INPUT>
													        </div>
													    </div>
													    <div class="row col-12 col-lg-4 align-content-start gy-1 p-0 m-0 ps-4 pe-4 ps-lg-2 ps-md-4 pe-md-4 gx-md-2 gx-3">
													    	<div class="col-12 col-md-6 col-lg-12 pe-0 pe-md-2 pe-lg-0 mx-0 px-0">
														        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
														            <label class="form-label col-11">Total</label><INPUT id = "total" class = "form-check-input" TYPE="checkbox" NAME="total" checked onChange = "actualizarTablaFC();"></INPUT>
														        </div>
														    </div>
														    <div class="col-12 col-md-6 col-lg-12 ps-0 ps-md-2 ps-lg-0 mx-0 px-0">
														        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
														            <label class="form-label col-11">Saldo</label><INPUT id = "saldo" class = "form-check-input" TYPE="checkbox" NAME="saldo" checked onChange = "actualizarTablaFC();"></INPUT>
														        </div>
														    </div>
													    </div>
													</div>
										        </div>
										    </div>

										    <!----------------------------------------- cobros -------------------------------------->
										    <h5 class = "text-center">Cobros</h5>
									        <div class="row col-12 m-0 p-0 gy-1 justify-content-center">
										        <div class="px-1 mt-1 row">
										        	<div class="col-12 mt-2 mb-3 pt-3 pb-4 bg-light rounded-3 row p-0 m-0 justify-content-center" style="background: linear-gradient(25deg, #f8f9fa, #f2f2f2, #f8f9fa);">
										        		<div class="row col-12 col-md-6 col-lg-4 align-content-start gy-1 p-0 m-0 ps-4 pe-4 pe-md-2">
													        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
													            <label class="form-label col-11">Fecha</label><INPUT id = "fechaC" class = "form-check-input" TYPE="checkbox" NAME="fechaC" checked onChange = "actualizarTablaFC();"></INPUT>
													        </div>
													    </div>
													    <div class="row col-12 col-md-6 col-lg-4 align-content-start gy-1 p-0 m-0 ps-4 pe-4 ps-md-2 pe-md-4 pe-lg-2">
													        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
													            <label class="form-label col-11">Monto</label><INPUT id = "monto" class = "form-check-input" TYPE="checkbox" NAME="monto" checked onChange = "actualizarTablaFC();"></INPUT>
													        </div>
													    </div>
													    <div class="row col-12 col-lg-4 align-content-start gy-1 p-0 m-0 ps-4 pe-4 ps-lg-2 ps-md-4 pe-md-4 gx-md-2 gx-3">
													    	<div class="col-12 col-md-6 col-lg-12 pe-0 pe-md-2 pe-lg-0 mx-0 px-0">
														        <div class="col-12 bg-white border rounded-3 py-1 px-3" style="height: 34px;">
														            <label class="form-label col-11">Observaciones</label><INPUT id = "observaciones" class = "form-check-input" TYPE="checkbox" NAME="observaciones" checked onChange = "actualizarTablaFC();"></INPUT>
														        </div>
														    </div>
														</div>
													</div>
										        </div>
										    </div>
										</div>
										<div class="row col-12 m-0 p-0 pt-4">
									        <hr>
							            </div>
							            <div class="row p-4 px-1 pt-0 mb-2 justify-content-center">
							            	<div class="row col-12 gy-1">
							            		<iframe name ="request" style="display: none;"></iframe>
							            		<input id = "tituloR" type = 'hidden' name = 'tituloR' value = "Reporte de cobros general"></input>

							            	    <div class="col-12 col-md-6 col-lg-6">
	                                                <label class=" form-label">Empacadora</label>
	                                                <Select id = "empacadora" class = "form-select form-select-sm col-12" name='empacadora' onChange = "consultar(); contEmpacadora();"></Select>
	                                            </div> 
                                                <div class="col-6 col-md-3">
                                                	<label class=" form-label">Fecha inicial</label><input id = "fechaI" class = "form-control form-control-sm col-12" type = 'date' name = 'fechaI' onChange = "consultar();"></input>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                	<label class=" form-label">Fecha final</label><input id = "fechaFin" class = "form-control form-control-sm col-12" type = 'date' name = 'fechaFin' onChange = "consultar();"></input>
                                                </div>
                                                <div class="col-12 mt-1 row m-0 p-0">
	                                                <div class="col-6 col-md-3 mt-3">
											        	<INPUT id = "exportarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar a Excel" TYPE="button" name = "exportarB" onClick="exportarTabla();" style = "background-color: #60c438;"></INPUT>
											        </div>
										            <div class="col-6 col-md-3 mt-3">
														<INPUT id = "pdfB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Generar reporte" TYPE="submit" name = "pdfB"  style = "background-color: #000000;"></INPUT>
													</div>
												</div>
										    </div>
							            </div>
							            <div class="row col-12 m-0 p-0 gy-1">
									        <hr>
							            </div>
										<!------------------------------------- tabla ------------------------------------------>
										<div class="p-4 px-lg-3 px-2 pt-3">
				                            <div class="col-12 mt-0 mb-0 pt-0 pb-4" style="overflow: auto;">
				                                <div id="divDes" style="display: none;"></div>	
				                            	<table id="tablaCobros" class="table table-bordered display">
									                <thead>
									                    <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
									                        <th>Folio</th>
									                        <th>Empacadora</th>
									                        <th>RFC</th>
									                        <th>Régimen</th>
									                        <th>Banco</th>
									                        <th>Número de cuenta</th>
									                        <th>Clabe</th>
									                        <th>Fecha factura</th>
									                        <th>Tipo aportación</th>
									                        <th>Estatus factura</th>
									                        <th>Subtotal</th>
									                        <th>Iva</th>
									                        <th>Total</th>
									                        <th>Saldo</th>
									                        <th>Concepto factura</th>
									                        <th>Número PDD</th>
									                        <th>Fecha cobro</th>
									                        <th>Monto</th>
									                        <th>Observaciones</th>
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