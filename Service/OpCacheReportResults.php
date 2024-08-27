<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Service;

use Element119\AdminOpCacheReport\Api\OpCacheReportResultsInterface;
use Element119\AdminOpCacheReport\System\ModuleConfig;
use Element119\AdminOpCacheReport\ViewModel\OpCache;

class OpCacheReportResults implements OpCacheReportResultsInterface
{
    public function __construct(
        private readonly ModuleConfig $moduleConfig,
        private readonly OpCache $opCache,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        $opCacheData = $this->opCache->getOpCacheStatus();

        if (!$this->moduleConfig->includeRawOpCacheScripts()) {
            unset($opCacheData['scripts']);
        }

        return [
            'data' => $opCacheData,
            'module_data' => $this->moduleConfig->includeModuleOpCacheScripts()
                ? $this->opCache->getOpCacheModuleData()
                : [],
        ];
    }
}
