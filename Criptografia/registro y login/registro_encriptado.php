<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'test_db';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener datos sin sanitizar (¡para propósitos de prueba!)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash SHA-256 de la contraseña
    $hashed_password = hash('sha256', $password);

    // Verificar si el usuario ya existe (usando consultas preparadas)
    $stmt_check = $conn->prepare("SELECT username FROM usuarios WHERE username = ?");
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        die("El usuario ya existe.");
    }

    // Insertar usuario con contraseña hasheada
    $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        echo "Usuario <strong>" . htmlspecialchars($username) . "</strong> registrado. <a href='index_encriptado.html'>Inicia sesión</a>";
    } else {
        echo "Error al registrar: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
} else {
    header('Location: registro.html');
    exit();
}
?>