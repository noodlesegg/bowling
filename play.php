<?php
namespace Org\Bowling;
require_once 'vendor/autoload.php';
echo "<pre>";
$player1 = new Game(
    [
        new Frame(5,2),
        new Frame(8,1),
        new Frame(6,4),
        new Frame(10),
        new Frame(0,5),
        new Frame(2,6),
        new Frame(8,1),
        new Frame(5,3),
        new Frame(6,1),
        new Frame(10,2,6),
    ]
);

echo "Player 1 score   ";
print_r($player1->getScores());

$player2 = new Game(
    [
        new Frame(10),
        new Frame(8,1),
        new Frame(6,4),
        new Frame(10),
        new Frame(0,5),
        new Frame(10),
        new Frame(8,1),
        new Frame(5,3),
        new Frame(6,1),
        new Frame(9,2,6),
    ]
);
echo "Player 2 score   ";
print_r($player2->getScores());