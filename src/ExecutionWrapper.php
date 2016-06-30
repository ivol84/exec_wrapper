<?php
namespace ivol;

use ivol\Config\ConfigurationFactory;
use ivol\EventDispatcher\AfterExecuteEvent;
use ivol\EventDispatcher\BeforeExecuteEvent;
use ivol\EventDispatcher\EscapeArgsSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ExecutionWrapper
{
    /** @var array  */
    private $config;
    /** @var EventDispatcher */
    private $eventDispatcher;

    /**
     * @param array $config
     */
    public function __construct($config = array())
    {
        $this->config = ConfigurationFactory::createFromArray($config);
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
     * @return ExecutionResult
     */
    public function exec($command, $params)
    {
        $execParams = new ExecutionContext($command, $params);
        $execParams->setConfig($this->config);
        $beforeExecuteEvent = new BeforeExecuteEvent($execParams);
        $this->eventDispatcher->dispatch(BeforeExecuteEvent::EVENT_NAME, $beforeExecuteEvent);
        exec($beforeExecuteEvent->getParams()->getFullCommand(), $output, $returnValue);
        $output = $output ?: array();
        $afterExecuteEvent = new AfterExecuteEvent(new ExecutionResult($returnValue, $output));
        $this->eventDispatcher->dispatch(AfterExecuteEvent::EVENT_NAME, $afterExecuteEvent);
        return $afterExecuteEvent->getResult();
    }
}