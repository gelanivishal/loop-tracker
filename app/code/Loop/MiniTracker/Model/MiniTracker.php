<?php

namespace Loop\MiniTracker\Model;

use Loop\MiniTracker\Api\Data\TrackerInterface;
use Loop\MiniTracker\Model\ResourceModel\MiniTracker as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class MiniTracker extends AbstractModel implements TrackerInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'loop_tracking_information_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->getData(self::SKU);
    }

    /**
     * @param string|null $sku
     */
    public function setSku(?string $sku): void
    {
        $this->setData(self::SKU, $sku);
    }

    /**
     * @return string|null
     */
    public function getTrackingCode(): ?string
    {
        return $this->getData(self::TRACKING_CODE);
    }

    /**
     * @param string|null $trackingCode
     */
    public function setTrackingCode(?string $trackingCode): void
    {
        $this->setData(self::TRACKING_CODE, $trackingCode);
    }

    /**
     * @return string|null
     */
    public function getTrackingMessage(): ?string
    {
        return $this->getData(self::TRACKING_MESSAGE);
    }

    /**
     * @param string|null $trackingMessage
     */
    public function setTrackingMessage(?string $trackingMessage): void
    {
        $this->setData(self::TRACKING_MESSAGE, $trackingMessage);
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @param string|null $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }
}
