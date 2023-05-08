
    </div><!-- container -->
    
    <script src="./libs/jquery-3.6.4/jquery-3.6.4.min.js"></script>
    <script src="./libs/bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
    <!--script src="./libs/bootstrap-table-1.21.0-dist/bootstrap-table.min.js"></script>
    <script src="./libs/bootstrap-table-1.21.0-dist/locale/bootstrap-table-es-ES.min.js"></script>
    <script src="./libs/jQueryTableExport/tableExport.min.js"></script>
    <script src="./libs/bootstrap-table-1.21.0-dist/extensions/export/bootstrap-table-export.min.js"></script-->
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