<?php
include "variables.php";

// Header
header("Content-Type: text/plain");

// Request
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = basename($request);

// Routes
if ($request === 'restoreAwococadoDB') {
    restoreDB($host, $bdA, $usuarioA, $contraseñaA);
} else {
    http_response_code(404);
    echo "Resourse not found";
}

// Restore DB
function restoreDB($db_host, $db_name, $db_user, $db_pass){
    $backup_path = "../awococado/Backups/" . basename($_POST["backup"]);
    $dump = "mysql --host='" . $db_host .
        "' --user='" . $db_user .
        "' --password='" . $db_pass .
        "' '" . $db_name .
        "' < '" . $backup_path . "'";

    exec($dump, $output, $worked); 

    if($worked == "0"){
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}
?>