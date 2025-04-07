<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS, GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once './config.php'; 

error_log("PHP script ejecutándose..."); 

class Register {
    private $db;

    public function __construct() {
        $dbConfig = new DbConfig();
        $this->db = $dbConfig->getConnection();
    }

    public function registerUser($username, $name, $lastname, $email, $password, $role) {
        error_log("Entrando en registerUser() con datos: " . json_encode([$username, $name, $email, $password, $role]));

        if (empty($username)  || empty($name) || empty($lastname) || empty($email) || empty($password)  || empty($role)  ) {
            echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios" . "username--> " .$username ." name --> ". $name . "email --> " .$email . "password --> " . $password . "rol --> " . $role]);
            return; 
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "error", "message" => "Correo electrónico inválido"]);
            return;
        }

        
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "error", "message" => "El correo ya está registrado"]);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertSql = "INSERT INTO users (username, name, last_name, email, password, role_id, status)
                                 VALUES (:username, :name, :last_name, :email, :password, :role_id, 'Active')";
        $insertStmt = $this->db->prepare($insertSql);
        $insertStmt->bindParam(':username', $username);
        $insertStmt->bindParam(':name', $name);
        $insertStmt->bindParam(':last_name', $lastname);
        $insertStmt->bindParam(':email', $email);
        $insertStmt->bindParam(':password', $hashedPassword);
        $insertStmt->bindParam(':role_id', $role);

        if ($insertStmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Registro exitoso"]);
        } else {
            error_log("Error en SQL: " . json_encode($insertStmt->errorInfo()));
            echo json_encode(["status" => "error", "message" => "Error al registrar usuario"]);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
   /*  data: { username: username, email:email, password: password },

 */

 //data: { username: username, name: name, email:email, password: password , role:role},

    $username = $_POST['username'] ?? null;
    $name = $_POST['name'] ?? null;
    $lastname = $_POST['lastname'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $role = $_POST['role'] ?? null;
/* 
    echo json_encode(["status" => "ok", "message" => $password  ]);
        exit; */

    $register = new Register();
    $register->registerUser($username, $name, $lastname,   $email, $password, $role );
}
?>