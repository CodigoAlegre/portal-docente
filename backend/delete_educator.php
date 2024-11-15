<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$servername = "localhost";
$username = "u132327133_juan";  
$password = "Abi05uni";  
$dbname = "u132327133_Educadores";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener el ID del docente a eliminar
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Eliminar el docente y todas las entradas relacionadas en otras tablas
    $stmt = $conn->prepare("DELETE FROM Educators WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode(["message" => "Docente eliminado con éxito"]);
    $stmt->close();
} else {
    echo json_encode(["message" => "ID no válido"]);
}

$conn->close();
?>
