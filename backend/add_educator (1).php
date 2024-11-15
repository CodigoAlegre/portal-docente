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

// Datos del docente a insertar
$name = "John Doe";
$area = "Educación Física";
$personalDescription = "John es un educador experimentado en educación física con más de 10 años de experiencia.";
$email = "john.doe@example.com";
$location = "Madrid, España";
$profilePic = "https://avatars.githubusercontent.com/u/69772530?v=4";
$optionalPics = [
    "https://avatars.githubusercontent.com/u/69772530?v=4",
    "https://media.licdn.com/dms/image/D4D03AQG0wdBc5NFGAA/profile-displayphoto-shrink_400_400/0/1674527155823?e=1724889600&v=beta&t=EGTz4QusKtF6V854iWENqWyv7X3dFeDC4AVZXx23TVU"
];
$bio = "John ha trabajado en varias instituciones educativas y ha desarrollado programas innovadores para la enseñanza de la educación física.";
$certifications = [
    "Certificado en Entrenamiento Personal",
    "Certificado en Nutrición Deportiva"
];
$experience = [
    "Profesor de Educación Física en el Colegio ABC (2010-2015)",
    "Entrenador Personal en Gimnasio XYZ (2015-presente)"
];
$oficialTitles = [
    "Licenciatura en Ciencias del Deporte",
    "Máster en Educación Física"
];
$articles = [
    [
        "articleName" => "Innovaciones en la Educación Física",
        "articlePicture" => "assets/article1.png",
        "articleDescription" => "Un artículo sobre las últimas innovaciones en el campo de la educación física.",
        "articleLink" => "https://avatars.githubusercontent.com/u/69772530?v=4"
    ],
    [
        "articleName" => "Nutrición y Deporte",
        "articlePicture" => "assets/article2.png",
        "articleDescription" => "Un artículo sobre la importancia de la nutrición en el rendimiento deportivo.",
        "articleLink" => "https://avatars.githubusercontent.com/u/69772530?v=4"
    ]
];
$communityMessages = [
    [
        "messageAutor" => "Jane Doe",
        "messageRelationship" => "Colega",
        "messageContent" => "John es un profesional dedicado y siempre dispuesto a ayudar a sus colegas."
    ],
    [
        "messageAutor" => "Richard Roe",
        "messageRelationship" => "Alumno",
        "messageContent" => "Gracias a John, he mejorado significativamente mi rendimiento físico y mi salud."
    ]
];

// Insertar en la tabla Educators
$sql = "INSERT INTO Educators (name, area, personalDescription, email, location, profilePic, bio) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $name, $area, $personalDescription, $email, $location, $profilePic, $bio);
$stmt->execute();
$educatorId = $stmt->insert_id; // Obtener el ID del educador recién insertado

// Insertar en la tabla OptionalPics
foreach ($optionalPics as $pic) {
    $sql = "INSERT INTO OptionalPics (educatorId, picUrl) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $educatorId, $pic);
    $stmt->execute();
}

// Insertar en la tabla Certifications
foreach ($certifications as $certification) {
    $sql = "INSERT INTO Certifications (educatorId, certification) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $educatorId, $certification);
    $stmt->execute();
}

// Insertar en la tabla Experience
foreach ($experience as $exp) {
    $sql = "INSERT INTO Experience (educatorId, experience) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $educatorId, $exp);
    $stmt->execute();
}

// Insertar en la tabla OficialTitles
foreach ($oficialTitles as $title) {
    $sql = "INSERT INTO OficialTitles (educatorId, title) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $educatorId, $title);
    $stmt->execute();
}

// Insertar en la tabla Articles
foreach ($articles as $article) {
    $sql = "INSERT INTO Articles (educatorId, articleName, articlePicture, articleDescription, articleLink) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $educatorId, $article['articleName'], $article['articlePicture'], $article['articleDescription'], $article['articleLink']);
    $stmt->execute();
}

// Insertar en la tabla CommunityMessages
foreach ($communityMessages as $message) {
    $sql = "INSERT INTO CommunityMessages (educatorId, messageAutor, messageRelationship, messageContent) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $educatorId, $message['messageAutor'], $message['messageRelationship'], $message['messageContent']);
    $stmt->execute();
}

echo json_encode(["message" => "Docente agregado con éxito"]);

$stmt->close();
$conn->close();
?>
