<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Controller\Adminhtml\ZipcodeAvailability;

class Edit extends \Coditron\ZipcodeAvailability\Controller\Adminhtml\ZipcodeAvailability
{

    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('zipcodeavailability_id');
        $model = $this->_objectManager->create(\Coditron\ZipcodeAvailability\Model\ZipcodeAvailability::class);
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Zipcodeavailability no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('coditron_zipcodeavailability_zipcodeavailability', $model);
        
        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Zipcodeavailability') : __('New Zipcodeavailability'),
            $id ? __('Edit Zipcodeavailability') : __('New Zipcodeavailability')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Zipcodeavailabilitys'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Zipcodeavailability %1', $model->getId()) : __('New Zipcodeavailability'));
        return $resultPage;
    }
}

