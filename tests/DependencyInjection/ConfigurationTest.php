<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Sylius\ElasticSearchPlugin\DependencyInjection;

use Sylius\ElasticSearchPlugin\Controller\AttributeView;
use Sylius\ElasticSearchPlugin\Controller\ImageView;
use Sylius\ElasticSearchPlugin\Controller\PriceView;
use Sylius\ElasticSearchPlugin\Controller\ProductListView;
use Sylius\ElasticSearchPlugin\Controller\ProductView;
use Sylius\ElasticSearchPlugin\Controller\TaxonView;
use Sylius\ElasticSearchPlugin\Controller\VariantView;
use Sylius\ElasticSearchPlugin\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Sylius\ElasticSearchPlugin\Document\AttributeDocument;
use Sylius\ElasticSearchPlugin\Document\AttributeValueDocument;
use Sylius\ElasticSearchPlugin\Document\ImageDocument;
use Sylius\ElasticSearchPlugin\Document\PriceDocument;
use Sylius\ElasticSearchPlugin\Document\ProductDocument;
use Sylius\ElasticSearchPlugin\Document\TaxonDocument;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @test
     */
    public function it_has_document_classes()
    {
        $this->assertProcessedConfigurationEquals([], ['document_classes' => [
            'product' => ProductDocument::class,
            'attribute' => AttributeDocument::class,
            'attribute_value' => AttributeValueDocument::class,
            'image' => ImageDocument::class,
            'price' => PriceDocument::class,
            'taxon' => TaxonDocument::class,
        ]], 'document_classes');
    }

    /**
     * @test
     */
    public function it_has_view_classes()
    {
        $this->assertProcessedConfigurationEquals([], ['view_classes' => [
            'product_list' => ProductListView::class,
            'product' => ProductView::class,
            'product_variant' => VariantView::class,
            'attribute' => AttributeView::class,
            'image' => ImageView::class,
            'price' => PriceView::class,
            'taxon' => TaxonView::class,
        ]], 'view_classes');
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }
}
