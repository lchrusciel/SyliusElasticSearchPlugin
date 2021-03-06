<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Sylius\ElasticSearchPlugin\DependencyInjection\Compiler;

use Sylius\ElasticSearchPlugin\DependencyInjection\Compiler\RegisterSearchCriteriaApplicatorPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\DefinitionHasMethodCallConstraint;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class RegisterSearchCriteriaApplicatorPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function it_collects_tagged_search_criteria_applicators()
    {
        $this->setDefinition('sylius_elastic_search.search.elastic_engine', new Definition());
        $this->setDefinition(
            'sylius_elastic_search.search_criteria_applicator.product_has_multiple_option_codes',
            (new Definition(\stdClass::class))->addTag('search_criteria_applicator')
        );

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'sylius_elastic_search.search.elastic_engine',
            'addSearchCriteriaApplicator',
            [
                new Reference('sylius_elastic_search.search_criteria_applicator.product_has_multiple_option_codes')
            ]
        );
    }

    /**
     * @test
     */
    public function it_does_nothing_if_there_is_no_search_criteria_applicators()
    {
        $this->compile();

        $this->assertContainerBuilderNotHasService('sylius_elastic_search.search.elastic_engine');
    }

    /**
     * @test
     */
    public function it_does_nothing_if_there_is_no_tagged_applicators()
    {
        $this->setDefinition('sylius_elastic_search.search.elastic_engine', new Definition());
        $this->setDefinition(
            'sylius_elastic_search.search_criteria_applicator.product_has_multiple_option_codes',
            new Definition(\stdClass::class)
        );

        $this->compile();

        $this->assertContainerBuilderNotHasServiceDefinitionWithMethodCall(
            'sylius_elastic_search.search.elastic_engine',
            'addSearchCriteriaApplicator',
            [new Reference('sylius_elastic_search.search_criteria_applicator.product_has_multiple_option_codes')]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterSearchCriteriaApplicatorPass());
    }

    /**
     * @param string $serviceId
     * @param string $method
     * @param array $arguments
     */
    private function assertContainerBuilderNotHasServiceDefinitionWithMethodCall($serviceId, $method, $arguments)
    {
        $definition = $this->container->findDefinition($serviceId);

        self::assertThat(
            $definition,
            new \PHPUnit_Framework_Constraint_Not(new DefinitionHasMethodCallConstraint($method, $arguments))
        );
    }
}
