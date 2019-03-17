<?php

namespace spec\Toiba\FullCalendarBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Toiba\FullCalendarBundle\DependencyInjection\Configuration;

class ConfigurationSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Configuration::class);
    }

    public function it_should_set_the_tree_builder_config()
    {
        $this
            ->getConfigTreeBuilder()
            ->shouldReturnAnInstanceOf(TreeBuilder::class)
        ;
    }
}
