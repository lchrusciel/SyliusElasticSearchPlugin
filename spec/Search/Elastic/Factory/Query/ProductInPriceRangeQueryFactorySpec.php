<?php

namespace spec\Sylius\ElasticSearchPlugin\Search\Elastic\Factory\Query;

use ONGR\ElasticsearchDSL\Query\TermLevel\RangeQuery;
use Sylius\ElasticSearchPlugin\Exception\MissingQueryParameterException;
use Sylius\ElasticSearchPlugin\Search\Elastic\Factory\Query\ProductInPriceRangeQueryFactory;
use Sylius\ElasticSearchPlugin\Search\Elastic\Factory\Query\QueryFactoryInterface;
use PhpSpec\ObjectBehavior;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class ProductInPriceRangeQueryFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProductInPriceRangeQueryFactory::class);
    }

    function it_is_query_factory()
    {
        $this->shouldImplement(QueryFactoryInterface::class);
    }

    function it_creates_price_range_query_for_products()
    {
        $this->create(['product_price_range' => ['grater_than' => 1000, 'less_than' => 2000]])
            ->shouldBeLike(new RangeQuery('price.amount', ['gte' => 1000, 'lte' => 2000]));
    }

    function it_cannot_be_created_without_price_range_parameters()
    {
        $this->shouldThrow(MissingQueryParameterException::class)->during('create', []);
    }

    function it_cannot_be_created_without_grater_than_parameter()
    {
        $this->shouldThrow(MissingQueryParameterException::class)->during('create', ['product_price_range' => ['less_than' => 20]]);
    }

    function it_cannot_be_created_without_less_than_parameter()
    {
        $this->shouldThrow(MissingQueryParameterException::class)->during('create', ['product_price_range' => ['grater_than' => 10]]);
    }
}
