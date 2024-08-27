<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Model\ResourceModel;

use Element119\AdminOpCacheReport\Api\Data\OpCacheReportInterface;
use Element119\AdminOpCacheReport\Api\OpCacheReportRepositoryInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OpCacheReport extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(OpCacheReportRepositoryInterface::MAIN_TABLE, OpCacheReportInterface::ENTITY_ID);
    }
}
