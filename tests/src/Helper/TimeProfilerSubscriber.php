<?php
namespace ivol\tests\Helper;

use ivol\EventDispatcher\AfterExecuteEvent;
use ivol\EventDispatcher\BeforeExecuteEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TimeProfilerSubscriber implements EventSubscriberInterface
{
    /** @var float  */
    private $startTime = -1;
    /** @var float  */
    private $profiledTime = -1;

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            BeforeExecuteEvent::EVENT_NAME => 'start',
            AfterExecuteEvent::EVENT_NAME => 'stop'
        );
    }

    public function start()
    {
        $this->startTime = microtime(true);
    }

    public function stop()
    {
        $this->profiledTime = microtime(true) - $this->startTime;
    }

    public function getProfiledTimestamp()
    {
        if ($this->profiledTime < 0) {
            throw new \RuntimeException('Profiling not started yet');
        }
        return $this->profiledTime;
    }
}