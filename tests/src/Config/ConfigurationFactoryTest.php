<?php

use ivol\Config\ConfigurationFactory;

class ConfigurationFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCreateFromArrayReturnsConfigurationByDefaultOnEmptyConfig()
    {
        $actual = ConfigurationFactory::createFromArray();
        
        $this->assertTrue($actual['escape_shell_args']);
        $this->assertTrue($actual['escape_shell_cmd']);
    }

    public function testCreateFromArrayReturnsConfigurationOnPassedArray()
    {
        $actual = ConfigurationFactory::createFromArray(['escape_shell_args' => false, 'escape_shell_cmd'=> false]);

        $this->assertFalse($actual['escape_shell_args']);
        $this->assertFalse($actual['escape_shell_cmd']);
    }
}
