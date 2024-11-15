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

// Obtener los datos del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$name = $data['name'];
$area = $data['area'];
$personalDescription = $data['personalDescription'];
$email = $data['email'];
$location = $data['location'];
$profilePic = $data['profilePic'];
$optionalPics = $data['optionalPics'];
$bio = $data['bio'];
$certifications = $data['certifications'];
$experience = $data['experience'];
$oficialTitles = $data['oficialTitles'];
$articles = $data['articles'];
$communityMessages = $data['communityMessages'];

// Actualizar la tabla Educators
$sql = "UPDATE Educators SET name=?, area=?, personalDescription=?, email=?, location=?, profilePic=?, bio=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssi", $name, $area, $personalDescription, $email, $location, $profilePic, $bio, $id);
$stmt->execute();

// Eliminar datos existentes en tablas relacionadas
$conn->query("DELETE FROM OptionalPics WHERE educatorId=$id");
$conn->query("DELETE FROM Certifications WHERE educatorId=$id");
$conn->query("DELETE FROM Experience WHERE educatorId=$id");
$conn->query("DELETE FROM OficialTitles WHERE educatorId=$id");
$conn->query("DELETE FROM Articles WHERE educatorId=$id");
$conn->query("DELETE FROM CommunityMessages WHERE educatorId=$id");

// Insertar datos actualizados en tablas relacionadas
foreach ($optionalPics as $pic) {
    $sql = "INSERT INTO OptionalPics (educatorId, picUrl) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $pic);
    $stmt->execute();
}

foreach ($certifications as $certification) {
    $sql = "INSERT INTO Certifications (educatorId, certification) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $certification);
    $stmt->execute();
}

foreach ($experience as $exp) {
    $sql = "INSERT INTO Experience (educatorId, experience) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $exp);
    $stmt->execute();
}

foreach ($oficialTitles as $title) {
    $sql = "INSERT INTO OficialTitles (educatorId, title) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $title);
    $stmt->execute();
}

foreach ($articles as $article) {
    $sql = "INSERT INTO Articles (educatorId, articleName, articlePicture, articleDescription, articleLink) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $id, $article['articleName'], $article['articlePicture'], $article['articleDescription'], $article['articleLink']);
    $stmt->execute();
}

foreach ($communityMessages as $message) {
    $sql = "INSERT INTO CommunityMessages (educatorId, messageAutor, messageRelationship, messageContent) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $id, $message['messageAutor'], $message['messageRelationship'], $message['messageContent']);
    $stmt->execute();
}

echo json_encode(["message" => "Docente actualizado con éxito"]);

$stmt->close();
$conn->close();
?>
