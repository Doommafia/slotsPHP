<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/887e44e44e.js" crossorigin="anonymous"></script>
<?php
include_once 'dbConn.php';
$username = $_POST['username'];
$password = $_POST['password'];  // Consider hashing the password


$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "User logged in successfully!";
    echo '<br/>welcome '. $username;
    header( "refresh:1;url=index.php" );
} else {
    echo "Invalid username or password!";
    header( "refresh:1;url=login.php" );

}



