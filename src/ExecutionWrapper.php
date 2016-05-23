<?php
namespace ivol;

use ivol\EventDispatcher\AfterExecuteEvent;
use ivol\EventDispatcher\BeforeExecuteEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ExecutionWrapper
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    /** @var array */
    private $observers = array();

    public function __construct()
    {
        $this->eventDispatcher = new EventDispatcher();
    }

    /**
     * @return EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @param string $command Sprintf formatted string @see http://php.net/manual/en/function.sprintf.php
     * @param array $params
     * @return Result
     */
    public function exec($command, $params)
    {
        $beforeExecuteEvent = new BeforeExecuteEvent(new ExecParams($command, $params));
        $this->eventDispatcher->dispatch(BeforeExecuteEvent::EVENT_NAME, $beforeExecuteEvent);
        exec($beforeExecuteEvent->getParams()->getFullCommand(), $output, $returnValue);
        $afterExecuteEvent = new AfterExecuteEvent(new Result($returnValue, $output));
        $this->eventDispatcher->dispatch(AfterExecuteEvent::EVENT_NAME, $afterExecuteEvent);
        return $afterExecuteEvent->getResult();
    }
}