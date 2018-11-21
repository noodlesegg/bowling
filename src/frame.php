<?php
namespace Org\Bowling;

/**
 * Class Frame
 * @package Org\Bowling
 * @author marjune <marjunebatac@gmail.com>
 */
class Frame implements \IteratorAggregate
{
    /**
     * @var array
     */
    private $pins = [];

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     * @codeCoverageIgnore
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->pins);
    }

    /**
     * Pin constructor.
     * @throws \InvalidArgumentException
     */
    public function __construct()
    {
        $pins = func_get_args();
        if (empty($pins) || count($pins) > 3) {
            throw new \InvalidArgumentException(
                'Invalid number of arguments. It should be between 1 and three'
            );
        }
        foreach ($pins as $pin) {
            if (false === $this->isCorrectInput($pin)) {
                throw new \InvalidArgumentException(
                    'Invalid input. It should be integer between zero and ten'
                );
            }
            $this->add($pin);
        }
    }

    /**
     * Check if integer input
     * @return bool
     */
    private function isCorrectInput($pin)
    {
        if (is_int($pin) && $pin >= 0 && $pin <= 10) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getPins()
    {
        return $this->pins;
    }

    /**
     * @param $pin
     */
    private function add($pin)
    {
        $this->pins[] = $pin;
    }

    /**
     * Calculate score per frame which is consists of at least one attempt up to three.
     * @return int
     */
    public function getScore()
    {
        $score = 0;
        foreach ($this->pins as $pin) {
            $score += $pin;
        }
        return $score;
    }
}