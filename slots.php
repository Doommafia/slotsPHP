<?php
    include_once 'logic.php';
    
?>

<script>
var gameArr = /* Your game array */;
var gameBoard = document.getElementById('gameBoard');

// Clear the game board
while (gameBoard.firstChild) {
    gameBoard.removeChild(gameBoard.firstChild);
}

// Create new rows and cells
for (var i = 0; i < gameArr.length; i++) {
    var row = document.createElement('tr');
    for (var j = 0; j < gameArr[i].length; j++) {
        var cell = document.createElement('td');
        cell.textContent = gameArr[i][j];  // Replace this with the appropriate icon
        row.appendChild(cell);
    }
    gameBoard.appendChild(row);
}

</script>


<table id="gameBoard">
    <!-- Rows of the game board will go here -->
</table>

<style>
    @keyframes scroll {
    0% { transform: translateY(0); }
    100% { transform: translateY(-100%); }
}

#gameBoard td {
    animation: scroll 1s linear infinite;
}

</style>