<?php

namespace Sylius\ElasticSearchPlugin\Search\Elastic\Factory\Query;

use ONGR\ElasticsearchDSL\Query\Joining\NestedQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use Sylius\ElasticSearchPlugin\Exception\MissingQueryParameterException;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.k.e@gmail.com>
 */
final class ProductHasOptionCodeQueryFactory implements QueryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $parameters = [])
    {
        if (!isset($parameters['option_value_code'])) {
            throw new MissingQueryParameterException('option_value_code', get_class($this));
        }

        return
            new NestedQuery(
                'variants',
                new NestedQuery(
                    'variants.optionValues',
                    new TermQuery('variants.optionValues.code', $parameters['option_value_code'])
                )
            );
    }
}
