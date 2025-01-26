<?php
session_start();
$boton = $_POST['enviar'];

if ($boton != "Activar/Desactivar") {
    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Activar y Desactivar Cursos</title>";
    echo "<link rel='stylesheet' href='estilo.css'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h1>Activar o Desactivar Cursos</h1>";
    echo "<button><a href='index.php'>Volver</a></button>";
    echo "<form action='activarDesactivarCursos.php' method='post'>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Codigo</th>";
    echo "<th>Nombre</th>";
    echo "<th>Abierto</th>";
    echo "<th>Numero de plazas</th>";
    echo "<th>Plazo de inscripcion</th>";
    echo "<th>Activar/Desactivar</th>";
    echo "</tr>";

    try {
        $enlace = new PDO('mysql:host=127.0.0.1; dbname=cursoscp', "root", "root");
        $enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $enlace->prepare("select * from cursos");
        $stmt->execute();

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($fila as $value) {
                echo "<td>$value</td>";
            }
            echo "<td><input type='checkbox' name='cursos[]' value=$fila[codigo]></td>";
            echo "</tr>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    echo "</table>";
    echo "<input type='submit' name='enviar' value='Activar/Desactivar'>";
    echo "</form>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
} else {
    $cursos = $_POST['cursos'] ?? [];

    try {
        $enlace = new PDO('mysql:host=127.0.0.1; dbname=cursoscp', "root", "root");
        $enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "<!DOCTYPE html>";
        echo "<html lang='es'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Activar y Desactivar Cursos</title>";
        echo "<link rel='stylesheet' href='estilo.css'>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h1>Activar o Desactivar Cursos</h1>";
        echo "<button><a href='activarDesactivarCursos.php'>Volver</a></button>";

        if (count($cursos) >= 1) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Codigo</th>";
            echo "<th>Nombre</th>";
            echo "<th>Abierto</th>";
            echo "<th>Numero de plazas</th>";
            echo "<th>Plazo de inscripcion</th>";
            echo "</tr>";
            foreach ($cursos as $codigoCurso) {

                $stmt2 = $enlace->prepare("select abierto from cursos where codigo = ?");
                $stmt2->bindValue(1, $codigoCurso);
                $stmt2->execute();

                while ($fila3 = $stmt2->fetch(PDO::FETCH_NUM)) {
                    if ($fila3[0] == 0) {
                        $stmt3 = $enlace->prepare("update cursos set abierto=1 where codigo = ?");
                        $stmt3->bindValue(1, $codigoCurso);
                        $stmt3->execute();

                        echo "</tr>";
                        echo '<td colspan="5">Curso activado</td>';
                        echo "<tr>";

                        $stmt = $enlace->prepare("select * from cursos where codigo = ?");
                        $stmt->bindValue(1, $codigoCurso);
                        $stmt->execute();

                        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            foreach ($fila as $value) {
                                echo "<td>$value</td>";
                            }
                            echo "</tr>";
                        }
                    } else {
                        $stmt4 = $enlace->prepare("update cursos set abierto=0 where codigo = ?");
                        $stmt4->bindValue(1, $codigoCurso);
                        $stmt4->execute();

                        echo "</tr>";
                        echo '<td colspan="5">Curso desactivado</td>';
                        echo "<tr>";

                        $stmt = $enlace->prepare("select * from cursos where codigo = ?");
                        $stmt->bindValue(1, $codigoCurso);
                        $stmt->execute();

                        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            foreach ($fila as $value) {
                                echo "<td>$value</td>";
                            }
                            echo "</tr>";
                        }
                    }
                }
            }
            echo "</table>";
        } else {
            echo "<p style='color: red'>No has marcado ningun curso para activar/desactivar</p>";
        }
        echo "</div>";
        echo "</body>";
        echo "</html>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
