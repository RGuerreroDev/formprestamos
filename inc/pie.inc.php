
    </div><!-- container -->
    
    <script src="./libs/jquery/jquery.min.js"></script>
    <script src="./libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./libs/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="./libs/bootstrap-table/locale/bootstrap-table-es-ES.min.js"></script>
    <!--script src="./libs/jQueryTableExport/tableExport.min.js"></script-->
    <!--script src="./libs/bootstrap-table-1.21.0-dist/extensions/export/bootstrap-table-export.min.js"></script-->
    <script src="./js/main.js"></script>
<?php

if (isset($_GET["mod"])) {
    if (isset($_GET["sub"])) {
        $destino = "mods/" . $_GET["mod"] . "/js/" . $_GET["sub"] . ".js";
    } else {
        if ($_GET["mod"])
        $destino = "mods/" . $_GET["mod"] . "/js/" . $_GET["mod"] . ".js";
    }
    if (@file_exists($destino)) {
        echo '    <script src="' . $destino .'"></script>';
    }
}

?>
</body>
</html>