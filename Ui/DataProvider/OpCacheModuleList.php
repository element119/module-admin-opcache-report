<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Ui\DataProvider;

use Element119\AdminOpCacheReport\ViewModel\OpCache;
use Hyva\Admin\Api\HyvaGridArrayProviderInterface;

class OpCacheModuleList implements HyvaGridArrayProviderInterface
{
    public function __construct(
        private readonly OpCache $opCache,
    ) { }

    public function getHyvaGridData(): array
    {
        return $this->opCache->getOpCacheModuleData();
    }
}
