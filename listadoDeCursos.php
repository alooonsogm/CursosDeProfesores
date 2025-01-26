<?php
session_start();
$boton = $_POST['enviar'];

try {
    if ($boton != "Enviar Inscripcion") {
        $enlace = new PDO('mysql:host=127.0.0.1; dbname=cursoscp', "root", "root");
        $enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "select * from cursos where abierto = 1";
        $resultado = $enlace->query($consulta);

        echo "<!DOCTYPE html>";
        echo "<html lang='es'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Listado de Cursos</title>";
        echo "<link rel='stylesheet' href='estilo.css'>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h1>Cursos Disponibles</h1>";
        echo "<button><a href='index.php'>Volver</a></button>";
        echo "<form action='listadoDeCursos.php' method='post'>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Codigo</th>";
        echo "<th>Nombre</th>";
        echo "<th>Abierto</th>";
        echo "<th>Numero de plazas</th>";
        echo "<th>Plazo de Inscripcion</th>";
        echo "<th>Inscribir</th></tr>";
        echo "</tr>";

        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($fila as $value) {
                echo "<td>$value</td>";
            }
            echo "<td><input type='checkbox' name='cursos[]' value=$fila[codigo]></td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<input type='submit' name='enviar' value='Enviar Inscripcion'>";
        echo "</form>";
        echo "</div>";
        echo "</body>";
        echo "</html>";
    } else {
        $cursos = $_POST['cursos'] ?? [];
        $dni = $_SESSION['dni'];
        $enlace = new PDO('mysql:host=127.0.0.1; dbname=cursoscp', "root", "root");
        $enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (!isset($dni)) {
            header("Location: iniciarSesion.php");
        }

        echo "<!DOCTYPE html>";
        echo "<html lang='es'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Listado de Cursos</title>";
        echo "<link rel='stylesheet' href='estilo.css'>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h1>Inscripcion a Cursos</h1>";
        echo "<button><a href='listadoDeCursos.php'>Volver a Inscripciones</a></button>";

        if (count($cursos) != 1) {
            echo "<p style='color: red'>Debes seleccionar exactamente un curso</p>";
        } else {
            foreach ($cursos as $codigoCurso) {
                $fecha = date("Y-m-d");
                $stmt = $enlace->prepare("INSERT INTO solicitudes (dni, codigocurso, fechasolicitud) VALUES (?, ?, ?)");
                $stmt->bindValue(1, $dni);
                $stmt->bindValue(2, $codigoCurso);
                $stmt->bindValue(3, $fecha);
                $stmt->execute();

                echo "<table>";
                echo "<tr>";
                echo "<th>Codigo</th>";
                echo "<th>Nombre</th>";
                echo "<th>Abierto</th>";
                echo "<th>Numero de plazas</th>";
                echo "<th>Plazo de Inscripcion</th>";
                echo "</tr>";

                $consulta2 = 'select * from cursos where abierto = 1 and codigo =' . $codigoCurso;
                $resultado2 = $enlace->query($consulta2);
                while ($fila = $resultado2->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    foreach ($fila as $value) {
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                }
            }

            echo "</table>";
            echo "<p style='color: green'>Se ha solicitado la inscripcion exitosamente</p>";
        }
        echo "</div>";
        echo "</body>";
        echo "</html>";
    }
} catch (PDOException $e) {
    echo "<p style='color: red'>Ya has solicitado inscripcion a este curso</p>";
}
