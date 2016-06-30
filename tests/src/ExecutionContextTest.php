<?php
namespace ivol\tests;

use ivol\Config\ConfigurationFactory;
use ivol\ExecutionContext;

class ExecutionContextTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ExecutionContext */
    private $sut;

    protected function setUp()
    {
        $this->sut = new ExecutionContext('echo ? %s', array("'123"));
    }

    public function testGetParamsReturnsEscapedParamsByDefault()
    {
        $this->assertEquals(["''\''123'"], $this->sut->getParams());
    }

    public function testGetParamsReturnsNotEscapedParamsIfConfigured()
    {
        $this->sut->setConfig(['escape_shell_args' => false]);

        $this->assertEquals(["'123"], $this->sut->getParams());
    }

    public function testGetFullCommandReturnsEscapedCommandByDefault()
    {
        $this->assertEquals("echo \? ''\\\\''123\'", $this->sut->getFullCommand());
    }

    public function testGetFullCommandReturnsNotEscapedCommandIfConfigured()
    {
        $this->sut->setConfig(ConfigurationFactory::createFromArray(['escape_shell_cmd' => false]));

        $this->assertEquals("echo ? ''\''123'", $this->sut->getFullCommand());
    }

    public function testGetFullCommandReturnsNotEscapedCommandAndArgsIfConfigured()
    {
        $this->sut->setConfig(ConfigurationFactory::createFromArray(['escape_shell_cmd' => false, 'escape_shell_args' => false]));

        $this->assertEquals("echo ? '123", $this->sut->getFullCommand());
    }

}