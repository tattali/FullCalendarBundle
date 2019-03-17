<?php

namespace spec\Toiba\FullCalendarBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Toiba\FullCalendarBundle\DependencyInjection\FullCalendarExtension;

class FullCalendarExtensionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(FullCalendarExtension::class);
    }

    public function it_should_set_parameters_correctly(ContainerBuilder $container, ParameterBag $parameterBag)
    {
        $parameterBag->resolveValue(Argument::any())->will(function ($args) {
            return $args[0];
        });
        $parameterBag->unescapeValue(Argument::any())->will(function ($args) {
            return $args[0];
        });

        $container->getParameterBag()->willReturn($parameterBag);
        $container->fileExists(Argument::any())->willReturn(true);
        $container->setParameter(Argument::any(), Argument::any())->will(function () {
        });
        $container->setDefinition(Argument::any(), Argument::any())->will(function () {
        });
        $container->getReflectionClass(Argument::type('string'))->will(function ($args) {
            return new \ReflectionClass($args[0]);
        });
        $container->addResource(Argument::any())->willReturn(null);

        $configuration = [];
        $this->load($configuration, $container);
    }
}
