<?php
include("../dbconnect.php");

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM users
                                WHERE username = :username
                                AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $user_id = $row['user_id'];
            
            $response = array(
                "success" => true,
                "user_id" => $user_id
            );
            
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            echo "Incorrect username or password";
        }
    } catch (PDOException $th) {
        echo json_encode(['error' => $th->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing reference']);
}

?>
