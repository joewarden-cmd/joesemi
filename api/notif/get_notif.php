<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

include("../dbconnect.php");

$uid = $_GET['uid'];

while (true) {
    try {
        $query = "SELECT likes.*, 
                     users.fullname,
                     users.profile_pic,
                     users.user_id AS uidd,
                     post.user_id AS kid
              FROM likes
              LEFT JOIN users ON users.user_id = likes.user_id
              LEFT JOIN post ON post.post_id = likes.post_id
              WHERE post.user_id = :uid AND likes.user_id != :uid
              GROUP BY likes.id
              ORDER BY likes.id DESC";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // header('Content-type: application/json');
        echo "data: " . json_encode($result) . "\n\n";
    } catch (PDOException $th) {
        echo "data: " . json_encode(['error' => $th->getMessage()]) . "\n\n";
    }
    ob_flush();
    flush();
    sleep(1);
}
