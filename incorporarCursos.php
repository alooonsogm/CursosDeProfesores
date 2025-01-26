<?php
session_start();

function pintaValores($tituloInput, $nombreInput)
{
    echo "$tituloInput: <input type='text' name='$nombreInput'>";
    echo "<br><br>";
}

function validaVacios($tituloInput, $variable, $nombreInput, &$contadorParam)
{
    if (!empty($variable)) {
        echo "$tituloInput: <input type='text' name='$nombreInput' value='$variable'>";
        echo "<br>";
        echo "<small style='color: green'>Campo relleno</small>";
        echo "<br>";
        $contadorParam++;
    } else {
        echo "$tituloInput: <input type='text' name='$nombreInput'>";
        echo "<br>";
        echo "<small style='color: red'>Campo vacio</small>";
        echo "<br>";
    }
}

$enviar = $_POST['enviar'];

if ($enviar != "Insertar curso") {
    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Incorporar Cursos</title>";
    echo "<link rel='stylesheet' href='estilo.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h1>Incorporar Cursos</h1>";
    echo "<form action='incorporarCursos.php' method='post'>";
    pintaValores("Nombre", "nombre");
    echo "<br>";
    echo "<label>Abierto:</label>";
    echo "<br>";
    echo "<input type='radio' name='abierto' value='1'>Si";
    echo "<input type='radio' name='abierto' value='0'>No";
    echo "<br><br><br>";
    pintaValores("Numero de plazas", "plazas");
    echo "<br>";
    echo "Plazo inscripcion: <input type='date' name='plazo'>";
    echo "<br><br><br>";
    echo "<input type='submit' name='enviar' value='Insertar curso'>";
    echo "</form>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
} else {
    $nombre = $_POST['nombre'];
    $abierto = $_POST['abierto'];
    $plazas = $_POST['plazas'];
    $plazo = $_POST['plazo'];
    $contador = 0;

    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Incorporar Cursos</title>";
    echo "<link rel='stylesheet' href='estilo.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h1>Incorporar Cursos</h1>";
    echo "<form action='incorporarCursos.php' method='post'>";
    validaVacios("Nombre", $nombre, "nombre", $contador);
    echo "<br>";
    echo "<label>Abierto:</label>";
    echo "<br>";
    if ($abierto == "1") {
        echo "<input type='radio' name='abierto' value='1' checked>Si";
        echo "<input type='radio' name='abierto' value='0'>No";
    } else if ($abierto == "0") {
        echo "<input type='radio' name='abierto' value='1'>Si";
        echo "<input type='radio' name='abierto' value='0' checked>No";
    } else {
        echo "<input type='radio' name='abierto' value='1'>Si";
        echo "<input type='radio' name='abierto' value='0'>No";
    }
    echo "<br><br><br>";
    validaVacios("Numero de plazas", $plazas, "plazas", $contador);
    echo "<br>";
    echo "Plazo inscripcion: <input type='date' name='plazo'>";
    echo "<br><br><br>";

    try {
        if ($contador == 2) {
            $enlace = new PDO('mysql:host=127.0.0.1; dbname=cursoscp', "root", "root");
            $enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consulta = "INSERT INTO cursos (nombre, abierto, numeroplazas, plazoinscripcion) VALUES (?, ?, ?, ?)";
            $resultado = $enlace->prepare($consulta);

            $resultado->bindValue(1, $nombre);
            $resultado->bindValue(2, $abierto);
            $resultado->bindValue(3, $plazas);
            $resultado->bindValue(4, $plazo);
            $resultado->execute();

            echo "<p>Curso insertado exitosamente</p>";
            echo "<button><a href='index.php'>Volver</a></button>";
        } else {
            echo "<input type='submit' name='enviar' value='Insertar curso'>";
            echo "</form>";
        }
    } catch (PDOException $e) {
        echo "<input type='submit' name='enviar' value='Insertar curso'>";
        echo "</form>";
    }
    echo "</div>";
    echo "</body>";
    echo "</html>";
}
