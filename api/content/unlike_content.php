<?php
include("../dbconnect.php");

if(isset($_GET['pid']) && isset($_GET['uid'])) {
    $post_id = $_GET['pid'];
    $user_id = $_GET['uid'];

    try {
        $query = "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['res' => 'success']);
        } else {
            echo json_encode(['res' => 'error',
                              'message' => 'Content not found']);
        }
    } catch (PDOException $th) {
        echo json_encode(['error' => $th->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing reference']);
}

?>