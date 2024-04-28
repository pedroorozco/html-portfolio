<?php
    /* Using session to check if its player's first playthrough. If it is, date is logged once
     * If player resets game, session is destroyed and reset once they hit play again to log
     * date again. Will also use session to modify play button text
     */
    session_start();

    // I have these two dice roll variables set to 1 up here so upon page refresh 
    // or first load of site the dice images are set to dice number 1 for both
    $diceRollOne = 1;
    $diceRollTwo = 1;

    // Function for rolling dice
    function rollDice() {
        return rand(1,6);
    }

    // Fuction for log file
    function logEvent($message) {
        $logFile = 'log.txt';
        file_put_contents($logFile, $message, FILE_APPEND);
    }


    // Function to get results from pressing play
    function rollResults($diceRollOne, $diceRollTwo) {
        $sum = $diceRollOne + $diceRollTwo;

        switch ($sum) {
            case 7: 
            case 11: 
                return "Win";
            case 2:
            case 3:
            case 12:
                return "Lose";
            default:
                return "Roll again...";
        }
    }

    // Checking to see if this is player's first visit to game and initializing session variables
    // Decided to use session variable to check for win / loss and update button text accordingly
    // If no win / loss detected, play button text changes to roll again
    if (!isset($_SESSION['first_playthrough'])) {
        $_SESSION['first_playthrough'] = true;
    }

    if (!isset($_SESSION['button_text'])) {
        $_SESSION['button_text'] = "Play";
    }


    // Rolling dice when player clicks play button. This also sets dice images to correct dice rolls
    // Using this to update session based on roll result
    if (isset($_POST['playButton'])) {
        $diceRollOne = rollDice();
        $diceRollTwo = rollDice();
        $rollResult = rollResults($diceRollOne, $diceRollTwo);

        // Logging game start. Using session variable to make sure date only logs once play is pressed. 
        // This way pressing play multiple times will not log date mutiple times to clutter log file
        if ($_SESSION['first_playthrough']) {
            $date = new DateTime();
            logEvent("Game started on: " . $date->format('Y-m-d H:i:s') . "\n");
            $_SESSION['first_playthrough'] = false;     // Setting to false so date it not logged more than once
        }

        if ($rollResult === "Win" || $rollResult === "Lose") {
            $_SESSION['button_text'] = "Play";                // Reset button as well
        } else {
            $_SESSION['button_text'] = "Roll Again...";       // Change text from play to roll again
        }

        // Logging game results
        logEvent(($diceRollOne + $diceRollTwo) . "--" . "Roll Result: " . $rollResult . "\n");
    }

    $buttonText = $_SESSION['button_text'];             // Variable to set the text of play button to play or roll again

    // Reset game upon pressing reset
    if (isset($_POST['reset'])) {
        // Clearing log file upon reset 
        $logFile = 'log.txt';
        file_put_contents($logFile, '');

        session_destroy();                              // Destroying session on reset to restart entire game
        $_SESSION = array();                            // Clearing session array. Was having text display when clicking reset when not text needed to show
        
        $_SESSION['button_text'] = "Play";              // Hard coding play button text after reset
        header("Location: " . $_SERVER['PHP_SELF']);    // Refresh page

        
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Craps Game</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="./styles.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="leftContainer">
                <h1>Craps Game!</h1>
                <form method="post">
                        <input type="submit" value="<?php echo $buttonText; ?>" name="playButton"/>
                        <input type="submit" value="Reset" name="reset" onclick="resetImages()"/>                    
                </form>            
                <div class="displayWinLoss">
                    <!-- Displaying "Win" or "Lose" text -->
                    <?php if (isset($rollResult) && !empty($_SESSION)): ?>
                        <?php switch ($rollResult): case "Win": ?>
                                <p>You win!</p>
                        <?php break; case "Lose":?>
                                <p>You lose!</p>
                                <?php break; ?>
                        <?php endswitch; ?>
                    <?php else: ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="rightContainer">
                <div>
                    <img src="./images/dice/<?php echo $diceRollOne; ?>.png" />
                </div>

                <div>
                    <img src="./images/dice/<?php echo $diceRollTwo; ?>.png" />
                </div>
            </div>
        </div>

        <!-- Has class name header because I originally had it up top. Did not know if looked better on top or bottom but kept on bottom too lazy to change class name -->
        <div class="header">
            <button id="game-info" onclick="gameInstructions()";>Click Here for Game Rules</button>
            <div id="game-instructions" class="instructions">
                <h2>Rules: </h2>
                <p>
                    Press 'Play' button to begin a match. This will cause 
                    game to roll both Dice seen above. Roll Dice to attempt and get a 7 or 11 roll. This 
                    results in a win. Rolling a 2, 3 or 12 results in a loss. All other rolls and you must 
                    keep rolling dice.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Function to set both images to dice number 1 on reset click
        function resetImages() {
            // Reset dice images to initial state
            let diceImages = document.querySelectorAll('.rightContainer div img');
            for (let i = 0; i < diceImages.length; i++) {
                diceImages[i].src = "./images/dice/1.png";
            }
        }

        // Function to reveal instructions / game rules to user
        function gameInstructions() {
            let instructions = document.getElementById("game-instructions");
            instructions.classList.toggle("show");
        }
    </script>

</body>
</html>