<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/887e44e44e.js" crossorigin="anonymous"></script>

<?php
include_once 'dbConn.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}


$userMoney = $_SESSION['money'];
$gain = 0;
$gainVal = 1/3;
$bet = floatval(0.20);
$gameArr = array_fill(0, 4, array_fill(0, 5, 0));
$counts = array('poo' => 0, 'hippo' => 0, 'ghost' => 0, 'umbrella' => 0, 'cloud' => 0, 'bomb' => 0);


function clearScreen(){
    for ($i = 0; $i < 50; $i++) echo "\r\n";
}
    function dataOut(){
        global $userMoney;
        global $gain;
        global $gainVal;
        global $bet;

        echo 'gain: '. $gain. '<br/>'
        .'userMoney: '. $userMoney. '<br/>'
        .'bet: '. $bet. '<br/>'
        .'gainVal: '. $gainVal. '<br/>';
    
        echo '--------------------------------<br/>';
        echo '$gain = '. $bet. '* ((1/'. $gainVal. ')/2 )'. '<br/>';
        echo '$gain = '. $bet. '*'. ((1/$gainVal)/2 ). '<br/>';
        echo '$gain = '. $gain;
    }

    function spin(&$gameArr) {
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $gameArr[$i][$j] = rand(0,46);
            }
        }
      }

    function iconOut($val){
        if ($val < 15){
            echo '<i class="fa-solid fa-poo fa-4x"style="color:#e17055"></i>';
        } else if ($val < 26){
            echo '<i class="fa-solid fa-hippo fa-4x"style="color:#a29bfe"></i>';
        } else if ($val < 36){
            echo '<i class="fa-solid fa-ghost fa-4x"style="color:#dfe6e9"></i>';
        } else if ($val < 42){
            echo '<i class="fa-solid fa-umbrella fa-4x"style="color:#fdcb6e"></i>';
        } else if ($val < 45){
            echo '<i class="fa-solid fa-cloud fa-4x"style="color:#636e72"></i>';
        } else {
            echo '<i class="fa-solid fa-bomb fa-4x" style="color:#ff7675"></i>';
        }
    }

      function cellOut($gameArr){
        echo '<div class="gameGrid">';
        for ($i = 0; $i < 4; $i++) {
            echo '<div class="gameColumn">';
            for ($j = 0; $j < 5; $j++) {
                echo '<div class="gameCell">';
                    iconOut($gameArr[$i][$j]);
                echo '</div>';
            }
            echo '</div>';
            echo ' ';
        }
        echo '</div>';
    }
    

    function cellPop(&$gameArr, $categoryToPop){
        clearScreen();
        global $bet;
        global $userMoney;
        global $conn;
        global $gainVal;

    // Pop the value
        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 4; $j++) {
                if (isset($gameArr[$i][$j]) && cellCategory($gameArr[$i][$j]) == $categoryToPop) {
                    $gameArr[$i][$j] = 0;  // Set the value to 0
                }
            }
        }

    // Drop the values
    for ($i = 3; $i >= 0; $i--) {  // Start from the bottom row
        for ($j = 0; $j < 5; $j++) {
            if (is_array($gameArr[$i]) && isset($gameArr[$i][$j]) && $gameArr[$i][$j] == 0) {  // If the current cell is 0
                for ($k = $i - 1; $k >= 0; $k--) {  // Look for a non-zero cell in the column above
                    if (is_array($gameArr[$k]) && isset($gameArr[$k][$j]) && $gameArr[$k][$j] != 0) {
                        $gameArr[$i][$j] = $gameArr[$k][$j];  // Swap the values
                        $gameArr[$k][$j] = 0;
                        break;
                    }
                }
            }
        }
    }
    
    // Gen new values
    for ($i = 0; $i < 4; $i++) {
        for ($j = 0; $j < 5; $j++) {
            if (is_array($gameArr[$i]) && isset($gameArr[$i][$j]) && $gameArr[$i][$j] == 0) {
                $gameArr[$i][$j] = rand(0, 46);  // Generate a new random value
            }
        }
    }

    global $counts;
    $counts = array_count_values(array_filter($gameArr, function($value) {
        return is_string($value) || is_int($value);
    }));
    
    $needFurtherRecursion = false;
    foreach ($counts as $count) {
        if ($count >= 8) {
            $needFurtherRecursion = true;
            break;
        }
    }

    // Only call gameEval if further recursion is necessary
    if ($needFurtherRecursion) {
        gameEval($gameArr);
    }


    cellOut($gameArr);    
    switch($categoryToPop){
        case 0:
            $gainVal = 1/15;
        case 1:
            $gainVal = 1/12;
        case 2:
            $gainVal = 1/9;
        case 3:
            $gainVal = 1/6;
        case 4:
            $gainVal = 1/3;
    }

    $gain = $bet * ((1/($gainVal))/2 );
    $userMoney += $gain;
    $_SESSION['money'] = $userMoney;

    $sql = "UPDATE `users` SET money = '$userMoney' WHERE username = '$_SESSION[username]'";
    mysqli_query($conn, $sql);
}

function cellCategory($value){
    if ($value < 15){
        return 'poo';
    } else if ($value < 26){
        return 'hippo';
    } else if ($value < 36){
        return 'ghost';
    } else if ($value < 42){
        return 'umbrella';
    } else if ($value < 45){
        return 'cloud';
    } else {
        return 'bomb';
    }
}

function gameEval(&$gameArr){
    global $counts;

    // Count the occurrences of each category in the game array
    for ($i = 0; $i < 4; $i++) {
        for ($j = 0; $j < 5; $j++) {
            $category = cellCategory($gameArr[$i][$j]);
            $counts[$category]++;
        }
    }

    foreach ($counts as $category => $count) {
        if ($count >= 8) {
            cellPop($gameArr, $category);
        }
    }

    //if ($counts['bomb'] >= 3) {
    //    scatter();
    //}
}

function scatter(){
    global $bet;
    // Count the occurrences of 'bomb'
    echo "Scatter! You get 9 free spins!\n";
    $freeSpins = 9;
    $totalBet = 0;
        while ($freeSpins > 0) {
            clearScreen();
            spin($gameArr);
            cellOut($gameArr); 
            gameEval($gameArr); 
            echo 'Total: '. $totalBet;
            $totalBet += $bet;
            for ($i = 0; $i < 4; $i++) {
                for ($j = 0; $j < 5; $j++) {
                    $category = cellCategory($gameArr[$i][$j]);
                    $counts[$category]++;
                }
            }

            if ($counts['bomb'] != 0){$freeSpins+=$counts['bomb'];}
            $freeSpins--;
        }
    }

?>

<style>
    .gameColumn{
    transition: margin-right 2s;
    display: inline-block;
    margin: 0 5;

    }

    .gameGrid{
    transition: margin-right 2s;
    display: block;
    text-align: center;
    
    }
  
    .gameCell{
    height: 75px;
    width: 75px;
    color: white;
    text-shadow: -3px 5px black;
    }

</style>