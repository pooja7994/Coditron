<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Controller\Adminhtml\Zipcode;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Coditron\ZipcodeAvailability\Model\ResourceModel\Zipcode\CollectionFactory;

class MassDelete extends Action
{
    protected $collectionFactory;

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected');
        $redirectUrl = $this->getRequest()->getServer('HTTP_REFERER');

        if (!is_array($ids) || empty($ids)) {
            $this->messageManager->addError(__('Please select zipcode(s).'));
        } else {
            try {
                $collection = $this->collectionFactory->create()
                    ->addFieldToFilter('zipcode_id', ['in' => $ids]);
                $deletedCount = 0;

                foreach ($collection as $zipcode) {
                    $zipcode->delete();
                    $deletedCount++;
                }

                $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $deletedCount));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setUrl($redirectUrl);
    }
}
