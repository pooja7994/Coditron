<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Controller\Adminhtml\ZipcodeAvailability;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;

class Download extends Action
{
    protected $fileDriver;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\Filesystem\Driver\File $fileDriver
    ) {
        parent::__construct($context);
        $this->fileDriver = $fileDriver;
    }

    public function execute()
    {
        $filePath = $this->_objectManager->get(DirectoryList::class)
            ->getPath(DirectoryList::APP) . '/code/Coditron/ZipcodeAvailability/view/adminhtml/web/csv/sample.csv';

        if ($this->fileDriver->isExists($filePath)) {
            $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
            $result->setHeader('Content-Type', 'text/csv');
            $result->setHeader('Content-Disposition', 'attachment; filename="sample.csv"');
            $result->setContents(file_get_contents($filePath));
            return $result;
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('adminhtml/system_config/edit/section/coditron_zipcodeavailability');
    }
}
