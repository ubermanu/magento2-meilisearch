<?php
declare(strict_types=1);

namespace Ubermanu\MeiliSearch\Model\DataProvider;

use Magento\AdvancedSearch\Model\SuggestedQueriesInterface;
use Magento\Search\Model\QueryInterface;

class Suggestions implements SuggestedQueriesInterface {

    public function getItems(QueryInterface $query)
    {
        // TODO: Implement getItems() method.
    }

    public function isResultsCountEnabled()
    {
        // TODO: Implement isResultsCountEnabled() method.
    }
}
