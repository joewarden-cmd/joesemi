<?php

include("../dbconnect.php");

$uid = $_GET['uid'];
$status = "read";

try {
    $updateQuery = "UPDATE likes 
                    JOIN post ON post.post_id = likes.post_id 
                    SET likes.status = :status 
                    WHERE post.user_id = :uid AND likes.user_id != :uid
                          AND likes.status = 'unread'";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bindParam(':status', $status);
    $updateStmt->bindParam(':uid', $uid, PDO::PARAM_INT);
    $updateStmt->execute();

    $affectedRows = $updateStmt->rowCount();

    header('Content-type: application/json');
    echo json_encode(['affectedRows' => $affectedRows]);
} catch (PDOException $th) {
    echo json_encode(['error' => $th->getMessage()]);
}