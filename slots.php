<script>let moneyBet;
document.querySelector("#btn").addEventListener("click", () => {
    moneyBet = document.querySelector("#moneyBet").value;
});
</script>

<input id="moneyBet" />
<button id="btn">Click me</button>

<?php
include_once 'dbConn.php';
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $_SESSION['username'] = $_POST['username'];
    $sql = "SELECT * FROM users WHERE username = '$_POST[username]' AND password = '$_POST[password]'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $_SESSION['userMoney'] = $row['userMoney'];
        header("Location: slots.php");
    } else {
        echo "How are u here?";
    }
}



/*
5x4 array
[][][][][]
[][][][][]
[][][][][]
[][][][][]

Rolling:
    roll columns L->R
    rand() 4 times, 1s/roll of

Symbols:
Scatter - 1/25 (need 3 for a scatter)
Default - 5%
        (can be any of 5, each with a diff value, 
        multiples of 3 as values, 
        1/3 -> cheapest | 1/6 | 1/9 | 1/12 | 1/15
        reverse this for spawnrates
        1-15 -> cheapest | 16 - 28 -> etc..
        $gain = round(money * ((1/rarityMax)/2))
        -----
        Examples:
        $gain = round(0.10 * ((1/(1/15))/2 ))) = 7.50$
        $gain = round(0.10 * ((1/(1/3))/2)) = 1.67$
        ----
Wild - Multipliers or smt idk

Pop:
    5 of same type
     -> del those values 
     -> rest of them "fall down"
        - decrease Y, til value is not 0, starting from 2nd row
        - then generate new values to fill in 0's starting from 1st row
        they HAVE to be seperate functions, that run in that order

Scatter:
    3 scatters required
     -> 9 free spins (+1 per each new scatter you discover during the spins)
     -> spin to decide multiplier/effect (affects $gain)

*/

$userMoney = $_SESSION['userMoney'];

$gain = 0;
$gainVal = 0;
$bet = $_POST['betAmt'];
$gameArr = array_fill(0, 5, array_fill(0, 4, 0));

function spin(&$gameArr){
    for ($i = 0; $i < 5; $i++) {
        array_unshift($gameArr[$i], rand(0, 46)); 
        array_pop($gameArr[$i]);
    }
}

function cellOut($gameArr){
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 4; $j++) {
            if ($gameArr[$i][$j] < 15){
                echo '<i class="fa-solid fa-poo fa-4x"></i>';
            } else if ($gameArr[$i][$j] < 26){
                echo '<i class="fa-solid fa-hippo fa-4x"></i>';
            } else if ($gameArr[$i][$j] < 36){
                echo '<i class="fa-solid fa-ghost fa-4x"></i>';
            } else if ($gameArr[$i][$j] < 42){
                echo '<i class="fa-solid fa-umbrella fa-4x"></i>';
            } else if ($gameArr[$i][$j] < 45){
                echo '<i class="fa-solid fa-cloud fa-4x"></i>';
            } else {
                echo '<i class="fa-solid fa-bomb fa-4x"></i>';
            }
        }
    }
}

function cellPop(&$gameArr, $categoryToPop){
    // Pop the value
        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 4; $j++) {
                if (cellCategory($gameArr[$i][$j]) == $categoryToPop) {
                    $gameArr[$i][$j] = 0;  // Set the value to 0
                }
            }
        }

    // Drop the values
    for ($i = 4; $i > 0; $i--) {  // Start from the bottom row
        for ($j = 0; $j < 4; $j++) {
            if ($gameArr[$i][$j] == 0) {  // If the current cell is 0
                for ($k = $i - 1; $k >= 0; $k--) {  // Look for a non-zero cell in the column above
                    if ($gameArr[$k][$j] != 0) {
                        $gameArr[$i][$j] = $gameArr[$k][$j];  // Swap the values
                        $gameArr[$k][$j] = 0;
                        break;
                    }
                }
            }
        }
    }

    // Gen new values
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 4; $j++) {
            if ($gameArr[$i][$j] == 0) {
                $gameArr[$i][$j] = rand(0, 46);  // Generate a new random value
            }
        }
    }
    switch($categoryToPop){
        case 0:
            $gainVal = 1/3;

    }
    $gain = $bet * ((1/($gainVal))/2 );
    // update money on database and session, to be userMoney = userMoney + $gain
    $userMoney = $userMoney + $gain;
    $_SESSION['userMoney'] = $userMoney;
    // does this change it in the database aswell?
    $sql = "UPDATE users SET userMoney = '$userMoney' WHERE username = '$_SESSION[username]'";
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
    // Create an array to count the occurrences of each category
    $counts = array('poo' => 0, 'hippo' => 0, 'ghost' => 0, 'umbrella' => 0, 'cloud' => 0, 'bomb' => 0);

    // Count the occurrences of each category in the game array
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 4; $j++) {
            $category = cellCategory($gameArr[$i][$j]);
            $counts[$category]++;
        }
    }

    // Check if any category occurs 5 times -> pop
    foreach ($counts as $category => $count) {
        if ($count == 5) {
            // If a category occurs 5 times, pop and shift it
            cellPop($gameArr, $category);
        }
    }
}

function scatter(&$gameArr, &$money, $spinValue){
    // Count the occurrences of 'bomb'
    $bombCount = 0;
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 4; $j++) {
            if (cellCategory($gameArr[$i][$j]) == 'bomb') {
                $bombCount++;
            }
        }
    }

    // Check if there are at least 3 'bombs'
    if ($bombCount >= 3) {
        // Perform the scatter operation...
        echo "Scatter! You get 9 free spins!\n";
        $freeSpins = 9;

        while ($freeSpins > 0) {
            spin($gameArr);  // Spin the game array
            cellOut($gameArr);  // Display the game array

            // Add the spin value to the user's money
            $money += $spinValue;

            // Check for new 'bombs'
            $newBombCount = 0;
            for ($i = 0; $i < 5; $i++) {
                for ($j = 0; $j < 4; $j++) {
                    if (cellCategory($gameArr[$i][$j]) == 'bomb') {
                        $newBombCount++;
                    }
                }
            }

            // If there are 3 new 'bombs', add 9 more free spins
            if ($newBombCount >= 3) {
                echo "You got 3 more bombs! You get 9 more free spins!\n";
                $freeSpins += 9;
            }

            $freeSpins--;
        }
    }
}
