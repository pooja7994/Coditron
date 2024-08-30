<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Block\Adminhtml\ZipcodeAvailability\Edit;

use Magento\Backend\Block\Template;

class DownloadSampleCsv extends Template
{
    /**
     * Get the URL for downloading the sample CSV.
     *
     * @return string
     */
    public function getSampleCsvUrl()
    {
        return $this->getUrl('custom_zipcodeavailability/zipcodeavailability/download');
    }
}
