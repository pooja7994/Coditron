<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Controller\Adminhtml\ZipcodeAvailability;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Coditron\ZipcodeAvailability\Model\ResourceModel\ZipcodeAvailability\CollectionFactory;

class DisableSelected extends Action
{
    protected $resultJsonFactory;
    protected $redirectFactory;
    protected $collectionFactory;

    public function __construct(
        Action\Context $context,
        JsonFactory $resultJsonFactory,
        RedirectFactory $redirectFactory, // Added RedirectFactory
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->redirectFactory = $redirectFactory; // Initialized RedirectFactory
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        $selectedIds = $this->getRequest()->getParam('selected');
        $excluded = $this->getRequest()->getParam('excluded');

        if (!is_array($selectedIds) && $excluded === 'false') {
            // 'Select All' was used, and no exclusions were made.
            $collection = $this->collectionFactory->create();
            $allIds = $collection->getAllIds(); // Fetch all IDs in the grid
            
            if (empty($allIds)) {
                $this->messageManager->addError(__('No items found.'));
            } else {
                $this->disableRecords($allIds);
                $this->messageManager->addSuccess(__('A total of %1 record(s) have been disabled.', count($allIds)));
            }
        } elseif (is_array($selectedIds)) {
            // Specific items were selected.
            $this->disableRecords($selectedIds);
            $this->messageManager->addSuccess(__('A total of %1 record(s) have been disabled.', count($selectedIds)));
        } else {
            $this->messageManager->addError(__('Please select item(s).'));
        }

        // Redirect after successful execution
        $resultRedirect = $this->redirectFactory->create();
        return $resultRedirect->setPath('coditron_zipcodeavailability/zipcodeavailability/index');
    }

    private function disableRecords(array $ids)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('zipcodeavailability_id', ['in' => $ids]);

        foreach ($collection as $item) {
            $item->setStatus(0); // Assuming 0 means disabled
            $item->save();
        }
    }


}
