<?php
    // TODO: Implement bet money support, currently set at 0.2.
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once 'logic.php';
    ob_start();
    echo 'Bet ammount: '. $bet;
    echo 'Money: '. $_SESSION['money'];
    echo 'Gain: '. $gain;

    if(!isset($_POST["spin"])){
    cellOut($gameArr);
    }

  
    if(isset($_POST['spin'])) { 
        clearScreen();
        spin($gameArr); 
        cellOut($gameArr);
        gameEval($gameArr);

    } 

    if(isset($_POST['scatter'])) { 
        scatter();
    }

?> 
  
<form method="post"> 
    <button type="submit" name="spin" value="spin"/>
        <i class="fa-solid fa-rotate-right fa-6x" id = "spin"></i>
    </button>
    <button type="submit" name="scatter" value="scatter"/>
        <i class="fa-solid fa-bomb fa-6x" id ="scatter" style="color:#e74c3c !important"></i>
    </button>
  


</form> 

<style>
    form{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 3%;
    }
    button{
        transition: 0.1s;
        background-color: rgba(0,0,0,0);
        border: none;
        border-radius: 50%;
        box-shadow: -5px 5px 1px #e1b12c ;
    }
    #spin{
        color: #fbc531;
        box-shadow: -0px 10px 5%;
        }
    #scatter{
        color: #e74c3c;
        box-shadow: -0px 10px 5%;
    }
        
    button:hover{
        transition: 0.1s;
        box-shadow: -2px 2px 1px #e1b12c;
    }
</style>

<script>

if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
