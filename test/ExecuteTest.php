<?php

use ivol\AfterListener;
use ivol\BeforeListener;
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

    public function testExecuteReturnsReturnCode()
    {
        $result = $this->sut->exec('echo %s', array('123'));

        $this->assertEquals(0, $result->getReturnCode());
    }

    public function testExecuteReturnsOutput()
    {
        $result = $this->sut->exec('echo %s', array('123'));

        $this->assertEquals('123', $result->getOutput());
    }

    public function testExecuteCallsListenerBeforeRunningApplication()
    {
        $obeserver = $this->getMock('TestListener');
        $params = new ExecParams('echo %s', array('123'));
        $obeserver->expects($this->once())->method('before')->with($params)->will($this->returnValue($params));
        $this->sut->addObserver($obeserver);
        
        $this->sut->exec('echo %s', array('123'));
    }

    public function testExecuteCallsListenerAfterRunningApplication()
    {
        $obeserver = $this->getMock('TestListener');
        $obeserver->expects($this->any())->method('before')->will($this->returnValue(new ExecParams('echo %s', array('123'))));
        $result = new Result(0, array('123'));
        $obeserver->expects($this->once())->method('after')->with($result)->will($this->returnValue($result));
        $this->sut->addObserver($obeserver);

        $this->sut->exec('echo %s', array('123'));
    }
}

class TestListener implements BeforeListener, AfterListener
{

    /**
     * @param Result $result
     * @return Result
     */
    public function after(Result $result)
    {
    }

    /**
     * @param ExecParams $params
     * @return ExecParams
     */
    public function before(ExecParams $params)
    {
    }
}
