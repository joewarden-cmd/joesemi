<?php
include("../dbconnect.php");

if(isset($_GET['postid']) && isset($_GET['content'])) {
    $postid = $_GET['postid'];
    $content = $_GET['content'];

    try {
        $query = "UPDATE post SET content = :content WHERE post_id = :postid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':postid', $postid);
        $stmt->bindParam(':content', $content);
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