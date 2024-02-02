<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/887e44e44e.js" crossorigin="anonymous"></script>
<?php
session_start();
include_once 'dbConn.php';
$username = $_POST['username'];
$password = $_POST['password'];  // Consider hashing the password

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $_SESSION['money'] = $row['money'];
    }
    echo "User logged in successfully!";
    $_SESSION['username'] = $username;
    echo '<br/>welcome '. $username;
    header( "refresh:1;url=index.php" );
} else {
    echo "Invalid username or password!";
    header( "refresh:1;url=login.php" );
}

session_write_close();
?>

