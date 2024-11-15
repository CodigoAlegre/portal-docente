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

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['name'])) {
            getEducatorByName($conn, $_GET['name']);
        } else {
            getEducatorsList($conn);
        }
        break;
    default:
        echo json_encode(["message" => "Método no soportado"]);
        break;
}

$conn->close();

function getEducatorsList($conn) {
    $sql = "SELECT * FROM Educators";
    $result = $conn->query($sql);

    $educators = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $educator = $row;
            $educator['optionalPics'] = getOptionalPics($conn, $row['id']);
            $educator['certifications'] = getCertifications($conn, $row['id']);
            $educator['experience'] = getExperience($conn, $row['id']);
            $educator['oficialTitles'] = getOficialTitles($conn, $row['id']);
            $educator['articles'] = getArticles($conn, $row['id']);
            $educator['communityMessages'] = getCommunityMessages($conn, $row['id']);
            $educators[] = $educator;
        }
    }

    echo json_encode($educators);
}

function getEducatorByName($conn, $name) {
    $sql = "SELECT * FROM Educators WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $educator = $result->fetch_assoc();
        $educator['optionalPics'] = getOptionalPics($conn, $educator['id']);
        $educator['certifications'] = getCertifications($conn, $educator['id']);
        $educator['experience'] = getExperience($conn, $educator['id']);
        $educator['oficialTitles'] = getOficialTitles($conn, $educator['id']);
        $educator['articles'] = getArticles($conn, $educator['id']);
        $educator['communityMessages'] = getCommunityMessages($conn, $educator['id']);
        echo json_encode($educator);
    } else {
        echo json_encode(["message" => "Educador no encontrado"]);
    }
    
    $stmt->close();
}

function getOptionalPics($conn, $educatorId) {
    $sql = "SELECT picUrl FROM OptionalPics WHERE educatorId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $educatorId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $pics = [];
    while($row = $result->fetch_assoc()) {
        $pics[] = $row['picUrl'];
    }
    
    $stmt->close();
    return $pics;
}

function getCertifications($conn, $educatorId) {
    $sql = "SELECT certification FROM Certifications WHERE educatorId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $educatorId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $certifications = [];
    while($row = $result->fetch_assoc()) {
        $certifications[] = $row['certification'];
    }
    
    $stmt->close();
    return $certifications;
}

function getExperience($conn, $educatorId) {
    $sql = "SELECT experience FROM Experience WHERE educatorId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $educatorId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $experiences = [];
    while($row = $result->fetch_assoc()) {
        $experiences[] = $row['experience'];
    }
    
    $stmt->close();
    return $experiences;
}

function getOficialTitles($conn, $educatorId) {
    $sql = "SELECT title FROM OficialTitles WHERE educatorId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $educatorId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $titles = [];
    while($row = $result->fetch_assoc()) {
        $titles[] = $row['title'];
    }
    
    $stmt->close();
    return $titles;
}

function getArticles($conn, $educatorId) {
    $sql = "SELECT articleName, articlePicture, articleDescription, articleLink FROM Articles WHERE educatorId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $educatorId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $articles = [];
    while($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
    
    $stmt->close();
    return $articles;
}

function getCommunityMessages($conn, $educatorId) {
    $sql = "SELECT messageAutor, messageRelationship, messageContent FROM CommunityMessages WHERE educatorId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $educatorId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $messages = [];
    while($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    
    $stmt->close();
    return $messages;
}
?>