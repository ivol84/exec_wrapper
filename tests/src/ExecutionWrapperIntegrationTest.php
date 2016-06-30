<?php
namespace ivol\tests;

use ivol\EventDispatcher\AfterExecuteEvent;
use ivol\EventDispatcher\BeforeExecuteEvent;
use ivol\ExecutionContext;
use ivol\ExecutionWrapper;
use ivol\tests\Helper\TimeProfilerSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExecutionWrapperIntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function testExecuteSubscriber()
    {
        $sut = new ExecutionWrapper();
        $profiler = new TimeProfilerSubscriber();
        $sut->getEventDispatcher()->addSubscriber($profiler);

        $sut->exec('echo %s', array("'123'"));

        $this->assertTrue($profiler->getProfiledTimestamp() > 0);
    }
}