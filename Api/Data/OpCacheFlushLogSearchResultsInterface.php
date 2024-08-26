<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Api\Data;

use Element119\AdminOpCacheReport\Api\Data\OpCacheFlushLogInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface OpCacheFlushLogSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return OpCacheFlushLogInterface[]
     */
    public function getItems(): array;

    /**
     * @param OpCacheFlushLogInterface[] $items
     * @return self
     */
    public function setItems(array $items): self;
}
