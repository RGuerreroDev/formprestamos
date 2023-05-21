<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_TITULO ?></title>

    <link rel="stylesheet" href="./libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./libs/bootstrap-table/bootstrap-table.min.css">
    <link rel="stylesheet" href="./libs/bootstrap-icons/font/bootstrap-icons.min.css">
</head>
<body>
    <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3" style="height: 60px;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon">
                    <img src="imgs/lacuracaomini.png" style="max-width: 40px;">
                </span>
                <span><?= APP_TITULO ?></span>
            </a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-5">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="?mod=solicitudes">Solicitudes</a></li>
                    <li class="nav-item"><a class="nav-link" href="?mod=usuarios">Usuarios</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i> <?= $_SESSION["usuario"] ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item small" href="#" id="linkLogout">Cerrar sesi&oacute;n</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
