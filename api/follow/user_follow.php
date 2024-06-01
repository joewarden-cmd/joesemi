<?php
include("../dbconnect.php");

if(isset($_GET['uid']) && isset($_GET['suid'])) {
    $follower_id = $_GET['uid'];
    $following_id = $_GET['suid'];

    try {
        $query = "INSERT INTO follows (follower_id, following_id)
                  VALUES (:follower_id, :following_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':follower_id', $follower_id);
        $stmt->bindParam(':following_id', $following_id);
        $res = $stmt->execute();

        if ($res) {
            echo json_encode(['res' => 'success']);
        } else {
            echo json_encode(['res' => 'error']);
        }
    } catch (PDOException $th) {
        echo json_encode(['error' => $th->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing reference']);
}

?>