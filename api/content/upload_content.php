<?php
include("../dbconnect.php");

if(isset($_POST['uid']) && isset($_FILES['img'])) {
    $userid = $_POST['uid'];
    $files = $_FILES['img'];

    try {
        $uploaded_files = [];

        foreach ($files['tmp_name'] as $key => $tmp_name) {
            $imguid = mt_rand();
            $filename = time() . '_' . basename($files["name"][$key]);
            $target_file = '../public/img/' . $filename;
            move_uploaded_file($files["tmp_name"][$key], $target_file);

            $target_file = str_replace("../", "/api/", $target_file);
            $uploaded_files[] = $target_file;
        }

        $query = "INSERT INTO image (user_id, filename, image_uid) VALUES (:user_id, :file, :image_uid)";
        $stmt = $conn->prepare($query);

        foreach ($uploaded_files as $file) {
            $stmt->bindParam(':user_id', $userid);
            $stmt->bindParam(':file', $file);
            $stmt->bindParam(':image_uid', $imguid);
            $res = $stmt->execute();
        }

        if ($res) {
            echo json_encode(['res' => 'success',
                              'img_uid' => $imguid]);
        } else {
            echo json_encode(['res' => 'error']);
        }
    } catch(PDOException $th) {
        echo json_encode(['error' => $th->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing reference']);
}

?>