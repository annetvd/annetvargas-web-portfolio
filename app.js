$(document).ready(function(){
	var altura = $('#barra').offset().top;
	
	$(window).on('scroll', function(){
		if ( $(window).scrollTop() > altura){
			$('#barra').addClass('header');
			$('#usuario').addClass('espacio');
		} else {
			$('#barra').removeClass('header');
			$('#usuario').removeClass('espacio');
		}
	});
});

$(window).resize(function() {
	var alturaNav = $('#imgLogo').position().top;
	if (alturaNav != "3.5"){
		$('#imgLogo').addClass('text-start');
		$('#imgLogo').removeClass('text-end');
	} else {
		$('#imgLogo').addClass('text-end');
		$('#imgLogo').removeClass('text-start');
	}
});

	
$("#btnNav").on("click", function() {
	var alturaNav = document.getElementById("navbarNav").style.height;
	if (alturaNav != ""){
		$('#imgLogo').addClass('text-start');
		$('#imgLogo').removeClass('text-end');
	} else {
		$('#imgLogo').addClass('text-end');
		$('#imgLogo').removeClass('text-start');
	}
});

