<?php

namespace Sylius\ElasticSearchPlugin\Document;

use ONGR\ElasticsearchBundle\Annotation as ElasticSearch;
use ONGR\ElasticsearchBundle\Collection\Collection;

/**
 * @ElasticSearch\Document(type="product")
 */
class ProductDocument
{
    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    private $code;

    /**
     * @var string
     *
     * @ElasticSearch\Property(
     *    type="text",
     *    name="name",
     *    options={
     *        "analyzer"="standard",
     *        "fields"={
     *            "raw"={"type"="keyword"},
     *            "standard"={"type"="text", "analyzer"="standard"}
     *        }
     *    }
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    private $slug;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    private $channelCode;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    private $localeCode;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="text")
     */
    private $description;

    /**
     * @var PriceDocument
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\PriceDocument")
     */
    private $price;

    /**
     * @var TaxonDocument
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\TaxonDocument")
     */
    private $mainTaxon;

    /**
     * @var Collection
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\TaxonDocument", multiple=true)
     */
    private $taxons;

    /**
     * @var Collection
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\AttributeValueDocument", multiple=true)
     */
    private $attributeValues;

    /**
     * @var Collection
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\ImageDocument", multiple=true)
     */
    private $images;

    /**
     * @var \DateTime
     *
     * @ElasticSearch\Property(type="date")
     */
    private $createdAt;

    public function __construct()
    {
        $this->attributeValues = new Collection();
        $this->taxons = new Collection();
        $this->images = new Collection();
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getChannelCode()
    {
        return $this->channelCode;
    }

    /**
     * @param string $channelCode
     */
    public function setChannelCode($channelCode)
    {
        $this->channelCode = $channelCode;
    }

    /**
     * @return string
     */
    public function getLocaleCode()
    {
        return $this->localeCode;
    }

    /**
     * @param string $localeCode
     */
    public function setLocaleCode($localeCode)
    {
        $this->localeCode = $localeCode;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return PriceDocument
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param PriceDocument $price
     */
    public function setPrice(PriceDocument $price)
    {
        $this->price = $price;
    }

    /**
     * @return TaxonDocument
     */
    public function getMainTaxon()
    {
        return $this->mainTaxon;
    }

    /**
     * @param TaxonDocument $mainTaxon
     */
    public function setMainTaxon(TaxonDocument $mainTaxon)
    {
        $this->mainTaxon = $mainTaxon;
    }

    /**
     * @return Collection
     */
    public function getTaxons()
    {
        return $this->taxons;
    }

    /**
     * @param Collection $taxons
     */
    public function setTaxons(Collection $taxons)
    {
        $this->taxons = $taxons;
    }

    /**
     * @return Collection
     */
    public function getAttributeValues()
    {
        return $this->attributeValues;
    }

    /**
     * @param Collection $attributeValues
     */
    public function setAttributeValues(Collection $attributeValues)
    {
        $this->attributeValues = $attributeValues;
    }

    /**
     * @return Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param Collection $images
     */
    public function setImages(Collection $images)
    {
        $this->images = $images;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
