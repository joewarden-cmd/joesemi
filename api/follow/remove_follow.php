<?php
include("../dbconnect.php");

if(isset($_GET['uid']) && isset($_GET['suid'])) {
    $follower_id = $_GET['uid'];
    $following_id = $_GET['suid'];

    try {
        $query = "DELETE FROM follows
                  WHERE follower_id = $follower_id AND following_id = $following_id";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
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