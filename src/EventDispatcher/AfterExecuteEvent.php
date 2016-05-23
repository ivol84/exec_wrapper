<?php
namespace ivol\EventDispatcher;

use ivol\Result;
use Symfony\Component\EventDispatcher\Event;

class AfterExecuteEvent extends Event
{
    const EVENT_NAME = 'exec-wrapper.after_execute';
    /** @var  Result */
    private $result;

    /**
     * @param Result $result
     */
    public function __construct(Result $result)
    {
        $this->result = $result;
    }

    /**
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param Result $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }
}