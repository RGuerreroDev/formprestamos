<?php
//-----------------------------------------------

require_once("../../../inc/includes.inc.php");
require_once("../../../inc/class/SolicitudEnLinea.php");

//-----------------------------------------------

$conn = new SQLSrvBD(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);
$conn->conectar();

//-----------------------------------------------

$objSolicitudes = new SolicitudEnLinea($conn);
$datos = $objSolicitudes->getAll();

$datosFinales = array();
foreach ($datos as $registro) {
    $nuevoRegistro = array(
        "id" => $registro["SOLICITUDENLINEAID"],
        "correlativo" => $registro["CORRELATIVO"],
        "apellidos" => iconv("ISO-8859-1", "UTF-8", $registro["APELLIDOS"]),
        "nombres" => iconv("ISO-8859-1", "UTF-8", $registro["NOMBRES"]),
        "estadoid" => $registro["SOLICITUDESTADOID"],
        "estado" => $registro["ESTADO"],
        "fecharecepcion" => $registro["FECHAHORARECEPCION"]->format('d/m/Y H:i:s'),
        "trabajo" => iconv("ISO-8859-1", "UTF-8", $registro["LUGARDETRABAJO"]),
        "ingreso" => $registro["INGRESOMENSUAL"]
    );

    array_push($datosFinales, $nuevoRegistro);
}

//-----------------------------------------------

// Retornar JSON con resultado

$resultado["datos"] = $datosFinales;

echo json_encode($resultado);

//-----------------------------------------------