<?php
require_once 'tarea.php';

$tarea = new Tarea();
$accion = $_GET['accion'] ?? $_POST['accion'] ?? null;

header('Content-Type: application/json');

try {
    switch ($accion) {
        case 'leer':
            $tareas = $tarea->leerTareas();
            $eventos = array_map(function($tarea) {
                return [
                    'id' => $tarea['id'],
                    'title' => $tarea['titulo'],
                    'start' => $tarea['inicio'],
                    'end' => $tarea['fin'],
                    'description' => $tarea['descripcion'],
                    'color' => $tarea['color'] ?: '#a7f3d0',
                    'allDay' => true,
                    'extendedProps' => [
                        'description' => $tarea['descripcion'],
                        'color' => $tarea['color'] ?: '#a7f3d0'
                    ]
                ];
            }, $tareas);
            echo json_encode($eventos);
            break;
            
        case 'crear':
            $titulo = $_POST['titulo'] ?? null;
            $inicio = $_POST['inicio'] ?? null;
            $fin = $_POST['fin'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $color = $_POST['color'] ?? '#a7f3d0';

            if (!$titulo || !$inicio) {
                throw new Exception('Título e inicio son obligatorios');
            }

            if ($tarea->crearTarea($titulo, $inicio, $fin, $descripcion, $color)) {
                echo json_encode(['status' => 'ok', 'mensaje' => 'Tarea creada exitosamente']);
            } else {
                throw new Exception('Error al crear la tarea');
            }
            break;
            
        case 'actualizar':
            $id = $_POST['id'] ?? null;
            $titulo = $_POST['titulo'] ?? null;
            $inicio = $_POST['inicio'] ?? null;
            $fin = $_POST['fin'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $color = $_POST['color'] ?? '#a7f3d0';

            if (!$id || !$titulo || !$inicio) {
                throw new Exception('ID, título e inicio son obligatorios');
            }

            if ($tarea->actualizarTarea($id, $titulo, $inicio, $fin, $descripcion, $color)) {
                echo json_encode(['status' => 'ok', 'mensaje' => 'Tarea actualizada exitosamente']);
            } else {
                throw new Exception('Error al actualizar la tarea');
            }
            break;
            
        case 'eliminar':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new Exception('ID de tarea no proporcionado');
            }

            if ($tarea->eliminarTarea($id)) {
                echo json_encode(['status' => 'ok', 'mensaje' => 'Tarea eliminada exitosamente']);
            } else {
                throw new Exception('Error al eliminar la tarea');
            }
            break;
            
        default:
            throw new Exception('Acción no válida');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'mensaje' => $e->getMessage()]);
}
?>