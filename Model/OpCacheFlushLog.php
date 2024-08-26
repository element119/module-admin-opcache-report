<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Model;

use Element119\AdminOpCacheReport\Api\Data\OpCacheFlushLogInterface;
use Element119\AdminOpCacheReport\Model\ResourceModel\OpCacheFlushLog as OpCacheFlushLogResourceModel;
use Magento\Framework\Model\AbstractModel;

class OpCacheFlushLog extends AbstractModel implements OpCacheFlushLogInterface
{
    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(OpCacheFlushLogResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getLogId(): int
    {
        return (int)$this->getData(self::LOG_ID);
    }

    /**
     * @inheritDoc
     */
    public function setLogId(int|string $logId): self
    {
        return $this->setData(self::LOG_ID, $logId);
    }

    /**
     * @inheritDoc
     */
    public function getAdminId(): int
    {
        return (int)$this->getData(self::ADMIN_ID);
    }

    /**
     * @inheritDoc
     */
    public function setAdminId(int|string $adminId): self
    {
        return $this->setData(self::ADMIN_ID, $adminId);
    }

    /**
     * @inheritDoc
     */
    public function getFlushedAt(): string
    {
        return $this->getData(self::FLUSHED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setFlushedAt(string $flushedAt): OpCacheFlushLogInterface
    {
        return $this->setData(self::FLUSHED_AT, $flushedAt);
    }
}
