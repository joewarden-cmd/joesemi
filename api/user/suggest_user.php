<?php
header('Content-type: application/json');

include("../dbconnect.php");

if(isset($_GET['uid'])) {
    $uid = $_GET['uid'];

    try {
        $query = "SELECT * FROM users
                  LEFT JOIN follows
                  ON users.user_id = follows.following_id
                  AND follows.follower_id = :uid
                  WHERE follows.following_id IS NULL
                  AND users.user_id != :uid
                  ORDER BY RAND()
                  LIMIT 5";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (PDOException $th) {
        echo json_encode(['error' => $th->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing reference']);
}

?>