<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Model;

use Element119\AdminOpCacheReport\Api\Data\OpCacheReportInterface;
use Element119\AdminOpCacheReport\Model\ResourceModel\OpCacheReport as OpCacheReportResourceModel;
use Magento\Framework\Model\AbstractModel;

class OpCacheReport extends AbstractModel implements OpCacheReportInterface
{
    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(OpCacheReportResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getEntityId(): int
    {
        return (int)$this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEntityId($entityId): self
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getReportData(): array
    {
        return $this->getData(json_decode(self::REPORT_DATA));
    }

    /**
     * @inheritDoc
     */
    public function setReportData(array $reportData): OpCacheReportInterface
    {
        return $this->setData(self::REPORT_DATA, json_encode($reportData));
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $createdAt): OpCacheReportInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt(string $updatedAt): OpCacheReportInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
