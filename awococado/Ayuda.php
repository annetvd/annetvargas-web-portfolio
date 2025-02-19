<?php
    session_start();
    require "funciones.php";
    $permisos = ["Administrador", "Contabilidad", "Auxiliar", "Empaque", "Estadística"];
    validarSesion($_SESSION["descripcion"], $permisos);
?>
<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
	<title>Ayuda</title>
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
<body class="bg-white h-100">
	<script>
		document.addEventListener("DOMContentLoaded", function () {
        	const accordions = document.querySelectorAll(".accordion-item");

    		accordions.forEach(item => {
     	    	const iframe = item.querySelector("iframe");

	        	if (!iframe) return;

            	const originalSrc = iframe.getAttribute("src");
    	    	iframe.removeAttribute("src");

        		item.addEventListener("shown.bs.collapse", function () {
            		iframe.setAttribute("src", originalSrc);
        		});

        		item.addEventListener("hidden.bs.collapse", function () {
            		iframe.removeAttribute("src");
        		});
    		});
		});
	</script>
	<hearder>
    </hearder>

    <main class="h-100">
		<div class = "row align-items-center m-0 h-100">
			<div class="row py-5 m-0 justify-content-center h-100 mx-0 px-0">
				<div class = "col-12 my-auto py-0 px-0" style="max-width: 1105px;">
					<div class="card border-0 py-4 px-0 px-md-2 px-lg-4">
						<div class="text-center col-12 mt-2 mb-4">
							<div class="text-center col-12">
				                <h2 class="px-3">
									<strong>Ayuda AWOCOCADO</strong>
									<span class="d-inline px-4 py-2 ms-5">
									    <img class="img-fluid position-absolute" src="Imagenes/LogoRI.png" style="height: 80px; top: 12px; transform: translate(-65%, 0px);" alt="" aria-hidden="true"/>
									</span>
								</h2>
				            </div>
							<div class="accordion mt-5 mb-4" id="ayuda">
							    <?php
							    	impAcordeon($_SESSION["descripcion"]);
							    ?>
							</div>
						</div>
					</div>
			    </div>
		    </div>
	    </div>
    </main>

	<footer>
    </footer>

    <!-- jquery -->
    <script src = "../libraries/jquery.min.3.6.0.js"></script>
    <!-- bootstrap -->
    <script src = "../libraries/bootstrap.min.js"></script>

</body>
</html>

