<?php

namespace Loop\MiniTracker\Observer;

use Loop\MiniTracker\Api\Data\TrackerInterfaceFactory;
use Loop\MiniTracker\Api\TrackerRepositoryInterface;
use Loop\MiniTracker\Service\MiniTrackService;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Psr\Log\LoggerInterface;

class TrackProduct implements ObserverInterface
{
    private MiniTrackService $miniTrackService;
    private TrackerInterfaceFactory $trackerInterfaceFactory;
    private TrackerRepositoryInterface $trackerRepository;
    private ScopeConfigInterface $scopeConfig;
    private LoggerInterface $logger;
    private Json $json;

    /**
     * @param MiniTrackService $miniTrackService
     * @param TrackerInterfaceFactory $trackerInterfaceFactory
     * @param TrackerRepositoryInterface $trackerRepository
     * @param ScopeConfigInterface $scopeConfig
     * @param LoggerInterface $logger
     * @param Json $json
     */
    public function __construct(
        MiniTrackService $miniTrackService,
        TrackerInterfaceFactory $trackerInterfaceFactory,
        TrackerRepositoryInterface $trackerRepository,
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger,
        Json $json
    ) {
        $this->miniTrackService = $miniTrackService;
        $this->trackerInterfaceFactory = $trackerInterfaceFactory;
        $this->trackerRepository = $trackerRepository;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        $this->json = $json;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->isTrackingEnabled()) {
            $quoteItem = $observer->getEvent()->getData('quote_item');
            $quoteItem = $quoteItem->getParentItem() ?? $quoteItem;
            $requestPayload = [
                'sku' => $quoteItem->getSku(),
                'price' => $quoteItem->getPrice()
            ];

            if ($this->isDebug()) {
                $this->logger->debug('Tracking - Request Payload:' . $this->json->serialize($requestPayload));
            }
            $response = $this->miniTrackService->trackMe($requestPayload);
            if ($this->isDebug()) {
                $this->logger->debug('Tracking - Response:' . $this->json->serialize($response));
            }

            if (!empty($response) && isset($response['code'])) {
                $trackerInterface = $this->trackerInterfaceFactory->create();
                $trackerInterface->setSku($response['sku']);
                $trackerInterface->setTrackingCode($response['code']);
                $trackerInterface->setTrackingMessage($response['message']);
                try {
                    $this->trackerRepository->save($trackerInterface);
                } catch (\Exception $e) {
                    if ($this->isDebug()) {
                        $this->logger->debug('Tracking - Error:' . $e->getMessage());
                    }
                    $this->logger->error('Tracking - Error:' . $e->getMessage());
                }
            }
        }
    }

    /**
     * @return bool
     */
    private function isTrackingEnabled(): bool
    {
        return (bool) $this->scopeConfig->getValue('loop/general/enabled');
    }

    /**
     * @return bool
     */
    private function isDebug(): bool
    {
        return (bool) $this->scopeConfig->getValue('loop/general/debug');
    }
}
