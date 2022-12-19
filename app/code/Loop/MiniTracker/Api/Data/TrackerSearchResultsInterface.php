<?php

namespace Loop\MiniTracker\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TrackerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Tracker list.
     * @return \Loop\MiniTracker\Api\Data\TrackerInterface[]
     */
    public function getItems();

    /**
     * Set Tracker list.
     * @param \Loop\MiniTracker\Api\Data\TrackerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
