<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Study Planner</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../css/styleHome.css">
  <link rel="stylesheet" href="../css/tasks.css">

</head>

<body>
  <!--    contenedor principal -->
  <div class="container-fluid"></div>
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
            <a class="navbar-brand d-none d-md-block" href="./home.php">
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
                <li><a class="dropdown-item" href="#">Academicas</a></li>
                <li><a class="dropdown-item" href="#">Trabajo</a></li>
                <li><a class="dropdown-item" href="#">Personales</a></li>
                <li><a class="dropdown-item" href="#">Hogar</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Todas las tareas</a></li>
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

      <div class="container mt-5">
        <div class="row justify-content-center categorias">
          <div class="col-md-2 mb-3">
            <button class="btn btn-primary w-100">
              Importantes
              <span class="material-symbols-outlined"></span>
            </button>
          </div>
          <div class="col-md-2 mb-3">
            <button class="btn btn-primary w-100">
              Pendientes
              <span class="material-symbols-outlined"></span>
            </button>
          </div>
          <div class="col-md-2 mb-3">
            <button class="btn btn-primary w-100">
              En curso
              <span class="material-symbols-outlined"></span>
            </button>
          </div>
          <div class="col-md-2 mb-3">
            <button class="btn btn-primary w-100">
              Archivados
              <span class="material-symbols-outlined"></span>
            </button>
          </div>
        </div>

        <div class="row cards">
          <div class="col-md-3 mb-3">
            <div class="card text-dark bg-light">
              <div class="card-body">
                <h5 class="card-title">Light card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card text-dark bg-light">
              <div class="card-body">
                <h5 class="card-title">Light card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card text-dark bg-light">
              <div class="card-body">
                <h5 class="card-title">Light card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card text-dark bg-light">
              <div class="card-body">
                <h5 class="card-title">Light card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card text-dark bg-light">
              <div class="card-body">
                <h5 class="card-title">Light card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card text-dark bg-light">
              <div class="card-body">
                <h5 class="card-title">Light card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card text-dark bg-light">
              <div class="card-body">
                <h5 class="card-title">Light card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card text-dark bg-light">
              <div class="card-body">
                <h5 class="card-title">Light card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- Enlace a Bootstrap JS -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</ht