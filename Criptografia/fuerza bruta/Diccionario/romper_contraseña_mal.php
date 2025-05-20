<?php
$hashObjetivo = '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4';
$diccionario = file('rockyou.txt', FILE_IGNORE_NEW_LINES);

foreach ($diccionario as $linea) {
    $linea = trim($linea);
    if (hash('sha256', $linea) === $hashObjetivo) {
        echo "Contraseña encontrada: $linea\n";
        break;
    }
}
?>