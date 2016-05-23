<?php

use Composer\EventDispatcher\Event;
use ivol\EventDispatcher\AfterExecuteEvent;
use ivol\EventDispatcher\BeforeExecuteEvent;
use ivol\ExecParams;
use ivol\ExecutionWrapper;
use ivol\Result;

class ExecuteTest extends PHPUnit_Framework_TestCase
{
    /** @var ExecutionWrapper */
    private $sut;

    protected function setUp()
    {
        $this->sut = new ExecutionWrapper();
    }

    public function testExecuteReturnsReturnResult()
    {
        $result = $this->sut->exec('echo %s', array('123'));

        $this->assertEquals(0, $result->getReturnCode());
        $this->assertEquals('123', $result->getOutput());
    }

    public function testExecuteNotifyBeforeAndAfterExecute()
    {
        $eventListener = new TestListener();
        $this->sut->getEventDispatcher()->addListener(BeforeExecuteEvent::EVENT_NAME, array($eventListener, 'before'));
        $this->sut->getEventDispatcher()->addListener(AfterExecuteEvent::EVENT_NAME, array($eventListener, 'after'));

        $this->sut->exec('echo %s', array('123'));

        $actualEvents = $eventListener->getEvents();
        $this->assertCount(2, $actualEvents);
        $this->assertInstanceOf('ivol\EventDispatcher\BeforeExecuteEvent', $actualEvents[0]);
        $this->assertEquals(new ExecParams('echo %s', array('123')), $actualEvents[0]->getParams());
        $this->assertInstanceOf('ivol\EventDispatcher\AfterExecuteEvent', $actualEvents[1]);
        $this->assertEquals(new Result(0 , array('123')), $actualEvents[1]->getResult());
    }
}

class TestListener
{
    /**
     * @var Event[]
     */
    private $events = array();

    public function before(BeforeExecuteEvent $event) {
        $this->events[] = $event;
    }

    public function after(AfterExecuteEvent $event) {
        $this->events[] = $event;
    }

    /**
     * @return \Composer\EventDispatcher\Event[]
     */
    public function getEvents()
    {
        return $this->events;
    }
}