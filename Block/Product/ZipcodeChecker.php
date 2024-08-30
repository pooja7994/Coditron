<?php 
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Block\Product;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Coditron\ZipcodeAvailability\Model\ResourceModel\ZipcodeAvailability\CollectionFactory;

class ZipcodeChecker extends Template
{
    protected $scopeConfig;
    protected $logger;
    protected $customerSession;
    protected $registry;
    protected $collectionFactory;

    public function __construct(
        Template\Context $context,
        LoggerInterface $logger,
        Session $customerSession,
        Registry $registry,
        ScopeConfigInterface $scopeConfig,
        CollectionFactory $collectionFactory,  // Inject CollectionFactory
        array $data = []
    ) {
        $this->logger = $logger;
        $this->customerSession = $customerSession;
        $this->registry = $registry;
        $this->scopeConfig = $scopeConfig;
        $this->collectionFactory = $collectionFactory;  // Assign CollectionFactory
        parent::__construct($context, $data);
    }

    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag('zipcode_validator_section/zipcodeavailability/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function getProductId()
    {
        $product = $this->getProduct();
        if ($product) {
            return $product->getId();
        } else {
            return null;
        }
    }

    public function getFormActionUrl()
    {
        return $this->getUrl('coditron_zipcodeavailability/index/check'); 
    }

    public function getUserZipcode()
    {
        if ($this->customerSession->isLoggedIn()) {
            $customer = $this->customerSession->getCustomer();
            $billingAddress = $customer->getDefaultBillingAddress();
            if ($billingAddress) {
                $zipcode = $billingAddress->getPostcode();
                return $zipcode;
            } 
        }
        return '';
    }

    /**
     * Get selected region IDs for the product
     *
     * @return array
     */
    public function getSelectedRegionIds()
    {
        $product = $this->getProduct();
        if ($product) {
            $regionIds = $product->getData('select_regions');
            if ($regionIds) {
                $regionIdsArray = explode(',', $regionIds);

                // Use the CollectionFactory to filter regions with status 1
                $collection = $this->collectionFactory->create();
                $collection->addFieldToFilter('status', 1)
                           ->addFieldToFilter('zipcodeavailability_id', ['in' => $regionIdsArray]);

                // Extract the region_ids from the filtered collection
                $filteredRegionIds = $collection->getColumnValues('zipcodeavailability_id');
                
                return $filteredRegionIds;
            }
        }
        return [];
    }

    public function getPreviousZipcodes()
    {
        // Example: Retrieve previous zipcodes stored in session
        $previousZipcodes = $this->customerSession->getPreviousZipcodes();
        return is_array($previousZipcodes) ? $previousZipcodes : [];
    }
}
