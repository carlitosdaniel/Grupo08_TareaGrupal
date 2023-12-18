<?php
$servername = "localhost";
$username = "root";
$password = "123";
$database = "veris";


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sqlMedicos = "SELECT idMedico, NombreMedico FROM medico";
$resultMedicos = $conn->query($sqlMedicos);
$idMedicoSeleccionado = isset($_POST['medico']) ? $_POST['medico'] : null;

if ($idMedicoSeleccionado) {

    $sql = "SELECT c.idConsulta, c.FechaConsultas, c.HoraInicio, c.HoraFin, c.Diagnostico, p.NombrePaciente, p.Edad, p.Genero
            FROM consulta c
            JOIN paciente p ON c.idPaciente = p.idPaciente
            WHERE c.idMedico = $idMedicoSeleccionado
            AND p.Edad >= 60
            ORDER BY c.FechaConsultas";

    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rep de consultas</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 2px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body>

<form method="post" action="">
    <label for="medico"><h2>Seleccione un médico:</h2></label>
    <select name="medico" id="medico">
        <?php
        while ($rowMedico = $resultMedicos->fetch_assoc()) {
            $selected = ($idMedicoSeleccionado == $rowMedico['idMedico']) ? 'selected' : '';
            echo "<option value='{$rowMedico['idMedico']}' $selected>{$rowMedico['NombreMedico']}</option>";
        }
        ?>
    </select>
    <input type="submit" value="Mostrar Consultas">
</form>

<?php
//Mostrar la tabla HTML
if ($idMedicoSeleccionado && $result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID Consulta</th>
                <th>Fecha</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Diagnóstico</th>
                <th>Nombre Paciente</th>
                <th>Edad</th>
                <th>Género</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['idConsulta']}</td>
                <td>{$row['FechaConsultas']}</td>
                <td>{$row['HoraInicio']}</td>
                <td>{$row['HoraFin']}</td>
                <td>{$row['Diagnostico']}</td>
                <td>{$row['NombrePaciente']}</td>
                <td>{$row['Edad']}</td>
                <td>{$row['Genero']}</td>
            </tr>";
    }

    echo "</table>";
} elseif ($idMedicoSeleccionado) {
    echo "No se encontraron consultas para este médico.";
}
$conn->close();
?>

</body>
</html>




