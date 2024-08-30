<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ZipcodeAvailabilityRepositoryInterface
{

    /**
     * Save ZipcodeAvailability
     * @param \Coditron\ZipcodeAvailability\Api\Data\ZipcodeAvailabilityInterface $zipcodeAvailability
     * @return \Coditron\ZipcodeAvailability\Api\Data\ZipcodeAvailabilityInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Coditron\ZipcodeAvailability\Api\Data\ZipcodeAvailabilityInterface $zipcodeAvailability
    );

    /**
     * Retrieve ZipcodeAvailability
     * @param string $zipcodeavailabilityId
     * @return \Coditron\ZipcodeAvailability\Api\Data\ZipcodeAvailabilityInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($zipcodeavailabilityId);

    /**
     * Retrieve ZipcodeAvailability matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Coditron\ZipcodeAvailability\Api\Data\ZipcodeAvailabilitySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete ZipcodeAvailability
     * @param \Coditron\ZipcodeAvailability\Api\Data\ZipcodeAvailabilityInterface $zipcodeAvailability
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Coditron\ZipcodeAvailability\Api\Data\ZipcodeAvailabilityInterface $zipcodeAvailability
    );

    /**
     * Delete ZipcodeAvailability by ID
     * @param string $zipcodeavailabilityId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($zipcodeavailabilityId);
}

