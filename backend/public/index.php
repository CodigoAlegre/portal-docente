<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

use App\Controllers\EducatorController;

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['name'])) {
            EducatorController::getEducatorByName($conn, $_GET['name']);
        } else {
            EducatorController::getEducatorsList($conn);
        }
        break;
    case 'POST':
        EducatorController::addEducator($conn);
        break;
    case 'PUT':
        EducatorController::updateEducator($conn);
        break;
    case 'DELETE':
        EducatorController::deleteEducator($conn);
        break;
    default:
        echo json_encode(["message" => "Método no soportado"]);
        break;
}

$conn->close();