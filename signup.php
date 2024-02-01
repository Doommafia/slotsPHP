<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/887e44e44e.js" crossorigin="anonymous"></script>

<div class="wrapper">
    <div class="inner">
        <i class="fa-solid fa-person-digging fa-4x"></i>
        <h1>Welcome to the mines!</h1>
        <form action="signup2.php" method="POST">
            Username<br>
            <input type="text" name="username"></input><br>
            Password<br>
            <input type="password" name="password"></input><br>
            Email<br>
            <input type="email" name="email"></input><br>
            <input type="submit" name="submit" class="submitBtn"></input>
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
