<?php
$hashObjetivo = 'fda8ac3e2d2f436ee0619f3f4579efe5a13870eb71707d9339761d0b5eaa3d19';
$archivo = fopen("rockyou.txt", "r");

if ($archivo) {
    while (($linea = fgets($archivo)) !== false) {
        $linea = trim($linea);
        if (hash('sha256', $linea) === $hashObjetivo) {
            echo "Contraseña encontrada: $linea\n";
            break;
        }
    }
    fclose($archivo);
} else {
    echo "Error al abrir el archivo.";
}
?>