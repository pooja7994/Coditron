<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Api\Data;

interface ZipcodeAvailabilitySearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get ZipcodeAvailability list.
     * @return \Coditron\ZipcodeAvailability\Api\Data\ZipcodeAvailabilityInterface[]
     */
    public function getItems();

    /**
     * Set region_name list.
     * @param \Coditron\ZipcodeAvailability\Api\Data\ZipcodeAvailabilityInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

