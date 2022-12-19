<?php

namespace Loop\MiniTracker\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MiniTracker extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'loop_tracking_information_resource_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('loop_tracking_information', 'entity_id');
        $this->_useIsObjectNew = true;
    }
}
