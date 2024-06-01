<?php
include("../dbconnect.php");

if(isset($_GET['cid']) && isset($_GET['comment'])) {
    $cmntid = $_GET['cid'];
    $cmnttxt = $_GET['comment'];

    try {
        $query = "UPDATE comment SET comment_text = :cmnttxt WHERE comment_id = :cmntid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':cmntid', $cmntid);
        $stmt->bindParam(':cmnttxt', $cmnttxt);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['res' => 'success']);
        } else {
            echo json_encode(['res' => 'error',
                              'message' => 'Invalid request']);
        }
    } catch(PDOException $th) {
        echo json_encode(['error' => $th->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing reference']);
}

?>