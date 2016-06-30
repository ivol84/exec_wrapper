<?php
namespace ivol\EventDispatcher;

use ivol\ExecutionResult;
use Symfony\Component\EventDispatcher\Event;

class AfterExecuteEvent extends Event
{
    const EVENT_NAME = 'exec-wrapper.after_execute';
    /** @var  ExecutionResult */
    private $result;

    /**
     * @param ExecutionResult $result
     */
    public function __construct(ExecutionResult $result)
    {
        $this->result = $result;
    }

    /**
     * @return ExecutionResult
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param ExecutionResult $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }
}