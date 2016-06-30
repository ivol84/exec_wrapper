<?php
namespace ivol;

class ExecutionResult
{
    /** @var array */
    private $output;
    /** @var int */
    private $returnCode;

    /**
     * @param int $returnCode
     * @param array $output
     */
    public function __construct($returnCode, $output)
    {
        $this->returnCode = $returnCode;
        $this->output = $output;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->output ? implode('\n', $this->output): '';
    }

    /**
     * @return int
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

}