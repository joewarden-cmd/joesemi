<?php
include("../dbconnect.php");

if(isset($_POST['postid']) && isset($_POST['userid'])) {
    $postid = $_POST['postid'];
    $userid = $_POST['userid'];
    $cmnttext = $_POST['commenttext'];

    try {
        $query = "INSERT INTO comment(user_id, post_id, comment_text)
                  VALUE (:user_id, :post_id, :comment_text)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id',$userid);
        $stmt->bindParam(':post_id',$postid);
        $stmt->bindParam(':comment_text',$cmnttext);
        $res = $stmt->execute();

        if ($res) {
            echo json_encode(['res' => 'success']);
        } else {
            echo json_encode(['res' => 'error',
                              'message' => 'Something went wrong']);
        }
    } catch (PDOException $th) {
        echo json_encode(['error' => $th->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing reference']);
}

?>