<?php
//-----------------------------------------------

session_start();

require_once("../../../inc/includes.inc.php");
require_once("../../../inc/class/Usuario.php");

//-----------------------------------------------

$conn = new SQLSrvBD(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);
$conn->conectar();

//-----------------------------------------------

// Datos

$id = $_POST["id"];
$nombreCompleto = $_POST["nombreCompleto"];
$usuario = $_POST["usuario"];
$contrasena = $_POST["contrasena"];

// $id = -1;
// $nombreCompleto = "Roberto Guerrero";
// $usuario = "rguerrero";
// $contrasena = "brethart";

$activo = empty($_POST['activo']) ? 0 : 1;

//-----------------------------------------------

$objUsuario = new Usuario($conn);

$guardado = false;
$mensajeGuardado = "Error al guardar datos";
$tipoAccion = "undefined";

// Actualizar

if ($id > -1)
{
    $cambios = array(
        "NOMBRECOMPLETO", $nombreCompleto,
        "USUARIO", $usuario,
        "ACTIVO", $activo
    );
    
    if (strlen($contrasena) > 0)
    {
        array_push($cambios, "CONTRASENA", password_hash($contrasena, PASSWORD_DEFAULT));
    }

    $guardado = $objUsuario->editarRegistro($id, $cambios);
    $tipoAccion = "actualiza";
}

// Crear

if ($id == -1)
{
    $buscarUsuario = $objUsuario->getWithFilters("USUARIO = '$usuario'");
    if (count($buscarUsuario) > 0)
    {
        $mensajeGuardado = "El usuario $usuario ya existe";
    }
    else
    {
        $guardado = $objUsuario->agregarRegistro($nombreCompleto, $usuario, $contrasena);
    }

    $tipoAccion = "crea";
}

//-----------------------------------------------

if ($guardado)
{
    $mensajeGuardado = $id == -1 ? "El usuario fue creado." : "El usuario fue actualizado";
}

//-----------------------------------------------

$resultado = array();

$resultado["error"] = $guardado ? "" : $objUsuario->mensajeError;
$resultado["tipoAccion"] = $tipoAccion;
$resultado["mensaje"] = $mensajeGuardado;
$resultado["id"] = $id;

// Retornar JSON con resultado

echo json_encode($resultado);

//-----------------------------------------------