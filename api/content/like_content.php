<?php
include("../dbconnect.php");

if(isset($_GET['pid']) && isset($_GET['uid'])) {
    $post_id = $_GET['pid'];
    $user_id = $_GET['uid'];
    $status = "unread";

    try {
        $query = "INSERT INTO likes (post_id, user_id, status)
                  VALUES (:post_id, :user_id, :status)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam('status', $status);
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