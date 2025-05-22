<?php
// incluimos el archivo de configuracion de la base de datos
require_once 'config.php';

// clase para manejar las operaciones de las tareas
class Tarea {
    // variable para la conexion a la base de datos
    private $pdo;
    
    // constructor de la clase, se conecta a la base de datos
    public function __construct() {
        $db = new DbConfig();
        $this->pdo = $db->getConnection();
    }

    // funcion para leer todas las tareas
    public function leerTareas() {
        try {
            // preparamos la consulta para seleccionar todas las tareas ordenadas por inicio
            $stmt = $this->pdo->prepare("SELECT id, titulo, descripcion, inicio, fin, color FROM tareas ORDER BY inicio");
            $stmt->execute(); // ejecutamos la consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // devolvemos los resultados como un array asociativo
        } catch (PDOException $e) {
            // si hay un error, lo registramos
            error_log("error al leer tareas: " . $e->getMessage());
            return []; // devolvemos un array vacio
        }
    }

    // funcion para crear una nueva tarea
    public function crearTarea($titulo, $inicio, $fin = null, $descripcion = null, $color = null) {
        try {
            // consulta para insertar una nueva tarea
            $sql = "INSERT INTO tareas (titulo, inicio, fin, descripcion, color) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql); // preparamos la consulta
            // ejecutamos la consulta con los parametros
            return $stmt->execute([$titulo, $inicio, $fin, $descripcion, $color]);
        } catch (PDOException $e) {
            // si hay un error, lo registramos
            error_log("error al crear tarea: " . $e->getMessage());
            return false; // devolvemos falso indicando que fallo
        }
    }

    // funcion para actualizar una tarea existente
    public function actualizarTarea($id, $titulo, $inicio, $fin = null, $descripcion = null, $color = null) {
        try {
            // consulta para actualizar una tarea por su id
            $sql = "UPDATE tareas SET titulo = ?, inicio = ?, fin = ?, descripcion = ?, color = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql); // preparamos la consulta
            // ejecutamos la consulta con los parametros
            return $stmt->execute([$titulo, $inicio, $fin, $descripcion, $color, $id]);
        } catch (PDOException $e) {
            // si hay un error, lo registramos
            error_log("error al actualizar tarea: " . $e->getMessage());
            return false; // devolvemos falso indicando que fallo
        }
    }

    // funcion para eliminar una tarea
    public function eliminarTarea($id) {
        try {
            // consulta para eliminar una tarea por su id
            $stmt = $this->pdo->prepare("DELETE FROM tareas WHERE id = ?");
            // ejecutamos la consulta con el id
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            // si hay un error, lo registramos
            error_log("error al eliminar tarea: " . $e->getMessage());
            return false; // devolvemos falso indicando que fallo
        }
    }
}
?>