<?php
namespace Org\Bowling;

/**
 * Class Game
 * @package Org\Bowling
 * @author marjune <marjunebatac@gmail.com>
 */
class Game
{
    /**
     * @var array
     */
    private $attempts = [];

    /**
     * @var array
     */
    private $scores = [];

    /**
     * @param array $attempt
     */
    private function addFrame(array $attempt)
    {
        $this->attempts[] = $attempt;
    }

    /**
     * Frame constructor.
     * @throws \InvalidArgumentException
     * @param array $attempts
     */
    public function __construct(array $attempts)
    {
        if (empty($attempts)) {
            throw new \InvalidArgumentException('Invalid arguments. The game is not yet finished');
        }
        foreach ($attempts as $attempt){
            if (false === $this->checkFrame($attempt)) {
                throw new \InvalidArgumentException('Invalid input');
            }
            $this->addFrame($attempt->getPins());
        }
    }

    /**
     * validate per frame according to rules
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function isValidGame()
    {
        $frames = $this->getAttempts();
        if (count($frames) < 10) {
            throw new \InvalidArgumentException(
                "Incomplete game. It should be ten frames in total"
            );
        }
        foreach ($frames as $frameIndex => $knockedPins)
        {
            if ($frameIndex < 9) {
                if ($this->ifStrike($knockedPins[0]) && count($knockedPins) > 1) {
                    throw new \InvalidArgumentException(
                        "There should no second attempt if strike at first attempt"
                    );
                } elseif (
                    !$this->ifStrike($knockedPins[0]) &&
                    (!in_array(count($knockedPins), [2]))
                ) {
                    throw new \InvalidArgumentException(
                        "There should be two attempts except the last frame"
                    );
                }
            } else {
                if (count($knockedPins) < 3) {
                    throw new \InvalidArgumentException(
                        "The last frame should have three attempts"
                    );
                }
            }
        }
        return true;
    }

    /**
     * check if input is valid
     * @param $frame Frame
     * @return bool
     */
    private function checkFrame(Frame $frame)
    {
        if ($frame instanceof Frame) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * @return array
     */
    public function getScores()
    {
        if ($this->isValidGame()) {
            $this->calculateScore();
            return $this->scores;
        }
        return [];
    }

    /**
     * Calculate total score according to the rules
     * 1. No additional score for a spare.
     * 2. If a bowler knocks down all ten pins on the first throw, it’s a strike.
     *    A strike is worth 10, plus the score in the next frame if the next frame is not a strike.
     *    If the next frame is also a strike, which means the bowler has made two strikes,
     *    then the score from the third frame is also added to the first frame.
     *      Ex. 10 (first frame)+10 (second frame)+10 (third frame) results in the first frame with a score of 30.
     *      Ex. 10 (first frame)+6 (second frame) results in the first frame with a score of 16.
     * 3. If a strike is not made in a frame, the score of the frame is just the sum of pins knocked down.
     * 4. The last frame has up to three throws. If a bowler had a strike on the first throw,
     *    the bowler is allowed to have one additional throw. So the bowler has three throws in total.
     *    If the bowler made two strikes he will still be able to do the last throw
     */
    private function calculateScore()
    {
        // calculate total score
        foreach (range(0, 9) as $frameIndex) {
            // for strike do special calculation
            if ($this->ifStrike($this->getAttempts()[$frameIndex][0]) && $frameIndex < 9) {
                $this->scores[$frameIndex] = 10 + $this->scores[$frameIndex - 1] + $this->getScorePerFrame($frameIndex+1);
                continue;
            }
            // normal calculation here
            $this->scores[$frameIndex] = @$this->scores[$frameIndex - 1] + @$this->getScorePerFrame(($frameIndex));
        }

    }

    /**
     * @param int $frameIndex
     * @return int
     */
    private function getScorePerFrame(int $frameIndex)
    {
        $frame = $this->getAttempts()[$frameIndex];
        $score = 0;
        foreach ($frame as $pin) {
            $score += $pin;
        }
        return $score;
    }

    /**
     * @param int $attempt
     * @return bool
     */
    private function ifStrike(int $attempt)
    {
        if (10 === $attempt) {
            return true;
        }
        return false;
    }
}