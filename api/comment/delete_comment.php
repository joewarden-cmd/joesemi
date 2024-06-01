<?php

include("../dbconnect.php");

if(isset($_GET['cid'])) {
    $commentid = $_GET['cid'];

    try {
        $query = "DELETE FROM comment WHERE comment_id = $commentid";
        $stmt = $conn->prepare($query);
        $res = $stmt->execute();

        if ($res) {
            echo json_encode(['res' => 'success']);
        } else {
            echo json_encode(['res' => 'error',
                              'message' => 'Invalid request']);
        }

    } catch (PDOException $th) {
        echo json_encode(['error' => $th->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing reference']);
}

?>