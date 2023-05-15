<?php
//-----------------------------------------------

require_once("../../../inc/includes.inc.php");
require_once("../../../inc/class/Usuario.php");

//-----------------------------------------------

$conn = new SQLSrvBD(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);
$conn->conectar();

//-----------------------------------------------

$objUsuarios = new Usuario($conn);
$datos = $objUsuarios->getAll();

$datosFinales = array();
foreach ($datos as $registro) {
    $nuevoRegistro = array(
        "id" => $registro["USUARIOID"],
        "usuario" => $registro["USUARIO"],
        "nombrecompleto" => $registro["NOMBRECOMPLETO"],
        "activo" => $registro["ACTIVO"] == 1 ? "S&iacute;" : "No"
    );

    array_push($datosFinales, $nuevoRegistro);
}

//-----------------------------------------------

// Retornar JSON con resultado

$resultado["datos"] = $datosFinales;

echo json_encode($resultado);

//-----------------------------------------------