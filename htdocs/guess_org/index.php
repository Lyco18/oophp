<?php
/**
 * Guess my number
 */

include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload.php");

session_name("lyco18");
session_start();
//incoming values
$guess    = $_POST["guess"] ?? null;
$doInit   = $_POST["doInit"] ?? null;
$doGuess  = $_POST["doGuess"] ?? null;
$doCheat  = $_POST["doCheat"] ?? null;

$number   = $_SESSION["number"] ?? null;
$tries    = $_SESSION["tries"] ?? null;
$game     = null;

//Init the game

if ($doInit || $number === null) {
    $game = new Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
} elseif ($doGuess) {
    $game = new Guess($number, $tries);
    $res = $game->makeGuess($guess);
    $_SESSION["tries"] = $game->tries();
}

//Render page
require __DIR__ . "/view/guess.php";
