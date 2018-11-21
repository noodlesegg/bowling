<?php
use PHPUnit\Framework\TestCase;
use Org\Bowling\Game;
use Org\Bowling\Frame;

/**
 * Class TestGame
 * @author marjune <marjunebatac@gmail.com>
 */
class TestGame extends TestCase
{
    /**
     * Per game, it should be a total of ten Games
     */
    public function testGameShouldHaveTotalOfTen()
    {
        // [[5,2],[8,1],[6,4],[10],[0,5],[2,6],[8,1],[5,3],[6,1],[10,2,6]]
        $game = new Game(
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
        $this->assertEquals(10, count($game->getAttempts()));
    }

    /**
     * Test that the last Game should have three attempts in total
     */
    public function testThatTheLastGameShouldHaveThreeAttempts()
    {
        $game = new Game(
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
        $lastAttempt = $game->getAttempts()[9];
        $this->assertEquals(3, count($lastAttempt));
    }

    /**
     * Test if Game is empty then it should throw an \InvalidArgumentException
     */
    public function testIncompleteGame()
    {
        $this->expectException(\InvalidArgumentException::class);
        $game = new Game([]);
        $game->getAttempts();
    }

    /**
     * test incomplete game
     */
    public function testPerGameShouldBeValidNumberOfAttempts()
    {
        $this->expectException(\InvalidArgumentException::class);
        $game = new Game(
            [
                new Frame(5,2),
                new Frame(8,1),
                new Frame(6,4),
                new Frame(10),
                new Frame(0,5),
                new Frame(2,6)
            ]
        );
        $this->assertTrue($game->isValidGame());
    }

    /**
     * Test too many attempts
     */
    public function testTooManyAttempts()
    {
        $this->expectException(\InvalidArgumentException::class);
        $game = new Game(
            [
                new Frame(5,2),
                new Frame(8,1),
                new Frame(6,4,9),
                new Frame(10),
                new Frame(0,5),
                new Frame(2,6),
                new Frame(8,1),
                new Frame(5,3),
                new Frame(6,1),
                new Frame(10,2,6),
            ]
        );
        $game->isValidGame();
    }

    /**
     * Test for complete and valid game
     */
    public function testCompleteAndValidGame()
    {
        $game = new Game(
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
        $this->assertTrue($game->isValidGame());
    }

    /**
     * Test for the total score per game.
     */
    public function testTotalScorePerGame()
    {
        $game = new Game(
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
        $this->assertEquals(
            [7, 16, 26, 41, 46, 54, 63, 71, 78, 96],
            $game->getScores()
        );
    }
}