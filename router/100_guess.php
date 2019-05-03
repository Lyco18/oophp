<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init game and redirect to play game.
 */
$app->router->get("guess/init", function () use ($app) {
    // init the session for game start;
    $game = new Lyds\Guess\Guess();

    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();

    return $app->response->redirect("guess/play");
});



/**
 * Play the game. show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the guess game";
    //incoming values
    $tries  = $_SESSION["tries"] ?? null;
    $number  = $_SESSION["number"] ?? null;
    $res    = $_SESSION["res"] ?? null;
    $guess  = $_SESSION["guess"] ?? null;
    $doCheat= $_SESSION["doCheat"] ?? null;

    $_SESSION["res"] = null;
    $_SESSION["guess"] = null;
    $_SESSION["doCheat"] = null;

    $data = [
        "guess" => $guess ?? null,
        "tries" => $tries,
        "res" => $res,
        "number" => $number,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat,
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Play the game. make a guess
*/
$app->router->post("guess/play", function () use ($app) {

    //incoming values
    $guess    = $_POST["guess"] ?? null;
    $doGuess  = $_POST["doGuess"] ?? null;
    $doInit   = $_POST["doInit"] ?? null;
    $doCheat  = $_POST["doCheat"] ?? null;

    //incomin sessions
    $number   = $_SESSION["number"] ?? null;
    $tries    = $_SESSION["tries"] ?? null;

    if ($doGuess) {
        //do a guess
        $game = new Lyds\Guess\Guess($number, $tries);
        $res = $game->makeGuess($guess);
        $_SESSION["tries"] = $game->tries();
        $_SESSION["res"] = $res;
        $_SESSION["guess"] = $guess;
    }

    if ($doInit) {
        // init the session for game start;
        $game = new Lyds\Guess\Guess();

        $_SESSION["number"] = $game->number();
        $_SESSION["tries"] = $game->tries();
    }

    if ($doCheat) {
        //cheat
        $_SESSION["doCheat"] = $doCheat;
    }

    return $app->response->redirect("guess/play");
});
