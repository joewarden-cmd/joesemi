<?php
include("../dbconnect.php");

if(isset($_GET['uid'])) {
    $uid = $_GET['uid'];

    try {
        $query = "SELECT users.*,
                    (SELECT COUNT(*) FROM follows WHERE follower_id = users.user_id) AS following_count,
                    (SELECT COUNT(*) FROM follows WHERE following_id = users.user_id) AS follower_count
                  FROM users
                  WHERE user_id = :uid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':uid', $uid);
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