<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/887e44e44e.js" crossorigin="anonymous"></script>

<div class="wrapper">
    <h1>Request Password</h1>
    <form action="forgot2.php" method="post">
        <input type="email" ></input></br>
        <input type="submit" value="Reset" class="submitBtn"></input>
        <input type="submit" value="Request" class="submitBtn"></input>
    </form>

</div>

<style>
.wrapper{
    padding-top:3%;
    margin-top: 15%;
    margin-left: 40%;
    width: 25%;
    height: 25%;
    position:relative;
    background-color: var(--decor_main);
    border-radius: 5%;
    color: white;
    text-align: center;
}

h1{
    text-shadow: var(--decor_dark) -3px 5px 5px;
}

.submitBtn{
    margin-right: 5px;
    color: darkblue
}


</style>
