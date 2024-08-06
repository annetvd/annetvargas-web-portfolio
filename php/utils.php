<?php
    function printModal(){
		$dir = substr(getcwd(), -11);
		if ($dir == "public_html"){
			$tempUrl = "templates/responseModal.php";
		} else{
			$tempUrl = "../templates/responseModal.php";
		}
		$template = file_get_contents($tempUrl);
		echo $template;
	}
?>