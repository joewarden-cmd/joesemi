<?php
include("../dbconnect.php");

if(isset($_GET['postid'])) {
    $postid = $_GET['postid'];

    try {
        $query = "SELECT * FROM comment
                  LEFT JOIN users ON comment.user_id = users.user_id 
                  WHERE post_id = :postid
                  ORDER BY comment_id DESC";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':postid', $postid);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-type: application/json');
        echo json_encode($result);
    } catch (PDOException $th) {
        echo json_encode(['error' => $th->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing reference']);
}

?>