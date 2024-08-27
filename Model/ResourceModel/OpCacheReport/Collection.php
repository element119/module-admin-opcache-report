<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Model\ResourceModel\OpCacheReport;

use Element119\AdminOpCacheReport\Model\OpCacheReport;
use Element119\AdminOpCacheReport\Model\ResourceModel\OpCacheReport as OpCacheReportResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /** @inheritDoc */
    protected $_idFieldName = 'entity_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(OpCacheReport::class, OpCacheReportResourceModel::class);
    }
}
