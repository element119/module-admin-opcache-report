<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Model\ResourceModel\OpCacheFlushLog;

use Element119\AdminOpCacheReport\Model\ResourceModel\OpCacheFlushLog;
use Element119\AdminOpCacheReport\Model\ResourceModel\OpCacheFlushLog as OpCacheFlushLogResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /** @inheritDoc */
    protected $_idFieldName = 'log_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(OpCacheFlushLog::class, OpCacheFlushLogResourceModel::class);
    }
}
