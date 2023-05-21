<?php
//-----------------------------------------------

require_once("../../../inc/includes.inc.php");
require_once("../../../inc/class/SolicitudEnLinea.php");

//-----------------------------------------------

$conn = new SQLSrvBD(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);
$conn->conectar();

//-----------------------------------------------

$desdeFecha = $_POST["desde"];
$estado = $_POST["estado"];

//-----------------------------------------------

$objSolicitudes = new SolicitudEnLinea($conn);

$filtros = "S.FECHAHORARECEPCION >= '$desdeFecha'";
$filtros .= $estado == "TOD" ? "" : " AND S.SOLICITUDESTADOID = '$estado'";

$datos = $objSolicitudes->getWithFilters($filtros);

$datosFinales = array();
foreach ($datos as $registro) {
    $nuevoRegistro = array(
        "id" => $registro["SOLICITUDENLINEAID"],
        "correlativo" => $registro["CORRELATIVO"],
        "apellidos" => $registro["APELLIDOS"],
        "nombres" => $registro["NOMBRES"],
        "estadoid" => $registro["SOLICITUDESTADOID"],
        "estado" => $registro["ESTADO"],
        "fecharecepcion" => $registro["FECHAHORARECEPCION"]->format('d/m/Y H:i:s'),
        "trabajo" => $registro["LUGARDETRABAJO"],
        "dui" => $registro["NUMERODOCUMENTO"],
        "telefono" => $registro["TELEFONO"],
        "correo" => $registro["CORREOELECTRONICO"]
    );

    array_push($datosFinales, $nuevoRegistro);
}

//-----------------------------------------------

// Retornar JSON con resultado

$resultado["datos"] = $datosFinales;
$resultado["filtros"] = $filtros;

echo json_encode($resultado);

//-----------------------------------------------