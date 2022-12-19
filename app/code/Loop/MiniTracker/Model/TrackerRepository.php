<?php

namespace Loop\MiniTracker\Model;

use Loop\MiniTracker\Api\Data;
use Loop\MiniTracker\Api\TrackerRepositoryInterface;
use Loop\MiniTracker\Model\MiniTrackerFactory;
use Loop\MiniTracker\Model\ResourceModel\MiniTracker as ResourceMiniTracker;
use Loop\MiniTracker\Model\ResourceModel\MiniTracker\CollectionFactory as TrackerCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\EntityManager\HydratorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;

class TrackerRepository implements TrackerRepositoryInterface
{
    /**
     * @var ResourceMiniTracker
     */
    protected ResourceMiniTracker $resource;

    /**
     * @var MiniTrackerFactory
     */
    protected \Loop\MiniTracker\Model\MiniTrackerFactory $miniTrackerFactory;

    /**
     * @var TrackerCollectionFactory
     */
    protected TrackerCollectionFactory $trackerCollectionFactory;

    /**
     * @var Data\TrackerSearchResultsInterfaceFactory
     */
    protected Data\TrackerSearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected DataObjectHelper $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected DataObjectProcessor $dataObjectProcessor;

    /**
     * @var \Loop\MiniTracker\Api\Data\TrackerInterfaceFactory
     */
    protected Data\TrackerInterfaceFactory $dataTrackerFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @param ResourceMiniTracker $resource
     * @param \Loop\MiniTracker\Model\MiniTrackerFactory $miniTrackerFactory
     * @param Data\TrackerInterfaceFactory $dataTrackerFactory
     * @param TrackerCollectionFactory $trackerCollectionFactory
     * @param Data\TrackerSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param CollectionProcessorInterface $collectionProcessor
     * @param HydratorInterface|null $hydrator
     */
    public function __construct(
        ResourceMiniTracker $resource,
        MiniTrackerFactory $miniTrackerFactory,
        \Loop\MiniTracker\Api\Data\TrackerInterfaceFactory $dataTrackerFactory,
        TrackerCollectionFactory $trackerCollectionFactory,
        Data\TrackerSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        CollectionProcessorInterface $collectionProcessor,
        ?HydratorInterface $hydrator = null
    ) {
        $this->resource = $resource;
        $this->miniTrackerFactory = $miniTrackerFactory;
        $this->trackerCollectionFactory = $trackerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataTrackerFactory = $dataTrackerFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->collectionProcessor = $collectionProcessor;
        $this->hydrator = $hydrator ?? ObjectManager::getInstance()->get(HydratorInterface::class);
    }

    /**
     * @param Data\TrackerInterface $tracker
     * @return Data\TrackerInterface|object
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(Data\TrackerInterface $tracker)
    {
        if ($tracker->getId() && $tracker instanceof MiniTracker && !$tracker->getOrigData()) {
            $tracker = $this->hydrator->hydrate($this->getById($tracker->getId()), $this->hydrator->extract($tracker));
        }

        try {
            $this->resource->save($tracker);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $tracker;
    }

    /**
     * @param string $entityId
     * @return Data\TrackerInterface
     * @throws NoSuchEntityException
     */
    public function getById($entityId)
    {
        $tracker = $this->miniTrackerFactory->create();
        $this->resource->load($tracker, $entityId);
        if (!$tracker->getId()) {
            throw new NoSuchEntityException(__('The Tracker with the "%1" ID doesn\'t exist.', $entityId));
        }
        return $tracker;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return Data\TrackerSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Loop\MiniTracker\Model\ResourceModel\MiniTracker\Collection $collection */
        $collection = $this->trackerCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var Data\TrackerSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param Data\TrackerInterface $tracker
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\TrackerInterface $tracker)
    {
        try {
            $this->resource->delete($tracker);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param string $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($entityId)
    {
        return $this->delete($this->getById($entityId));
    }
}
