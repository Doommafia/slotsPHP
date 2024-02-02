<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/887e44e44e.js" crossorigin="anonymous"></script>
<?php
session_start();

if (isset($_SESSION['username'])) {
echo $_SESSION['username'].'<br/>';
echo $_SESSION['money'];
echo'<br/><a href="logout.php"><i class="fas fa-sign-out-alt fa-4x"></i></a>';
}else{
    echo '<br/><a href="login.php"><i class="fas fa-sign-in-alt fa-4x"></i></a>';
}
session_write_close();
?>




<h1>Welcome to the slots website!</h1>
<a href="slots.php" class="solo">Solo</a>
<a href="construction.php" class="versus">Versus</a>


<style>
    :root {
    text-align:center;
    color:white;
    text-decoration: none;
    
    }
    h1 {
        text-align: center;
        color: white;
        margin-top: 10%
    }

</style>