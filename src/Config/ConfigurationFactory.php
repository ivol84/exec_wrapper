<?php

namespace ivol\Config;


use Symfony\Component\Config\Definition\Processor;

class ConfigurationFactory
{

    public static function createFromArray($params = array())
    {
        $processor = new Processor();
        $configuration = new ExecWrapperConfiguration();
        $processedConfiguration = $processor->processConfiguration(
            $configuration,
            array($params)
        );
        return $processedConfiguration;
    }
}