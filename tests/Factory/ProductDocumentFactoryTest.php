<?php

namespace Tests\Sylius\ElasticSearchPlugin\Factory;

use ONGR\ElasticsearchBundle\Collection\Collection;
use Sylius\Component\Attribute\AttributeType\TextAttributeType;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\ChannelPricing;
use Sylius\Component\Core\Model\Product as SyliusProduct;
use Sylius\Component\Core\Model\ProductTaxon;
use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Core\Model\Taxon as SyliusTaxon;
use Sylius\Component\Currency\Model\Currency;
use Sylius\Component\Locale\Model\Locale;
use Sylius\Component\Product\Model\ProductAttribute;
use Sylius\Component\Product\Model\ProductAttributeValue;
use Sylius\ElasticSearchPlugin\Document\AttributeDocument;
use Sylius\ElasticSearchPlugin\Document\AttributeValueDocument;
use Sylius\ElasticSearchPlugin\Document\ImageDocument;
use Sylius\ElasticSearchPlugin\Document\PriceDocument;
use Sylius\ElasticSearchPlugin\Document\ProductDocument;
use Sylius\ElasticSearchPlugin\Document\TaxonDocument;
use Sylius\ElasticSearchPlugin\Exception\UnsupportedFactoryMethodException;
use Sylius\ElasticSearchPlugin\Factory\ProductDocumentFactory;

final class ProductDocumentFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_creates_product_document_from_sylius_product_model()
    {
        $createdAt = \DateTime::createFromFormat(\DateTime::W3C, '2017-04-18T16:12:55+02:00');
        $syliusProductAttributeValue = new ProductAttributeValue();
        $syliusProductAttribute = new ProductAttribute();
        $syliusProductAttribute->setCurrentLocale('en_US');
        $syliusProductAttribute->setCode('red');
        $syliusProductAttribute->setName('Color red');
        $syliusProductAttributeValue->setLocaleCode('en_US');
        $syliusProductAttribute->setType(TextAttributeType::TYPE);
        $syliusProductAttribute->setStorageType(TextAttributeType::TYPE);
        $syliusProductAttributeValue->setAttribute($syliusProductAttribute);
        $syliusProductAttributeValue->setValue('red');

        $syliusTaxon = new SyliusTaxon();
        $syliusTaxon->setCurrentLocale('en_US');
        $syliusTaxon->setCode('tree');
        $syliusTaxon->setSlug('/tree');
        $syliusTaxon->setDescription('Lorem ipsum');
        $syliusProductTaxon = new ProductTaxon();

        $syliusLocale = new Locale();
        $syliusLocale->setCode('en_US');

        $syliusProduct = new SyliusProduct();
        $syliusProductVariant = new ProductVariant();
        $channelPrice = new ChannelPricing();
        $syliusChannel = new Channel();
        $currency = new Currency();
        $currency->setCode('USD');

        $syliusProductTaxon->setProduct($syliusProduct);
        $syliusProductTaxon->setTaxon($syliusTaxon);
        $channelPrice->setPrice(1000);
        $channelPrice->setChannelCode('mobile');

        $syliusChannel->setCode('mobile');
        $syliusChannel->setDefaultLocale($syliusLocale);
        $syliusChannel->addLocale($syliusLocale);
        $syliusChannel->addCurrency($currency);
        $syliusChannel->setBaseCurrency($currency);

        $syliusProductVariant->addChannelPricing($channelPrice);
        $syliusProduct->addVariant($syliusProductVariant);
        $syliusProduct->addChannel($syliusChannel);
        $syliusProduct->setMainTaxon($syliusTaxon);
        $syliusProduct->addProductTaxon($syliusProductTaxon);
        $syliusProduct->setCreatedAt($createdAt);
        $syliusProduct->setCurrentLocale('en_US');
        $syliusProduct->setName('Banana');
        $syliusProduct->setSlug('/banana');
        $syliusProduct->setDescription('Lorem ipsum');
        $syliusProduct->setCode('banana');
        $syliusProduct->addAttribute($syliusProductAttributeValue);

        $factory = new ProductDocumentFactory(
            ProductDocument::class,
            AttributeDocument::class,
            AttributeValueDocument::class,
            ImageDocument::class,
            PriceDocument::class,
            TaxonDocument::class
        );
        /** @var ProductDocument $product */
        $product = $factory->createFromSyliusSimpleProductModel(
            $syliusProduct,
            $syliusLocale,
            $syliusChannel
        );

        $taxon = new TaxonDocument();
        $taxon->setCode('tree');
        $taxon->setPosition(0);
        $taxon->setSlug('/tree');
        $taxon->setDescription('Lorem ipsum');

        $productTaxon = new TaxonDocument();
        $productTaxon->setCode('tree');
        $productTaxon->setSlug('/tree');
        $productTaxon->setPosition(0);
        $productTaxon->setDescription('Lorem ipsum');

        $productAttribute = new AttributeDocument();
        $productAttribute->setCode('red');
        $productAttribute->setName('Color red');

        $productAttributeValue = new AttributeValueDocument();
        $productAttributeValue->setValue('red');
        $productAttributeValue->setAttribute($productAttribute);

        $this->assertEquals('banana', $product->getCode());
        $this->assertEquals('Banana', $product->getName());
        $this->assertEquals('en_US', $product->getLocaleCode());
        $this->assertEquals(
            new Collection([
                $productAttributeValue
            ]),
            $product->getAttributeValues()
        );
        $this->assertEquals(1000, $product->getPrice()->getAmount());
        $this->assertEquals('USD', $product->getPrice()->getCurrency());
        $this->assertEquals('en_US', $product->getLocaleCode());
        $this->assertEquals('mobile', $product->getChannelCode());
        $this->assertEquals('/banana', $product->getSlug());
        $this->assertEquals('Banana', $product->getName());
        $this->assertEquals($createdAt, $product->getCreatedAt());
        $this->assertEquals('Lorem ipsum', $product->getDescription());
        $this->assertEquals($taxon, $product->getMainTaxon());
        $this->assertEquals(new Collection([$productTaxon]), $product->getTaxons());
    }

    /**
     * @test
     */
    public function it_cannot_create_product_document_from_configurable_product()
    {
        $this->expectException(UnsupportedFactoryMethodException::class);
        $factory = new ProductDocumentFactory(
            ProductDocument::class,
            AttributeDocument::class,
            AttributeValueDocument::class,
            ImageDocument::class,
            PriceDocument::class,
            TaxonDocument::class
        );

        $syliusProduct = new SyliusProduct();
        $syliusProduct->addVariant(new ProductVariant());
        $syliusProduct->addVariant(new ProductVariant());
        $syliusLocale = new Locale();
        $syliusChannel = new Channel();

        $factory->createFromSyliusSimpleProductModel($syliusProduct, $syliusLocale, $syliusChannel);
    }
}
