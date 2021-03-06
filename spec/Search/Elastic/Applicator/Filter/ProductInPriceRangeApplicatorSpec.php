<?php

namespace spec\Sylius\ElasticSearchPlugin\Search\Elastic\Applicator\Filter;

use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use Sylius\ElasticSearchPlugin\Document\ProductDocument;
use Sylius\ElasticSearchPlugin\Search\Criteria\Criteria;
use Sylius\ElasticSearchPlugin\Search\Criteria\Filtering\ProductInPriceRangeFilter;
use Sylius\ElasticSearchPlugin\Search\Elastic\Applicator\Filter\ProductInPriceRangeApplicator;
use Sylius\ElasticSearchPlugin\Search\Elastic\Applicator\SearchCriteriaApplicatorInterface;
use Sylius\ElasticSearchPlugin\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Search;
use PhpSpec\ObjectBehavior;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class ProductInPriceRangeApplicatorSpec extends ObjectBehavior
{
    function let(QueryFactoryInterface $productInPriceRangeQueryFactory)
    {
        $this->beConstructedWith($productInPriceRangeQueryFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ProductInPriceRangeApplicator::class);
    }

    function it_is_search_criteria_applicator()
    {
        $this->shouldImplement(SearchCriteriaApplicatorInterface::class);
    }

    function it_applies_search_criteria_for_given_query(QueryFactoryInterface $productInPriceRangeQueryFactory, Search $search, TermQuery $termQuery)
    {
        $criteria = Criteria::fromQueryParameters(ProductDocument::class, ['product_price_range' => ['grater_than' => 20, 'less_than' => 50]]);
        $productInPriceRangeQueryFactory->create($criteria->filtering()->fields())->willReturn($termQuery);
        $search->addPostFilter($termQuery, BoolQuery::MUST)->shouldBeCalled();

        $this->apply($criteria, $search);
    }

    function it_supports_product_price_range_parameter()
    {
        $criteria = Criteria::fromQueryParameters(ProductDocument::class, ['product_price_range' => ['grater_than' => 20, 'less_than' => 50]]);
        $this->supports($criteria)->shouldReturn(true);

        $criteria = Criteria::fromQueryParameters(ProductDocument::class, []);
        $this->supports($criteria)->shouldReturn(false);
    }
}
