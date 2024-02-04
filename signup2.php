<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/887e44e44e.js" crossorigin="anonymous"></script>
<?php
    include_once 'dbConn.php';
    if (isset($_POST['submit']) && $_POST['username'] != null && $_POST['password']!= null && $_POST['email']!= null) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, money) VALUES (?, ?, ?, 0)");
        $stmt->bind_param("sss", $username, $password, $email);
        
        if ($stmt->execute()) {
            echo "Account created successfully!";
            header( "refresh:1;url=login.php" );
        } else {
            echo "Error: " . $stmt->error;
        }
    }
?>


