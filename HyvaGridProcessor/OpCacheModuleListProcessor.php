<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\HyvaGridProcessor;

use Element119\AdminOpCacheReport\ViewModel\OpCache;
use Hyva\Admin\Model\GridSource\AbstractGridSourceProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;

class OpCacheModuleListProcessor extends AbstractGridSourceProcessor
{
    public function __construct(
        private readonly OpCache $opCache,
    ) {
    }

    public function afterLoad($rawResult, SearchCriteriaInterface $searchCriteria, string $gridName)
    {
        foreach ($rawResult as &$data) {
            $data[OpCache::MODULE_DATA_MEMORY_USAGE] = $this->opCache->getOrdinalMemoryValue($data[OpCache::MODULE_DATA_MEMORY_USAGE]);
        }

        return $rawResult;
    }
}
