<?php
namespace ivol\tests\Helper;

use ivol\EventDispatcher\AfterExecuteEvent;
use ivol\EventDispatcher\BeforeExecuteEvent;

class TestListener
{
    /**
     * @var Event[]
     */
    private $events = array();

    public function before(BeforeExecuteEvent $event) {
        $this->events[] = $event;
    }

    public function after(AfterExecuteEvent $event) {
        $this->events[] = $event;
    }

    /**
     * @return \Composer\EventDispatcher\Event[]
     */
    public function getEvents()
    {
        return $this->events;
    }
}