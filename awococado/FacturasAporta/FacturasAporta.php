<?php
    session_start();
    require "../funciones.php";
    $permisos = ["Administrador", "Contabilidad"];
    validarSesion($_SESSION["descripcion"], $permisos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Facturas empacadoras</title>
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
<body class="bg-light" onload="impNombre(); impTipAport();">
	<script>
		const tabla = 'empacadora', usuario = "<?php echo $_SESSION['nombre'];?>";
		var valido = false;
		const dirScriptsPhp = '<?php echo $absolutePathAwScripts ?>';
		var folio = "";

		document.addEventListener("DOMContentLoaded", () => {
			inicTabla();
		});

		function inicTabla() {
			var id = "conFactAporta";
		    $('#tablaFac').DataTable({
		    	"ajax":{           
			        "url": dirScriptsPhp + "consultar.php", 
			        "method": 'POST',
			        "data": {
			        	id: id,
					    fechaI: function() { return $('#fechaI').val() },
					    fechaF: function() { return $('#fechaF').val() }
					}
			    },
		    	"columns": [
					{ "data": "FolioFactura" },
					{ "data": "Empacadora" },
					{ "data": "FechaEmision" },
					{ "data": "Estatus" },
					{ "data": "SubTotal" },
					{ "data": "Iva" },
					{ "data": "Total" },
					{ "data": "Saldo"},
					{ "data": "Aportacion" },
					{ "data": "Concepto" },
					{ "data": "FechaCan" },
					{ "data": "Justificacion" },
					{ "data": "pdf" },
					{ "data": "xml" },
					{ "data": "email" }
			    ],
			    "columnDefs": [
                    { className: "dt-right", "targets": [4, 5, 6, 7] }
                ],
                order: [[2, 'desc'], [0, 'desc']],
			    fixedHeader: {
                    header: true,
                    headerOffset: $('#barra').height() - 6
                },
                scrollX: true
		    })
		}

		function impTipAport(){
			var tipoAport = "tipoAport";
		    var tipA = document.getElementById("aportacion").value;

			var parametros = {
				"id" : tipoAport
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	if(tipA == ""){
		            	$("#aportacion").html(response);
		            } 
	            }
	        });
		}
		
		function impNombre(){
			var empacadoras = "empacadoras";
			var emp = document.getElementById("empacadora").value; 

			var parametros = {
				"id" : empacadoras
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	if(emp == ""){
	            	    $("#empacadora").html(response);
		            }
	            }
	        });
		}

		var xt = "empacadoraFA";

		function consultar() {
			if ($.fn.DataTable.isDataTable("#tablaFac")) {
                $.ajax({
	                success:  function () {
	                    $("#tablaFac").DataTable().ajax.reload(null, false);
	                }
	            });
            } else {
                setTimeout(consutar, 1000);
            }
		}

		function imprimir() {
			var obtEmpacadora = "obtDatosEmp";
			var empacadora = document.getElementById("empacadora").value;
			var nomEmpa = document.getElementById("empacadora").options[document.getElementById("empacadora").selectedIndex].text;
			$("#folio, #fecha, #concepto, #subTotal, #total, #iva, #aportacion, #archivoPDF, #archivoXML").val("");
			$("#folio, #fecha, #concepto, #subTotal, #total, #iva, #aportacion, #modRegisB").attr("disabled", "");

			if (nomEmpa == "..."){
				$("#RFC, #banco, #cuenta, #clabe, #regimen, #saldo").val("");
			    $("#archivoPDF, #archivoXML").attr("disabled", "");
			} else{
				var parametros = {
					"id" : obtEmpacadora,
					"empacadora" : empacadora
					
				}
				
				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            dataType: "json",
		            success:  function (response) {
		            	rellenar(response.result.IdEmpacadora, response.result.RFC, response.result.Banco, response.result.NumCuenta, response.result.Clabe, response.result.Regimen, response.result.SaldoFormato);
						
		            }
		        });
			}
		} 

		function rellenar(IdEmpacadora, RFC, banco, cuenta, clabe, reg, sald){
			document.getElementById("idEmpacadora").value = IdEmpacadora;
			document.getElementById("RFC").value = RFC;
			document.getElementById("banco").value = banco;
			document.getElementById("cuenta").value = cuenta;
			document.getElementById("clabe").value = clabe;
			document.getElementById("regimen").value = reg;
			document.getElementById("saldo").value = sald;
			document.getElementById("archivoPDF").disabled = false;
			document.getElementById("archivoXML").disabled = false;
			$("#folio, #fecha, #concepto, #subTotal, #total, #iva, #aportacion, #archivoPDF, #archivoXML").val('');
		}


		function validar (){
			var formulario = document.getElementById('formularioR');
			valido = formulario.checkValidity();
		}

		function validarCan (){
			var formulario = document.getElementById('formularioCan');
			valido = formulario.checkValidity();
		}
		
		function confirmar(){
			if(valido == true ){
			    var nomArchPDF = document.getElementById('archivoPDF').value;
                if(nomArchPDF.includes(".pdf")){ 
                    var nomArchXML = document.getElementById('archivoXML').value;
                    if (nomArchXML.includes(".xml")){
                        $.ajax({
		                    success:  function () {
		                    	$("#abrirmodalC").trigger("click");
		                    }
		                });
                    } else{
                        if (nomArchXML != ""){
                            $("#registro").html('Ha seleccionado un tipo de archivo que no es XML en el apartado <i>"Documento XML"</i>.');
		            	    $("#titulo").html("Tipo de archivo no válido");
			                $("#abrirmodal").trigger("click");
                        }
                    }
                } else{
                    if (nomArchPDF != ""){
                        $("#registro").html('Ha seleccionado un tipo de archivo que no es PDF en el apartado <i>"Documento PDF"</i>.');
		                $("#titulo").html("Tipo de archivo no válido");
			            $("#abrirmodal").trigger("click");
                    }
                }
			}
		}

		function registrar (){
		    if(valido == true){
		        var formData = new FormData();
		        var folio = document.getElementById("folio").value;
		        formData.append("id", "regFacturaAporta");
			    formData.append("IdEmpacadora", document.getElementById("empacadora").value);
			    formData.append("Folio", folio);
			    formData.append("Fecha", document.getElementById("fecha").value);
			    formData.append("SubTotal", document.getElementById("subTotal").value);
			    formData.append("Total", $('#total').val());
			    formData.append("Iva", $('#iva').val());
			    formData.append("Aportacion", $('#aportacion').val());
			    formData.append("Concepto", document.getElementById("concepto").value);
			    formData.append("archivoPDF", $('#archivoPDF').get(0).files.item(0));
			    formData.append("archivoXML", $('#archivoXML').get(0).files.item(0));
			    formData.append("Usuario", usuario);

				$.ajax({
					url: dirScriptsPhp + 'registrar.php',
				    type: "POST",
				    data: formData,
				    processData: false, 
				    contentType: false,  
		            success:  function (response) {
		                if(response[0] == "1"){
			            	$("#registro").html("La factura con folio <i>"+folio+"</i> ha sido registrada correctamente");
			            	$("#titulo").html("Registro exitoso");
			                document.getElementById('formularioR').reset();
			                impNombre();
			                impTipAport();
			                $("#folio, #fecha, #concepto, #subTotal, #total, #iva, #aportacion, #modRegisB, #archivoPDF, #archivoXML").attr("disabled", "");	  
			            } else {
		            		if(response[0] == "3"){
		            			$("#registro").html("No es posible registrar la factura con folio <i>"+folio+"</i>, esta ya existe.");
		            	        $("#titulo").html("Folio existente");
		            		} else {
		            		    if(response[0] == "2"){
		            		        $("#registro").html("No fue posible registrar la factura con folio <i>"+folio+"</i>, hubo un problema al momento de subir los documentos al servidor. Intentelo nuevamente.");
		            	            $("#titulo").html("Ha ocurrido un error");
		            		    } else {
		            		        if(response[0] == "4"){
		            		            $("#registro").html("La factura con folio <i>"+folio+"</i> ha sido registrada correctamente, sin embargo, no fue posible enviarla por correo electrónico. Intentelo nuevamente desde la consulta.");
		            	                $("#titulo").html("Registro exitoso sin enviar");
		            		        } else {
		            		            $("#registro").html("La factura con folio <i>"+folio+"</i> no se ha podido registrar.");
		            	                $("#titulo").html("Ha ocurrido un error");
		            		        }
		            		    }
		            		}
		            	}
			            $("#abrirmodal").trigger("click");
		            }
		        });
			}
	    }

		function subirPDF(){
		    $("#subirArchFac").val('');
			$("#tituloModSubFac").html("PDF");
		    $("#cuerpoModSubFac").html("Por favor seleccione el documento PDF correspondiente a la factura con folio <i>"+folio+"<i>.");
		    $('#subirArchFac').attr("accept", "application/pdf");
		    $("#abrirmodalSub").trigger("click");
		}

		function subirXML(){
		    $("#subirArchFac").val('');
			$("#tituloModSubFac").html("XML");
		    $("#cuerpoModSubFac").html("Por favor seleccione el documento XML correspondiente a la factura con folio <i>"+folio+"<i>.");
		    $('#subirArchFac').attr("accept", "application/xml");
		    $("#abrirmodalSub").trigger("click");
		}

		function cargarFactura(){
		    if ($("#subirArchFac").val() != "") {
		        var nombreArch = document.getElementById('subirArchFac').value;
		        var extencion = "." + $("#tituloModSubFac").html().toLowerCase();
                if(nombreArch.includes(extencion)){ 
                    var formData = new FormData();
				    formData.append("archivo", $('#subirArchFac').get(0).files.item(0));
				    formData.append("folio", folio);
				    formData.append("id", "cargarFacAport");
				    formData.append("ext", $("#tituloModSubFac").html());
				    
	                $.ajax({
					    url: dirScriptsPhp + 'registrar.php',
					    type: "POST",
					    data: formData,
					    processData: false, 
					    contentType: false,  
					    success:  function (response) {
					        if(response[0] == "1"){
			            		$("#registro").html("El documento "+$("#tituloModSubFac").html()+" correspondiente a la factura con folio <i>"+folio+"</i> ha sido guardado correctamente.");
			            	    $("#titulo").html("Importación exitosa");
			            	} else {
			            		$("#registro").html("No fue posible guardar el documento "+$("#tituloModSubFac").html()+".");
			            	    $("#titulo").html("Ha ocurrido un error");
			            	}
			            	$("#abrirmodal").trigger("click");
						    consultar();	   
					    }
					});

				 //   fetch(dirScriptsPhp + 'registrar.php', {
					//     method: 'POST',
					//     body: formData
					// })
					// .then(function(response) {
					    
					// });
					// .then(function(texto) {
					//     alert(texto);
					// })
					// .catch(function(err) {
					//     alert(err);
					// });
				    $("#subirArchFac").val = "";
                } else {
                    $("#registro").html("El archivo seleccionado no es de tipo " + $("#tituloModSubFac").html() + ".");
			        $("#titulo").html("Acción denegada");
			        $("#abrirmodal").trigger("click");
                }
		    } else{
			    $("#registro").html("No se ha seleccionado ningun archivo.");
			    $("#titulo").html("Acción denegada");
			    $("#abrirmodal").trigger("click");
		    }
		}
		
		function abrFac(ext, estado){
		    $("#divAbrir").html('<a id = "enlaceAbrir" href = "Facturas'+ext.toUpperCase()+'/'+estado+folio+'.'+ext+'" target="_blank">Abrir factura</a>');
		    $('#divAbrir a')[0].click();
		}
		
		function enviarCorreo(empacadora){
		    var eviArchConFacturas = "eviArchConFacturas";
		    var parametros = {
		        "id" : eviArchConFacturas,
			    "folio" : folio,
			    "empacadora" : empacadora
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'registrar.php',
	            type: 'post',
	            success:  function (response) {
		            if(response[0] == "1"){
	            		$("#registro").html("El corrreo electónico correspondiente a la factura con folio <i>"+folio+"</i> ha sido enviado correctamente.");
	            	    $("#titulo").html("Envio exitoso");
	            	} else {
	            	    $("#registro").html("No fue posible enviar el correo electrónico correspondiente a la factura con folio <i>"+folio+"</i>.");
	            	    $("#titulo").html("Ha ocurrido un error");
	            	}
	                $("#abrirmodal").trigger("click");
	                consultar();
	            }
	        });  
		}

		function obtXml(){
			var nomArchXML = document.getElementById('archivoXML').value;
			$("#folio, #fecha, #concepto, #subTotal, #total, #iva, #aportacion, #archivoPDF").val("");
			$("#folio, #fecha, #concepto, #subTotal, #total, #iva, #aportacion, #modRegisB").attr("disabled", "");
			
            if (nomArchXML.includes(".xml")){
                var formData = new FormData();
			    formData.append("id", "obtFacturaXml");
			    formData.append("archivoXML", $('#archivoXML').get(0).files.item(0));

				$.ajax({
					url: dirScriptsPhp + 'consultar.php',
				    type: "POST",
				    data: formData,
				    processData: false, 
				    contentType: false,  
				    dataType: "json",
		            success:  function (response) {
		                var fecha = response.Fecha, 
		                    concepto = response.Descripcion;

		                if (fecha !== undefined){
		                	$("#folio").val(response.Folio);
			                $("#fecha").val(fecha.substring(0, 4) + "-" + fecha.substring(5, 7) + "-" + fecha.substring(8, 10));
			                $("#concepto").val(concepto);
			                $("#subTotal").val(response.SubTotal);
			                $("#total").val(response.Total);
			                $("#iva").val(response.Iva);
			                document.getElementById("modRegisB").disabled = false;
			                document.getElementById("aportacion").disabled = false;

			                if (concepto.toLowerCase().includes("cuota")){
			                	var lista = document.getElementById("aportacion");
								for (i = 0; i < lista.options.length; i++) {
								    if (lista.options[i].text.toLowerCase() == "cuota") {
								        $("#aportacion").val(lista.options[i].value);
								    }
								}
			                }
		                } else{
                            $('#archivoXML').val("");
		                    $("#registro").html('Ha seleccionado un archivo XML que no coincide con el formato de la factura.');
		            	    $("#titulo").html("Archivo no válido");
			                $("#abrirmodal").trigger("click");
		                }
		            }
		        });
            } else{
                if (nomArchXML != ""){
                    $('#archivoXML').val("");
                    $("#registro").html('Ha seleccionado un tipo de archivo que no es XML en el apartado <i>"Documento XML"</i>.');
            	    $("#titulo").html("Tipo de archivo no válido");
	                $("#abrirmodal").trigger("click");
                }
            }
		}

		function modRegistro(){
		    document.getElementById('folio').disabled = false;
		    document.getElementById('fecha').disabled = false;
		    document.getElementById('concepto').disabled = false;
		    document.getElementById('subTotal').disabled = false;
		    document.getElementById('total').disabled = false;
		    document.getElementById('iva').disabled = false;
		}

		function limpiarCan(){
			var folio = document.getElementById("folioC").value;
            document.getElementById('formularioCan').reset();
			document.getElementById("cancelarB").disabled = true;
			document.getElementById("abrirPDFB").disabled = true;
			document.getElementById("justificacionC").disabled = true;
            document.getElementById("folioC").value = folio;
		}

		function buscarC(){
			var folio = document.getElementById("folioC").value;
			var busquedaCFacAporta = "busquedaCFacAporta";
            document.getElementById('formularioCan').reset();
            document.getElementById("folioC").value = folio;

			var parametros = {
				"id" :busquedaCFacAporta,
				"folio" : folio
			}

			$.ajax({
				data: parametros,
				url: dirScriptsPhp + "consultar.php",
				type: "post",
		        dataType: "json",
				success: function (response) {
					if(response == "2" && valido == true){
	            		$("#registro").html("La factura con folio <i>"+folio+"</i> no está registrada");
	            	    $("#titulo").html("Folio inexistente");
	            	    $("#abrirmodal").trigger("click");
	            	} else {
	            		if (response == "3" && valido == true){
	            			$("#registro").html("La factura con folio <i>"+folio+"</i> actualmente tiene uno o más cobros registrados");
	            	        $("#titulo").html("Acción denegada");
	            	        $("#abrirmodal").trigger("click");
	            		} else{
		            		if (response.result.Estatus == "Cancelada"){
		            			$("#registro").html("La factura con folio <i>"+folio+"</i> actualmente ya está cancelada");
		            	        $("#titulo").html("Acción denegada");
		            	        $("#abrirmodal").trigger("click");
		            		} else{
		            			$("#empacadoraC").val(response.result.Empacadora);
		            			$("#estatusC").val(response.result.Estatus);
		            			$("#fechaC").val(response.result.FechaEmision);
		            			$("#conceptoC").val(response.result.Concepto);
		            			$("#aportacionC").val(response.result.Aportacion);
		            			$("#ivaC").val(response.result.Iva);
		            			$("#subTotalC").val(response.result.SubTotal);
		            			$("#totalC").val(response.result.Total);
		            			$("#saldoC").val(response.result.Saldo);
		            			document.getElementById("abrirPDFB").disabled = false;
		            			document.getElementById("cancelarB").disabled = false;
		            			document.getElementById("justificacionC").disabled = false;
		            		} 
		            	}
	            	}
				}
			})
		}

		function abrFacR(){
		    var pdf = $("#folioC").val(), rutaFacCobro = "rutaFacCobro";
		    var parametros = {
		        "id" : rutaFacCobro,
			    "folio" : pdf
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	                if (response != ""){
	                    $("#divAbrir").html('<a id = "enlaceAbrir" href = "'+response+'" target="_blank">Abrir factura</a>');
		                $('#divAbrir a')[0].click();
	                }
	            }
	        }); 
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

		function cancelarE(){
			var folio = document.getElementById("folioC").value;
			var modEstatusCanFacAporta = "modEstatusCanFacAporta";

			var parametros = {
				"id" : modEstatusCanFacAporta,
				"folio" : folio, 
				"justificacion" : $("#justificacionC").val(),
				"usuario" : usuario, 
				"total" : $("#totalC").val()
			}

			$.ajax({
				data: parametros,
				url: dirScriptsPhp + "registrar.php",
				type: "post",
				success: function (response) {
					if(response[0] == "1"){
	            		$("#registro").html("La factura con folio <i>"+folio+"</i> ha sido cancelada correctamente");
	            	    $("#titulo").html("Cancelación exitosa");
	            	} else {
	            	    $("#registro").html("La factura con folio <i>"+folio+"</i> no se ha podido cancelar");
	            	    $("#titulo").html("Ha ocurrido un error");
	            	}
	                $("#abrirmodal").trigger("click");
	                document.getElementById('formularioCan').reset();
	                document.getElementById("cancelarB").disabled = true;
			        document.getElementById("abrirPDFB").disabled = true;
			        document.getElementById("justificacionC").disabled = true;
				}
			})
		}

		function exportarTabla(){
			document.getElementById("nombreDes").value = "";
			$("#abrirmodalDes").trigger("click");
		}

		function descargarCSV(){
			nombreCsv = document.getElementById("nombreDes").value;

			if (nombreCsv != ""){
				var tabla = $("#tablaFac").DataTable().rows({ filter : 'applied'}).data();
				var arreglo = [];

	            $.each( tabla, function( key, value ) {
				    arreglo[key] = value;
				});

				var parametros = {
				    "id" : "expFactAporta",
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
	                            <?php echo impMenu($_SESSION['descripcion'], 'FacturasAporta', 'facturasAporta');?>
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
	                <ul class="nav nav-tabs cambioColor">
	                    <li class="nav-item active rounded-top" style="background-color: #19221f;">
	                        <a href="#registrar" class="nav-link active" role="tab" data-toggle="tab" onClick="impNombre(); impTipAport();"><strong>Registrar</strong></a>
	                    </li>

	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#consultaGen" class="nav-link" role="tab" data-toggle="tab" onClick="consultar();"><strong>Consultar</strong></a>
	                    </li>
	                    
	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#cancelar" class="nav-link" role="tab" data-toggle="tab"><strong>Cancelar</strong></a>
	                    </li>
	                </ul>

	                <div class="tab-content bg-white border border-top-0 rounded-3 text-justify" style="box-shadow: 0px 0px 10px #c6c6c6;">
	                	<!-- --------------------------------------------Registrar-------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane in active" id="registrar">
	                        <div class="px-5">
	                        	<!---------------------------------- formulario ---------------------------------->
	                        	<FORM id = "formularioR" NAME="formularioR" method = 'POST' action = '#' target ="request">
									<div class="card border-0">
									    <div class="text-center col-md-12 col-12 mt-5">
				                            <h2><strong>Registrar factura de empacadora</strong></h2>
				                        </div>
									    <div class="card-body row gy-2 pt-4 px-lg-5 px-2 px-md-3 pb-0">
									    	<!------------------------------- Apartado de empacadora -------------------------------->
									        <div class="row col-12 col-md-6 m-0 p-0 gy-1">
										        <div class="col-12">
										        	<label class=" form-label">Empacadora</label>
										        	<Select id = "empacadora" class = "form-select form-select-sm col-12" name='empacadora'required onChange = "imprimir();"></Select>
										        	<INPUT id = "idEmpacadora" TYPE="hidden" NAME="idEmpacadora" disabled></INPUT>
										        </div>
											    <div class="col-12">
											        <label class=" form-label">Banco</label><INPUT id = "banco" class = "form-control form-control-sm" type='text' NAME="banco" disabled></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">No. Cuenta</label><INPUT id = "cuenta" class = "form-control form-control-sm" type='text' NAME="cuenta" disabled></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Clabe</label><INPUT id = "clabe" class = "form-control form-control-sm" type='text' NAME="clabe" disabled></INPUT>
											    </div>
											</div>
											<!------------------------------ segunda columna ---------------------------->
											<div class="row col-12 col-md-6 m-0 p-0 gy-1">
											    <div class="col-12">
											        <label class=" form-label">Regimen</label><INPUT id = "regimen" class = "form-control form-control-sm" type='text' NAME="regimen" disabled></INPUT>
											    </div>
										        <div class="col-6 col-md-7">
										        	<label class="form-label">RFC </label><INPUT id = "RFC" class = "form-control form-control-sm col-12" TYPE="text" NAME="RFC" disabled></INPUT>
										        </div>
											    <div class="col-6 col-md-5">
											        <label class=" form-label">Saldo</label><INPUT id = "saldo" class = "form-control form-control-sm" TYPE="text" NAME="saldo" disabled></INPUT>
											    </div>
											    <div class="col-0 col-md-12 col-lg-12 mt-0 mt-md-4 mt-lg-4 mb-0 mb-md-4 mb-lg-4 pt-0 pt-md-3 pt-lg-3 pb-0 pb-md-1 pb-lg-1">
											    </div>
											</div>
											<div class="row col-12 m-0 p-0 gy-1 mt-4">
									            <hr/>
							                </div>
									    </div>
						                <!-------------------------------- input file -------------------------------->
									    <div class="row px-lg-5 px-2 px-md-3 pt-0 mt-0">
										    <div class="row col-12 m-0 p-0 gy-1">
										        <div class="col-12 col-md-6 col-lg-6">
													<label class="form-label">Documento XML</label>
													<INPUT id = 'archivoXML' class="btn form-control-lg col-12 border border-1 bg-white" VALUE='Subir XML' TYPE='file' name = 'archivoXML' accept = "application/xml" required onChange = "obtXml();" disabled></INPUT>
													<br>
												</div>
												<div class="col-12 col-md-6 col-lg-6">
													<label class="form-label">Documento PDF</label>
													<INPUT id = 'archivoPDF' class="btn form-control-lg col-12 border border-1 bg-white" VALUE='Subir PDF' TYPE='file' name = 'archivoPDF' accept = "application/pdf" required disabled></INPUT>
													<br>
												</div>
										        <div class="row col-12 m-0 p-0 gy-1 mt-4">
										            <hr/>
												</div>
								            </div>
										</div>
							            <!------------------------------- Apartado factura -------------------------------->
							            <div class="row px-lg-5 px-2 px-md-3">
                                            <div class="row col-12 col-md-6 m-0 p-0 gy-2">
                                            	<div class="col-6">
										        	<label class=" form-label">Folio</label><INPUT id = "folio" class = "form-control form-control-sm" TYPE="text" NAME="folio" autocomplete="off" required title="Sólo se permiten números enteros" pattern='[0-9]+' maxlength='40' disabled></INPUT>
										        </div>
										        <div class="col-6">
											        <label class=" form-label">Fecha</label><input id = "fecha" class = "form-control form-control-sm col-12" type = 'date' name = 'fecha' required disabled></input>
											    </div>
											    <!--<div class="row col-12 m-0 p-0 gy-1">-->
											    <div class="col-12">
											        <label class=" form-label">Concepto</label><textarea style="height: 87px; resize: none;" id = "concepto" class="form-control form-control-sm" maxlength='150' name='concepto' autocomplete="off" disabled required pattern = "[^\u{0022}]*" title="No se permiten comillas dobles"></textarea>
											    </div>
											<!--</div>-->
											</div>
											<!------------------------------ segunda columna ---------------------------->
										    <div class="row col-12 col-md-6 m-0 p-0 gy-2">
										        <div class="col-8">
										        	<label class=" form-label">Tipo de aportación</label>
										        	<Select id = "aportacion" class = "form-select form-select-sm col-12" name='aportacion' onChange = "" disabled required>
										        	    <option value="" selected>...</option>
										        	</Select>
										        </div>
											    <div class="col-4">
											        <label class=" form-label">Iva</label><INPUT id = "iva" class = "form-control form-control-sm" NAME="iva" required type="number" step="0.01" title="Sólo se permiten valores numéricos con un máximo de 2 decimales" min = "0.00" autocomplete="off" disabled></INPUT>
											    </div>
										        <div class="col-6">
											        <label class=" form-label">Sub total</label><INPUT id = "subTotal" class = "form-control form-control-sm" NAME="subTotal" required type="number" step="0.01" title="Sólo se permiten valores numéricos con un máximo de 2 decimales" min = "0.01" autocomplete="off" disabled></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Total</label><INPUT id = "total" class = "form-control form-control-sm" NAME="total" required type="number" step="0.01" title="Sólo se permiten valores numéricos con un máximo de 2 decimales" min = "0.01" autocomplete="off" disabled></INPUT>
											    </div>
											    <div class="col-12 col-md-6 col-lg-6 mt-3">
													<INPUT id = "modRegisB" class = "form-control-sm btn col-12 rounded-1 text-white" VALUE="Modificar" TYPE="button" name = "modRegisB" onClick="modRegistro();" style = "background-color: #19221f;" disabled></INPUT>
												</div>
											</div>
											<div class="row col-12 m-0 p-0 gy-1 mt-4">
									            <hr/>
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

						    <INPUT id = "abrirmodalSub" data-toggle="modal" data-target="#modSubFac" VALUE="abrirmodalSub" TYPE="button" style = "display: none;"></INPUT>

						    <div id="modSubFac" class="modal fade" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
							    <div class="modal-dialog modal-md modal-dialog-top">
								    <div class="modal-content">
								        <div class="modal-header">
								            <h5 class="modal-title">Seleccionar archivo <span id = "tituloModSubFac"></span></h5>
								            <button type="button" class="close border-0" data-dismiss="modal">X</button>
								        </div>
								        <div class="modal-body">
								            <p><span id = "cuerpoModSubFac"></span></p>
								            <INPUT id = 'subirArchFac' class="btn form-control-lg col-12" TYPE='file' name = 'subirArchFac' style = "background-color: #e9ecef;"></INPUT>
								        </div>
								        <div class="modal-footer">
								            <button type="button" class="btn text-white" style = "background-color: #19221f;" data-dismiss="modal">Cancelar</button>
								            <button id = "btnModSubFac" type="button" class="btn text-white" name = "btnModSubFac" onClick="cargarFactura();" style = "background-color: #318a3a;" data-dismiss="modal">Subir archivo</button>
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
								            <p>Confirmo que deseo cancelar esta factura.</p>
								        </div>
								        <div class="modal-footer">
								            <button type="button" class="btn text-white" style = "background-color: #19221f;" data-dismiss="modal">No cancelar</button>
								            <button id = "confCanB" type="button" class="btn text-white" name = "confCanB" onClick="cancelarE();" style = "background-color: #318a3a;" data-dismiss="modal">Cancelar</button>
								        </div>
								    </div>
							    </div>
							</div>

							<!------------------------------------- Modal de descarga CSV --------------------------------->

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

	                    <!-- --------------------------------------------Consultar--------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="consultaGen">
	                        <div class="px-2 px-md-3 px-lg-5">
	                        	<FORM id = "formularioCons" NAME="formularioCons" method = 'POST' action = '#' target ="request" enctype="multipart/form-data">
									<div class="card border-0 mb-4 p-4">
								        <div class="text-center col-md-12 col-12 mt-4">
								            <h2><strong>Consultar facturas de empacadoras</strong></h2>
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
				                            <div id="divAbrir" style="display: none;"></div>
				                            <div id="divDes" style="display: none;"></div>	
								            <table id="tablaFac" class="table table-bordered display" style="width: 2050px;">
									                <thead>
									                    <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
										                <th>Folio</th>
										                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Empacadora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
														<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; de&nbsp;emisión</th>
														<th>Estatus</th>
														<th>SubTotal</th>
														<th>Iva</th>
														<th>Total</th>
														<th>Saldo</th>
														<th>Tipo de aportación</th>
														<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Concepto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
														<th>Fecha&nbsp;de cancelación</th>
														<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Justificación&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
										                <th>PDF</th>
										                <th>XML</th>
										                <th></th>
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
				                            <h2><strong>Cancelar factura de empacadora</strong></h2>
				                        </div>
									    <div class="card-body row gy-2 p-4 px-lg-5 px-2 px-md-3">
									        <!------------------------------- Apartado de busqueda -------------------------------->
									        <div class="row col-12 m-0 p-0 gy-1">
										        <div class="col-6 col-lg-3 col-md-4">
										        	<label class=" form-label">Folio</label><INPUT id = "folioC" class = "form-control form-control-sm" TYPE="text" NAME="folioCan" autocomplete="off" required title="Sólo se permiten números enteros" pattern='[0-9]+' maxlength='40' onkeydown = "limpiarCan();"></INPUT>
										        </div>
										        <div class="col-lg-3 col-md-3 col-6">
										        	<div style="height: 27px;"></div>
													<INPUT id = "buscarBC" class = "form-control-lg btn btn-sm col-12 rounded-1 text-white" VALUE="Buscar" TYPE="submit" name = "buscarBC" onClick="validarCan(); buscarC();" style = "background-color: #318a3a;"></INPUT>
												</div>
												<div class="row col-12 m-0 p-0 gy-1 mt-4 px-2">
										            <hr/>
								                </div>
											</div>
							                <!------------------------------- Apartado factura -------------------------------->
                                            <div class="row col-12 col-md-6 m-0 p-0 gy-2">
                                            	<div class="col-12">
										        	<label class=" form-label">Empacadora</label><INPUT id = "empacadoraC" class = "form-control form-control-sm" TYPE="text" NAME="empacadoraC" disabled></INPUT>
										        </div>
                                            	<div class="col-6">
										        	<label class=" form-label">Estatus</label><INPUT id = "estatusC" class = "form-control form-control-sm" TYPE="text" NAME="estatusC" disabled></INPUT>
										        </div>
										        <div class="col-6">
											        <label class=" form-label">Fecha</label><input id = "fechaC" class = "form-control form-control-sm col-12" type = 'text' name = 'fechaC' disabled></input>
											    </div>
											    <!--<div class="row col-12 m-0 p-0 gy-1">-->
											    <div class="col-12">
											        <label class=" form-label">Concepto</label><textarea style="height: 87px; resize: none;" id = "conceptoC" class="form-control form-control-sm" name='conceptoC' disabled></textarea>
											    </div>
											<!--</div>-->
											</div>
											<!------------------------------ segunda columna ---------------------------->
										    <div class="row col-12 col-md-6 m-0 p-0 gy-2">
										        <div class="col-8">
										        	<label class=" form-label">Tipo de aportación</label><input id = "aportacionC" class = "form-control form-control-sm col-12" type = 'text' name = 'aportacionC' disabled></input>
										        </div>
											    <div class="col-4">
											        <label class=" form-label">Iva</label><INPUT id = "ivaC" class = "form-control form-control-sm" TYPE="text" NAME="ivaC" disabled></INPUT>
											    </div>
										        <div class="col-6">
											        <label class=" form-label">Sub total</label><INPUT id = "subTotalC" class = "form-control form-control-sm" TYPE="text" NAME="subTotalC" disabled></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Total</label><INPUT id = "totalC" class = "form-control form-control-sm" TYPE="text" NAME="totalC" disabled></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Saldo</label><INPUT id = "saldoC" class = "form-control form-control-sm" TYPE="text" NAME="saldoC" disabled></INPUT>
											    </div>
											    <div class="col-6 mt-3">
													<INPUT id = "abrirPDFB" class = "form-control-sm btn col-12 rounded-1 mt-3" VALUE="Abrir PDF" TYPE="button" name = "abrirPDFB" onClick="abrFacR();" disabled style = 'background-color: #e9ecef;'></INPUT>
												</div>
												<div class="col-0 col-md-12 col-lg-12 mt-0 mt-md-5 mt-lg-5">
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
									        	<div class="col-12 col-md-6">
													<INPUT id = "cancelarB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Cancelar" TYPE="submit" name = "cancelarB" onClick="validarCan(); confirmarC();" style = "background-color: #7eca28;" disabled></INPUT>
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