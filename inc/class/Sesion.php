<?php
//-----------------------------------------------

class Sesion
{
    //-------------------------------------------

    public static function validarSesion()
    {
        if (isset($_SESSION["sesion"]) && $_SESSION["sesion"] == true) {
            // PASS
        } else if (isset($_GET["mod"]) && $_GET["mod"] == "login") {
            // PASS
        } else {
            header("Location: ?mod=login");
        }
    }

    //-------------------------------------------

    public static function existeSesion()
    {
        return (isset($_SESSION["sesion"]) && $_SESSION["sesion"] == true);
    }

    //-------------------------------------------
}