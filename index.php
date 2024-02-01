<?php
session_start();
echo $_SESSION['username'];
echo $_SESSION['password'];
echo $_SESSION['email'];
echo $_SESSION['money'];
session_abort();

?>


<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/887e44e44e.js" crossorigin="anonymous"></script>

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
