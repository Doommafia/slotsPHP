<?php
    if(isset($_POST["password"]) && isset($_POST["username"])){
        echo'<script>alert("You have successfully registered")</script>';
        header('location:   index.php');        
    }else{
    echo
        '<div class="wrapper">
            <script src="https://kit.fontawesome.com/887e44e44e.js" crossorigin="anonymous"></script>
            <form action="login.php" method="post">
                Username</br>
                <input type="text" name="username"></input></br>
                Password</br>
                <input type="password" name="password"></input></br>
                <input type="submit" value="Start" class="submitBtn"></input>
            </form>            

            <a href="signup.php">Sign up</a></br>
            <a href="forgot.php">Forgot Password?</a>
        </div>';
    }
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

:root {
    background: radial-gradient(circle, #0A0A33 36%, #000068 100%);
}
body {
    font-family: Roboto, sans-serif;
    color: white;
    display: flexbox;
    justify-content: center;
    align-items: center;
}

.wrapper{
    margin-top: 40dvh;
    display: flex;
    flex-direction: column;
    align-items: center;
}
</style>
