<?php

namespace Sylius\ElasticSearchPlugin\Search\Criteria;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.k.e@gmail.com>
 */
final class Paginating
{
    const DEFAULT_CURRENT_PAGE = 1;
    const DEFAULT_ITEMS_LIMIT = 10;

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * @var int
     */
    private $offset;

    /**
     * @param int $currentPage
     * @param int $itemsPerPage
     */
    private function __construct($currentPage, $itemsPerPage)
    {
        $this->currentPage = (int) $currentPage;
        if (0 >= $currentPage) {
            $this->currentPage = self::DEFAULT_CURRENT_PAGE;
        }

        $this->itemsPerPage = (int) $itemsPerPage;
        if (0 >= $itemsPerPage) {
            $this->itemsPerPage = self::DEFAULT_ITEMS_LIMIT;
        }

        $this->offset = $this->currentPage * $this->itemsPerPage - $this->itemsPerPage;
    }

    /**
     * @param array $parameters
     *
     * @return Paginating
     */
    public static function fromQueryParameters(array $parameters)
    {
        $currentPage = isset($parameters['page']) ? $parameters['page'] : self::DEFAULT_CURRENT_PAGE;
        $itemsPerPage = isset($parameters['limit']) ? $parameters['limit'] : self::DEFAULT_ITEMS_LIMIT;

        return new self($currentPage, $itemsPerPage);
    }

    /**
     * @return int
     */
    public function currentPage()
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function itemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @return int
     */
    public function offset()
    {
        return $this->offset;
    }
}
