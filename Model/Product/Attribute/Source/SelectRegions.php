<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Model\Product\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\App\ResourceConnection;

class SelectRegions extends AbstractSource
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * Constructor
     *
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Get all options from the database
     *
     * @return array
     */
    public function getAllOptions()
    {
        $options = [];
        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName('coditron_zipcodeavailability_zipcodeavailability'); // Adjust the table name as needed
        
        $results = $connection->fetchAll('SELECT zipcodeavailability_id, region_name FROM ' . $table);

        foreach ($results as $row) {
            $options[] = [
                'value' => $row['zipcodeavailability_id'],
                'label' => __($row['region_name'])
            ];
        }

        return $options;
    }
}
