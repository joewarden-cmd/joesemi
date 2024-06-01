<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

include("../dbconnect.php");

$uid = $_GET['uid'];

while (true) {
    try {
        $countQuery = "SELECT COUNT(*) AS total_likes 
                   FROM likes 
                   LEFT JOIN post ON post.post_id = likes.post_id 
                   WHERE post.user_id = :uid AND likes.user_id != :uid
                         AND status = 'unread'";
        $countStmt = $conn->prepare($countQuery);
        $countStmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $countStmt->execute();
        $total = $countStmt->fetch(PDO::FETCH_ASSOC);

        echo "data: " . json_encode($total) . "\n\n";
    } catch (PDOException $th) {
        echo "data: " . json_encode(['error' => $th->getMessage()]) . "\n\n";
    }
    ob_flush();
    flush();
    sleep(1);
}