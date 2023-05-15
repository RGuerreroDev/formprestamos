<?php
//-----------------------------------------------

session_start();

//-----------------------------------------------

require_once("./inc/includes.inc.php");

//-----------------------------------------------

// Valida si existe sesión, en caso de no existir, redirige a login
Sesion::validarSesion();

//-----------------------------------------------

// Se ha definido entrar a un módulo
if (isset($_GET["mod"])) {
    // Si se está tratando de entrar a pantalla de inicio de sesión, pero
    // ya existe sesión: enviar a inicio
    if ($_GET["mod"] == "login" && Sesion::existeSesion())
    {
        //header("Location: ?mod=inicio");
        header("Location: ?mod=solicitudes");
    }

    // Carga encabezado HTML
    // Si no es pantalla de inicio de sesión, mostrar menú de aplicación
    if ($_GET["mod"] != "login")
    {
        require_once("inc/encabezado.inc.php");
    }
    else
    {
        require_once("inc/encabezadologin.inc.php");
    }

    // Si existe una opción dentro del módulo, cargar esa opción
    // de lo contrario, cargar pantalla inicial del módulo
    if (isset($_GET["sub"])) {
        $destino = "mods/" . $_GET["mod"] . "/" . $_GET["sub"] . ".php";
    } else {
        $destino = "mods/" . $_GET["mod"] . "/" . $_GET["mod"] . ".php";
    }

    // Si no se pudo cargar el módulo porque no existe, regresar a inicio
    if (!@include_once($destino)) {
        header("Location: ?mod=inicio");
    } else {}
} else {
    // No hay un módulo definido, entonces verificar si hay sesión para
    // dirigir a inicio, y, si no hay sesión, enviar a pantalla de login
    if (Sesion::existeSesion())
    {
        //header("Location: ?mod=inicio");
        header("Location: ?mod=solicitudes");
    }
    else
    {
        header("Location: ?mod=login");
    }
}

//-----------------------------------------------

// Pié de HTML
require_once("inc/pie.inc.php");

//-----------------------------------------------