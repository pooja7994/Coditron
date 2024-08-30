<?php
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Model\ResourceModel\ZipcodeAvailability;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Coditron\ZipcodeAvailability\Model\ZipcodeAvailability as Model;
use Coditron\ZipcodeAvailability\Model\ResourceModel\ZipcodeAvailability as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
