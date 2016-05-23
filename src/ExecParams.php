<?php

namespace ivol;

class ExecParams
{
    /**
     * @var string Sprintf formatted string @see http://php.net/manual/en/function.sprintf.php
     */
    private $command;
    /** @var  array */
    private $params;

    /**
     * @param $command
     * @param $params
     */
    public function __construct($command, $params)
    {
        $this->command = $command;
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getFullCommand() {
        $params = $this->params;
        array_unshift($params, $this->command);
        return call_user_func_array('sprintf', $params);
    }
}