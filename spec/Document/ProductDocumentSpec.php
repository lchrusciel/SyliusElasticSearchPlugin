<?php

namespace spec\Sylius\ElasticSearchPlugin\Document;

use ONGR\ElasticsearchBundle\Collection\Collection;
use Sylius\ElasticSearchPlugin\Document\PriceDocument;
use Sylius\ElasticSearchPlugin\Document\ProductDocument;
use PhpSpec\ObjectBehavior;
use Sylius\ElasticSearchPlugin\Document\TaxonDocument;

final class ProductDocumentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProductDocument::class);
    }

    function it_has_code()
    {
        $this->setCode('Mug');

        $this->getCode()->shouldReturn('Mug');
    }

    function it_has_name()
    {
        $this->setName('Big Mug');

        $this->getName()->shouldReturn('Big Mug');
    }

    function it_has_channel_code()
    {
        $this->setChannelCode('WEB');

        $this->getChannelCode()->shouldReturn('WEB');
    }

    function it_has_locale_code()
    {
        $this->setLocaleCode('en');

        $this->getLocaleCode()->shouldReturn('en');
    }

    function it_has_description()
    {
        $this->setDescription('Lorem ipsum');

        $this->getDescription()->shouldReturn('Lorem ipsum');
    }

    function it_has_price()
    {
        $price = new PriceDocument();
        $this->setPrice($price);

        $this->getPrice()->shouldReturn($price);
    }

    function it_has_main_taxon()
    {
        $taxon = new TaxonDocument();
        $this->setMainTaxon($taxon);

        $this->getMainTaxon()->shouldReturn($taxon);
    }

    function it_has_taxons()
    {
        $taxons = new Collection();
        $this->setTaxons($taxons);

        $this->getTaxons()->shouldReturn($taxons);
    }

    function it_has_attributes()
    {
        $attributeValues = new Collection();
        $this->setAttributeValues($attributeValues);

        $this->getAttributeValues()->shouldReturn($attributeValues);
    }

    function it_has_slug()
    {
        $this->setSlug('/mug');

        $this->getSlug()->shouldReturn('/mug');
    }

    function it_has_images()
    {
        $images = new Collection();
        $this->setImages($images);

        $this->getImages()->shouldReturn($images);
    }
}
