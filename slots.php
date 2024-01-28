<?php
/*
5x4 array
[][][][][]
[][][][][]
[][][][][]
[][][][][]

Rolling:
    roll columns L->R
    random() 5 times, 1s/roll

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

$gameArr [5][4];

function spin(){
    for ($i = 0; $i < 4; $i++) {
            $gameArr[i][0] = rand(0,45);
            $gameArr[i][1] = rand(0,45);
            $gameArr[i][2] = rand(0,45);
            $gameArr[i][3] = rand(0,45);
        }
}

function cellVal(){
    for ($i = 0; $i < 5; $i++) {
        for( $j = 0; $j < 4; $j++){
            if ($gameArr[$i][$j] < 15){
                echo'<i class="fa-solid fa-poo fa-4x"></i>';
            }else if ($gameArr[$i][$j] < 26 & $gameArr[$i][$j] >= 15){
                echo '<i class="fa-solid fa-hippo fa-4x"></i>';
            }else if ($gameArr < 36 & $gameArr[$i][$j] >= 27 ){
                echo '<i class="fa-solid fa-ghost fa-4x"></i>';
            }else if ($gameArr < 42 & $gameArr[$i][$j] >= 36){
                echo '<i class="fa-solid fa-umbrella fa-4x"></i>';
            }else if ($gameArr < 45 & $gameArr[$i][$j] >= 42){
                echo '<i class="fa-solid fa-cloud fa-4x"></i>';
            }else if ($gameArr >= 45){
                echo '<i class="fa-solid fa-bomb fa-4x"></i>';
                }
            }
    }
}
