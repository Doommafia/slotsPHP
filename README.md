# slotsPHP
Working on a slots site in PHP, so you can gamble without all the downsides

# Logic

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
        reverse this for spawnrates (but starting from 0)
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
