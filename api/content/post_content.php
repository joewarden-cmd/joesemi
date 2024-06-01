<?php
include("../dbconnect.php");

if(isset($_POST['userid'])) {
    $userid = $_POST['userid'];
    $content = $_POST['content'] ?? null;
    $imguid = $_POST['imguid'] ?? null;

    try {
        $query = "INSERT INTO post(user_id, content, image_uid)
            VALUE (:userid, :content, :imguid)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':userid',$userid);
        $stmt->bindParam(':content',$content);
        $stmt->bindParam(':imguid',$imguid);
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