<?php
// Habilitar reporte de errores para depuración (quitar en producción)
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

    // Obtener datos del formulario
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // CONSULTA PREPARADA (Segura contra SQLi)
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        echo "¡Login exitoso! Bienvenido, " . htmlspecialchars($user_data['username']);
    } else {
        echo "Credenciales incorrectas.";
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: index.html');
    exit();
}
?>