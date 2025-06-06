<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $nombre = $_SESSION['nombre'];
} else {
    header("Location: ../index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Study Planner</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/styleHome.css">
    <link rel="stylesheet" href="../css/job.css">

</head>

<body>
    <!--    contenedor principal -->
    <div class="container-fluid">
        <!-- fila 1 -->
        <div class="row">
            <!-- columna 1 fila 1 -->
            <div class="col ">
                <nav class="navbar navbar-dark bg-custom fixed-top">
                    <div class="container-fluid">
                        <!-- Menu-->
                        <div class="d-flex align-items-center">
                            <button class="navbar-toggler custom-toggler me-2" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasCustomNavbar" aria-controls="offcanvasCustomNavbar">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <!-- logo-->
                            <a class="navbar-brand d-none d-md-block" href="#">
                                <img src="../assets/logo.png" alt="" width="30" height="24"
                                    class="d-inline-block align-text-top">
                            </a>
                        </div>

                        <ul class="nav nav-underline me-auto align-items-center">
                            <!-- Inicio -->
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link active text-white" aria-current="page" href="./home.php"> Inicio</a>
                            </li>

                            <!-- Proyectos -->
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link text-white" href="./project.php">Proyectos</a>
                            </li>

                            <!-- Tareas -->
                            <li class="nav-item dropdown d-flex align-items-center d-none d-md-block">
                                <a class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown" href="#"
                                    role="button" aria-expanded="false">Tareas</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarProjects">
                                    <li><a class="dropdown-item" href="./academic.php">Academicas</a></li>
                                    <li><a class="dropdown-item" href="./job.php">Trabajo</a></li>
                                    <li><a class="dropdown-item" href="./personales.php">Personales</a></li>
                                    <li><a class="dropdown-item" href="./hogar.php">Hogar</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="./tasks.php">Todas las tareas</a></li>
                                </ul>
                            </li>
                        </ul>

                        <div class="d-flex align-items-center">
                            <div class="d-none d-md-flex align-items-center">
                                <!-- Barra de búsqueda -->
                                <form class="d-flex me-1">
                                    <input class="form-control form-control-sm" type="search" placeholder="Buscar"
                                        aria-label="Buscar">
                                </form>

                                <!-- Notificaciones -->
                                <div class="dropdown me-3">
                                    <a href="../views/reminder.php" class="btn btn-link position-relative text-white p-0">
                                        <i class="bi bi-bell fs-5"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            3 <span class="visually-hidden">notificaciones</span>
                                        </span>
                                    </a>
                                </div>
                            </div>

                            <!-- Perfil-->
                            <div class="dropdown">
                                <button class="btn p-0 border-0 bg-transparent shadow-none dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle fs-3" style="color: white;"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#">Perfil</a></li>
                                    <li><a class="dropdown-item" href="#">Configuración</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../backend/logout.php">Cerrar sesión</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="offcanvas offcanvas-start custom-offcanvas" style="width: 300px;" tabindex="-1"
                    id="offcanvasCustomNavbar" aria-labelledby="offcanvasCustomNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title canvas-title" id="offcanvasCustomNavbarLabel">
                            <img src="../assets/logo.png" alt="Logo" width="25" height="25">
                            Study Planner
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>

                    <div class="offcanvas-body p-3">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" href="./home.php"><i class="bi bi-house-door me-2"></i>Inicio</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" href="./project.php"><i class="bi bi-folder me-2"></i>Proyectos</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" href="./tasks.php"><i class="bi bi-folder me-2"></i>Tareas</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" href="./calendar.php"><i class="bi bi-calendar me-2"></i>Calendario</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" href="./reports.php"><i
                                        class="bi bi-file-earmark-text me-2"></i>Reports</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid d-flex flex-column h-100">
        <div class="row flex-grow-1">
            <!-- Columna de tarjetas (ocupa más espacio) -->
            <div class="col-12 col-lg-8 d-flex flex-column">
                <div class="row flex-grow-1">
                    <!-- Primera columna de tarjetas -->
                    <div class="col-12 col-md-4 d-flex flex-column">
                        <div class="card flex-grow-1 mb-3">
                            <div class="date-header">
                                <i class="bi bi-calendar-date me-2"></i>Lunes 4 de marzo
                            </div>
                            <div class="card-body p-3">
                                <div class="content-placeholder"></div>
                            </div>
                        </div>
                        <div class="card flex-grow-1 mb-3">
                            <div class="date-header">
                                <i class="bi bi-calendar-date me-2"></i>Lunes 4 de marzo
                            </div>
                            <div class="card-body p-3">
                                <div class="content-placeholder"></div>
                            </div>
                        </div>
                        <div class="card flex-grow-1">
                            <div class="date-header">
                                <i class="bi bi-calendar-date me-2"></i>Lunes 4 de marzo
                            </div>
                            <div class="card-body p-3">
                                <div class="content-placeholder"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Segunda columna de tarjetas -->
                    <div class="col-12 col-md-4 d-flex flex-column">
                        <div class="card flex-grow-1 mb-3">
                            <div class="date-header">
                                <i class="bi bi-calendar-date me-2"></i>Lunes 4 de marzo
                            </div>
                            <div class="card-body p-3">
                                <div class="content-placeholder"></div>
                            </div>
                        </div>
                        <div class="card flex-grow-1 mb-3">
                            <div class="date-header">
                                <i class="bi bi-calendar-date me-2"></i>Lunes 4 de marzo
                            </div>
                            <div class="card-body p-3">
                                <div class="content-placeholder"></div>
                            </div>
                        </div>
                        <div class="card flex-grow-1">
                            <div class="date-header">
                                <i class="bi bi-calendar-date me-2"></i>Lunes 4 de marzo
                            </div>
                            <div class="card-body p-3">
                                <div class="content-placeholder"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Tercera columna de tarjetas -->
                    <div class="col-12 col-md-4 d-flex flex-column">
                        <div class="card flex-grow-1 mb-3">
                            <div class="date-header">
                                <i class="bi bi-calendar-date me-2"></i>Lunes 4 de marzo
                            </div>
                            <div class="card-body p-3">
                                <div class="content-placeholder"></div>
                            </div>
                        </div>
                        <div class="card flex-grow-1 mb-3">
                            <div class="date-header">
                                <i class="bi bi-calendar-date me-2"></i>Lunes 4 de marzo
                            </div>
                            <div class="card-body p-3">
                                <div class="content-placeholder"></div>
                            </div>
                        </div>
                        <div class="card flex-grow-1">
                            <div class="date-header">
                                <i class="bi bi-calendar-date me-2"></i>Lunes 4 de marzo
                            </div>
                            <div class="card-body p-3">
                                <div class="content-placeholder"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bienvenida -->
            <div class="col-12 col-lg-4 d-flex align-items-stretch">
                <div class="card p-4 shadow-lg w-100">
                    <img src="../assets/jobs.png" class="card-img-top mb-3" alt="Imagen de bienvenida">
                    <div class="card-body">
                        <h2 class="welcome-title">¡Bienvenido(a) <span class="welcome-name">Darknessss</span>!</h2>
                        <p class="welcome-text">
                            El éxito no es solo cuestión de talento, sino de constancia, esfuerzo y actitud. Enfócate en
                            mejorar un poco cada día, y pronto verás cómo tu dedicación da frutos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>