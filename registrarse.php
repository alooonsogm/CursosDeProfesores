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

if ($enviar != "Registrarse") {
    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Registro</title>";
    echo "<link rel='stylesheet' href='estilo.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h1>Registro de solicitantes</h1>";
    echo "<form action='registrarse.php' method='post'>";
    pintaValores("Nombre", "nombre");
    echo "<br>";
    pintaValores("Apellidos", "apellidos");
    echo "<br>";
    pintaValores("DNI", "dni");
    echo "<br>";
    echo "Telefono: <input type='number' name='telefono'>";
    echo "<br><br><br>";
    pintaValores("Correo electronico", "correo");
    echo "<br>";
    echo "Codigo del centro: <input type='text' name='codcentro' placeholder='Ejemplo: CT001'>";
    echo "<br><br><br>";
    echo "<label>Coordinador TIC:</label>";
    echo "<br>";
    echo "<input type='radio' name='coor' value='1'>Si";
    echo "<input type='radio' name='coor' value='0'>No";
    echo "<br><br><br>";
    echo "<label>Grupo TIC:</label>";
    echo "<br>";
    echo "<input type='radio' name='grupo' value='1'>Si";
    echo "<input type='radio' name='grupo' value='0'>No";
    echo "<br><br><br>";
    echo "Nombre grupo: <input type='text' name='nombgrupo' placeholder='Ejemplo: G1'>";
    echo "<br><br><br>";
    echo "<label>Bilingue:</label>";
    echo "<br>";
    echo "<input type='radio' name='bilin' value='1'>Si";
    echo "<input type='radio' name='bilin' value='0'>No";
    echo "<br><br><br>";
    echo "<label>Cargo:</label>";
    echo "<br>";
    echo "<input type='radio' name='cargo' value='1'>Si";
    echo "<input type='radio' name='cargo' value='0'>No";
    echo "<br><br><br>";
    echo "Nombre cargo: <input type='text' name='nombcargo'>";
    echo "<br><br><br>";
    echo "<label>Situacion:</label>";
    echo "<br>";
    echo "<select name='situacion'>";
    echo "<option value='activo'>activo</option>";
    echo "<option value='inactivo'>inactivo</option>";
    echo "</select>";
    echo "<br><br><br>";
    echo "Fecha de nacimiento: <input type='date' name='fecha'>";
    echo "<br><br><br>";
    echo "Especialidad: <input type='text' name='especialidad'>";
    echo "<br><br><br>";
    echo "Contraseña: <input type='text' name='pass'>";
    echo "<br><br><br>";
    echo "<input type='submit' name='enviar' value='Registrarse'>";
    echo "</form>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
} else {
    $contador = 0;
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $codcentro = $_POST['codcentro'];
    $coor = $_POST['coor'];
    $grupo = $_POST['grupo'];
    $nombgrupo = $_POST['nombgrupo'];
    $bilin = $_POST['bilin'];
    $cargo = $_POST['cargo'];
    $nombcargo = $_POST['nombcargo'];
    $situacion = $_POST['situacion'];
    $fecha = new DateTime($_POST['fecha']);
    $laFecha = $fecha->format("Y-m-d");
    $especialidad = $_POST['especialidad'];
    $pass = $_POST['pass'];

    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Registro</title>";
    echo "<link rel='stylesheet' href='estilo.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h1>Registro de solicitantes</h1>";
    echo "<form action='registrarse.php' method='post'>";
    validaVacios("Nombre", $nombre, "nombre", $contador);
    echo "<br>";
    validaVacios("Apellidos", $apellidos, "apellidos", $contador);
    echo "<br>";
    validaVacios("DNI", $dni, "dni", $contador);
    echo "<br>";
    validaVacios("Telefono", $telefono, "telefono", $contador);
    echo "<br>";
    validaVacios("Correo electronico", $correo, "correo", $contador);
    echo "<br>";
    validaVacios("Codigo del centro", $codcentro, "codcentro", $contador);
    echo "<br>";
    echo "<label>Coordinador TIC:</label>";
    echo "<br>";
    if ($coor == "1") {
        echo "<input type='radio' name='coor' value='1' checked>Si";
        echo "<input type='radio' name='coor' value='0'>No";
    } else if ($coor == "0") {
        echo "<input type='radio' name='coor' value='1'>Si";
        echo "<input type='radio' name='coor' value='0' checked>No";
    } else {
        echo "<input type='radio' name='coor' value='1'>Si";
        echo "<input type='radio' name='coor' value='0'>No";
    }
    echo "<br><br><br>";
    echo "<label>Grupo TIC:</label>";
    echo "<br>";
    if ($grupo == "1") {
        echo "<input type='radio' name='grupo' value='1' checked>Si";
        echo "<input type='radio' name='grupo' value='0>No";
    } else if ($grupo == "0") {
        echo "<input type='radio' name='grupo' value='1'>Si";
        echo "<input type='radio' name='grupo' value='0'checked>No";
    } else {
        echo "<input type='radio' name='grupo' value='1'>Si";
        echo "<input type='radio' name='grupo' value='0'>No";
    }
    echo "<br><br><br>";
    validaVacios("Nombre grupo", $nombgrupo, "nombgrupo", $contador);
    echo "<br>";
    echo "<label>Bilingue:</label>";
    echo "<br>";
    if ($bilin == "1") {
        echo "<input type='radio' name='bilin' value='1' checked>Si";
        echo "<input type='radio' name='bilin' value='0'>No";
    } else if ($bilin == "0") {
        echo "<input type='radio' name='bilin' value='1'>Si";
        echo "<input type='radio' name='bilin' value='0'checked>No";
    } else {
        echo "<input type='radio' name='bilin' value='1'>Si";
        echo "<input type='radio' name='bilin' value='0'>No";
    }
    echo "<br><br><br>";
    echo "<label>Cargo:</label>";
    echo "<br>";
    if ($cargo == "1") {
        echo "<input type='radio' name='cargo' value='1' checked>Si";
        echo "<input type='radio' name='cargo' value='0'>No";
    } else if ($cargo == "0") {
        echo "<input type='radio' name='cargo' value='1'>Si";
        echo "<input type='radio' name='cargo' value='0'checked>No";
    } else {
        echo "<input type='radio' name='cargo' value='1'>Si";
        echo "<input type='radio' name='cargo' value='0'>No";
    }
    echo "<br><br><br>";
    validaVacios("Nombre cargo", $nombcargo, "nombcargo", $contador);
    echo "<br>";
    echo "<label>Situacion:</label>";
    echo "<br>";

    if ($situacion == "activo") {
        echo "<select name='situacion'>";
        echo "<option value='activo' selected>activo</option>";
        echo "<option value='inactivo'>inactivo</option>";
        echo "</select>";
    } else {
        echo "<select name='situacion'>";
        echo "<option value='activo'>activo</option>";
        echo "<option value='inactivo' selected>inactivo</option>";
        echo "</select>";
    }
    echo "<br><br><br>";
    echo "Fecha de nacimiento: <input type='date' name='fecha'>";
    echo "<br><br><br>";
    validaVacios("Especialidad", $especialidad, "especialidad", $contador);
    echo "<br>";
    validaVacios("Contraseña", $pass, "pass", $contador);
    echo "<br>";
    echo "<input type='submit' name='enviar' value='Registrarse'>";
    echo "</form>";
    echo "</div>";
    echo "</body>";
    echo "</html>";

    try {
        if ($contador == 10) {
            $puntos = 0;
            if ($coor == true) {
                $puntos = $puntos + 4;
            }
            if ($grupo == true) {
                $puntos = $puntos + 3;
            }
            if ($bilin == true) {
                $puntos = $puntos + 3;
            }
            if ($cargo == true) {
                $puntos = $puntos + 2;
            }
            if ($situacion == "activo") {
                $puntos = $puntos + 1;
            }

            $enlace = new PDO('mysql:host=127.0.0.1; dbname=cursoscp', "root", "root");
            $enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consulta = "INSERT INTO solicitantes (dni, apellidos, nombre, telefono, correo, codigocentro, coordinadortc, grupotc, nombregrupo, 
                                    pbilin, cargo, nombrecargo, situacion, fechanac, especialidad, puntos, password, admin
                                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $resultado = $enlace->prepare($consulta);

            $resultado->bindValue(1, $dni);
            $resultado->bindValue(2, $apellidos);
            $resultado->bindValue(3, $nombre);
            $resultado->bindValue(4, $telefono);
            $resultado->bindValue(5, $correo);
            $resultado->bindValue(6, $codcentro);
            $resultado->bindValue(7, $coor);
            $resultado->bindValue(8, $grupo);
            $resultado->bindValue(9, $nombgrupo);
            $resultado->bindValue(10, $bilin);
            $resultado->bindValue(11, $cargo);
            $resultado->bindValue(12, $nombcargo);
            $resultado->bindValue(13, $situacion);
            $resultado->bindValue(14, $laFecha);
            $resultado->bindValue(15, $especialidad);
            $resultado->bindValue(16, $puntos);
            $resultado->bindValue(17, $pass);
            $resultado->bindValue(18, 0);
            $resultado->execute();

            $_SESSION['nombre'] = $nombre;
            $_SESSION['apellidos'] = $apellidos;
            $_SESSION['esAdmin'] = 0;
            $_SESSION['dni'] = $dni;
            header("Location: index.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
