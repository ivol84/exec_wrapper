<?php
namespace ivol\Config;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ExecWrapperConfiguration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('exec_wrapper');
        $rootNode
            ->children()
                ->booleanNode('escape_shell_args')
                    ->info('Escape shell args passed to exec')
                    ->defaultTrue()
                ->end()
                ->booleanNode('escape_shell_cmd')
                    ->info('Escape shell command passed to exec')
                    ->defaultTrue()
                ->end()
            ->end();
        return $treeBuilder;
    }
}