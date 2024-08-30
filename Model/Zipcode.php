<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Model;

use Magento\Framework\Model\AbstractModel;
use Coditron\ZipcodeAvailability\Model\ResourceModel\Zipcode as ResourceModel;

class Zipcode extends AbstractModel
{
    /**
     * Define the primary key field name
     *
     * @var string
     */
    protected $_idFieldName = 'zipcode_id';

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
