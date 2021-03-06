<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\ElasticSearchPlugin\Search\Elastic\Factory\Query;

use Sylius\ElasticSearchPlugin\Exception\MissingQueryParameterException;
use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.k.e@gmail.com>
 */
interface QueryFactoryInterface
{
    /**
     * @param array $parameters
     *
     * @return BuilderInterface
     *
     * @throws MissingQueryParameterException
     */
    public function create(array $parameters = []);
}
