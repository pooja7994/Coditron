<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Controller\Adminhtml\ZipcodeAvailability;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\App\Filesystem\DirectoryList as FilesystemDirectoryList;
use Magento\Framework\App\ResourceConnection;

class Save extends \Magento\Backend\App\Action
{
    protected $dataPersistor;
    protected $uploaderFactory;
    protected $directoryList;
    protected $resourceConnection;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        DataPersistorInterface $dataPersistor,
        UploaderFactory $uploaderFactory,
        DirectoryList $directoryList,
        ResourceConnection $resourceConnection
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->uploaderFactory = $uploaderFactory;
        $this->directoryList = $directoryList;
        $this->resourceConnection = $resourceConnection;
        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $file = $this->getRequest()->getFiles('csv_file');
        
        if ($data) {
            $id = $this->getRequest()->getParam('zipcodeavailability_id');
            $model = $this->_objectManager->create(\Coditron\ZipcodeAvailability\Model\ZipcodeAvailability::class)->load($id);

            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Zipcodeavailability no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Zipcodeavailability.'));
                $this->dataPersistor->clear('coditron_zipcodeavailability_zipcodeavailability');

                if ($file && isset($file['name']) && !empty($file['name'])) {
                    $this->processCsvFile($file, $model->getId());
                }
              
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['zipcodeavailability_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Zipcodeavailability.'));
            }

            $this->dataPersistor->set('coditron_zipcodeavailability_zipcodeavailability', $data);
            return $resultRedirect->setPath('*/*/edit', ['zipcodeavailability_id' => $this->getRequest()->getParam('zipcodeavailability_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function processCsvFile($file, $regionId)
    {
        if (isset($file['tmp_name']) && !empty($file['tmp_name'])) {
            $uploader = $this->uploaderFactory->create(['fileId' => 'csv_file']); // The fileId should match the form field name
            $uploader->setAllowedExtensions(['csv']);
            $uploader->setAllowCreateFolders(true);
            $path = $this->directoryList->getPath(FilesystemDirectoryList::VAR_DIR) . '/import';
            $result = $uploader->save($path);
             // die;
            if (isset($result['file'])) {
                $csvFile = $path . '/' . $result['file'];
                $this->importCsvData($csvFile, $regionId);
            } else {
                $this->messageManager->addErrorMessage(__('File upload failed.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('No file uploaded or file upload error.'));
        }
    }

    protected function importCsvData($filePath, $regionId)
    {
        if (($handle = fopen($filePath, 'r')) !== false) {
            $data = [];
            $existingZipcodes = [];
            
            // Read the existing zip codes for this region_id to avoid duplicates
            $readConnection = $this->resourceConnection->getConnection();
            $select = $readConnection->select()
                ->from('coditron_zipcodeavailability_zipcode', ['zipcode'])
                ->where('region_id = ?', $regionId);
            $existingZipcodes = $readConnection->fetchCol($select);

            while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                if (isset($row[0]) && !empty($row[0])) {
                    $zipcode = $row[0];
                    
                    if (!in_array($zipcode, $existingZipcodes)) {
                        $data[] = [
                            'region_id' => $regionId,
                            'zipcode' => $zipcode
                        ];
                        // Add the new zipcode to the list of existing zipcodes to prevent further duplicates in the same file
                        $existingZipcodes[] = $zipcode;
                    }
                }
            }
            fclose($handle);

            // Insert data into the database
            if (!empty($data)) {
                $writeConnection = $this->resourceConnection->getConnection();
                $writeConnection->insertMultiple('coditron_zipcodeavailability_zipcode', $data);
            }

            // Delete the uploaded CSV file after successful insertion
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

}
