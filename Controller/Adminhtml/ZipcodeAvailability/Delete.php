<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Controller\Adminhtml\ZipcodeAvailability;

use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\Model\View\Result\Redirect;

class Delete extends \Coditron\ZipcodeAvailability\Controller\Adminhtml\ZipcodeAvailability
{
    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('zipcodeavailability_id');
        if ($id) {
            try {
                // Init the main model
                $model = $this->_objectManager->create(\Coditron\ZipcodeAvailability\Model\ZipcodeAvailability::class);
                $model->load($id);

                if (!$model->getId()) {
                    throw new \Magento\Framework\Exception\LocalizedException(__('This Zipcodeavailability no longer exists.'));
                }

                // Delete related records in custom_zipcodeavailability_zipcode table
                $relatedModel = $this->_objectManager->create(\Coditron\ZipcodeAvailability\Model\ResourceModel\Zipcode\Collection::class);
                $relatedModel->addFieldToFilter('region_id', $id);
                
                foreach ($relatedModel as $zipcode) {
                    $zipcode->delete();
                }

                // Delete the main record
                $model->delete();

                // Display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Zipcodeavailability and its related zipcodes.'));
                
                // Redirect to the grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // Display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                
                // Redirect back to edit form
                return $resultRedirect->setPath('*/*/edit', ['zipcodeavailability_id' => $id]);
            }
        }

        // Display error message if no ID is found
        $this->messageManager->addErrorMessage(__('We can\'t find a Zipcodeavailability to delete.'));
        
        // Redirect to the grid
        return $resultRedirect->setPath('*/*/');
    }
}
