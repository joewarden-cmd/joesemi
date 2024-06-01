<?php
include("../dbconnect.php");

if(isset($_POST['email']) && isset($_POST['fullname'])
&& isset($_POST['username']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $fullname = $_POST['fullname'];
        $username = strtolower($_POST['username']);
        $password = $_POST['password'];
        $default = "/src/assets/img/default_profile.png";

    try {
        $query = "INSERT INTO users(email, fullname, username, password, profile_pic)
                  VALUE (:email, :fullname, :username, :password, :profile)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':fullname',$fullname);
        $stmt->bindParam(':username',$username);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':profile', $default);
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
    echo json_encode(['error' => 'Something went wrong']);
}

?>