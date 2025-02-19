<?php
    session_start();
    require "../funciones.php";
    $permisos = ["Administrador", "Contabilidad"];
    validarSesion($_SESSION["descripcion"], $permisos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Cobros empacadoras</title>
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
<body class="bg-light" onload="impNombre(); impCuenta();">
	<script>
		const tabla = 'empacadora', usuario = "<?php echo $_SESSION['nombre'];?>";
		var valido = false;
		const dirScriptsPhp = '<?php echo $absolutePathAwScripts ?>';
		var numeroPDD = '', folio = '';

		document.addEventListener("DOMContentLoaded", () => {
			iniciarTabla();
		});

		function iniciarTabla(){
			var id = "conCobros";
		    $('#tablaCobros').DataTable({
		    	"ajax":{            
			        "url": dirScriptsPhp + "consultar.php", 
			        "method": 'POST',
			        "data": {
			        	id: id,
					    fechaI: function() { return $('#fechaIC').val()},
					    fechaF: function() { return $('#fechaFC').val()}
					}
			    },
		    	"columns": [
					{ "data": "NumeroPDD"},
					{ "data": "FechaCobro"},
					{ "data": "Monto"},
					{ "data": "FolioFactura"},
					{ "data": "Empacadora"},
					{ "data": "Estatus"},
					{ "data": "Total"},
					{ "data": "Saldo"},
					{ "data": "Aportacion"},
					{ "data": "FechaEmision"},
					{ "data": "BancoEmp"},
					{ "data": "NumCuentaEmp"},
					{ "data": "BancoAs"},
					{ "data": "NumCuentaAs"},
					{ "data": "Observaciones"},
					{ "data": "pdf"},
					{ "data": "xml"},
					{ "data": "email"}
			    ],
			    "columnDefs": [
                    { className: "dt-right", "targets": [2, 6, 7] }
                ],
                order: [[1, 'desc'], [0, 'desc']],
			    fixedHeader: {
                    header: true,
                    headerOffset: $('#barra').height() - 6
                },
                scrollX: true
		    });

		    id = "conFactAportaCobros";
		    var empacadora = "empacadora";
		    $('#tablaFac').DataTable({
		    	"ajax":{           
			        "url": dirScriptsPhp + "consultar.php", 
			        "method": 'POST',
			        "data": {
			        	id: id,
			        	empacadora: function() { return $('#empacadora').val()}
					}
			    },
		    	"columns": [
					{ "data": "FolioFactura"},
					{ "data": "FechaEmision"},
					{ "data": "Total"},
					{ "data": "Saldo"},
					{ "data": "Aportacion"},
					{ "data": "Concepto"}
			    ],
			    "columnDefs": [
                    { className: "dt-right", "targets": [2, 3] }
                ],
			    fixedHeader: {
                    header: true,
                    headerOffset: $('#barra').height() - 6
                },
                scrollX: true
		    });
		}

		function impCuenta(){
			if ($("#cuentaAs").val() == ""){
				var parametros = {
					"id" : "impCuenta",
				}
				
				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (response) {
		            	$("#cuentaAs").html(response);
		            }
		        });
			}
		}

		function impNombre(){
			if ($("#empacadora").val() == ""){
				var parametros = {
					"id" : "empacadoras"
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
		}

		function imprimir() {
			var obtEmpacadora = "obtDatosEmp";
			var empacadora = document.getElementById("empacadora").value;
			var nomEmpa = document.getElementById("empacadora").options[document.getElementById("empacadora").selectedIndex].text;
			$("#folio, #fecha, #concepto, #subTotal, #total, #iva, #aportacion, #saldoC, #numPDD, #fechaC, #monto, #observaciones, #archivoPDF, #archivoXML, #cuentaAs").val("");
			$("#folio, #fecha, #concepto, #subTotal, #total, #iva, #aportacion, #saldoC, #numPDD, #fechaC, #monto, #observaciones, #modRegisB, #abrirPDFB, #cuentaAs").attr("disabled", "");
			
			if ($.fn.DataTable.isDataTable("#tablaFac")) {
                $.ajax({
	                success:  function () {
	                    $("#tablaFac").DataTable().ajax.reload(null, false);
	                }
	            });
            } else {
                setTimeout(consutar, 1000);
            }

			if (nomEmpa == "..."){
				$("#RFC, #banco, #cuenta, #clabe, #regimen, #saldo").val("");
			    $("#archivoPDF, #archivoXML").attr("disabled", "");
			}else{
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
		            	rellenar(response.result.RFC, response.result.Banco, response.result.NumCuenta, response.result.Clabe, response.result.Regimen, response.result.SaldoFormato);
						
		            }
		        });
			}
		} 

		function rellenar(RFC, banco, cuenta, clabe, reg, sald){
			document.getElementById("RFC").value = RFC;
			document.getElementById("banco").value = banco;
			document.getElementById("cuenta").value = cuenta;
			document.getElementById("clabe").value = clabe;
			document.getElementById("regimen").value = reg;
			document.getElementById("saldo").value = sald;
			obtFacturas();
		}

		function obtFacturas(){
		    var idEmpacadora = document.getElementById("empacadora").value;
		    if (idEmpacadora != ""){
		    	var obtFacturasCobros = "obtFacturasCobros";
			    var folioF = document.getElementById("folio").value;

		        var parametros = {
					"id" : obtFacturasCobros,
					"idEmpacadora" : idEmpacadora
				}
				
				$.ajax({
				    data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (response) {
		            	if(folioF == ""){
		            	    $("#folio").html(response);
			            }

			            if (document.getElementById("folio").options.length == 1){
				        	$("#archivoPDF, #archivoXML").attr("disabled", "");
				        } else{
				        	document.getElementById("archivoPDF").disabled = false;
			                document.getElementById("archivoXML").disabled = false;
				        }
		            }
		        });
		    }
		}

		function consultar() {
			if ($.fn.DataTable.isDataTable("#tablaCobros")) {
                $.ajax({
	                success:  function () {
	                    $("#tablaCobros").DataTable().ajax.reload(null, false);
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

		function validarM (){
			var formulario = document.getElementById('formularioM');
			valido = formulario.checkValidity();
		}

		function impFactura() {
		    folio = document.getElementById("folio").value;
		    if (folio == ""){
		        $("#fecha, #concepto, #subTotal, #total, #iva, #aportacion, #saldoC").val("");
		        document.getElementById("abrirPDFB").disabled = true;
		    } else{
			    var obtFacturaAporta = "obtFacturaAporta";

				var parametros = {
					"id" : obtFacturaAporta,
					"folio" : folio
				}
				
				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            dataType: "json",
		            success:  function (response) {
	        			$("#fecha").val(response.result.FechaEmision);
	        			$("#concepto").val(response.result.Concepto);
	        			$("#aportacion").val(response.result.Aportacion);
	        			$("#iva").val(response.result.Iva);
	        			$("#subTotal").val(response.result.SubTotal);
	        			$("#total").val(response.result.Total);
	        			$("#saldoC").val(response.result.Saldo);
	        			document.getElementById("abrirPDFB").disabled = false;
		            }
		        });
			}
		} 

		function registrar (){
		    if(valido == true ){
		        var formData = new FormData();
		        folio = document.getElementById("folio").value;
		        var numeroPDD = document.getElementById("numPDD").value;
		        formData.append("id", "InsCobrosA");
				formData.append("folio", folio);
				formData.append("numPDD", numeroPDD);
				formData.append("fecha", document.getElementById("fechaC").value);
				formData.append("monto", document.getElementById("monto").value);
				formData.append("observaciones", document.getElementById("observaciones").value);
				formData.append("cuenta", document.getElementById("cuentaAs").value);
				formData.append("idEmpacadora", document.getElementById("empacadora").value);
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
			            	$("#registro").html("El cobro correspondiente a la factura con folio <i>"+folio+"</i> ha sido registrado correctamente.");
			            	$("#titulo").html("Registro exitoso");
			                document.getElementById('formularioR').reset();
			                impNombre(); 
			                impCuenta();
		                    $("#tablaFac").DataTable().ajax.reload(null, false);
			                $("#folio, #fecha, #concepto, #subTotal, #total, #iva, #aportacion, #saldoC, #numPDD, #fechaC, #monto, #observaciones, #modRegisB, #abrirPDFB, #archivoPDF, #archivoXML, #cuentaAs").attr("disabled", "");
			            } else {
			                if(response[0] == "3"){
		            			$("#registro").html("No es posible registrar el cobro correspondiente a la factura con folio <i>"+folio+"</i>, el número PDD <i>"+numeroPDD+"</i> ya existe.");
		            	        $("#titulo").html("Número PDD existente");
		            		} else {
		            		    if(response[0] == "2"){
		            		        $("#registro").html("No fue posible registrar el cobro correspondiente a la factura con folio <i>"+folio+"</i>, hubo un problema al momento de subir los documentos al servidor. Intentelo nuevamente.");
		            	            $("#titulo").html("Ha ocurrido un error");
		            		    } else {
		            		        if(response[0] == "4"){
		            		            $("#registro").html("El cobro correspondiente a la factura con folio <i>"+folio+"</i> ha sido registrada correctamente, sin embargo, no fue posible enviarla por correo electrónico. Intentelo nuevamente desde la consulta.");
		            	                $("#titulo").html("Registro exitoso sin enviar");
		            		        } else{
		            	                if(response[0] == "5"){
			            		            $("#registro").html("No es posible registrar el cobro correspondiente a la factura con folio <i>"+folio+"</i>, la diferencia del saldo de la factura y el monto del cobro es igual a un número negativo.");
			            	                $("#titulo").html("Saldo negativo");
			            		        } else{
			            	                $("#registro").html("El cobro correspondiente a la factura con folio <i>"+folio+"</i> no se ha podido registrar.");
			            	                $("#titulo").html("Ha ocurrido un error");
			            		        }
		            		        }
		            		    }
		            		}
		            	}
			            $("#abrirmodal").trigger("click");
		            }
		        });
			}
		}
		
		function exportarTabla(){
			document.getElementById("nombreDes").value = "";
			$("#abrirmodalDes").trigger("click");
		}

		function descargarCSV(){
			var nombre = document.getElementById("nombreDes").value;

			if (nombre != ""){
				var expCobros = "expCobros";
				var tabla = $("#tablaCobros").DataTable().rows({ filter : 'applied'}).data();
				var arreglo = [];

	            $.each( tabla, function( key, value ) {
				    arreglo[key] = value;
				});

				var parametros = {
				    "id" : expCobros,
				    "datos" : JSON.stringify(arreglo),
				    "nombre" : nombre
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
			} else{
				$("#registro").html("No es posible descargar el archivo, no le ha asignado ningun nombre.");
		        $("#titulo").html("Acción denegada");
		        $("#abrirmodal").trigger("click");
			}
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
		
		function obtMesAño(){
		    var fecha = $("#fechaC").val();
		    $("#mes").val(fecha.substring(5, 7));
		    $("#año").val(fecha.substring(0, 4));
		}
		
		function abrFac(ext, estado){
		    $("#divAbrir").html('<a id = "enlaceAbrir" href = "Cobros'+ext.toUpperCase()+'/'+estado+numeroPDD+'.'+ext+'" target="_blank">Abrir factura</a>');
		    $('#divAbrir a')[0].click();
		}
		
		function abrFacR(){
		    var pdf = $("#folio").val(), rutaFacCobro = "rutaFacCobro";
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
		
		function enviarCorreo(empacadora){
		    var eviArchConCobros = "eviArchConCobros";
		    var parametros = {
		        "id" : eviArchConCobros,
			    "numPDD" : numeroPDD,
			    "empacadora" : empacadora
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'registrar.php',
	            type: 'post',
	            success:  function (response) {
		            if(response[0] == "1"){
	            		$("#registro").html("El corrreo electónico correspondiente al cobro con número PDD <i>"+numeroPDD+"</i> relacionado a la factura con folio <i>"+folio+"</i> ha sido enviado correctamente.");
	            	    $("#titulo").html("Envio exitoso");
	            	} else {
	            	    $("#registro").html("No fue posible enviar el correo electrónico correspondiente al cobro con número PDD <i>"+numeroPDD+"</i> relacionado a la factura con folio <i>"+folio+"</i>.");
	            	    $("#titulo").html("Ha ocurrido un error");
	            	}
	                $("#abrirmodal").trigger("click");
	                consultar();
	            }
	        });  
		}
		
		function cargarFactura(){
		    if ($("#subirArchFac").val() != "") {
		        var nombreArch = document.getElementById('subirArchFac').value;
		        var extencion = "." + $("#tituloModSubFac").html().toLowerCase();
                if(nombreArch.includes(extencion)){ 
                    var formData = new FormData();
				    formData.append("archivo", $('#subirArchFac').get(0).files.item(0));
				    formData.append("numPDD", numeroPDD);
				    formData.append("id", "cargarCobro");
				    formData.append("ext", $("#tituloModSubFac").html());
				    
	                $.ajax({
					    url: dirScriptsPhp + 'registrar.php',
					    type: "POST",
					    data: formData,
					    processData: false, 
					    contentType: false,  
					    success:  function (response) {
					        if(response[0] == "1"){
			            		$("#registro").html("El documento "+$("#tituloModSubFac").html()+" correspondiente al cobro con número PDD <i>"+numeroPDD+"</i> relacionado a la factura con folio <i>"+folio+"</i> ha sido guardado correctamente.");
			            	    $("#titulo").html("Importación exitosa");
			            	} else {
			            		$("#registro").html("No fue posible guardar el documento "+$("#tituloModSubFac").html()+".");
			            	    $("#titulo").html("Ha ocurrido un error");
			            	}
			            	$("#abrirmodal").trigger("click");
						    consultar();	   
					    }
					});
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
		
		function subirPDF(){
		    $("#subirArchFac").val('');
			$("#tituloModSubFac").html("PDF");
		    $("#cuerpoModSubFac").html("Por favor seleccione el documento PDF correspondiente al cobro con número PDD <i>"+numeroPDD+"</i> relacionado a la factura con folio <i>"+folio+"</i>.");
		    $('#subirArchFac').attr("accept", "application/pdf");
		    $("#abrirmodalSub").trigger("click");
		}

		function subirXML(){
		    $("#subirArchFac").val('');
			$("#tituloModSubFac").html("XML");
		    $("#cuerpoModSubFac").html("Por favor seleccione el documento XML correspondiente al cobro con número PDD <i>"+numeroPDD+"</i> relacionado a la factura con folio <i>"+folio+"</i>.");
		    $('#subirArchFac').attr("accept", "application/xml");
		    $("#abrirmodalSub").trigger("click");
		}

		function obtXml(){
			var nomArchXML = document.getElementById('archivoXML').value;
			$("#folio, #fecha, #concepto, #subTotal, #total, #iva, #aportacion, #saldoC, #numPDD, #fechaC, #monto, #observaciones, #cuentaAs, #archivoPDF").val("");
			$("#folio, #fecha, #concepto, #subTotal, #total, #iva, #aportacion, #saldoC, #numPDD, #fechaC, #monto, #observaciones, #modRegisB, #abrirPDFB, #cuentaAs").attr("disabled", "");
			
            if (nomArchXML.includes(".xml")){
                var formData = new FormData();
			    formData.append("id", "obtFacturaXmlCobros");
			    formData.append("archivoXML", $('#archivoXML').get(0).files.item(0));

				$.ajax({
					url: dirScriptsPhp + 'consultar.php',
				    type: "POST",
				    data: formData,
				    processData: false, 
				    contentType: false,  
				    dataType: "json",
		            success:  function (response) {
		                var numPDD = response.NumPDD;

		                if (numPDD !== undefined){
		                	var lista = document.getElementById("folio"),
		                        fecha = response.Fecha;

							for (i = 0; i < lista.options.length; i++) {
							    if (lista.options[i].text == response.Folio) {
							        $("#folio").val(response.Folio);
							    }
							}

		                	if ($("#folio").val() != ""){
		                		$("#fechaC").val(fecha.substring(0, 4) + "-" + fecha.substring(5, 7) + "-" + fecha.substring(8, 10));
				                $("#numPDD").val(numPDD);
				                $("#folio").val(response.Folio);
				                $("#monto").val(response.Monto);
				                document.getElementById("modRegisB").disabled = false;
				                document.getElementById("abrirPDFB").disabled = false;
				                document.getElementById("observaciones").disabled = false;
				                document.getElementById("cuentaAs").disabled = false;
				                impFactura();
		                	} else{
		                		$('#archivoXML').val("");
			                    $("#registro").html('La factura seleccionada no corresponde con ninguna de las facturas pendientes a nombre de la empacadora <i>' + document.getElementById("empacadora").options[document.getElementById("empacadora").selectedIndex].text + '</i>.');
			            	    $("#titulo").html("Acción denegada");
				                $("#abrirmodal").trigger("click");
		                	}
		                } else{
                            $('#archivoXML').val("");
		                    $("#registro").html('Ha seleccionado un archivo XML que no coincide con el formato de la factura.');
		            	    $("#titulo").html("Archivo no válido");
			                $("#abrirmodal").trigger("click");
		                }
		            },
		            error: function() { 
				        $('#archivoXML').val("");
	                    $("#registro").html('Es posible que haya seleccionado un archivo XML que no coincide con el formato de la factura, intentelo nuevamente.');
	            	    $("#titulo").html("Acción denegada");
		                $("#abrirmodal").trigger("click");
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
		    document.getElementById('numPDD').disabled = false;
		    document.getElementById('fechaC').disabled = false;
		    document.getElementById('monto').disabled = false;
		}

		function exportarTabla(){
			document.getElementById("nombreDes").value = "";
			$("#abrirmodalDes").trigger("click");
		}

		function descargarCSV(){
			nombreCsv = document.getElementById("nombreDes").value;

			if (nombreCsv != ""){
				var tabla = $("#tablaCobros").DataTable().rows({ filter : 'applied'}).data();
				var arreglo = [];

	            $.each( tabla, function( key, value ) {
				    arreglo[key] = value;
				});

				var parametros = {
				    "id" : "expCobros",
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
	                            <?php echo impMenu($_SESSION['descripcion'], 'CobrosAportaciones', 'cobros');?>
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
				<div class = "col-12" style="max-width: 1100px;">
	                <!-- -----------------------------------------tabs----------------------------------------- -->
	                <ul class="nav nav-tabs cambioColor">
	                    <li class="nav-item active rounded-top" style="background-color: #19221f;">
	                        <a href="#registrar" class="nav-link active" role="tab" data-toggle="tab" onClick="impNombre(); obtFacturas(); impCuenta();"><strong>Registrar</strong></a>
	                    </li>

	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#consultaGen" class="nav-link" role="tab" data-toggle="tab" onClick="consultar();"><strong>Consultar cobros</strong></a>
	                    </li>
							
	                    
	                </ul>

	                <div class="tab-content bg-white border border-top-0 rounded-3 text-justify" style="box-shadow: 0px 0px 10px #c6c6c6;">
	                	<!-- --------------------------------------------Registrar-------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane in active" id="registrar">
	                        <div class="px-5">
	                        	<!---------------------------------- formulario ---------------------------------->
	                        	<FORM id = "formularioR" NAME="INSERTAR" method = 'POST' action = '#' target ="request" enctype="multipart/form-data">
									<div class="card border-0">
									    <div class="text-center col-md-12 col-12 mt-5">
				                            <h2><strong>Registrar cobro</strong></h2>
				                        </div>
									    <div class="card-body row gy-2 pt-3 pb-0 px-lg-5 px-2 px-md-3 my-0">
											<!------------------------------- Apartado de empacadora -------------------------------->
									        <div class="row col-12 col-md-6 m-0 p-0 gy-1">
										        <div class="col-12">
										        	<label class=" form-label">Empacadora</label>
										        	<Select id = "empacadora" class = "form-select form-select-sm col-12" name='empacadora'required onChange = "imprimir();">
										        		<option value="" selected>...</option>
										        	</Select>
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
											<!------------------------------------ apartado tabla ------------------------------------>
											<div class="col-12 mt-0 mb-3 pt-3 pb-0 p-0 px-2">
									            <table id="tablaFac" class="table table-bordered display" style="width: 905px;">
										            <thead>
										                <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
											                <th>Folio</th>
															<th>Fecha&nbsp;de emisión</th>
															<th>Total</th>
															<th>Saldo</th>
															<th>Tipo de aportación</th>
															<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Concepto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</th>
											            </tr>
											        </thead>
											        <tbody id="idTBody">
											        </tbody>
											    </table>
										    </div> 
										    <!-------------------------------- input file -------------------------------->
										    <div class="row col-12 m-0 p-0 gy-1 pb-3">
										        <div class="row col-12 m-0 p-0 gy-1">
										            <hr/>
												</div>
										        <div class="col-6">
													<label class="form-label">Documento XML (PDD)</label>
													<INPUT id = 'archivoXML' class="btn form-control-lg col-12 border border-1 bg-white" VALUE='Subir XML' TYPE='file' name = 'archivoXML' disabled accept = "application/xml" required onChange = "obtXml();"></INPUT>
													<br>
												</div>
												<div class="col-6">
													<label class="form-label">Documento PDF (PDD)</label>
													<INPUT id = 'archivoPDF' class="btn form-control-lg col-12 border border-1 bg-white" VALUE='Subir PDF' TYPE='file' name = 'archivoPDF' disabled accept = "application/pdf" required></INPUT>
													<br>
												</div>
								            </div>
											<!----------------------------------- apartado de factura ------------------------------>
											<div class="row col-12 m-0 p-0 gy-1 mt-2">
										        <hr/>
											</div> 
									        <div class="row col-12 col-md-6 m-0 p-0 gy-1">
                                            	<div class="col-6">
										        	<label class=" form-label">Folio</label>
										        	<Select id = "folio" class = "form-select form-select-sm col-12" name='folio' required onChange = "impFactura();" disabled>
										        		<option value="" selected>...</option>
										        	</Select>
										        </div>
										        <div class="col-6">
											        <label class=" form-label">Fecha</label><input id = "fecha" class = "form-control form-control-sm col-12" type = 'text' name = 'fecha' disabled></input>
											    </div>
											    <div class="col-12">
											        <label class=" form-label">Concepto</label><textarea style="height: 97px; resize: none;" id = "concepto" class="form-control form-control-sm" name='concepto' disabled></textarea>
											    </div>
                                            </div>
                                            <div class="row col-12 col-md-6 m-0 p-0 gy-1">
											    <div class="col-4">
											        <label class=" form-label">Iva</label><INPUT id = "iva" class = "form-control form-control-sm" TYPE="text" NAME="iva" disabled></INPUT>
											    </div>
										        <div class="col-8">
										        	<label class=" form-label">Tipo de aportación</label><input id = "aportacion" class = "form-control form-control-sm col-12" type = 'text' name = 'aportacion' disabled></input>
										        </div>
										        <div class="col-6">
											        <label class=" form-label">Sub total</label><INPUT id = "subTotal" class = "form-control form-control-sm" TYPE="text" NAME="subTotal" disabled></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Total</label><INPUT id = "total" class = "form-control form-control-sm" TYPE="text" NAME="total" disabled></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label">Saldo</label><INPUT id = "saldoC" class = "form-control form-control-sm" TYPE="text" NAME="saldoC" disabled></INPUT>
											    </div>
											    <div class="col-6 mt-3">
													<INPUT id = "abrirPDFB" class = "form-control-sm btn col-12 rounded-1 mt-3" VALUE="Abrir PDF" TYPE="button" name = "abrirPDFB" onClick="abrFacR();" disabled style = 'background-color: #e9ecef;'></INPUT>
												</div>
											</div>
	                                        <div class="row col-12 m-0 p-0 gy-1 mt-4">
										        <hr/>
								            </div>
										</div>
										<!-------------------------------------- apartado de cobro ------------------------------------->
										<div class="card-body row gy-2 px-lg-5 px-2 px-md-3 py-0 my-0">
											<div class="row col-12 col-md-6 m-0 p-0 gy-1">
                                                <div class="col-6">
											        <label class=" form-label">Número PDD </label><INPUT id = "numPDD" class = "form-control form-control-sm" TYPE="text" NAME="numPDD" pattern='[0-9]+' maxlength='40' autocomplete="off" disabled required title="Sólo se permiten números enteros"></INPUT>
												</div>
												<div class="col-6">
											        <label class=" form-label">Fecha del cobro</label><INPUT id = "fechaC" class = "form-control form-control-sm" TYPE="date" NAME="fechaC" disabled required onChange = "obtMesAño();"></INPUT>
											    </div>
											    <div class="col-6">
											        <label class=" form-label col-12">Monto</label><INPUT id = "monto" class = "form-control form-control-sm" NAME="monto" autocomplete="off" disabled required type="number" step="0.01" title="Sólo se permiten valores numéricos con un máximo de 2 decimales" min = "0.01"></INPUT>
                                                </div>
											    <div class="col-6 mt-3">
													<INPUT id = "modRegisB" class = "form-control-sm btn col-12 rounded-1 text-white mt-3" VALUE="Modificar" TYPE="button" name = "modRegisB" onClick="modRegistro();" style = "background-color: #19221f;" disabled></INPUT>
												</div>
												<div class="col-12">
										        	<label class=" form-label">Cuenta de la asociación</label>
										        	<Select id = "cuentaAs" class = "form-select form-select-sm col-12" name='cuentaAs' required disabled>
										        		<option value="" selected>...</option>
										        	</Select>
										        </div>
                                            </div>
                                            <!------------------------------ segunda columna ---------------------------->
                                            <div class="row col-12 col-md-6 m-0 p-0 gy-1 mb-1">
											    <div class="col-12">
											        <div class="row col-12 m-0 p-0">
                                                        <label class=" form-label">Observaciones</label><textarea style="height: 98px; resize: none;" id = "observaciones" class="form-control form-control-sm" maxlength='200' name='observaciones' autocomplete="off" disabled pattern = "[^\u{0022}]*" title="No se permiten comillas dobles"></textarea>
                                                    </div>
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
								<FORM id = "formulario" NAME="formulario" method = 'POST' action="#" target ="request">
								    <div class="card border-0 mb-4 p-4">
									    <div class="text-center col-md-12 col-12 mt-4">
				                            <h2><strong>Consultar cobros</strong></h2>
				                        </div>
				                        <!---------------------------------------- periodo -------------------------------------------->
				                        <div class="row m-0 p-0 gy-1 mt-3 mb-0">
				                        	<div class="row col-12 m-0 p-0 gy-1 mb-2">
											<div class="col-6 col-md-3 col-lg-3">
											        <label class=" form-label">Fecha inicial</label><input id = "fechaIC" class = "form-control form-control-sm col-12" type = 'date' name = 'fechaIC' onChange = "consultar();"></input>
											    </div>
											    <div class="col-6 col-md-3 col-lg-3">
											        <label class=" form-label">Fecha final</label><input id = "fechaFC" class = "form-control form-control-sm col-12" type = 'date' name = 'fechaFC' onChange = "consultar();"></input>
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
				                            	<table id="tablaCobros" class="table table-bordered display" style="width: 2150px;">
									                <thead>
									                    <tr style="background-color: #318a3a; color: white; border-color: #318a3a;" class="text-center">
															<th>Número PDD</th>
															<th>Fecha&nbsp;cobro</th>
															<th>Monto</th>
															<th>Folio factura</th>
															<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Empacadora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
															<th>Estatus</th>
															<th>Total</th>
															<th>Saldo</th>
															<th>Tipo aportación</th>
															<th>Fecha&nbsp;factura</th>
															<th>Banco empacadora</th>
															<th>Num&nbsp;cuenta empacadora</th>
															<th>Banco asociación</th>
															<th>Num&nbsp;cuenta asociación</th>
															<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Observaciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
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