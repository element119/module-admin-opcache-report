<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Api;

interface OpCacheReportResultsInterface
{
    /**
     * Get PHP OpCache report data for the current moment.
     *
     * @return array
     */
    public function get(): array;
}
