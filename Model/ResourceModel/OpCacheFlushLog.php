<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Model\ResourceModel;

use Element119\AdminOpCacheReport\Api\Data\OpCacheFlushLogInterface;
use Element119\AdminOpCacheReport\Api\OpCacheFlushLogRepositoryInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OpCacheFlushLog extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(OpCacheFlushLogRepositoryInterface::MAIN_TABLE, OpCacheFlushLogInterface::LOG_ID);
    }
}