<?php
    function impAcordeon($tipoUsuario){

    	switch ($tipoUsuario) {
    		///////////////////////////////////////////// administrador ////////////////////////////////////////////////////
			case "Administrador":
			    echo '<!-------------------------------- descarga -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="descarga">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemDescarga" aria-expanded="false" aria-controls="itemDescarga">
					        Abrir descarga
					        </button>
					    </h2>
					    <div id="itemDescarga" class="accordion-collapse collapse" aria-labelledby="descarga" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Abrir_descarga__SbhIm22OSZ-NjLyElO68KQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

					<!-------------------------------- cuenta -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="cuenta">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCuenta" aria-expanded="false" aria-controls="itemCuenta">
					        Activación y cambio de contraseña
					        </button>
					    </h2>
					    <div id="itemCuenta" class="accordion-collapse collapse" aria-labelledby="cuenta" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Activacion_y_cambio_de_contrasena__cXxkRP5WSFeyk2aVrTjHSw?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

			        <!-------------------------------- tablas -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="tablas">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemTablas" aria-expanded="false" aria-controls="itemTablas">
					        Tablas dinámicas
					        </button>
					    </h2>
					    <div id="itemTablas" class="accordion-collapse collapse" aria-labelledby="tablas" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Tablas_dinamicas__WuwMiHtjS6qrmmy4VM01CQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

					<!-------------------------------- catálogos -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="catalogos">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCatalogos" aria-expanded="false" aria-controls="itemCatalogos">
					        Catálogos
					        </button>
					    </h2>
					    <div id="itemCatalogos" class="accordion-collapse collapse" aria-labelledby="catalogos" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <div class="accordion" id="ayudaCat">
					                <!------------------------------ empacadoras --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="empacadoras">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemEmpacadoras" aria-expanded="false" aria-controls="itemEmpacadoras">
									        Registrar empacadora
									        </button>
									    </h2>
									    <div id="itemEmpacadoras" class="accordion-collapse collapse" aria-labelledby="empacadoras" data-bs-parent="#ayudaCat">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Registrar_empacadora__XMAM2JexTjqvE5llszhUWQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>

									<!------------------------------ usuarios --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="usuarios">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemUsuarios" aria-expanded="false" aria-controls="itemUsuarios">
									        Registrar usuario
									        </button>
									    </h2>
									    <div id="itemUsuarios" class="accordion-collapse collapse" aria-labelledby="usuarios" data-bs-parent="#ayudaCat">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Registrar_usuario__eiEifaXST6KpERcTLfvaBw?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>
								</div>
					        </div>
					    </div>
					</div>

					<!------------------------------------------ movimientos -------------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="movimientos">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemMovimientos" aria-expanded="false" aria-controls="itemMovimientos">
					        Movimientos
					        </button>
					    </h2> 
					    <div id="itemMovimientos" class="accordion-collapse collapse" aria-labelledby="movimientos" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <div class="accordion" id="ayudaMov">
					                <!----------------------------------- certificados ------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="certificados">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCertificados" aria-expanded="false" aria-controls="itemCertificados">
									        Certificados
									        </button>
									    </h2>
									    <div id="itemCertificados" class="accordion-collapse collapse" aria-labelledby="certificados" data-bs-parent="#ayudaMov">
									        <div class="accordion-body">
									            <div class="accordion" id="ayudaCert">
										            <!------------------------------ registrar --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="regCertificados">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemRegCert" aria-expanded="false" aria-controls="itemRegCert">
													        Registrar certificado
													        </button>
													    </h2>
													    <div id="itemRegCert" class="accordion-collapse collapse" aria-labelledby="regCertificados" data-bs-parent="#ayudaCert">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Registrar_certificado__4LBcRrOJSNObC-wHG0wVIw?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>

													<!------------------------------ cancelar --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="canCertificados">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCanCert" aria-expanded="false" aria-controls="itemCanCert">
													        Cancelar certificado
													        </button>
													    </h2>
													    <div id="itemCanCert" class="accordion-collapse collapse" aria-labelledby="canCertificados" data-bs-parent="#ayudaCert">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Cancelar_certificado__Snypj_EXTYCDUfcaXyZhew?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>

													<!------------------------------ reemplazar --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="reeCertificados">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemReeCert" aria-expanded="false" aria-controls="itemReeCert">
													        Reemplazar certificado
													        </button>
													    </h2>
													    <div id="itemReeCert" class="accordion-collapse collapse" aria-labelledby="reeCertificados" data-bs-parent="#ayudaCert">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Reemplazar_certificado__lA1IiSKGTyquQ2wrwNQsJA?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>
												</div>
									        </div>
									    </div>
									</div>

                                    <!----------------------------------- cobros ------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="cobros">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCobros" aria-expanded="false" aria-controls="itemCobros">
									        Cobros
									        </button>
									    </h2>
									    <div id="itemCobros" class="accordion-collapse collapse" aria-labelledby="cobros" data-bs-parent="#ayudaMov">
									        <div class="accordion-body">
									            <div class="accordion" id="ayudaCob">
										            <!------------------------------ registrar --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="regCobros">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemRegCobros" aria-expanded="false" aria-controls="itemRegCobros">
													        Registrar cobro
													        </button>
													    </h2>
													    <div id="itemRegCobros" class="accordion-collapse collapse" aria-labelledby="regCobros" data-bs-parent="#ayudaCob">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Registrar_cobro__FdUai2RgR7WP3vF9Q5O22Q?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>

													<!------------------------------ consultar --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="conCobros">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemConCobros" aria-expanded="false" aria-controls="itemConCobros">
													        Consultar cobros
													        </button>
													    </h2>
													    <div id="itemConCobros" class="accordion-collapse collapse" aria-labelledby="conCobros" data-bs-parent="#ayudaCob">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Consultar_cobro__3F39lDjWR4i3VnTikaL6Xw?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>
												</div>
									        </div>
									    </div>
									</div>

                                    <!----------------------------------- facturas ------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="facturas">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemFacturas" aria-expanded="false" aria-controls="itemFacturas">
									        Facturas de empacadoras
									        </button>
									    </h2>
									    <div id="itemFacturas" class="accordion-collapse collapse" aria-labelledby="facturas" data-bs-parent="#ayudaMov">
									        <div class="accordion-body">
									            <div class="accordion" id="ayudaFac">
									            <!------------------------------ registrar --------------------------------->
												<div class="accordion-item bg-light">
												    <h2 class="accordion-header" id="regFacturas">
												        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemRegFact" aria-expanded="false" aria-controls="itemRegFact">
												        Registrar factura
												        </button>
												    </h2>
												    <div id="itemRegFact" class="accordion-collapse collapse" aria-labelledby="regFacturas" data-bs-parent="#ayudaFac">
												        <div class="accordion-body">
												            <iframe class="iframe" src="https://scribehow.com/embed/Registrar_factura_de_empacadora__-CC7oXJPRh2kLK4FZBkS9w?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
												        </div>
												    </div>
												</div>

												<!------------------------------ consultar --------------------------------->
												<div class="accordion-item bg-light">
												    <h2 class="accordion-header" id="conFacturas">
												        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemConFact" aria-expanded="false" aria-controls="itemConFact">
												        Consultar facturas
												        </button>
												    </h2>
												    <div id="itemConFact" class="accordion-collapse collapse" aria-labelledby="conFacturas" data-bs-parent="#ayudaFac">
												        <div class="accordion-body">
												            <iframe class="iframe" src="https://scribehow.com/embed/Consultar_factura__WWn2QsrJTTG_gTCK3nBlyg?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
												        </div>
												    </div>
												</div>

												<!------------------------------ cancelar --------------------------------->
												<div class="accordion-item bg-light">
												    <h2 class="accordion-header" id="canFacturas">
												        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCanFact" aria-expanded="false" aria-controls="itemCanFact">
												        Cancelar factura
												        </button>
												    </h2>
												    <div id="itemCanFact" class="accordion-collapse collapse" aria-labelledby="canFacturas" data-bs-parent="#ayudaFac">
												        <div class="accordion-body">
												            <iframe class="iframe" src="https://scribehow.com/embed/Cancelar_factura__wzHmiQSqRnOCQm5o_JG7Gg?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
												        </div>
												    </div>
												</div>
									        </div>
									    </div>
									</div>
								</div>
					        </div>
					    </div>
					</div>

					<!------------------------------------------- reportes ------------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="reportes">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemReportes" aria-expanded="false" aria-controls="itemReportes">
					        Reportes
					        </button>
					    </h2>
					    <div id="itemReportes" class="accordion-collapse collapse" aria-labelledby="reportes" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <div class="accordion" id="ayudaRep">
					                <!------------------------------------ aportaciones --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="aportaciones">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemAportaciones" aria-expanded="false" aria-controls="itemAportaciones">
									        Aportaciones
									        </button>
									    </h2>
									    <div id="itemAportaciones" class="accordion-collapse collapse" aria-labelledby="aportaciones" data-bs-parent="#ayudaRep">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Reporte_de_aportaciones__P3NzeEzHTm2It_LscQ-wQg?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>

									<!----------------------------------- ingresos ------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="ingresos">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemIngresos" aria-expanded="false" aria-controls="itemIngresos">
									        Ingresos
									        </button>
									    </h2>
									    <div id="itemIngresos" class="accordion-collapse collapse" aria-labelledby="ingresos" data-bs-parent="#ayudaRep">
									        <div class="accordion-body">
									            <div class="accordion" id="ayudaIng">
										            <!------------------------------ general --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="general">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemIngGen" aria-expanded="false" aria-controls="itemIngGen">
													        Reporte de ingresos general
													        </button>
													    </h2>
													    <div id="itemIngGen" class="accordion-collapse collapse" aria-labelledby="general" data-bs-parent="#ayudaIng">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Reporte_de_ingresos_general__H2Q7PRJjRZKV7zvqFD9XBA?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>

													<!------------------------------ resumen --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="resumen">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemIngResumen" aria-expanded="false" aria-controls="itemIngResumen">
													        Resumen de reporte de ingresos
													        </button>
													    </h2>
													    <div id="itemIngResumen" class="accordion-collapse collapse" aria-labelledby="resumen" data-bs-parent="#ayudaIng">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Resumen_de_reporte_de_ingresos__QbC87Zj7TiWKp4NB_Kg2oA?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>

													<!------------------------------ estadosC --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="estadosC">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemIngEstadosC" aria-expanded="false" aria-controls="itemIngEstadosC">
													        Estados de cuenta
													        </button>
													    </h2>
													    <div id="itemIngEstadosC" class="accordion-collapse collapse" aria-labelledby="estadosC" data-bs-parent="#ayudaIng">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Estados_de_cuenta__K1X3ssh_QgWJbjrvjnlZbQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>
												</div>
									        </div>
									    </div>
									</div>

									<!------------------------------------ certificados --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="certificados">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemRepCert" aria-expanded="false" aria-controls="itemRepCert">
									        Certificados
									        </button>
									    </h2>
									    <div id="itemRepCert" class="accordion-collapse collapse" aria-labelledby="certificados" data-bs-parent="#ayudaRep">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Reportes_de_certificados__gHRNGtY0RZKeHeLxSti7MA?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>
								</div>
					        </div>
					    </div>
					</div>';
			    break;

			///////////////////////////////////////////// contabilidad ////////////////////////////////////////////////////

			case "Contabilidad":
			    echo '<!-------------------------------- descarga -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="descarga">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemDescarga" aria-expanded="false" aria-controls="itemDescarga">
					        Abrir descarga
					        </button>
					    </h2>
					    <div id="itemDescarga" class="accordion-collapse collapse" aria-labelledby="descarga" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Abrir_descarga__SbhIm22OSZ-NjLyElO68KQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

					<!-------------------------------- cuenta -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="cuenta">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCuenta" aria-expanded="false" aria-controls="itemCuenta">
					        Activación y cambio de contraseña
					        </button>
					    </h2>
					    <div id="itemCuenta" class="accordion-collapse collapse" aria-labelledby="cuenta" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Activacion_y_cambio_de_contrasena__cXxkRP5WSFeyk2aVrTjHSw?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

			        <!-------------------------------- tablas -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="tablas">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemTablas" aria-expanded="false" aria-controls="itemTablas">
					        Tablas dinámicas
					        </button>
					    </h2>
					    <div id="itemTablas" class="accordion-collapse collapse" aria-labelledby="tablas" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Tablas_dinamicas__WuwMiHtjS6qrmmy4VM01CQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

					<!-------------------------------- catálogos -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="catalogos">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCatalogos" aria-expanded="false" aria-controls="itemCatalogos">
					        Catálogos
					        </button>
					    </h2>
					    <div id="itemCatalogos" class="accordion-collapse collapse" aria-labelledby="catalogos" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <div class="accordion" id="ayudaCat">
					                <!------------------------------ empacadoras --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="empacadoras">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemEmpacadoras" aria-expanded="false" aria-controls="itemEmpacadoras">
									        Registrar empacadora
									        </button>
									    </h2>
									    <div id="itemEmpacadoras" class="accordion-collapse collapse" aria-labelledby="empacadoras" data-bs-parent="#ayudaCat">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Registrar_empacadora__XMAM2JexTjqvE5llszhUWQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>
								</div>
					        </div>
					    </div>
					</div>

					<!------------------------------------------ movimientos -------------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="movimientos">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemMovimientos" aria-expanded="false" aria-controls="itemMovimientos">
					        Movimientos
					        </button>
					    </h2> 
					    <div id="itemMovimientos" class="accordion-collapse collapse" aria-labelledby="movimientos" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <div class="accordion" id="ayudaMov">
                                    <!----------------------------------- cobros ------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="cobros">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCobros" aria-expanded="false" aria-controls="itemCobros">
									        Cobros
									        </button>
									    </h2>
									    <div id="itemCobros" class="accordion-collapse collapse" aria-labelledby="cobros" data-bs-parent="#ayudaMov">
									        <div class="accordion-body">
									            <div class="accordion" id="ayudaCob">
										            <!------------------------------ registrar --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="regCobros">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemRegCobros" aria-expanded="false" aria-controls="itemRegCobros">
													        Registrar cobro
													        </button>
													    </h2>
													    <div id="itemRegCobros" class="accordion-collapse collapse" aria-labelledby="regCobros" data-bs-parent="#ayudaCob">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Registrar_cobro__FdUai2RgR7WP3vF9Q5O22Q?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>

													<!------------------------------ consultar --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="conCobros">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemConCobros" aria-expanded="false" aria-controls="itemConCobros">
													        Consultar cobros
													        </button>
													    </h2>
													    <div id="itemConCobros" class="accordion-collapse collapse" aria-labelledby="conCobros" data-bs-parent="#ayudaCob">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Consultar_cobro__3F39lDjWR4i3VnTikaL6Xw?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>
												</div>
									        </div>
									    </div>
									</div>

                                    <!----------------------------------- facturas ------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="facturas">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemFacturas" aria-expanded="false" aria-controls="itemFacturas">
									        Facturas de empacadoras
									        </button>
									    </h2>
									    <div id="itemFacturas" class="accordion-collapse collapse" aria-labelledby="facturas" data-bs-parent="#ayudaMov">
									        <div class="accordion-body">
									            <div class="accordion" id="ayudaFac">
									            <!------------------------------ registrar --------------------------------->
												<div class="accordion-item bg-light">
												    <h2 class="accordion-header" id="regFacturas">
												        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemRegFact" aria-expanded="false" aria-controls="itemRegFact">
												        Registrar factura
												        </button>
												    </h2>
												    <div id="itemRegFact" class="accordion-collapse collapse" aria-labelledby="regFacturas" data-bs-parent="#ayudaFac">
												        <div class="accordion-body">
												            <iframe class="iframe" src="https://scribehow.com/embed/Registrar_factura_de_empacadora__-CC7oXJPRh2kLK4FZBkS9w?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
												        </div>
												    </div>
												</div>

												<!------------------------------ consultar --------------------------------->
												<div class="accordion-item bg-light">
												    <h2 class="accordion-header" id="conFacturas">
												        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemConFact" aria-expanded="false" aria-controls="itemConFact">
												        Consultar facturas
												        </button>
												    </h2>
												    <div id="itemConFact" class="accordion-collapse collapse" aria-labelledby="conFacturas" data-bs-parent="#ayudaFac">
												        <div class="accordion-body">
												            <iframe class="iframe" src="https://scribehow.com/embed/Consultar_factura__WWn2QsrJTTG_gTCK3nBlyg?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
												        </div>
												    </div>
												</div>

												<!------------------------------ cancelar --------------------------------->
												<div class="accordion-item bg-light">
												    <h2 class="accordion-header" id="canFacturas">
												        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCanFact" aria-expanded="false" aria-controls="itemCanFact">
												        Cancelar factura
												        </button>
												    </h2>
												    <div id="itemCanFact" class="accordion-collapse collapse" aria-labelledby="canFacturas" data-bs-parent="#ayudaFac">
												        <div class="accordion-body">
												            <iframe class="iframe" src="https://scribehow.com/embed/Cancelar_factura__wzHmiQSqRnOCQm5o_JG7Gg?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
												        </div>
												    </div>
												</div>
									        </div>
									    </div>
									</div>
								</div>
					        </div>
					    </div>
					</div>

					<!------------------------------------------- reportes ------------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="reportes">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemReportes" aria-expanded="false" aria-controls="itemReportes">
					        Reportes
					        </button>
					    </h2>
					    <div id="itemReportes" class="accordion-collapse collapse" aria-labelledby="reportes" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <div class="accordion" id="ayudaRep">
					                <!------------------------------------ aportaciones --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="aportaciones">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemAportaciones" aria-expanded="false" aria-controls="itemAportaciones">
									        Aportaciones
									        </button>
									    </h2>
									    <div id="itemAportaciones" class="accordion-collapse collapse" aria-labelledby="aportaciones" data-bs-parent="#ayudaRep">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Reporte_de_aportaciones__P3NzeEzHTm2It_LscQ-wQg?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>

									<!----------------------------------- ingresos ------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="ingresos">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemIngresos" aria-expanded="false" aria-controls="itemIngresos">
									        Ingresos
									        </button>
									    </h2>
									    <div id="itemIngresos" class="accordion-collapse collapse" aria-labelledby="ingresos" data-bs-parent="#ayudaRep">
									        <div class="accordion-body">
									            <div class="accordion" id="ayudaIng">
										            <!------------------------------ general --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="general">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemIngGen" aria-expanded="false" aria-controls="itemIngGen">
													        Reporte de ingresos general
													        </button>
													    </h2>
													    <div id="itemIngGen" class="accordion-collapse collapse" aria-labelledby="general" data-bs-parent="#ayudaIng">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Reporte_de_ingresos_general__H2Q7PRJjRZKV7zvqFD9XBA?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>

													<!------------------------------ resumen --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="resumen">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemIngResumen" aria-expanded="false" aria-controls="itemIngResumen">
													        Resumen de reporte de ingresos
													        </button>
													    </h2>
													    <div id="itemIngResumen" class="accordion-collapse collapse" aria-labelledby="resumen" data-bs-parent="#ayudaIng">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Resumen_de_reporte_de_ingresos__QbC87Zj7TiWKp4NB_Kg2oA?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>

													<!------------------------------ estadosC --------------------------------->
													<div class="accordion-item bg-light">
													    <h2 class="accordion-header" id="estadosC">
													        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemIngEstadosC" aria-expanded="false" aria-controls="itemIngEstadosC">
													        Estados de cuenta
													        </button>
													    </h2>
													    <div id="itemIngEstadosC" class="accordion-collapse collapse" aria-labelledby="estadosC" data-bs-parent="#ayudaIng">
													        <div class="accordion-body">
													            <iframe class="iframe" src="https://scribehow.com/embed/Estados_de_cuenta__K1X3ssh_QgWJbjrvjnlZbQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
													        </div>
													    </div>
													</div>
												</div>
									        </div>
									    </div>
									</div>
								</div>
					        </div>
					    </div>
					</div>';
			    break;


			///////////////////////////////////////////// estadística ////////////////////////////////////////////////////

			case "Estadística":
			    echo '<!-------------------------------- descarga -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="descarga">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemDescarga" aria-expanded="false" aria-controls="itemDescarga">
					        Abrir descarga
					        </button>
					    </h2>
					    <div id="itemDescarga" class="accordion-collapse collapse" aria-labelledby="descarga" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Abrir_descarga__SbhIm22OSZ-NjLyElO68KQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

					<!-------------------------------- cuenta -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="cuenta">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCuenta" aria-expanded="false" aria-controls="itemCuenta">
					        Activación y cambio de contraseña
					        </button>
					    </h2>
					    <div id="itemCuenta" class="accordion-collapse collapse" aria-labelledby="cuenta" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Activacion_y_cambio_de_contrasena__cXxkRP5WSFeyk2aVrTjHSw?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

			        <!-------------------------------- tablas -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="tablas">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemTablas" aria-expanded="false" aria-controls="itemTablas">
					        Tablas dinámicas
					        </button>
					    </h2>
					    <div id="itemTablas" class="accordion-collapse collapse" aria-labelledby="tablas" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Tablas_dinamicas__WuwMiHtjS6qrmmy4VM01CQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

					<!-------------------------------- catálogos -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="catalogos">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCatalogos" aria-expanded="false" aria-controls="itemCatalogos">
					        Catálogos
					        </button>
					    </h2>
					    <div id="itemCatalogos" class="accordion-collapse collapse" aria-labelledby="catalogos" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <div class="accordion" id="ayudaCat">
					                <!------------------------------ empacadoras --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="empacadoras">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemEmpacadoras" aria-expanded="false" aria-controls="itemEmpacadoras">
									        Registrar empacadora
									        </button>
									    </h2>
									    <div id="itemEmpacadoras" class="accordion-collapse collapse" aria-labelledby="empacadoras" data-bs-parent="#ayudaCat">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Registrar_empacadora__XMAM2JexTjqvE5llszhUWQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>
								</div>
					        </div>
					    </div>
					</div>

					<!----------------------------------- certificados ------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="certificados">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCertificados" aria-expanded="false" aria-controls="itemCertificados">
					        Certificados
					        </button>
					    </h2>
					    <div id="itemCertificados" class="accordion-collapse collapse" aria-labelledby="certificados" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <div class="accordion" id="ayudaCert">
						            <!------------------------------ registrar --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="regCertificados">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemRegCert" aria-expanded="false" aria-controls="itemRegCert">
									        Registrar certificado
									        </button>
									    </h2>
									    <div id="itemRegCert" class="accordion-collapse collapse" aria-labelledby="regCertificados" data-bs-parent="#ayudaCert">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Registrar_certificado__4LBcRrOJSNObC-wHG0wVIw?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>

									<!------------------------------ cancelar --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="canCertificados">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCanCert" aria-expanded="false" aria-controls="itemCanCert">
									        Cancelar certificado
									        </button>
									    </h2>
									    <div id="itemCanCert" class="accordion-collapse collapse" aria-labelledby="canCertificados" data-bs-parent="#ayudaCert">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Cancelar_certificado__Snypj_EXTYCDUfcaXyZhew?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>

									<!------------------------------ reemplazar --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="reeCertificados">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemReeCert" aria-expanded="false" aria-controls="itemReeCert">
									        Reemplazar certificado
									        </button>
									    </h2>
									    <div id="itemReeCert" class="accordion-collapse collapse" aria-labelledby="reeCertificados" data-bs-parent="#ayudaCert">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Reemplazar_certificado__lA1IiSKGTyquQ2wrwNQsJA?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>
								</div>
					        </div>
					    </div>
					</div>

					<!------------------------------------------- reportes ------------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="reportes">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemReportes" aria-expanded="false" aria-controls="itemReportes">
					        Reportes
					        </button>
					    </h2>
					    <div id="itemReportes" class="accordion-collapse collapse" aria-labelledby="reportes" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <div class="accordion" id="ayudaRep">
					                <!------------------------------------ aportaciones --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="aportaciones">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemAportaciones" aria-expanded="false" aria-controls="itemAportaciones">
									        Aportaciones
									        </button>
									    </h2>
									    <div id="itemAportaciones" class="accordion-collapse collapse" aria-labelledby="aportaciones" data-bs-parent="#ayudaRep">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Reporte_de_aportaciones__P3NzeEzHTm2It_LscQ-wQg?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>

									<!------------------------------------ certificados --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="certificados">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemRepCert" aria-expanded="false" aria-controls="itemRepCert">
									        Certificados
									        </button>
									    </h2>
									    <div id="itemRepCert" class="accordion-collapse collapse" aria-labelledby="certificados" data-bs-parent="#ayudaRep">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Reportes_de_certificados__gHRNGtY0RZKeHeLxSti7MA?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>
								</div>
					        </div>
					    </div>
					</div>';
			    break;

			///////////////////////////////////////////// auxiliar ////////////////////////////////////////////////////

			case "Auxiliar":
			    echo '<!-------------------------------- descarga -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="descarga">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemDescarga" aria-expanded="false" aria-controls="itemDescarga">
					        Abrir descarga
					        </button>
					    </h2>
					    <div id="itemDescarga" class="accordion-collapse collapse" aria-labelledby="descarga" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Abrir_descarga__SbhIm22OSZ-NjLyElO68KQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

					<!-------------------------------- cuenta -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="cuenta">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCuenta" aria-expanded="false" aria-controls="itemCuenta">
					        Activación y cambio de contraseña
					        </button>
					    </h2>
					    <div id="itemCuenta" class="accordion-collapse collapse" aria-labelledby="cuenta" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Activacion_y_cambio_de_contrasena__cXxkRP5WSFeyk2aVrTjHSw?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

			        <!-------------------------------- tablas -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="tablas">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemTablas" aria-expanded="false" aria-controls="itemTablas">
					        Tablas dinámicas
					        </button>
					    </h2>
					    <div id="itemTablas" class="accordion-collapse collapse" aria-labelledby="tablas" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Tablas_dinamicas__WuwMiHtjS6qrmmy4VM01CQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

					<!----------------------------------- certificados ------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="certificados">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCertificados" aria-expanded="false" aria-controls="itemCertificados">
					        Certificados
					        </button>
					    </h2>
					    <div id="itemCertificados" class="accordion-collapse collapse" aria-labelledby="certificados" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <div class="accordion" id="ayudaCert">
						            <!------------------------------ registrar --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="regCertificados">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemRegCert" aria-expanded="false" aria-controls="itemRegCert">
									        Registrar certificado
									        </button>
									    </h2>
									    <div id="itemRegCert" class="accordion-collapse collapse" aria-labelledby="regCertificados" data-bs-parent="#ayudaCert">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Registrar_certificado__4LBcRrOJSNObC-wHG0wVIw?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>

									<!------------------------------ cancelar --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="canCertificados">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCanCert" aria-expanded="false" aria-controls="itemCanCert">
									        Cancelar certificado
									        </button>
									    </h2>
									    <div id="itemCanCert" class="accordion-collapse collapse" aria-labelledby="canCertificados" data-bs-parent="#ayudaCert">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Cancelar_certificado__Snypj_EXTYCDUfcaXyZhew?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>

									<!------------------------------ reemplazar --------------------------------->
									<div class="accordion-item bg-light">
									    <h2 class="accordion-header" id="reeCertificados">
									        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemReeCert" aria-expanded="false" aria-controls="itemReeCert">
									        Reemplazar certificado
									        </button>
									    </h2>
									    <div id="itemReeCert" class="accordion-collapse collapse" aria-labelledby="reeCertificados" data-bs-parent="#ayudaCert">
									        <div class="accordion-body">
									            <iframe class="iframe" src="https://scribehow.com/embed/Reemplazar_certificado__lA1IiSKGTyquQ2wrwNQsJA?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
									        </div>
									    </div>
									</div>
								</div>
					        </div>
					    </div>
					</div>';
			    break;

			///////////////////////////////////////////// empaque ////////////////////////////////////////////////////

			case "Empaque":
			    echo '<!-------------------------------- descarga -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="descarga">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemDescarga" aria-expanded="false" aria-controls="itemDescarga">
					        Abrir descarga
					        </button>
					    </h2>
					    <div id="itemDescarga" class="accordion-collapse collapse" aria-labelledby="descarga" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Abrir_descarga__SbhIm22OSZ-NjLyElO68KQ?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

					<!-------------------------------- cuenta -------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="cuenta">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemCuenta" aria-expanded="false" aria-controls="itemCuenta">
					        Activación y cambio de contraseña
					        </button>
					    </h2>
					    <div id="itemCuenta" class="accordion-collapse collapse" aria-labelledby="cuenta" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Activacion_y_cambio_de_contrasena__cXxkRP5WSFeyk2aVrTjHSw?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>

					<!------------------------------------ certificados --------------------------------->
					<div class="accordion-item bg-light">
					    <h2 class="accordion-header" id="repCertificados">
					        <button class="accordion-button text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemRepCert" aria-expanded="false" aria-controls="itemRepCert">
					        Reportes de certificados
					        </button>
					    </h2>
					    <div id="itemRepCert" class="accordion-collapse collapse" aria-labelledby="repCertificados" data-bs-parent="#ayuda">
					        <div class="accordion-body">
					            <iframe class="iframe" src="https://scribehow.com/embed/Reportes_de_certificados__gHRNGtY0RZKeHeLxSti7MA?as=scrollable" height="590" allowfullscreen frameborder="0"></iframe>
					        </div>
					    </div>
					</div>';
			    break;
    	}
    }
?>