# slotsPHP
Working on a slots site in PHP, so you can gamble without all the downsides

# Logic

  5x4 array
  [][][][][]
  [][][][][]
  [][][][][]
  [][][][][]

Rolling:
  roll columns L->R__
  rand() 4 times, 1s/roll of__

Symbols:__
Scatter - 1/25 (need 3 for a scatter)__
Default - 5%__
        (can be any of 5, each with a diff value, __
        multiples of 3 as values, __
        1/3 -> cheapest | 1/6 | 1/9 | 1/12 | 1/15__
        reverse this for spawnrates (but starting from 0)__
        1-15 -> cheapest | 16 - 28 -> etc..__
        $gain = round(money * ((1/rarityMax)/2))__
        -----__
        Examples:__
        $gain = round(0.10 * ((1/(1/15))/2 ))) = 7.50$__
        $gain = round(0.10 * ((1/(1/3))/2)) = 1.67$__
        ----__
Wild - Multipliers or smt idk__

Pop:__
    5 of same type__
     -> del those values __
     -> rest of them "fall down"__
        - decrease Y, til value is not 0, starting from 2nd row__
        - then generate new values to fill in 0's starting from 1st row__
        they HAVE to be seperate functions, that run in that order__

Scatter:__
    3 scatters required__
     -> 9 free spins (+1 per each new scatter you discover during the spins)__
     -> spin to decide multiplier/effect (affects $gain)__
