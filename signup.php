<?php
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random = '';
    for( $i = 0; $i < 8; $i++ ){
        $random .= $characters[rand(0, strlen($characters) -1)];
    }

?>


<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/887e44e44e.js" crossorigin="anonymous"></script>

<div class="wrapper" action="main.php">
    <div class="inner">
        <i class="fa-solid fa-person-digging fa-4x"></i>
        <h1>Welcome to the mines!</h1>
        <form action="main.php">
            Username</br>
            <input type="text"></input></br>
            Password</br>
            <input type="text"></input></br>
            Email</br>
            <input type="text"></input></br>
            Please type out <?php echo $random; ?>.</br>
            <input type="text"></input></br>
            <input type="submit" value="Join" class="submitBtn"></input>
        </form>

    </div>
</div>

<style>
    
.wrapper{
    display: flex;
    justify-content: center;    
    align-items: center;
    margin-top: 7%;
    margin-left: 40%;
    width: 25%;
    height: 70%;
    position:relative;
    background-color: var(--decor_main);
    border-radius: 5%;
}

.inner{
    color: white;
    text-align: center;
}

.rel{
    padding-top: 5px;
}

a{
    text-decoration: none;
    color: var(--main)
}

input { 
    text-align: center; 
}


</style>
