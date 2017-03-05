<?php

function compare_integers($int1, $int2) {
    if ($int1 < $int2) {
        return -1;
    }
    if ($int1 == $int2) {
        return 0;
    }
    if ($int1 > $int2) {
        return 1;
    }
}

//$random = filter_has_var(INPUT_POST, 'random') ? htmlspecialchars($_POST['random']) : rand(1, 20);

if (filter_has_var(INPUT_POST, "random")) {
    $random = filter_input(INPUT_POST, "random", FILTER_SANITIZE_NUMBER_INT);
} else {
    $random = rand(1, 20);
}



if (filter_has_var(INPUT_POST, "guess")) {
    $guess = filter_input(INPUT_POST, "guess", FILTER_SANITIZE_NUMBER_INT);
    if ($guess < 1 || $guess > 20) {
        $message = "Invalid guess. Please enter a number between 1 and 20.";
    } else {
        $result = compare_integers($guess, $random);
        switch ($result) {
            case -1:
                $message = "Your guess " . $guess . " was way to low.";
                break;
            case 0:
                $message = "Congratulations! You guessed the hidden number!";
                unset($random);
                break;
            case 1:
                $message = "Your guess " . $guess . " was way to high.";
                break;
        }
    }
}
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Guessing Game</title>
        <link rel="stylesheet" href="lib/css/reset.css">
        <style>
            * {
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
            }
            body {
                background-color: cornsilk;
                padding: 0;
                margin: 0;
            }
            div.container {
                display: block;
                width: 100%;
                max-width: 600px;
                height: auto;
                background-color: #fff;
                padding: 20px;
                margin: 20px auto;
            }
            div.container h1 {
                font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
                font-size: 1.8rem;
                line-height: 1.5;
                text-align: center;
            }
            div.container p {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 1.2rem;
                line-height: 1.5;
                text-align: center;
            }
            form#game {
                display: block;
                width: 100%;
                max-width: 360px;
                height: auto;
                background-color: #2e2e2e;
                padding: 10px;
                margin: 0 auto;
            }
            form#game fieldset {
                border: 1px solid #fff;
                padding: 20px;
            }
            form#game legend {
                font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
                font-size: 1.2rem;
                color: #fff;
                padding: 0 5px;
            }
            form#game label {
                float: left;
                display: block;
                width: 100%;
                max-width: 200px;
                height: 30px;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 1.0rem;
                line-height: 30px;
                color: #fff;
            }
            form#game input {
                clear: right;
                display: block;
                width: 100%;
                max-width: 95px;
                height: 30px;
                padding: 0 5px;
            }
            form#game input[type=submit] {
                display: block;
                width: 100px;
                height: 30px;
                border: none;
                outline: none;
                cursor: pointer;
                background-color: #69c;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 1.2rem;
                text-transform: capitalize;
                color: #fff;
                margin: 15px auto 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>The Guessing Game Instructions</h1>
            <p>Pick a number between 1 and 20 then press the Guess button!</p>
        </div>
        <form id="game" action="guessing.php" method="post">
            <fieldset>
                <legend>The Guessing Game</legend>
                <label for="guess">Number between 1 and 20</label>
                <input id="guess" type="text" name="guess" value="">
                <input type="hidden" name="random" value="<?php echo $random; ?>">
                <input type="submit" name="submit" value="guess">
            </fieldset>
        </form>
        <?php if (isset($message)) { ?>
            <div class="container">
                <p><?php echo $message; ?></p>
            </div>
        <?php } ?>
    </body>
</html>