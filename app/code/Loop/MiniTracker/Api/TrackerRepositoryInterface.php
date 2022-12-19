<?php

namespace Loop\MiniTracker\Api;

interface TrackerRepositoryInterface
{
    /**
     * Save tracker.
     *
     * @param \Loop\MiniTracker\Api\Data\TrackerInterface $tracker
     * @return \Loop\MiniTracker\Api\Data\TrackerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\TrackerInterface $tracker);

    /**
     * Retrieve tracker.
     *
     * @param string $entityId
     * @return \Loop\MiniTracker\Api\Data\TrackerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($entityId);

    /**
     * Retrieve tracker matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Loop\MiniTracker\Api\Data\TrackerSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete tracker.
     *
     * @param \Loop\MiniTracker\Api\Data\TrackerInterface $tracker
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\TrackerInterface $tracker);

    /**
     * Delete tracker by ID.
     *
     * @param string $entityId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($entityId);
}
