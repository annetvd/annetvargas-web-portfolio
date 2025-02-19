<?php
    session_start();
    require "funciones.php";
    $permisos = [""];
    validarSesion("", $permisos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Awococado</title>
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
	            <div class="navbar navbar-expand-lg navbar-light px-3 bg-light py-0" style="min-height: 75px; font: 100% Arial;">
	                <div class="container-fluid">
	                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="btnNav">
	                        <span class="navbar-toggler-icon"></span>
	                    </button>

	                    <div class="collapse navbar-collapse" id="navbarNav">
	                        <ul class="navbar-nav">
	                            <?php echo impMenu($_SESSION['descripcion'], 'menu', 'public');?>
	                        </ul>
	                    </div>
						<div class="col-lg-3 col-md-4 col-7 px-3 text-end" id="imgLogo">
	                	    <img src = "Imagenes\Logo2.png" class = "img-fluid d-none" alt="" aria-hidden="true" style="max-height: 68px;">
	            		</div>
	                </div>
	            </div>
	        </nav>
	    </div>
    </hearder>

    <main>
		<div class = "container-fluid">
			<div class="row justify-content-center">
				<div class="col-12 col-md-11 col-lg-8" id = "cuerpo">
	                <div class="px-5" style = "height: auto;">
	                   <div class="px-md-5 px-0">
	                       <img src = "Imagenes\logoOficial.png" class="img-fluid px-md-5 px-0">
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