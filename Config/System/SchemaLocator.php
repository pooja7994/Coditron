<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Config\System;

use Magento\Framework\Module\Dir;

class SchemaLocator implements \Magento\Framework\Config\SchemaLocatorInterface
{

    protected $_perFileSchema = null;
    protected $_schema = null;

    /**
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     */
    public function __construct(
        \Magento\Framework\Module\Dir\Reader $moduleReader
    ) {
        $etcDir = $moduleReader->getModuleDir(Dir::MODULE_ETC_DIR, 'Coditron_ZipcodeAvailability');
        $this->_schema = $etcDir . '/system_merged.xsd';
        $this->_perFileSchema = $etcDir . '/system.xsd';
    }

    /**
     * Get path to merged config schema
     *
     * @return string|null
     */
    public function getSchema()
    {
        return $this->_schema;
    }

    /**
     * Get path to pre file validation schema
     *
     * @return string|null
     */
    public function getPerFileSchema()
    {
        return $this->_perFileSchema;
    }
}

