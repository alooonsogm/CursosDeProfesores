<?php
session_start();

$nombre = $_SESSION['nombre'];
$esAdmin = $_SESSION['esAdmin'];
$apellidos = $_SESSION['apellidos'];

if (isset($nombre)) {
    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Gestion Cursos</title>";
    echo "<link rel='stylesheet' href='estilo.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<button><a href='index.php?cerrar_sesion=1'>Cerrar sesion</a></button><br>";
    $cerrar = $_GET['cerrar_sesion'];
    if (isset($cerrar)) {
        $_SESSION = array();
        setcookie('PHPSESSID', '', time() - 3600);
        session_destroy();
        header("Location: index.php");
    }
    echo "<h1>Bienvenido, " . $nombre . " " . $apellidos . "</h1>";
    if ($esAdmin == 1) {
        echo "<p>Permisos de Administrador</p>";
        echo "<button><a href='activarDesactivarCursos.php'>Activar/Desactivar Cursos</a></button>";
        echo "<button><a href='incorporarCursos.php'>Incorporar cursos</a></button>";
        echo "<button><a href='eliminarCursos.php'>Eliminar cursos</a></button>";
        echo "<button><a href='baremacionDeCursos.php'>Asignar plazas de cursos</a></button>";
    }
    echo "<p>Ver cursos disponibles para ti</p>";
    echo "<button><a href='listadoDeCursos.php'>Ver Cursos</a></button>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
} else {
    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Gestion Cursos</title>";
    echo "<link rel='stylesheet' href='estilo.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<button><a href='iniciarSesion.php'>Iniciar Sesion</a></button>";
    echo "<h1>Gestion de cursos para Profesores</h1>";
    echo "<p>Ver cursos disponibles ahora mismo para ti</p>";
    echo "<button><a href='listadoDeCursos.php'>Ver Cursos</a></button>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
}
