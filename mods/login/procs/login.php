<?php
//-----------------------------------------------

session_start();

require_once("../../../inc/includes.inc.php");
require_once("../../../inc/class/Usuario.php");

//-----------------------------------------------

$conn = new SQLSrvBD(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);
$conn->conectar();

//-----------------------------------------------

$resultado = array();
$resultado["error"] = 1;

//-----------------------------------------------

if($_POST && isset($_POST["usuario"]) && !$conn->getExisteError())
{
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];
    
    $objUsuario = new Usuario($conn);
    if($objUsuario->login($usuario, $contrasena))
    {
        $resultado["error"] = 0;
    }
}

//-----------------------------------------------

// Mostrar resultado de proceso
header('Content-type: application/json; charset=utf-8');
echo json_encode($resultado);
exit();

//-----------------------------------------------