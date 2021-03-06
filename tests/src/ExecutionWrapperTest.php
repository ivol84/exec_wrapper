<?php
namespace ivol\tests;

use Composer\EventDispatcher\Event;
use ivol\Config\ConfigurationFactory;
use ivol\EventDispatcher\AfterExecuteEvent;
use ivol\EventDispatcher\BeforeExecuteEvent;
use ivol\ExecutionContext;
use ivol\ExecutionWrapper;
use ivol\ExecutionResult;
use ivol\tests\Helper\TestListener;

class ExecutionWrapperTest extends \PHPUnit_Framework_TestCase
{
    /** @var ExecutionWrapper */
    private $sut;

    protected function setUp()
    {
        $this->sut = new ExecutionWrapper();
    }

    public function testExecuteReturnsResult()
    {
        $result = $this->sut->exec('echo %s', array('123'));

        $this->assertEquals(0, $result->getReturnCode());
        $this->assertEquals('123', $result->getOutput());
    }

    public function testExecuteEscapesDataByDefault()
    {
        $this->sut = new ExecutionWrapper();
        $result = $this->sut->exec('echo ? %s', array("'"));

        $this->assertEquals(0, $result->getReturnCode());
        $this->assertEquals("? \'", $result->getOutput());
    }

    public function testExecuteDoesntEscapesCmdWithConfig()
    {
        $this->sut = new ExecutionWrapper(['escape_shell_cmd' => false]);
        $result = $this->sut->exec('echo ? %s', array("'"));

        $this->assertEquals(0, $result->getReturnCode());
        $this->assertEquals("? '", $result->getOutput());
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
        $this->assertEquals(new ExecutionContext('echo %s', array('123')), $actualEvents[0]->getParams());
        $this->assertInstanceOf('ivol\EventDispatcher\AfterExecuteEvent', $actualEvents[1]);
        $this->assertEquals(new ExecutionResult(0, array('123')), $actualEvents[1]->getResult());
    }
}