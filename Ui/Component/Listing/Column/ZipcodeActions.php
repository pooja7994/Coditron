<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\Action as ActionRenderer;

class ZipcodeActions extends Column
{
    /**
     * Prepare actions for column
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = [
                    [
                        'label' => __('Delete'),
                        'url' => $this->getUrl('coditron_zipcodeavailability/zipcodeavailability/delete', ['id' => $item['zipcode_id']]),
                        'confirm' => [
                            'title' => __('Delete item'),
                            'message' => __('Are you sure you want to delete this item?')
                        ],
                        'hidden' => false
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
