<?php
    session_start();
    include '../conexion.php'; 
    require "../funciones.php";
    $permisos = ["Administrador", "Estadística", "Empaque"];
    validarSesion($_SESSION["descripcion"], $permisos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Reportes de certificados</title>
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

	<link rel="shortcut icon" href="..\Imagenes\icono.ico">
</head>
<body class="bg-light" onload="impPeriodoAños(); inicializarG(); actualizarL(); impTemporadas();">
	<script>
		const dirScriptsPhp = '<?php echo $absolutePathAwScripts ?>';
		var myChartL;
		var myChartB;
		var myChartMK;
		var myChartMA;
		var myChartME;
		var myChartMEB;
		var myChartMEA;
		var totalT1;

		var colores = ['RGBA(166, 184, 40, 1)', 'RGBA(115, 180, 0, 1)', 'RGBA(28, 72, 45, 1)', 'RGBA(10, 103, 91, 1)', 'RGBA(2, 109, 125, 1)', 'rgba(0, 146, 215, 1)', 'rgba(64, 72, 205, 1)', 'rgba(27, 53, 88, 1)', 'rgba(186, 35, 0, 1)', 'rgba(248, 89, 31, 1)', 'rgba(255, 153, 0, 1)', 'rgba(242, 213, 0, 1)'];

		var meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
		
		function impNombre(){
			var empacadoras = "empacadoras";
			var emp = document.getElementById("empacadoraME").value; 

			var parametros = {
				"id" : empacadoras
			}

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	if(emp == ""){
	            	    $("#empacadoraME").html(response);
		            }
	            }
	        });
		}

		function impPeriodoAños(){
			var impAnios = "impAnios";

			var parametros = {
			    "id" : impAnios
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	$("#añoIL").html(response);
	            	$("#añoFL").html(response);
	            }
	        });
		}

		function inicializarG(){
			document.getElementById('chartL');
            document.getElementById('chartL').getContext('2d');
			var ctx = document.getElementById('chartL');
		    myChartL = new Chart(ctx, {
			    type: 'line',
			    data: {
			        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
			    },
			    options: {
			    	animation: false,
			        scales: {
			            y: {
			                beginAtZero: true,
			                title: {
					            display: true,
					            text: 'Kilogramos'
					        }
			            }
			        }
			    }
			});

			document.getElementById('chartB');
            document.getElementById('chartB').getContext('2d');
			ctx = document.getElementById('chartB');
		    myChartB = new Chart(ctx, {
			    type: 'bar',
			    data: {
			        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
			    },
			    options: {
			    	animation: false,
			        scales: {
			            y: {
			                beginAtZero: true,
			                title: {
					            display: true,
					            text: 'Kilogramos'
					        }
			            }
			        }
			    }
			});

			document.getElementById('chartMK');
            document.getElementById('chartMK').getContext('2d');
			ctx = document.getElementById('chartMK');
		    myChartMK = new Chart(ctx, {
			    type: 'bar',
			    data: {
			    },
			    options: {
			    	animation: false,
			        scales: {
			            y: {
			                beginAtZero: true,
			                title: {
					            display: true,
					            text: 'Kilogramos'
					        }
			            }
			        }
			    }
			});

			document.getElementById('chartMA');
            document.getElementById('chartMA').getContext('2d');
			ctx = document.getElementById('chartMA');
		    myChartMA = new Chart(ctx, {
			    type: 'doughnut',
			    data: {
			    },
			    options: {
			    	animation: false,
			        borderWidth: 0
			    }
			});

			document.getElementById('chartME');
            document.getElementById('chartME').getContext('2d');
			ctx = document.getElementById('chartME');
		    myChartME = new Chart(ctx, {
			    type: 'bar',
			    data: {
			        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
			    },
			    options: {
			    	animation: false,
			        scales: {
			            y: {
			                beginAtZero: true
			            },
			            x: {
			                title: {
					            display: true,
					            text: 'Embarques'
					        }
			            }
			        },
			        indexAxis: 'y'
			    }
			});
			
			document.getElementById('chartMEB');
            document.getElementById('chartMEB').getContext('2d');
			ctx = document.getElementById('chartMEB');
		    myChartMEB = new Chart(ctx, {
			    type: 'bar',
			    data: {
			    },
			    options: {
			    	animation: false,
			        scales: {
			            y: {
			                beginAtZero: true,
			                title: {
					            display: true,
					            text: 'Kilogramos'
					        }
			            }
			        }
			    }
			});

			document.getElementById('chartMEA');
            document.getElementById('chartMEA').getContext('2d');
			ctx = document.getElementById('chartMEA');
		    myChartMEA = new Chart(ctx, {
			    type: 'doughnut',
			    data: {
			    },
			    options: {
			    	animation: false,
			        borderWidth: 0
			    }
			});
			
			document.getElementById('chartTB1');
            document.getElementById('chartTB1').getContext('2d');
			ctx = document.getElementById('chartTB1');
		    myChartTB1 = new Chart(ctx, {
			    type: 'bar',
			    data: {},
			    options: {
			    	animation: false,
			        scales: {
			            y: {
			                beginAtZero: true,
			                title: {
					            display: true,
					            text: 'Kilogramos'
					        }
			            }
			        }
			    }
			});

			document.getElementById('chartTB2');
            document.getElementById('chartTB2').getContext('2d');
			ctx = document.getElementById('chartTB2');
		    myChartTB2 = new Chart(ctx, {
			    type: 'bar',
			    data: {},
			    options: {
			    	animation: false,
			        scales: {
			            y: {
			                beginAtZero: true,
			                title: {
					            display: true,
					            text: 'Kilogramos'
					        }
			            }
			        }
			    }
			});

			document.getElementById('chartTB3');
            document.getElementById('chartTB3').getContext('2d');
			ctx = document.getElementById('chartTB3');
		    myChartTB3 = new Chart(ctx, {
			    type: 'bar',
			    data: {
			        labels: ['Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', 'Ene', 'Feb', 'Mar', 'Abr', 'May']
			    },
			    options: {
			    	animation: false,
			        scales: {
			            y: {
			                beginAtZero: true,
			                title: {
					            display: true,
					            text: 'Kilogramos'
					        }
			            }
			        }
			    }
			});

			document.getElementById('chartTL');
            document.getElementById('chartTL').getContext('2d');
			var ctx = document.getElementById('chartTL');
		    myChartTL = new Chart(ctx, {
			    type: 'line',
			    data: {
			        labels: ['Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', 'Ene', 'Feb', 'Mar', 'Abr', 'May']
			    },
			    options: {
			    	animation: false,
			        scales: {
			            y: {
			                beginAtZero: true,
			                title: {
					            display: true,
					            text: 'Kilogramos'
					        }
			            }
			        }
			    }
			});
		}

		function actualizarL(){
			var chartLength = myChartL.data.datasets.length;
		    for (var i = 0; i<chartLength; i++){
		    	myChartL.data.datasets.pop();
		    }

			var añoI = document.getElementById("añoIL").value;
			var añoF = document.getElementById("añoFL").value;

			if (añoI != "" && añoF != ""){
				var repPerA = "repPerA";

				var parametros = {
				    "id" : repPerA, 
				    "anioI" : añoI,
				    "anioF" : añoF
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            dataType: "json",
		            success:  function (response) {
		            	var titulo;
		            	if (añoI == añoF){
		            		titulo = 'Estadísticas de Exportación de Aguacate de Jalisco de ' + añoI + ".";
		            	} else{
		            		titulo = 'Estadísticas de Exportación de Aguacate de Jalisco de ' + añoI + ' a ' + añoF + '.';
		            	}
		            	
		            	myChartL.options.plugins.title = {
			                display: true,
			                text: titulo,
			                color : ['rgba(50, 50, 50, 1)'],
			                font : {
			                	size: 15,
			                	weight: 'normal'
			                }
			            };

			            Object.entries(response).forEach(([key, value]) => {
						    myChartL.data.datasets.push({
					            label: key,
					            data: value,
					            backgroundColor: [
					                'RGBA(166, 184, 40, 0.5)', 
					                'RGBA(115, 180, 0, 0.5)', 
					                'RGBA(28, 72, 45, 0.5)', 
					                'RGBA(10, 103, 91, 0.5)', 
					                'RGBA(2, 109, 125, 0.5)', 
					                'rgba(0, 146, 215, 0.5)', 
					                'rgba(64, 72, 205, 0.5)', 
					                'rgba(27, 53, 88, 0.5)', 
					                'rgba(186, 35, 0, 0.5)', 
					                'rgba(248, 89, 31, 0.5)', 
					                'rgba(255, 153, 0, 0.5)', 
					                'rgba(242, 213, 0, 0.5)'],
					            borderColor: [
					                'RGBA(166, 184, 40, 1)', 
					                'RGBA(115, 180, 0, 1)', 
					                'RGBA(28, 72, 45, 1)', 
					                'RGBA(10, 103, 91, 1)', 
					                'RGBA(2, 109, 125, 1)', 
					                'rgba(0, 146, 215, 1)', 
					                'rgba(64, 72, 205, 1)', 
					                'rgba(27, 53, 88, 1)', 
					                'rgba(186, 35, 0, 1)', 
					                'rgba(248, 89, 31, 1)', 
					                'rgba(255, 153, 0, 1)', 
					                'rgba(242, 213, 0, 1)']
					        },);
						});
	                    myChartL.update();
		            }
		        });
			} else{
				var repGenA = "repGenA";

				var parametros = {
				    "id" : repGenA
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            dataType: "json",
		            success:  function (response) {
		            	var i = 0;
		            	var aI;
		            	var aF;
			            Object.entries(response).forEach(([key, value]) => {
			            	if (i == 0){
			            		aI = key;
			            	    i = i + 1;
			            	}
			            	aF = key;
						    myChartL.data.datasets.push({
					            label: key,
					            data: value,
					            backgroundColor: [
					                'RGBA(166, 184, 40, 0.5)', 
					                'RGBA(115, 180, 0, 0.5)', 
					                'RGBA(28, 72, 45, 0.5)', 
					                'RGBA(10, 103, 91, 0.5)', 
					                'RGBA(2, 109, 125, 0.5)', 
					                'rgba(0, 146, 215, 0.5)', 
					                'rgba(64, 72, 205, 0.5)', 
					                'rgba(27, 53, 88, 0.5)', 
					                'rgba(186, 35, 0, 0.5)', 
					                'rgba(248, 89, 31, 0.5)', 
					                'rgba(255, 153, 0, 0.5)', 
					                'rgba(242, 213, 0, 0.5)'],
					            borderColor: [
					                'RGBA(166, 184, 40, 1)', 
					                'RGBA(115, 180, 0, 1)', 
					                'RGBA(28, 72, 45, 1)', 
					                'RGBA(10, 103, 91, 1)', 
					                'RGBA(2, 109, 125, 1)', 
					                'rgba(0, 146, 215, 1)', 
					                'rgba(64, 72, 205, 1)', 
					                'rgba(27, 53, 88, 1)', 
					                'rgba(186, 35, 0, 1)', 
					                'rgba(248, 89, 31, 1)', 
					                'rgba(255, 153, 0, 1)', 
					                'rgba(242, 213, 0, 1)']
					        },);
						});
						myChartL.options.plugins.title = {
			                display: true,
			                text: 'Estadísticas de Exportación de Aguacate de Jalisco de ' + aI + ' a ' + aF + '.',
			                color : ['rgba(50, 50, 50, 1)'],
			                font : {
			                	size: 15,
			                	weight: 'normal'
			                }
			            };
	                    myChartL.update();
		            }
		        });
			}

			/////////////////////////////////////  grafica de barras /////////////////////////////////////

			var chartLength = myChartB.data.datasets.length;
		    for (var i = 0; i<chartLength; i++){
		    	myChartB.data.datasets.pop();
		    }

			if (añoI != "" && añoF != ""){
				var repPerA = "repPerA";

				var parametros = {
				    "id" : repPerA, 
				    "anioI" : añoI,
				    "anioF" : añoF
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            dataType: "json",
		            success:  function (response) {
		            	var titulo;
		            	if (añoI == añoF){
		            		titulo = 'Estadísticas de Exportación de Aguacate de Jalisco de ' + añoI + ".";
		            	} else{
		            		titulo = 'Estadísticas de Exportación de Aguacate de Jalisco de ' + añoI + ' a ' + añoF + '.';
		            	}
		            	myChartB.options.plugins.title = {
			                display: true,
			                text: titulo,
			                color : ['rgba(50, 50, 50, 1)'],
			                font : {
			                	size: 15,
			                	weight: 'normal'
			                }
			            };

			            var color;

			            Object.entries(response).forEach(([key, value]) => {
			            	if (myChartB.data.datasets.length <= colores.length){
			            		color = colores[myChartB.data.datasets.length];
			            	} else{
			            		color = colores[myChartB.data.datasets.length - (colores.length * parseInt((myChartB.data.datasets.length/colores.length), 10))];
			            	}

						    myChartB.data.datasets.push({
					            label: key,
					            data: value,
					            backgroundColor: [color]
					        },);
						});
	                    myChartB.update();
		            }
		        });
			} else{
				var repGenA = "repGenA";

				var parametros = {
				    "id" : repGenA
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            dataType: "json",
		            success:  function (response) {
		            	var i = 0;
		            	var aI;
		            	var aF;
		            	var color;

			            Object.entries(response).forEach(([key, value]) => {
			            	if (myChartB.data.datasets.length <= colores.length){
			            		color = colores[myChartB.data.datasets.length];
			            	} else{
			            		color = colores[myChartB.data.datasets.length - (colores.length * parseInt((myChartB.data.datasets.length/colores.length), 10))];
			            	}

			            	if (i == 0){
			            		aI = key;
			            	    i = i + 1;
			            	}
			            	aF = key;

						    myChartB.data.datasets.push({
					            label: key,
					            data: value,
					            backgroundColor: [color]
					        },);
						});

						myChartB.options.plugins.title = {
			                display: true,
			                text: 'Estadísticas de Exportación de Aguacate de Jalisco de ' + aI + ' a ' + aF + '.',
			                color : ['rgba(50, 50, 50, 1)'],
			                font : {
			                	size: 15,
			                	weight: 'normal'
			                }
			            };
	                    myChartB.update();
		            }
		        });
			}
		}

		function actualizarMK(){
			myChartMK.data.datasets.pop();
			var mes = document.getElementById("mesK").value;
			var repMesK = "repMesK";

			if (mes == ""){
				mes = new Date();
				mes = mes.getFullYear() + "-" + (mes.getMonth() + 1);
			}

			var parametros = {
			    "id" : repMesK, 
			    "fecha" : mes
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            dataType: "json",
	            success:  function (response) {
	            	var año = mes.substring(0, 4);
	            	var aux = mes.substring(5, 7);
	            	var total = 0;
	            	var paises = [];
	            	var valores = [];

	            	Object.entries(response).forEach(([key, value]) => {
		            	total = total + value;
		            	paises.push(key);
		            	valores.push(value);
		            });

		            var titulo = meses[parseInt(aux,10) - 1].substring(0, 1).toUpperCase() + meses[parseInt(aux,10) - 1].substring(1, 12) + ' del año ' + año + '.';

	            	myChartMK.options.plugins.title = {
		                display: true,
		                text: titulo,
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 24
		                }
		            };

		            myChartMK.options.plugins.subtitle = {
		                display: true,
		                text: 'Exportación de Aguacate de Jalisco del mes de ' + meses[parseInt(aux,10) - 1] + ' del año ' + año + '. En este mes se exportaron en total '+ millares(total) +' kg de aguacate.',
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 15,
		                	weight: 'normal'
		                }
		            };

		            myChartMK.data.labels = paises;
		            
				    myChartMK.data.datasets.push({
			            label: "",
			            data: valores,
			            backgroundColor: ['#a6b828']
			        },);
			        myChartMK.update();
	            }
	        });

	        //////////////////////////////////////////// grafica de anillo ////////////////////////////////////////

	        myChartMA.data.datasets.pop();
			var repMesA = "repMesK";

			var parametros = {
			    "id" : repMesA, 
			    "fecha" : mes
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            dataType: "json",
	            success:  function (response) {
	            	var añoA = mes.substring(0, 4);
	            	var auxa = mes.substring(5, 7);
	            	var totalA = 0;
	            	var paisesA = [];
	            	var valoresA = [];
	            	var masN = ""; 
	            	var masC = 0;
	            	var menosN = "";
	            	var menosC = 0;
	            	var i = 0;

	            	Object.entries(response).forEach(([key, value]) => {
	            		if (i == 0){
	            			masN = key;
	            			masC = value;
	            			i = 1;
	            		}
	            		menosN = key;
	            	    menosC = value;
		            	totalA = totalA + value;
		            	paisesA.push(key);
		            	valoresA.push(value);
		            });

		            var titulo = "Kilogramos exportados en " + meses[parseInt(auxa,10) - 1] + ' del año ' + añoA + '.';

	            	myChartMA.options.plugins.title = {
		                display: true,
		                text: titulo,
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 24
		                }
		            };

		            myChartMA.options.plugins.subtitle = {
		                display: true,
		                text: 'Total de kg exportados: ' + millares(totalA) + '. Mayor total: ' + masN + ' con ' + millares(masC) + ' kg. Menor total: ' + menosN + ' con ' + millares(menosC) + ' kg.',
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 15,
		                	weight: 'normal'
		                }
		            };

		            myChartMA.data.labels = paisesA;
		            
				    myChartMA.data.datasets.push({
			            label: "",
			            data: valoresA,
			            backgroundColor: [
					        'RGBA(166, 184, 40, 1)', 
					        'RGBA(115, 180, 0, 1)', 
					        'RGBA(28, 72, 45, 1)', 
					        'RGBA(10, 103, 91, 1)', 
					        'RGBA(2, 109, 125, 1)', 
					        'rgba(0, 146, 215, 1)', 
					        'rgba(64, 72, 205, 1)', 
					        'rgba(27, 53, 88, 1)', 
					        'rgba(186, 35, 0, 1)', 
					        'rgba(248, 89, 31, 1)', 
					        'rgba(255, 153, 0, 1)', 
					        'rgba(242, 213, 0, 1)']
			        },);
			        myChartMA.update();
	            }
	        });

	        //////////////////////////////////////////////////// embarques ////////////////////////////////////////////////

	        myChartME.data.datasets.pop();
			var repMesE = "repMesE";

			var parametros = {
			    "id" : repMesE, 
			    "fecha" : mes
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            dataType: "json",
	            success:  function (response) {
	            	var añoE = mes.substring(0, 4);
	            	var auxE = mes.substring(5, 7);
	            	var totalE = 0;
	            	var paisesE = [];
	            	var valoresE = [];
	            	var masNE = "";
	            	var masCE = 0;
	            	var menosNE = "";
	            	var menosCE = 0;
	            	var iE = 0;

	            	Object.entries(response).forEach(([key, value]) => {
	            		if (iE == 0){
	            			masNE = key;
	            			masCE = value;
	            			iE = 1;
	            		}
	            		menosNE = key;
	            	    menosCE = value;
		            	totalE = totalE + parseInt(value);
		            	paisesE.push(key);
		            	valoresE.push(value);
		            });

		            paisesE = paisesE.reverse();
		            valoresE = valoresE.reverse();

		            var titulo = meses[parseInt(auxE,10) - 1].substring(0, 1).toUpperCase() + meses[parseInt(auxE,10) - 1].substring(1, 12) + ' del año ' + añoE + '.';

	            	myChartME.options.plugins.title = {
		                display: true,
		                text: titulo,
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 24
		                }
		            };

		            myChartME.options.plugins.subtitle = {
		                display: true,
		                text: 'Total de embarques exportados: ' + millares(totalE) + '. Mayor total: ' + masNE + ' con ' + millares(masCE) + ' embarques. Menor total: ' + menosNE + ' con ' + millares(menosCE) + ' embarques.',
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 15,
		                	weight: 'normal'
		                }
		            };

		            myChartME.data.labels = paisesE;
		            
				    myChartME.data.datasets.push({
			            label: "",
			            data: valoresE,
			            backgroundColor: ['#116f39']
			        },);
			        myChartME.update();
	            }
	        });
		}
		
	    window.onclick = graficas;
		
		function graficas() {
			///////////////////////////// gráficas históricas ///////////////////////////////

		    var ncanva = document.getElementById("chartL");
            var img = ncanva.toDataURL("image/png");
            document.getElementById("grafL1").value = img;

            ncanva = document.getElementById("chartB");
            img = ncanva.toDataURL("image/png");
            document.getElementById("grafL2").value = img;

            ///////////////////////////// gráficas mensuales ///////////////////////////////
            
            ncanva = document.getElementById("chartMK");
		    img = ncanva.toDataURL("image/png");
		    document.getElementById("grafK1").value = img;

			ncanva = document.getElementById("chartMA");
		    img = ncanva.toDataURL("image/png");
		    document.getElementById("grafK2").value = img;

			ncanva = document.getElementById("chartME");
		    img = ncanva.toDataURL("image/png");
		    document.getElementById("grafK3").value = img;

		    ////////////////////////// gráficas´por empaque ///////////////////////////////
		    
		    ncanva = document.getElementById("chartMEB");
		    img = ncanva.toDataURL("image/png");
		    document.getElementById("grafME1").value = img;
		    
		    ncanva = document.getElementById("chartMEA");
		    img = ncanva.toDataURL("image/png");
		    document.getElementById("grafME2").value = img;

		    /////////////////////////// gráficas por temporada //////////////////////////

		    ncanva = document.getElementById("chartTB1");
		    img = ncanva.toDataURL("image/png");
		    document.getElementById("grafT1").value = img;

		    ncanva = document.getElementById("chartTB2");
		    img = ncanva.toDataURL("image/png");
		    document.getElementById("grafT2").value = img;

		    ncanva = document.getElementById("chartTB3");
		    img = ncanva.toDataURL("image/png");
		    document.getElementById("grafT3").value = img;

		    ncanva = document.getElementById("chartTL");
		    img = ncanva.toDataURL("image/png");
		    document.getElementById("grafT4").value = img;

		    // ncanva = document.getElementById("chartTM");
		    // img = ncanva.toDataURL("image/png");
		    // document.getElementById("grafT5").value = img;
		}
		
		function actualizarME(){
			myChartMEB.data.datasets.pop();
			myChartMEA.data.datasets.pop();
			if ($("#empacadoraME").val() != ""){
				var mes = document.getElementById("mesME").value;
				var repMesMEB = "repMesMEB";
				var idEmp = document.getElementById("empacadoraME").value;
				var nomEmp = document.getElementById("empacadoraME").options[document.getElementById("empacadoraME").selectedIndex].text;

				if (mes == ""){
					mes = new Date();
					mes = mes.getFullYear() + "-" + (mes.getMonth() + 1);
				}

				var parametros = {
				    "id" : repMesMEB, 
				    "fecha" : mes,
				    "empacadora" : idEmp
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            dataType: "json",
		            success:  function (response) {
		            	var año = mes.substring(0, 4);
		            	var aux = mes.substring(5, 7);
		            	var total = 0;
		            	var paises = [];
		            	var valores = [];

		            	Object.entries(response).forEach(([key, value]) => {
			            	total = total + value;
			            	paises.push(key);
			            	valores.push(value);
			            });

			            var titulo = meses[parseInt(aux,10) - 1].substring(0, 1).toUpperCase() + meses[parseInt(aux,10) - 1].substring(1, 12) + ' del año ' + año + '.';

		            	myChartMEB.options.plugins.title = {
			                display: true,
			                text: titulo,
			                color : ['rgba(50, 50, 50, 1)'],
			                font : {
			                	size: 24
			                }
			            };

			            myChartMEB.options.plugins.subtitle = {
			                display: true,
			                text: 'El empaque ' + nomEmp + ' exportó un total de '+ millares(total) +' kg de aguacate en el mes de ' + meses[parseInt(aux,10) - 1] + ' del año ' + año + '.',
			                color : ['rgba(50, 50, 50, 1)'],
			                font : {
			                	size: 15,
			                	weight: 'normal'
			                }
			            };

			            myChartMEB.data.labels = paises;
			            
					    myChartMEB.data.datasets.push({
				            label: "",
				            data: valores,
				            backgroundColor: ['#a6b828']
				        },);
				        myChartMEB.update();
		            }
		        });

		        ////////////////////////////////////////// grafica de anillo ////////////////////////////////////////

				var repMesEA = "repMesEA";

				var parametros = {
				    "id" : repMesEA, 
				    "fecha" : mes,
				    "empacadora" : idEmp
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            dataType: "json",
		            success:  function (response) {
		            	var añoE = mes.substring(0, 4);
		            	var auxE = mes.substring(5, 7);
		            	var totalE = 0;
		            	var paisesE = [];
		            	var valoresE = [];
		            	var masNE = "";
		            	var masCE = 0;
		            	var menosNE = "";
		            	var menosCE = 0;
		            	var iE = 0;

		            	Object.entries(response).forEach(([key, value]) => {
		            		if (iE == 0){
		            			masNE = key;
		            			masCE = value;
		            			iE = 1;
		            		}
		            		menosNE = key;
		            	    menosCE = value;
			            	totalE = totalE + parseInt(value);
			            	paisesE.push(key);
			            	valoresE.push(value);
			            });

			            paisesE = paisesE.reverse();
			            valoresE = valoresE.reverse();

			            var titulo = "Embarques exportados en " + meses[parseInt(auxE,10) - 1] + ' del año ' + añoE + '.';

		            	myChartMEA.options.plugins.title = {
			                display: true,
			                text: titulo,
			                color : ['rgba(50, 50, 50, 1)'],
			                font : {
			                	size: 24
			                }
			            };

			            myChartMEA.options.plugins.subtitle = {
			                display: true,
			                text: 'Total de embarques exportados: ' + millares(totalE) + '. Mayor total: ' + masNE + ' con ' + millares(masCE) + ' embarques. Menor total: ' + menosNE + ' con ' + millares(menosCE) + ' embarques.',
			                color : ['rgba(50, 50, 50, 1)'],
			                font : {
			                	size: 15,
			                	weight: 'normal'
			                }
			            };

			            myChartMEA.data.labels = paisesE;
			            
					    myChartMEA.data.datasets.push({
				            label: "",
				            data: valoresE,
				            backgroundColor: [
					            'RGBA(166, 184, 40, 1)', 
					            'RGBA(115, 180, 0, 1)', 
					            'RGBA(28, 72, 45, 1)', 
					            'RGBA(10, 103, 91, 1)', 
					            'RGBA(2, 109, 125, 1)', 
					            'rgba(0, 146, 215, 1)', 
					            'rgba(64, 72, 205, 1)', 
					            'rgba(27, 53, 88, 1)', 
					            'rgba(186, 35, 0, 1)', 
					            'rgba(248, 89, 31, 1)', 
					            'rgba(255, 153, 0, 1)', 
					            'rgba(242, 213, 0, 1)']
				        },);
				        myChartMEA.update();
		            }
		        });
			} else{
			    /////////////////////////////////// barras ////////////////////////////////////
			    myChartMEB.options.plugins.title = {
	                display: true,
	                text: ""
	            };

	            myChartMEB.options.plugins.subtitle = {
	                display: true,
	                text: ''
	            };

	            myChartMEB.data.labels = "";
	            
			    myChartMEB.data.datasets.push({
		            label: "",
		            data: ""
		        },);
		        myChartMEB.update();
		        
		        /////////////////////////////////// anillo ////////////////////////////////////
			    myChartMEA.options.plugins.title = {
	                display: true,
	                text: ""
	            };

	            myChartMEA.options.plugins.subtitle = {
	                display: true,
	                text: ''
	            };

	            myChartMEA.data.labels = "";
	            
			    myChartMEA.data.datasets.push({
		            label: "",
		            data: ""
		        },);
		        myChartMEA.update();
			}
		}

		function impTemporadas(){
			var impTemporadas = "impTemporadas";

			var parametros = {
			    "id" : impTemporadas
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (response) {
	            	if($("#tempI").val() == ""){
	            	    $("#tempI").html(response);
		            }
		            if($("#tempF").val() == ""){
	            	    $("#tempF").html(response);
	            	}
	            }
	        });
		}
		
		function actualizarT(){
			var temI, temF, long;
			myChartTB1.data.datasets.pop();
			myChartTB2.data.datasets.pop();
			var chartLength = myChartTB3.data.datasets.length;
		    for (var i = 0; i<chartLength; i++){
		    	myChartTB3.data.datasets.pop();
		    }
		    chartLength = myChartTL.data.datasets.length;
		    for (var i = 0; i<chartLength; i++){
		    	myChartTL.data.datasets.pop();
		    }
		    
		    temI = document.getElementById("tempI").value;
			temF = document.getElementById("tempF").value;

			if ((temI != "" && temF == "") || (temI == "" && temF != "") || (temI == "" && temF == "")){
                long = $("#tempI").text();
                long = long.length;
                long = (long - 3) / 11;
				temI = $("#tempI option:eq("+ (long - 1) +")").text();
				temF = $("#tempI option:eq("+ long +")").text();
			}

			///////////////////////////////// temporada 1 //////////////////////////////////////

			var repTemp = "repTemp";

			var parametros = {
			    "id" : repTemp, 
			    "anioI" : temI.substring(0, 4),
			    "anioF" : temI.substring(7, 11)
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            dataType: "json",
	            success:  function (response) {
	            	var añoI = temI.substring(0, 4);
	            	var añoF = temI.substring(7, 11);
	            	var total = 0;
	            	var etiquetas = [];
	            	var valores = [];
	            	var titulo = 'Datos Estadísticos de Exportación de Aguacate de Jalisco (01 Junio ' + añoI + ' - 31 Mayo ' + añoF + ')';

	            	Object.entries(response).forEach(([key, value]) => {
		            	total = total + value;
		            	etiquetas.push(key);
		            	valores.push(value);
		            });

		            totalT1 = total;

		            myChartTB1.options.plugins.title = {
		                display: true,
		                text: "Temporada " + temI + ".",
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 24
		                }
		            };

		            myChartTB1.options.plugins.subtitle = {
		                display: true,
		                text: titulo,
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 15,
		                	weight: 'normal'
		                }
		            };

		            myChartTB1.data.labels = etiquetas;
		            
				    myChartTB1.data.datasets.push({
			            label: "",
			            data: valores,
			            backgroundColor: ['#a6b828']
			        },);
			        myChartTB1.update();

			        //////////// graf B ///////////

			        myChartTB3.data.datasets.push({
			        	label: temI,
			            data: valores,
			            backgroundColor: [
			                'rgba(166, 184, 40, 1)'
			            ]
			        });

			        //////////// graf L ///////////

			        myChartTL.data.datasets.push({
			        	label: temI,
			            data: valores,
			            backgroundColor: [
			                'rgba(166, 184, 40, 0.5)'
			            ],
			            borderColor: [
			                'rgba(166, 184, 40, 1)'
			            ]
			        });
	            }
	        });

	        //////////////////////////////////// temporada 2 ///////////////////////////////////

			var parametros = {
			    "id" : repTemp, 
			    "anioI" : temF.substring(0, 4),
			    "anioF" : temF.substring(7, 11)
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            dataType: "json",
	            success:  function (response) {
	            	var añoI = temF.substring(0, 4);
	            	var añoF = temF.substring(7, 11);
	            	var total = 0;
	            	var etiquetas = [];
	            	var valores = [];
	            	var titulo = 'Datos Estadísticos de Exportación de Aguacate de Jalisco (01 Junio ' + añoI + ' - 31 Mayo ' + añoF + ')';

	            	Object.entries(response).forEach(([key, value]) => {
		            	total = total + value;
		            	etiquetas.push(key);
		            	valores.push(value);
		            });

	            	myChartTB2.options.plugins.title = {
		                display: true,
		                text: "Temporada " + temF + ".",
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 24
		                }
		            };

		            myChartTB2.options.plugins.subtitle = {
		                display: true,
		                text: titulo,
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 15,
		                	weight: 'normal'
		                }
		            };

		            myChartTB2.data.labels = etiquetas;
		            
				    myChartTB2.data.datasets.push({
			            label: "",
			            data: valores,
			            backgroundColor: ['#fc9911']
			        },);
			        myChartTB2.update();

			        /////////////////// graf B /////////////////

			        myChartTB3.options.plugins.title = {
		                display: true,
		                text: "Comparativo temporada " + temI + " vs " + temF + ".",
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 24
		                }
		            };

			        myChartTB3.data.datasets.push({
			        	label: temF,
			            data: valores,
			            backgroundColor: [
			                'rgba(252, 153, 17, 1)'
			            ]
			        });
			        myChartTB3.update();

			        /////////////////// graf L /////////////////

		            myChartTL.options.plugins.title = {
		                display: true,
		                text: "Comparativo temporadas " + temI + " y " + temF + ".",
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 24
		                }
		            };

		            myChartTL.options.plugins.subtitle = {
		                display: true,
		                text: "Comparativo temporadas " + temI + " con " + millares(totalT1) + " Kg exportados y " + temF + " con " + millares(total) + " kg exportados.",
		                color : ['rgba(50, 50, 50, 1)'],
		                font : {
		                	size: 15,
		                	weight: 'normal'
		                }
		            };

			        myChartTL.data.datasets.push({
			        	label: temF,
			            data: valores,
			            backgroundColor: [
			                'rgba(252, 153, 17, 0.5)',
			            ],
			            borderColor: [
			                'rgba(252, 153, 17, 1)'
			            ]
			        });
			        myChartTL.update();
	            }
	        });
		}

		function exportarHist(){
			var date = Date.now();
            var hoy = new Date(date);
            hoy = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear() + " " + hoy.getHours() + '.' + hoy.getMinutes() + '.' + hoy.getSeconds();

			var parametros = {
			    "id" : "exportarHist",
			    "anioI" : $("#añoIL").val(),
			    "anioF" : $("#añoFL").val()
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (data) {
		            var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
	            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "Estadísticas anuales '+ hoy +'.csv" target="_blank">descargar</a>');
	            	$('#divDes a')[0].click();
	            }
	        });
		}

		function exportarEstMen(){
			var date = Date.now();
            var hoy = new Date(date);
            hoy = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear() + " " + hoy.getHours() + '.' + hoy.getMinutes() + '.' + hoy.getSeconds();
            var fecha = $("#mesK").val();

			if ($("#mesK").val() == ""){
				fecha = new Date();
				fecha = fecha.getFullYear() + "-" + (fecha.getMonth() + 1);
			}

			var parametros = {
			    "id" : "exportarEstMen",
			    "fecha" : fecha
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (data) {
		            var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
	            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "Estadísticas mensuales '+ hoy +'.csv" target="_blank">descargar</a>');
	            	$('#divDes a')[0].click();
	            }
	        });
		}

		function exportarEstMenEmp(){
			if ($("#empacadoraME").val() != ""){
				var date = Date.now();
	            var hoy = new Date(date);
	            hoy = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear() + " " + hoy.getHours() + '.' + hoy.getMinutes() + '.' + hoy.getSeconds();
	            var fecha = $("#mesME").val();
	            var nombre = document.getElementById("empacadoraME").options[document.getElementById("empacadoraME").selectedIndex].text;

				if ($("#mesME").val() == ""){
					fecha = new Date();
					fecha = fecha.getFullYear() + "-" + (fecha.getMonth() + 1);
				}

				var parametros = {
				    "id" : "exportarEstMenEmp",
				    "fecha" : fecha,
				    "empacadora" : $("#empacadoraME").val()
			    }

				$.ajax({
					data: parametros,
		            url: dirScriptsPhp + 'consultar.php',
		            type: 'post',
		            success:  function (data) {
			            var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
		            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "'+ nombre + " " + hoy +'.csv" target="_blank">descargar</a>');
		            	$('#divDes a')[0].click();
		            }
		        });
			} else{
			    $('#empacadoraME').focus();	
			}
		}

		function exportarEstTemp(){
			var date = Date.now();
            var hoy = new Date(date);
            hoy = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear() + " " + hoy.getHours() + '.' + hoy.getMinutes() + '.' + hoy.getSeconds();
            var temI, temF, long;

            temI = document.getElementById("tempI").value;
			temF = document.getElementById("tempF").value;

			if ((temI != "" && temF == "") || (temI == "" && temF != "") || (temI == "" && temF == "")){
                long = $("#tempI").text();
                long = long.length;
                long = (long - 3) / 11;
				temI = $("#tempI option:eq("+ (long - 1) +")").text();
				temF = $("#tempI option:eq("+ long +")").text();
			}

			var parametros = {
			    "id" : "exportarEstTemp",
			    "temI" : temI,
			    "temF" : temF
		    }

			$.ajax({
				data: parametros,
	            url: dirScriptsPhp + 'consultar.php',
	            type: 'post',
	            success:  function (data) {
		            var uri = 'data: text/csv; charset = UTF-8,' + encodeURIComponent("\uFEFF"+data);
	            	$("#divDes").html('<a id = "enlaceDes" href = "'+uri+'" download = "'+ temI + " vs " + temF + " " + hoy +'.csv" target="_blank">descargar</a>');
	            	$('#divDes a')[0].click();
	            }
	        });
		}

		function millares(num){
            var exp = /(\d)(?=(\d{3})+(?!\d))/g;
            return num.toString().replace(exp, '$1,');
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
	                            <?php echo impMenu($_SESSION['descripcion'], 'RepCertificados', 'certificados');?>
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
	                <ul class="nav nav-tabs cambioColor rounded-top" style="background-color: #19221f;"> <!-- header -->
	                	<li class="nav-item active rounded-top" style="background-color: #19221f;">
	                        <a href="#lineas" class="nav-link active" role="tab" data-toggle="tab" onClick="actualizarL();"><strong>Estadísticas anuales</strong></a>
	                    </li>

	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#mensualKg" class="nav-link" role="tab" data-toggle="tab" onClick = "actualizarMK();"><strong>Estadísticas mensuales</strong></a>
	                    </li>
	                    
	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#mensualEmp" class="nav-link" role="tab" data-toggle="tab" onClick = "<?php  impEmp(); ?> actualizarME();"><strong>Estadísticas mensuales por empacadora</strong></a>
	                    </li>

	                    <li class="nav-item rounded-top" style="background-color: #19221f;">
	                        <a href="#temporada" class="nav-link" role="tab" data-toggle="tab" onClick = "actualizarT(); impTemporadas();"><strong>Comparativos por temporada</strong></a>
	                    </li>
	                </ul>

	                <div class="tab-content bg-white border border-top-0 rounded-3 text-justify" style="box-shadow: 0px 2px 12px rgba(0,0,10,.175);">
                        <!-- ------------------------------------------- Lineas ------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane in active" id="lineas">
	                        <div class="px-2 px-sm-4 px-md-5">
	                        	<!---------------------------------- formulario ---------------------------------->
	                        	<FORM id = "formularioL" NAME="formularioL" method = 'POST' action = 'RepHistoricoG.php' target="_blank">
									<div class="card border-0">
										<div class="text-center col-md-9 col-12 mt-5 align-self-center">
										    <div class="text-center">
					                            <h2><strong>Datos estadísticos históricos de exportación de aguacate</strong></h2>
					                        </div>
				                        </div>
									    <!---------------------------------------- periodo -------------------------------------------->
				                        <div class="row m-0 p-0 gy-1 mt-4 mb-0">
				                        	<div class="row col-12 m-0 p-0 gy-1 mb-2">
				                        		<div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label">Año inicial</label>
										        	<Select id = "añoIL" class = "form-select form-select-sm col-12" name='añoIL' onChange = "actualizarL();"></Select>
										        </div>
										        <div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label">Año final</label>
										        	<Select id = "añoFL" class = "form-select form-select-sm col-12" name='añoFL' onChange = "actualizarL();"></Select>
										        </div>
										        <div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label"></label>
										        	<INPUT id = "repBBG" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Generar reporte" TYPE="submit" name = "repBBG" onClick="exportarGL();" style = "background-color: #000000;"></INPUT>
										        </div>
										        <div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label"></label>
										        	<INPUT id = "expHistB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar a Excel" TYPE="button" name = "expHistB" onClick="exportarHist();" style = "background-color: #14541b;"></INPUT>
										        	<div id="divDes" style="display: none;"></div>	
										        </div>
										        <div>
										        	<INPUT id = "grafL1" TYPE="hidden" value = "" name = "grafL1"></INPUT>
										        	<INPUT id = "grafL2" TYPE="hidden" value = "" name = "grafL2"></INPUT>
										        </div>
											</div>

										    <div class="row col-12 m-0 p-0 gy-1 mt-4 px-2">
										        <hr/>
								            </div>
				                        </div>
									    <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3 mb-4">
									        <div class="card border-0 mb-2">
									        	<div class="row justify-content-center">
									        		<img src = "..\Imagenes\fondoGraficas.png" class = "img-fluid">
									        	</div>
												<div class="card-img-overlay m-0 p-0">
											        <canvas id="chartL" name="chartL" width="400" height="250"></canvas>
						                        </div>
					                        </div>
									        <iframe name ="request" style="display: none;"></iframe>
									    </div>
									    <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3 mb-4 mt-5">
									        <div class="card border-0 mb-2">
									        	<div class="row justify-content-center">
									        		<img src = "..\Imagenes\fondoGraficas.png" class = "img-fluid">
									        	</div>
												<div class="card-img-overlay m-0 p-0">
											        <canvas id="chartB" name="chartB" width="400" height="250"></canvas>
						                        </div>
					                        </div>
									    </div>
									</div>
								</FORM>
	                        </div>
	                    </div>

	                    <!------------------------------------------ Elementos ocultos -------------------------------------->
	                    <div class="container">
	                    	<div id="divEnlace" style="display: none;"></div>	

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
						</div>

	                    <!-- ---------------------------------------- Exportaciones mensuales ----------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="mensualKg">
	                        <div class="px-2 px-sm-4 px-md-5">
	                        	<FORM id = "formularioMK" NAME="formularioMK" method = 'POST' action = 'RepHistoricoGM.php' target="_blank">
									<div class="card border-0">
				                        <div class="text-center col-md-9 col-lg-8 col-12 mt-5 align-self-center">
										    <div class="text-center">
					                            <h2><strong>Estadísticas mensuales de exportación de aguacate</strong></h2>
					                        </div>
				                        </div>
									    <!---------------------------------------- periodo -------------------------------------------->
				                        <div class="row m-0 p-0 gy-1 mt-4 mb-0">
				                        	<div class="row col-12 m-0 p-0 gy-1 mb-2">
				                        		<div class="col-6 col-md-4 col-lg-3">
										        	<label class=" form-label">Mes</label>
										        	<input id = "mesK" class = "form-select form-select-sm col-12" name='mesK' onChange = "actualizarMK();" type = 'month'></input>
										        </div>
										        <div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label"></label>
										        	<INPUT id = "repMKB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Generar reporte" TYPE="submit" name = "repMKB" onClick="exportarMK();" style = "background-color: #000000;"></INPUT>
										        </div>
										        <div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label"></label>
										        	<INPUT id = "expMenB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar a Excel" TYPE="button" name = "expMenB" onClick="exportarEstMen();" style = "background-color: #14541b;"></INPUT>
										        </div>
										        <div>
										        	<INPUT id = "grafK1" TYPE="hidden" value = "" name = "grafK1"></INPUT>
										        	<INPUT id = "grafK2" TYPE="hidden" value = "" name = "grafK2"></INPUT>
										        	<INPUT id = "grafK3" TYPE="hidden" value = "" name = "grafK3"></INPUT>
										        </div>
											</div>

										    <div class="row col-12 m-0 p-0 gy-1 mt-4 px-2">
										        <hr/>
								            </div>
				                        </div>
									    <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3 mb-4">
									        <div class="card border-0 mb-2">
									        	<div class="row justify-content-center">
									        		<img src = "..\Imagenes\fondoGraficas2.png" class = "img-fluid">
									        	</div>
												<div class="card-img-overlay m-0 p-0">
											        <canvas id="chartMK" name="chartMK" width="400" height="270"></canvas>
						                        </div>
					                        </div>
									    </div>
									    <div class="row justify-content-center mt-3 px-2">
									        <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3 mb-4 col-12 col-md-10 col-lg-9">
											    <div class="card border-0 mb-3 bg-success">
										        	<div class="row">
										        		<img src = "..\Imagenes\fondoGraficas3.png" class="img-fluid p-0 m-0">
										        	</div>
													<div class="card-img-overlay m-0 p-0">
													    <canvas id="chartMA" name="chartMA" width="150" height="150"></canvas>
							                        </div>
						                        </div>
					                        </div>
										</div>

										<div class="text-center col-md-9 col-lg-8 col-12 mt-4 align-self-center">
										    <div class="text-center">
					                            <h2><strong>Estadísticas mensuales de embarques de aguacate</strong></h2>
					                        </div>
				                        </div>

				                        <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3 mb-3 mt-2">
									        <div class="card border-0 mb-4">
									        	<div class="row justify-content-center">
									        		<img src = "..\Imagenes\fondoGraficas2.png" class="img-fluid">
									        	</div>
												<div class="card-img-overlay m-0 p-0">
											        <canvas id="chartME" name="chartME" width="400" height="270"></canvas>
						                        </div>
					                        </div>
									    </div>
									</div>
								</FORM>
	                        </div>
	                    </div>
	                    
	                    <!-- -------------------------------- Exportaciones mensuales por empaque ------------------------------ -->
	                    <div role="tabpanel" class="tab-pane fade" id="mensualEmp">
	                        <div class="px-2 px-sm-4 px-md-5">
	                        	<FORM id = "formularioME" NAME="formularioME" method = 'POST' action = 'RepMensualEmp.php' target="_blank">
									<div class="card border-0">
				                        <div class="text-center col-md-9 col-lg-8 col-12 mt-5 align-self-center">
										    <div class="text-center">
					                            <h2><strong>Estadísticas mensuales de exportación de aguacate por empacadora</strong></h2>
					                        </div>
				                        </div>
									    <!---------------------------------------- periodo -------------------------------------------->
				                        <div class="row m-0 p-0 gy-1 mt-4 mb-0 justify-content-center">
				                        	<div class="row col-12 col-md-12 col-lg-11 m-0 p-0 gy-1 mb-2">
				                        		<?php impComboEmp(); ?>
				                        		<div class="col-6 col-md-4 col-lg-4">
										        	<label class=" form-label">Mes</label>
										        	<input id = "mesME" class = "form-select form-select-sm col-12" name='mesME' onChange = "actualizarME();" type = 'month'></input>
										        </div>
										        <div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label"></label>
										        	<INPUT id = "repMEB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Generar reporte" TYPE="submit" name = "repMEB" style = "background-color: #000000;"></INPUT>
										        </div>
										        <div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label"></label>
										        	<INPUT id = "expMenEmpB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar a Excel" TYPE="button" name = "expMenEmpB" onClick="exportarEstMenEmp();" style = "background-color: #14541b;"></INPUT>
										        </div>
										        <div>
										        	<INPUT id = "grafME1" TYPE="hidden" value = "" name = "grafME1"></INPUT>
										        	<INPUT id = "grafME2" TYPE="hidden" value = "" name = "grafME2"></INPUT>
										        </div>
											</div>

										    <div class="row col-12 m-0 p-0 gy-1 mt-4 px-2">
										        <hr/>
								            </div>
				                        </div>
									    <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3 mb-4">
									        <div class="card border-0 mb-2">
									        	<div class="row justify-content-center">
									        		<img src = "..\Imagenes\fondoGraficas2.png" class="img-fluid">
									        	</div>
												<div class="card-img-overlay m-0 p-0">
											        <canvas id="chartMEB" name="chartMEB" width="400" height="270"></canvas>
						                        </div>
					                        </div>
									    </div>

									    <div class="text-center col-md-9 col-lg-8 col-12 mt-5 align-self-center">
										    <div class="text-center">
					                            <h2><strong>Estadísticas mensuales de embarques de aguacate</strong></h2>
					                        </div>
				                        </div>
									    <div class="row justify-content-center mt-3 px-2">
										    <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3 mb-4 col-12 col-md-10 col-lg-9">
											    <div class="card border-0 mb-1">
										        	<div class="row">
										        		<img src = "..\Imagenes\fondoGraficas3.png" class="img-fluid p-0 m-0">
										        	</div>
													<div class="card-img-overlay m-0 p-0">
													    <canvas id="chartMEA" name="chartMEA" width="150" height="150"></canvas>
							                        </div>
						                        </div>
					                        </div>
										</div>
									</div>
								</FORM>
	                        </div>
	                    </div> 

	                    <!-- ------------------------------------------- temporadas ------------------------------------- -->
	                    <div role="tabpanel" class="tab-pane fade" id="temporada">
	                        <div class="px-2 px-sm-4 px-md-5">
	                        	<!---------------------------------- formulario ---------------------------------->
	                        	<FORM id = "formularioT" NAME="formularioT" method = 'POST' action = 'RepTemporada.php' target="_blank">
									<div class="card border-0">
										<div class="text-center col-md-9 col-12 mt-5 align-self-center">
										    <div class="text-center">
					                            <h2><strong>Estadísticas comparartivas por temporadas</strong></h2>
					                        </div>
				                        </div>
									    <!---------------------------------------- periodo -------------------------------------------->
				                        <div class="row m-0 p-0 gy-1 mt-4 mb-0">
				                        	<div class="row col-12 m-0 p-0 gy-1 mb-2">
				                        		<div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label">Temporada inicial</label>
										        	<Select id = "tempI" class = "form-select form-select-sm col-12" name='tempI' onChange = "actualizarT();">
										        	    <option value="" selected>...</option>
										        	</Select>
										        </div>
										        <div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label">Temporada final</label>
										        	<Select id = "tempF" class = "form-select form-select-sm col-12" name='tempF' onChange = "actualizarT();">
										        	    <option value="" selected>...</option>
										        	</Select>
										        </div>
										        <div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label"></label>
										        	<INPUT id = "repTB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Generar reporte" TYPE="submit" name = "repTB" onClick="exportarGT();" style = "background-color: #000000;"></INPUT>
										        </div>
										        <div class="col-6 col-md-3 col-lg-3">
										        	<label class=" form-label"></label>
										        	<INPUT id = "expTempB" class = "form-control-lg btn col-12 rounded-1 text-white" VALUE="Exportar a Excel" TYPE="button" name = "expTempB" onClick="exportarEstTemp();" style = "background-color: #14541b;"></INPUT>
										        </div>
										        <div>
										        	<INPUT id = "grafT1" TYPE="hidden" value = "" name = "grafT1"></INPUT>
										        	<INPUT id = "grafT2" TYPE="hidden" value = "" name = "grafT2"></INPUT>
										        	<INPUT id = "grafT3" TYPE="hidden" value = "" name = "grafT3"></INPUT>
										        	<INPUT id = "grafT4" TYPE="hidden" value = "" name = "grafT4"></INPUT>
										        	<INPUT id = "grafT5" TYPE="hidden" value = "" name = "grafT5"></INPUT>
										        </div>
											</div>

										    <div class="row col-12 m-0 p-0 gy-1 mt-4 px-2">
										        <hr/>
								            </div>
				                        </div>
									    <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3 mb-4">
									        <div class="card border-0 mb-2">
									        	<div class="row justify-content-center">
									        		<img src = "..\Imagenes\fondoGraficas.png" class="img-fluid">
									        	</div>
												<div class="card-img-overlay m-0 p-0">
											        <canvas id="chartTB1" name="chartTB1" width="400" height="250"></canvas>
						                        </div>
					                        </div>
									        <iframe name ="request" style="display: none;"></iframe>
									    </div>
									    <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3 mb-4 mt-5">
									        <div class="card border-0 mb-2">
									        	<div class="row justify-content-center">
									        		<img src = "..\Imagenes\fondoGraficas.png" class="img-fluid">
									        	</div>
												<div class="card-img-overlay m-0 p-0">
											        <canvas id="chartTB2" name="chartTB2" width="400" height="250"></canvas>
						                        </div>
					                        </div>
									    </div>
									    <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3 mb-4 mt-5">
									        <div class="card border-0 mb-2">
									        	<div class="row justify-content-center">
									        		<img src = "..\Imagenes\fondoGraficas.png" class="img-fluid">
									        	</div>
												<div class="card-img-overlay m-0 p-0">
											        <canvas id="chartTB3" name="chartTB3" width="400" height="250"></canvas>
						                        </div>
					                        </div>
									    </div>
									    <div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3 mb-4 mt-5">
									        <div class="card border-0 mb-2">
									        	<div class="row justify-content-center">
									        		<img src = "..\Imagenes\fondoGraficas.png" class="img-fluid">
									        	</div>
												<div class="card-img-overlay m-0 p-0">
											        <canvas id="chartTL" name="chartTL" width="400" height="250"></canvas>
						                        </div>
					                        </div>
									    </div>
									    <!--<div class="text-muted bg-white gy-2 p-4 px-lg-5 px-2 px-md-3 mb-4 mt-5">-->
									    <!--    <canvas id="chartTM" name="chartTM" width="400" height="250" class="mb-2"></canvas>-->
									    <!--</div>-->
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
    <!-- tabs -->
    <script src = "../../libraries/tabs.bootstrap.js"></script>
    <!-- chartjs -->
    <script src = "../../libraries/chart.min.3.6.0.js"></script>
    <!-- para el menú sticky -->
	<script src = "../app.js"></script>
    <!-- bootstrap -->
    <script src = "../../libraries/bootstrap.min.js"></script>

</body>
</html>