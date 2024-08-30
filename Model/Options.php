<?php 
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Model;
use Magento\Framework\Data\OptionSourceInterface;


class Options implements OptionSourceInterface
{
   
  public function toOptionArray(){
    
         return [
            ['label' => __('Enable'), 'value' => '1'],
            ['label' => __('Disable'), 'value' => '0']
        ];
    }
}