<?php
/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
*/
declare(strict_types=1);

namespace Coditron\ZipcodeAvailability\Api;

interface ZipcodeAvailabilityManagementInterface
{

    /**
     * GET for ZipcodeAvailability api
     * @param string $param
     * @return string
     */
    public function getZipcodeAvailability($param);
}

