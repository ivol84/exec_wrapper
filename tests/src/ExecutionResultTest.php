<?php
namespace ivol\tests;

use ivol\ExecutionResult;

class ExecutionResultTest extends \PHPUnit_Framework_TestCase
{
    public function testGetOutputOnEmptyOutput()
    {
        $sut = new ExecutionResult(0, array());

        $this->assertEquals('', $sut->getOutput());
    }
}