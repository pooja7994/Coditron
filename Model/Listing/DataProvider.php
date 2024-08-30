<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Model\Listing;

use Coditron\ZipcodeAvailability\Model\ResourceModel\Zipcode\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    protected $request;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        RequestInterface $request, // Inject RequestInterface
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->request = $request; // Assign RequestInterface
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return [
                'items' => array_values($this->loadedData), 
                'totalRecords' => count($this->loadedData), 
            ];
        }
    
        // Get the region ID from the request
        $regionId = $this->request->getParam('id'); // Use RequestInterface to get parameters
    
        // Apply filter based on the region ID
        if ($regionId) {
            $this->collection->addFieldToFilter('region_id', $regionId);
        }
    
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }
        
        $data = $this->dataPersistor->get('coditron_zipcodeavailability_zipcode');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('coditron_zipcodeavailability_zipcode');
        }
    
        // Return data in the expected format
        return [
            'items' => array_values($this->loadedData), 
            'totalRecords' => count($this->loadedData),
        ];
    }    
}