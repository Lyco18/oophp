<?php

namespace Anax\View;

/**
 * Render content within an game.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<h1>Guess My Number</h1>
<h3>Im thinking of a number in between 1 and 100. You have <?= $tries ?> guesses left!</h3>
<form method="POST">
    <input type="text" name="guess">

    <input type="submit" name="doGuess" value="Guess!">
    <input type="submit" name="doInit" value="Restart!">
    <input type="submit" name="doCheat" value="Cheat!">
</form>

<?php if ($res) : ?>
    <p>Your guess is <?= $guess ?> is <b><?= $res ?></b></p>
<?php endif; ?>
<?php if ($doCheat) : ?>
    <p>The number is: <?= $number ?></p>
<?php endif; ?>
