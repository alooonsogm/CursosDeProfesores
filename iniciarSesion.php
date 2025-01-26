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

if ($enviar != "Inciar sesion") {
    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Inicio de Sesion</title>";
    echo "<link rel='stylesheet' href='estilo.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h1>Inicio de Sesion</h1>";
    echo "<form action='iniciarSesion.php' method='post'>";
    pintaValores("DNI", "dni");
    echo "<br>";
    pintaValores("Contraseña", "pass");
    echo "<br>";
    echo "<input type='submit' name='enviar' value='Inciar sesion'>";
    echo "<button><a href='registrarse.php'>Registrarse</a></button>";
    echo "</form>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
} else {
    $dni = $_POST['dni'];
    $pass = $_POST['pass'];
    $contador = 0;

    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Inicio de Sesion</title>";
    echo "<link rel='stylesheet' href='estilo.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h1>Inicio de Sesion</h1>";
    echo "<form action='iniciarSesion.php' method='post'>";
    validaVacios("DNI", $dni, "dni", $contador);
    echo "<br>";
    validaVacios("Contraseña", $pass, "pass", $contador);
    echo "<br>";
    echo "<input type='submit' name='enviar' value='Inciar sesion'>";

    try {
        $enlace = new PDO('mysql:host=127.0.0.1; dbname=cursoscp', "root", "root");
        $enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "select * from solicitantes";
        $resultado = $enlace->query($consulta);

        if ($contador == 2 && $resultado->rowCount() > 0) {
            $encontrado = false;
            while ($fila = $resultado->fetch(PDO::FETCH_BOTH)) {
                $dni2 = $fila[0];
                $pass2 = $fila[16];
                $esAdminis = $fila[17];
                $nombre = $fila[2];
                $apellidos = $fila[1];
                if ($dni2 == $dni && $pass == $pass2) {
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['apellidos'] = $apellidos;
                    $_SESSION['esAdmin'] = $esAdminis;
                    $_SESSION['dni'] = $dni2;
                    header("Location: index.php");
                }
            }
            if (!$encontrado) {
                echo "<p style='color: red'>Usuario o contraseña incorrectos</p>";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    echo "<button><a href='registrarse.php'>Registrarse</a></button>";
    echo "</form>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
}
