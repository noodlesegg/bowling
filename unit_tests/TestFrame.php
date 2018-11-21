 <?php
use PHPUnit\Framework\TestCase;
use Org\Bowling\Frame;

/**
 * Class TestFrame
 * @author marjune <marjunebatac@gmail.com>
 */
class TestFrame extends TestCase
{
    /**
     * If the arguments passed for pin is not between one and three then expect a InvalidArgumentException
     */
    public function testPinWithInValidNumberOfArguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $pin = new Frame();
        $pin->getPins();
    }
    /**
     * If not strike, then input number should between zero and ten
     */
    public function testPinShouldBetweenZeroAndTen()
    {
        $pins = new Frame(1, 7);
        foreach ($pins->getPins() as $pin) {
            $this->assertTrue($pin >= 0);
            $this->assertTrue($pin <= 10);
        }
    }

    /**
     * Attempts per frame should only two times
     */
    public function testPinCountShouldBeTwoIfNotStrikeInFirstAttempt()
    {
        $pins = new Frame(8, 3);
        $this->assertTrue(2 == count($pins->getIterator()));
    }

    /**
     * If first attempt is strike then there's no longer second attempt
     */
    public function testPinCountShouldOnlyOneIfFirstAttemptIsStrike()
    {
        $pins = new Frame(10);
        $this->assertTrue(1 == count($pins->getIterator()));
    }

    /**
     * Get total score per frame, it should be 19 or less
     */
    public function testCalculateScorePerFrame()
    {
        $pins = new Frame(5, 9);
        $this->assertEquals(14, $pins->getScore());
    }
}
