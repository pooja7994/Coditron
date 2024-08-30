<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Api\Data;

interface ZipcodeAvailabilityInterface
{

    const STATUS = 'status';
    const ZIPCODEAVAILABILITY_ID = 'zipcodeavailability_id';
    const REGION_NAME = 'region_name';

    /**
     * Get zipcodeavailability_id
     * @return string|null
     */
    public function getZipcodeavailabilityId();

    /**
     * Set zipcodeavailability_id
     * @param string $zipcodeavailabilityId
     * @return \Coditron\ZipcodeAvailability\ZipcodeAvailability\Api\Data\ZipcodeAvailabilityInterface
     */
    public function setZipcodeavailabilityId($zipcodeavailabilityId);

    /**
     * Get region_name
     * @return string|null
     */
    public function getRegionName();

    /**
     * Set region_name
     * @param string $regionName
     * @return \Coditron\ZipcodeAvailability\ZipcodeAvailability\Api\Data\ZipcodeAvailabilityInterface
     */
    public function setRegionName($regionName);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Coditron\ZipcodeAvailability\ZipcodeAvailability\Api\Data\ZipcodeAvailabilityInterface
     */
    public function setStatus($status);
}

