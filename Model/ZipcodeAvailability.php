<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Model;

use Coditron\ZipcodeAvailability\Api\Data\ZipcodeAvailabilityInterface;
use Magento\Framework\Model\AbstractModel;

class ZipcodeAvailability extends AbstractModel implements ZipcodeAvailabilityInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Coditron\ZipcodeAvailability\Model\ResourceModel\ZipcodeAvailability::class);
    }

    /**
     * @inheritDoc
     */
    public function getZipcodeavailabilityId()
    {
        return $this->getData(self::ZIPCODEAVAILABILITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setZipcodeavailabilityId($zipcodeavailabilityId)
    {
        return $this->setData(self::ZIPCODEAVAILABILITY_ID, $zipcodeavailabilityId);
    }

    /**
     * @inheritDoc
     */
    public function getRegionName()
    {
        return $this->getData(self::REGION_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setRegionName($regionName)
    {
        return $this->setData(self::REGION_NAME, $regionName);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}

