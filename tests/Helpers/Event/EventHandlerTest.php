<?php


use PHPUnit\Framework\TestCase;
use Ballybran\Helpers\Event\EventHandler;
use Ballybran\Helpers\Event\Event;

class EventHandlerTest extends TestCase
{
    public function setUp()
    {
    }

    public function testConstructorCallsInternalMethods()
    {
        // Create a mock for the Observer class,
        // only mock the update() method.
        $observer = $this->getMockBuilder(EventHandler::class)
                         ->disableOriginalConstructor()
                         ->getMock();

        // Set up the expectation for the update() method
        // to be called only once and with the string 'something'
        // as its parameter.
        $observer->method('getEventName');
        // Create a EventHandler object and getEventName the mocked
        $obj = new EventHandler(new Event('onEvent'), 'data');
        $c = $obj->getEventName();

        $this->assertEquals('onEvent', $c);
    }

    /*
    * @dataProvider raiseProvider
    */
    public function testRaise()
    {
        $observer = $this->getMockBuilder(EventHandler::class)
                         ->disableOriginalConstructor()
                         ->getMock();

        // Set up the expectation for the update() method
        // to be called only once and with the string 'something'
        // as its parameter.
        $observer->method('raise');

        // Create a EventHandler object and getEventName the mocked
        $args = ['args' => 7];
        $obj = new EventHandler(new Event('onEvent'), 'EventHandlerTest::TestData');
        $c = $obj->raise('onEvent', $args);
        $this->assertEquals($args, $c);
    }

    public static function TestData($sender, $args)
    {
        $arg = ['args' => 7];

        var_dump($sender);

        self::assertEquals($arg, $args);
    }
}
