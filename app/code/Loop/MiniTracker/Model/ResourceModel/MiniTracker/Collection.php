<?php

namespace Loop\MiniTracker\Model\ResourceModel\MiniTracker;

use Loop\MiniTracker\Model\MiniTracker as Model;
use Loop\MiniTracker\Model\ResourceModel\MiniTracker as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'loop_tracking_information_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
