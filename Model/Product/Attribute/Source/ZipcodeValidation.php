<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Model\Product\Attribute\Source;

class ZipcodeValidation extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [
        ['value' => 'enabled', 'label' => __('Enabled')],
        ['value' => 'disabled', 'label' => __('Disabled')]
        ];
        return $this->_options;
    }
}

