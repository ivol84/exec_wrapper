<?php
namespace ivol;

use ivol\Config\ConfigurationFactory;

class ExecParams
{
    /**
     * @var string Sprintf formatted string @see http://php.net/manual/en/function.sprintf.php
     */
    private $command;
    /** @var  array */
    private $params;
    /** @var  array */
    private $config;

    /**
     * @param $command
     * @param $params
     */
    public function __construct($command, $params)
    {
        $this->command = $command;
        $this->params = $params;
        $this->config = ConfigurationFactory::createFromArray();
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
        return $this->config['escape_shell_args'] ? $this->getEscapedParams() : $this->params;
    }

    /**
     * @return string
     */
    public function getFullCommand() {
        $params = $this->getParams();
        array_unshift($params, $this->command);
        $command = call_user_func_array('sprintf', $params);
        return $this->config['escape_shell_cmd'] ? escapeshellcmd($command) : $command;
    }

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    private function getEscapedParams() {
        $escapedArgs = array();
        foreach ($this->params as $param) {
            $escapedArgs[] = escapeshellarg($param);
        }
        return $escapedArgs;
    }
}