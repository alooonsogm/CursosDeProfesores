<?php
session_start();
$boton = $_POST['enviar'];

try {
    if ($boton != "Eliminar cursos") {
        $enlace = new PDO('mysql:host=127.0.0.1; dbname=cursoscp', "root", "root");
        $enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "select * from cursos";
        $resultado = $enlace->query($consulta);

        echo "<!DOCTYPE html>";
        echo "<html lang='es'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Eliminar cursos</title>";
        echo "<link rel='stylesheet' href='estilo.css'>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h1>Eliminar cursos</h1>";
        echo "<button><a href='index.php'>Volver</a></button>";
        echo "<form action='eliminarCursos.php' method='post'>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Codigo</th>";
        echo "<th>Nombre</th>";
        echo "<th>Abierto</th>";
        echo "<th>Numero de plazas</th>";
        echo "<th>Plazo de Inscripcion</th>";
        echo "<th>Eliminar</th></tr>";
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
        echo "<input type='submit' name='enviar' value='Eliminar cursos'>";
        echo "</form>";
        echo "</div>";
        echo "</body>";
        echo "</html>";
    } else {
        $cursos = $_POST['cursos'] ?? [];
        $enlace = new PDO('mysql:host=127.0.0.1; dbname=cursoscp', "root", "root");
        $enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "<!DOCTYPE html>";
        echo "<html lang='es'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Eliminar cursos</title>";
        echo "<link rel='stylesheet' href='estilo.css'>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h1>Eliminar cursos</h1>";
        echo "<button><a href='eliminarCursos.php'>Volver a eliminar cursos</a></button>";

        if (count($cursos) == 0) {
            echo "<p style='color: red'>Debes seleccionar al menos un curso para eliminar</p>";
        } else {
            echo "<table>";
            echo "<tr>";
            echo "<th>Codigo</th>";
            echo "<th>Nombre</th>";
            echo "<th>Abierto</th>";
            echo "<th>Numero de plazas</th>";
            echo "<th>Plazo de Inscripcion</th>";
            echo "</tr>";

            foreach ($cursos as $codigoCurso) {
                $consulta2 = "select * from cursos where codigo = ?";
                $resultado2 = $enlace->prepare($consulta2);
                $resultado2->bindValue(1, $codigoCurso);
                $resultado2->execute();
                while ($fila = $resultado2->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    foreach ($fila as $value) {
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                }

                $stmt2 = $enlace->prepare("Delete from solicitudes where codigocurso = ?");
                $stmt2->bindValue(1, $codigoCurso);
                $stmt2->execute();

                $stmt = $enlace->prepare("Delete from cursos where codigo = ?");
                $stmt->bindValue(1, $codigoCurso);
                $stmt->execute();
            }
            echo "</table>";
            echo "<p style='color: green'>Se ha eliminado los cursos con exito</p>";
        }
        echo "</div>";
        echo "</body>";
        echo "</html>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
