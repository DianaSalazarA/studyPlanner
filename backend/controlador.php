<?php
// aqui incluimos el archivo de la clase tarea, que es la que sabe hablar con la base de datos
require_once 'tarea.php';

// creamos un objeto de la clase tarea para poder usar sus funciones
$tarea = new Tarea();
// intentamos obtener la 'accion' que nos piden (leer, crear, etc.)
// puede venir por GET (si es en la url) o por POST (si es un formulario)
$accion = $_GET['accion'] ?? $_POST['accion'] ?? null;

// le decimos al navegador que lo que vamos a responder es en formato json
header('Content-Type: application/json');

try {
    // usamos un "switch" para ver que accion nos pidieron
    switch ($accion) {
        case 'leer':
            // si la accion es 'leer', traemos todas las tareas de la base de datos
            $tareas = $tarea->leerTareas();
            // y las transformamos a un formato que el calendario entienda (fullcalendar lo necesita asi)
            $eventos = array_map(function($tarea) {
                return [
                    'id' => $tarea['id'],
                    'title' => $tarea['titulo'],
                    'start' => $tarea['inicio'],
                    'end' => $tarea['fin'],
                    'description' => $tarea['descripcion'],
                    'color' => $tarea['color'] ?: '#a7f3d0', // si no tiene color, le ponemos uno por defecto
                    'allDay' => true, // para que se muestren como eventos de todo el dia
                    'extendedProps' => [ // propiedades extras para usar en el javascript
                        'description' => $tarea['descripcion'],
                        'color' => $tarea['color'] ?: '#a7f3d0'
                    ]
                ];
            }, $tareas);
            // enviamos los eventos en formato json
            echo json_encode($eventos);
            break;
            
        case 'crear':
            // si la accion es 'crear', obtenemos los datos de la nueva tarea
            $titulo = $_POST['titulo'] ?? null;
            $inicio = $_POST['inicio'] ?? null;
            $fin = $_POST['fin'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $color = $_POST['color'] ?? '#a7f3d0'; // color por defecto

            // verificamos que el titulo y la fecha de inicio no esten vacios
            if (!$titulo || !$inicio) {
                throw new Exception('titulo e inicio son obligatorios');
            }

            // intentamos crear la tarea en la base de datos
            if ($tarea->crearTarea($titulo, $inicio, $fin, $descripcion, $color)) {
                // si se creo bien, enviamos un mensaje de exito
                echo json_encode(['status' => 'ok', 'mensaje' => 'tarea creada exitosamente']);
            } else {
                // si hubo un error, lanzamos una excepcion
                throw new Exception('error al crear la tarea');
            }
            break;
            
        case 'actualizar':
            // si la accion es 'actualizar', obtenemos todos los datos para actualizar la tarea
            $id = $_POST['id'] ?? null;
            $titulo = $_POST['titulo'] ?? null;
            $inicio = $_POST['inicio'] ?? null;
            $fin = $_POST['fin'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $color = $_POST['color'] ?? '#a7f3d0'; // color por defecto

            // verificamos que el id, titulo y fecha de inicio no esten vacios
            if (!$id || !$titulo || !$inicio) {
                throw new Exception('id, titulo e inicio son obligatorios');
            }

            // intentamos actualizar la tarea en la base de datos
            if ($tarea->actualizarTarea($id, $titulo, $inicio, $fin, $descripcion, $color)) {
                // si se actualizo bien, enviamos un mensaje de exito
                echo json_encode(['status' => 'ok', 'mensaje' => 'tarea actualizada exitosamente']);
            } else {
                // si hubo un error, lanzamos una excepcion
                throw new Exception('error al actualizar la tarea');
            }
            break;
            
        case 'eliminar':
            // si la accion es 'eliminar', obtenemos el id de la tarea a borrar
            $id = $_POST['id'] ?? null;
            // verificamos que el id no este vacio
            if (!$id) {
                throw new Exception('id de tarea no proporcionado');
            }

            // intentamos eliminar la tarea de la base de datos
            if ($tarea->eliminarTarea($id)) {
                // si se elimino bien, enviamos un mensaje de exito
                echo json_encode(['status' => 'ok', 'mensaje' => 'tarea eliminada exitosamente']);
            } else {
                // si hubo un error, lanzamos una excepcion
                throw new Exception('error al eliminar la tarea');
            }
            break;
            
        default:
            // si la accion no es ninguna de las anteriores, es una accion no valida
            throw new Exception('accion no valida');
    }
} catch (Exception $e) {
    // si ocurre alguna excepcion (error), enviamos un codigo de error http (400)
    http_response_code(400);
    // y enviamos un mensaje de error en formato json
    echo json_encode(['status' => 'error', 'mensaje' => $e->getMessage()]);
}
?>