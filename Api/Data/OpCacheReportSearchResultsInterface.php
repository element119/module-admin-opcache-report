<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Api\Data;

use Element119\AdminOpCacheReport\Api\Data\OpCacheReportInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface OpCacheReportSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return OpCacheReportInterface[]
     */
    public function getItems(): array;

    /**
     * @param OpCacheReportInterface[] $items
     * @return self
     */
    public function setItems(array $items): self;
}
