<?php
session_start();
$boton = $_POST['enviar'];

try {
    if ($boton != "Asignar curso") {
        $enlace = new PDO('mysql:host=127.0.0.1; dbname=cursoscp', "root", "root");
        $enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "SELECT DISTINCT c.* FROM cursos c INNER JOIN solicitudes s ON c.codigo = s.codigocurso WHERE s.codigocurso NOT IN (
                        SELECT codigocurso FROM solicitudes WHERE admitido = 1)";
        $resultado = $enlace->query($consulta);

        echo "<!DOCTYPE html>";
        echo "<html lang='es'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Asignar cursos</title>";
        echo "<link rel='stylesheet' href='estilo.css'>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h1>Asignar plazas de cursos</h1>";
        echo "<button><a href='index.php'>Volver</a></button>";
        echo "<form action='baremacionDeCursos.php' method='post'>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Codigo</th>";
        echo "<th>Nombre</th>";
        echo "<th>Abierto</th>";
        echo "<th>Numero de plazas</th>";
        echo "<th>Plazo de Inscripcion</th>";
        echo "<th>Asignar plazas</th></tr>";
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
        echo "<input type='submit' name='enviar' value='Asignar curso'>";
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
        echo "<title>Asignar cursos</title>";
        echo "<link rel='stylesheet' href='estilo.css'>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h1>Asignar plazas de cursos</h1>";
        echo "<button><a href='baremacionDeCursos.php'>Volver a asignar</a></button>";

        if (count($cursos) != 1) {
            echo "<p style='color: red'>Debes seleccionar exactamente un curso</p>";
        } else {
            foreach ($cursos as $codigoCurso) {
                $stmt = $enlace->prepare("SELECT numeroplazas FROM cursos WHERE codigo = ?");
                $stmt->bindValue(1, $codigoCurso);
                $stmt->execute();

                while ($fila = $stmt->fetch(PDO::FETCH_NUM)) {
                    $stmt2 = $enlace->prepare("SELECT s.codigocurso, s.dni, sol.puntos FROM solicitudes s INNER JOIN solicitantes sol ON s.dni = sol.dni
                                            INNER JOIN cursos c ON s.codigocurso = c.codigo WHERE c.codigo = ? ORDER BY s.codigocurso, sol.puntos DESC LIMIT $fila[0]");
                    $stmt2->bindValue(1, $codigoCurso);
                    $stmt2->execute();

                    while ($fila2 = $stmt2->fetch(PDO::FETCH_NUM)) {
                        $stmt3 = $enlace->prepare("update solicitudes set admitido = 1 where dni = ? and codigocurso = ?");
                        $stmt3->bindValue(1, $fila2[1]);
                        $stmt3->bindValue(2, $fila2[0]);
                        $stmt3->execute();

                        $stmt4 = $enlace->prepare("update cursos set numeroplazas=numeroplazas-1 where codigo = ?");
                        $stmt4->bindValue(1, $fila2[0]);
                        $stmt4->execute();
                    }
                }

                echo "<p>Personas admitidas al curso " . $codigoCurso . ":</p>";
                echo "<table>";
                echo "<tr>";
                echo "<th>Nombre</th>";
                echo "<th>Apellidos</th>";
                echo "<th>DNI</th>";
                echo "<th>Fecha de nacimiento</th>";
                echo "<th>Puntos</th>";
                echo "</tr>";

                $stmt5 = $enlace->prepare("SELECT sol.nombre, sol.apellidos, sol.dni, sol.fechanac, sol.puntos FROM solicitudes s
                                                    INNER JOIN solicitantes sol ON s.dni = sol.dni WHERE s.codigocurso = ? AND s.admitido = 1");
                $stmt5->bindValue(1, $codigoCurso);
                $stmt5->execute();
                while ($fila3 = $stmt5->fetch(PDO::FETCH_NUM)) {
                    echo "<tr>";
                    foreach ($fila3 as $value) {
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        echo "</div>";
        echo "</body>";
        echo "</html>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
