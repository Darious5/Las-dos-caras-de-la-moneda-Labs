<?php
// Configuración de la base de datos
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'test_db';

// Crear conexión
$conn = new mysqli($host, $user, $pass);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Crear base de datos
$sql = "CREATE DATABASE IF NOT EXISTS $db_name";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos creada correctamente.<br>";
} else {
    die("Error al crear base de datos: " . $conn->error);
}

// Seleccionar la base de datos
$conn->select_db($db_name);

// Crear tabla de usuarios
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabla 'usuarios' creada correctamente.<br>";
} else {
    die("Error al crear tabla: " . $conn->error);
}

// Datos de ejemplo (20 usuarios)
$users = [
    ['admin', 'P@ssw0rd123!'],
    ['juan.perez', 'Ju4nP3r3z#'],
    ['maria.garcia', 'M4r14G4rc14!'],
    ['pablo.martin', 'P4bl0_2023'],
    ['laura.sanchez', 'L4ur4S4nch3z'],
    ['usuario6', 'pass123'],
    ['test.user', 'Test1234'],
    ['hack.me', 'InsecurePass'],
    ['empleado1', 'Empl3ad0_01'],
    ['invitado', 'Guest123!'],
    ['sysadmin', 'S3cur3P4$$'],
    ['webmaster', 'W3bM4st3r!'],
    ['user13', 'SimplePassword'],
    ['john.doe', 'DoeJ0hn!'],
    ['ana.torres', 'Torr3sA#'],
    ['miguel.angel', 'M1gu3l2023'],
    ['sara.rosa', 'R0s4S4r4!'],
    ['david.boss', 'B0ssD4v1d'],
    ['info', '1nf0S3cr3t'],
    ['root.user', 'R00t.P4ss!']
];

// Insertar usuarios
$stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);

$count = 0;
foreach ($users as $user) {
    $username = $user[0];
    $password = $user[1];
    
    if ($stmt->execute()) {
        $count++;
    } else {
        echo "Error insertando usuario $username: " . $conn->error . "<br>";
    }
}

echo "Se insertaron $count usuarios correctamente.<br>";

$stmt->close();
$conn->close();
?>