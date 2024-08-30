<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Model\ResourceModel\Zipcode;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Coditron\ZipcodeAvailability\Model\Zipcode as Model;
use Coditron\ZipcodeAvailability\Model\ResourceModel\Zipcode as ResourceModel;

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
