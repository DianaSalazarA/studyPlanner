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

      <br>
      <div class="container mt-4">
        <div class="row justify-content-center">
          <div class="col-md-3">
            <button id="btn-f" class="btn w-100">Favoritos</button>
          </div>
          <div class="col-md-3">
            <button id="btn-f" class="btn w-100">Pendientes</button>
          </div>
          <div class="col-md-3">
            <button id="btn-f" class="btn w-100">Terminados</button>
          </div>
        </div>
      </div>

      <div class="container mt-4">
        <div class="row">
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Fecha</h5>
                <div class="card" style="width: 100%;"></div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Fecha</h5>
                <div class="card" style="width: 100%;"></div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Fecha</h5>
                <div class="card" style="width: 100%;"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">hora</h5>
                <div class="card" style="width: 100%;"></div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">hora</h5>
                <div class="card" style="width: 100%;"></div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">hora</h5>
                <div class="card" style="width: 100%;"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">año</h5>
                <div class="card" style="width: 100%;"></div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">año</h5>
                <div class="card" style="width: 100%;"></div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">año</h5>
                <div class="card" style="width: 100%;"></div>
              </div>
            </div>
          </div>
        </div>

        <button type="button" id="btn-NT" class="btn btn-category" data-bs-toggle="modal" data-bs-target="#createTaskModal">
          Crear Nueva Tarea
        </button>

        <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="createTaskModalLabel">Crear Nueva Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="mb-3">
                    <label for="taskTitle" class="form-label">Título de la tarea</label>
                    <input type="text" class="form-control" id="taskTitle" placeholder="Ej: Estudiar para el examen">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Color</label>
                    <div class="color-palette">
                      <div class="color-swatch" style="background-color: #a8dadc;"></div>
                      <div class="color-swatch" style="background-color: #fce7f3;"></div>
                      <div class="color-swatch" style="background-color: #ffe8d6;"></div>
                      <div class="color-swatch" style="background-color: #b8f2e6;"></div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="taskDescription" class="form-label">Descripción</label>
                    <textarea class="task-description" id="taskDescription" placeholder="Añade una descripción de la tarea"></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Calendario de Google</label>
                    <div class="google-calendar-container">
                      <iframe src="https://calendar.google.com/calendar/embed?src=TU_CORREO_DE_GMAIL%40gmail.com&ctz=America%2FBogota" class="google-calendar-iframe" frameborder="0" scrolling="no"></iframe>
                    </div>
                    <p class="text-muted small">Este es una vista integrada de tu Calendario de Google. Puedes interactuar con él para seleccionar la fecha.</p>
                  </div>

                  <div class="date-time-container">
                    <div class="calendar-container">
                      <div class="calendar-header">
                        <span class="prev-month">&lt;</span>
                        <span>Abril 2025</span>
                        <span class="next-month">&gt;</span>
                      </div>
                      <div class="calendar-body">
                        <div>D</div>
                        <div>L</div>
                        <div>M</div>
                        <div>X</div>
                        <div>J</div>
                        <div>V</div>
                        <div>S</div>
                        <div></div>
                        <div></div>
                        <div>1</div>
                        <div class="calendar-day">2</div>
                        <div class="calendar-day">3</div>
                        <div class="calendar-day">4</div>
                        <div class="calendar-day active">5</div>
                        <div class="calendar-day">6</div>
                        <div class="calendar-day">7</div>
                        <div class="calendar-day">8</div>
                        <div class="calendar-day">9</div>
                        <div class="calendar-day">10</div>
                        <div class="calendar-day">11</div>
                        <div class="calendar-day">12</div>
                        <div class="calendar-day">13</div>
                        <div class="calendar-day">14</div>
                        <div class="calendar-day">15</div>
                        <div class="calendar-day">16</div>
                        <div class="calendar-day">17</div>
                        <div class="calendar-day">18</div>
                        <div class="calendar-day">19</div>
                        <div class="calendar-day">20</div>
                        <div class="calendar-day">21</div>
                        <div class="calendar-day">22</div>
                        <div class="calendar-day">23</div>
                        <div class="calendar-day">24</div>
                        <div class="calendar-day">25</div>
                        <div class="calendar-day">26</div>
                        <div class="calendar-day">27</div>
                        <div class="calendar-day">28</div>
                        <div class="calendar-day">29</div>
                        <div class="calendar-day">30</div>
                      </div>
                    </div>
                    <div class="time-selector">
                      <label class="form-label">Hora</label>
                      <div class="time-input-group">
                        <input type="number" class="form-control time-input" id="hour" min="1" max="12" placeholder="H">
                        <span>:</span>
                        <input type="number" class="form-control time-input" id="minute" min="0" max="59" placeholder="M">
                        <select class="form-select form-select-sm" id="amPm">
                          <option value="am">AM</option>
                          <option value="pm" selected>PM</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary">+ Añadir</button>
              </div>
            </div>
          </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../js/tasks.js"></script>

</body>

</html>