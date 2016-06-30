<?php

namespace ivol\EventDispatcher;


use ivol\ExecutionContext;
use Symfony\Component\EventDispatcher\Event;

class BeforeExecuteEvent extends Event
{
    const EVENT_NAME = 'exec-wrapper.before_execute';
    /** @var ExecutionContext */
    private $params;

    /**
     * @param ExecutionContext $params
     */
    public function __construct(ExecutionContext $params)
    {
        $this->params = $params;
    }

    /**
     * @return ExecutionContext
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param ExecutionContext $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
}