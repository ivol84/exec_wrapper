<?php

namespace ivol\EventDispatcher;


use ivol\ExecParams;
use Symfony\Component\EventDispatcher\Event;

class BeforeExecuteEvent extends Event
{
    const EVENT_NAME = 'exec-wrapper.before_execute';
    /** @var ExecParams */
    private $params;

    /**
     * @param ExecParams $params
     */
    public function __construct(ExecParams $params)
    {
        $this->params = $params;
    }

    /**
     * @return ExecParams
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param ExecParams $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
}