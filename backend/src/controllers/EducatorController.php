<?php

namespace App\Controllers;

use App\Models\Educator;

class EducatorController {
    public static function getEducatorsList($conn) {
        $sql = "SELECT * FROM Educators";
        $result = $conn->query($sql);

        $educators = [];

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $educator = new Educator($row);
                $educator->optionalPics = self::getOptionalPics($conn, $row['id']);
                $educator->certifications = self::getCertifications($conn, $row['id']);
                $educator->experience = self::getExperience($conn, $row['id']);
                $educator->oficialTitles = self::getOficialTitles($conn, $row['id']);
                $educator->articles = self::getArticles($conn, $row['id']);
                $educator->communityMessages = self::getCommunityMessages($conn, $row['id']);
                $educators[] = $educator;
            }
        }

        echo json_encode($educators);
    }

    public static function getEducatorByName($conn, $name) {
        $sql = "SELECT * FROM Educators WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $educator = $result->fetch_assoc();
        echo json_encode(new Educator($educator));
    }

    public static function addEducator($conn) {
        $data = json_decode(file_get_contents('php://input'), true);
        $educator = new Educator($data);

        $sql = "INSERT INTO Educators (name, area, personalDescription, email, location, profilePic) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $educator->name, $educator->area, $educator->personalDescription, $educator->email, $educator->location, $educator->profilePic);
        $stmt->execute();

        echo json_encode(["message" => "Educator added successfully"]);
    }

    public static function updateEducator($conn) {
        $data = json_decode(file_get_contents('php://input'), true);
        $educator = new Educator($data);

        $sql = "UPDATE Educators SET name=?, area=?, personalDescription=?, email=?, location=?, profilePic=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $educator->name, $educator->area, $educator->personalDescription, $educator->email, $educator->location, $educator->profilePic, $educator->id);
        $stmt->execute();

        echo json_encode(["message" => "Educator updated successfully"]);
    }

    public static function deleteEducator($conn) {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id > 0) {
            $stmt = $conn->prepare("DELETE FROM Educators WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            echo json_encode(["message" => "Educator deleted successfully"]);
        } else {
            echo json_encode(["message" => "Invalid ID"]);
        }
    }

    // Helper methods to get related data
    private static function getOptionalPics($conn, $educatorId) {
        $sql = "SELECT * FROM OptionalPics WHERE educatorId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $educatorId);
        $stmt->execute();
        $result = $stmt->get_result();
        $pics = [];
        while ($row = $result->fetch_assoc()) {
            $pics[] = $row;
        }
        return $pics;
    }

    private static function getCertifications($conn, $educatorId) {
        $sql = "SELECT * FROM Certifications WHERE educatorId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $educatorId);
        $stmt->execute();
        $result = $stmt->get_result();
        $certifications = [];
        while ($row = $result->fetch_assoc()) {
            $certifications[] = $row;
        }
        return $certifications;
    }

    private static function getExperience($conn, $educatorId) {
        $sql = "SELECT * FROM Experience WHERE educatorId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $educatorId);
        $stmt->execute();
        $result = $stmt->get_result();
        $experience = [];
        while ($row = $result->fetch_assoc()) {
            $experience[] = $row;
        }
        return $experience;
    }

    private static function getOficialTitles($conn, $educatorId) {
        $sql = "SELECT * FROM OficialTitles WHERE educatorId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $educatorId);
        $stmt->execute();
        $result = $stmt->get_result();
        $titles = [];
        while ($row = $result->fetch_assoc()) {
            $titles[] = $row;
        }
        return $titles;
    }

    private static function getArticles($conn, $educatorId) {
        $sql = "SELECT * FROM Articles WHERE educatorId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $educatorId);
        $stmt->execute();
        $result = $stmt->get_result();
        $articles = [];
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
        return $articles;
    }

    private static function getCommunityMessages($conn, $educatorId) {
        $sql = "SELECT * FROM CommunityMessages WHERE educatorId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $educatorId);
        $stmt->execute();
        $result = $stmt->get_result();
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        return $messages;
    }
}