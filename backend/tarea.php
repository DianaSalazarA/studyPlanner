<?php
require_once 'config.php';

class Tarea {
    private $pdo;
    
    public function __construct() {
        $db = new DbConfig();
        $this->pdo = $db->getConnection();
    }

    public function leerTareas() {
        try {
            $stmt = $this->pdo->prepare("SELECT id, titulo, descripcion, inicio, fin, color FROM tareas ORDER BY inicio");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al leer tareas: " . $e->getMessage());
            return [];
        }
    }

    public function crearTarea($titulo, $inicio, $fin = null, $descripcion = null, $color = null) {
        try {
            $sql = "INSERT INTO tareas (titulo, inicio, fin, descripcion, color) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$titulo, $inicio, $fin, $descripcion, $color]);
        } catch (PDOException $e) {
            error_log("Error al crear tarea: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarTarea($id, $titulo, $inicio, $fin = null, $descripcion = null, $color = null) {
        try {
            $sql = "UPDATE tareas SET titulo = ?, inicio = ?, fin = ?, descripcion = ?, color = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$titulo, $inicio, $fin, $descripcion, $color, $id]);
        } catch (PDOException $e) {
            error_log("Error al actualizar tarea: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarTarea($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM tareas WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error al eliminar tarea: " . $e->getMessage());
            return false;
        }
    }
}
?>