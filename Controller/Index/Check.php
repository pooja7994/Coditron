<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);
namespace Coditron\ZipcodeAvailability\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Coditron\ZipcodeAvailability\Model\ResourceModel\Zipcode\CollectionFactory;

class Check extends Action
{
    protected $resultJsonFactory;
    protected $zipcodeCollectionFactory;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        CollectionFactory $zipcodeCollectionFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->zipcodeCollectionFactory = $zipcodeCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $zipcode = $this->getRequest()->getPost('zipcode');
        $result = ['success' => false, 'message' => __('Invalid Zipcode')];

        if ($zipcode) {
            $regionIds = $this->getRequest()->getPost('region_ids'); // Get region IDs from POST data
            $isAvailable = $this->isZipcodeAvailableInRegions($zipcode, $regionIds);
            if ($isAvailable) {
                $result = ['success' => true, 'message' => __('Zipcode is available')];
            }
        }

        return $this->resultJsonFactory->create()->setData($result);
    }

    private function isZipcodeAvailableInRegions($zipcode, $regionIds)
    {
        if ($regionIds) {
            foreach ($regionIds as $regionId) {
                // Create a new collection for each regionId to avoid appending conditions
                $zipcodeCollection = $this->zipcodeCollectionFactory->create();
                $zipcodeCollection->addFieldToFilter('region_id', $regionId)
                                  ->addFieldToFilter('zipcode', $zipcode);
                                  
                if ($zipcodeCollection->getSize() > 0) {
                    return true;
                }
            }
        }
        return false;
    }

}
