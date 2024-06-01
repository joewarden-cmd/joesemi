<?php
include("../dbconnect.php");

if(isset($_POST['userid']) && isset($_POST['username'])) {
    $uid = $_POST['userid'];
    $fname = $_POST['fullname'];
    $uname = strtolower($_POST['username']);
    $profile = $_FILES['profile'];

    try {

        $original_filename = $_FILES['profile']['name'];
        $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);
        $filename = $uid . '_' . time() . '.' . $file_extension;

        $target_directory = '../public/img/profile/';
        $target_file = $target_directory . $filename;

        move_uploaded_file($_FILES['profile']['tmp_name'], $target_file);
        $target_file = str_replace("../", "/api/", $target_file);

        $query = "UPDATE users SET fullname = :fname, username = :uname, profile_pic = IFNULL(:pic, profile_pic)
                  WHERE user_id = :uid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':uname', $uname);
        $stmt->bindParam(':pic', $target_file);
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