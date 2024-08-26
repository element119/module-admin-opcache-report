<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Api\Data;

interface OpCacheFlushLogInterface
{
    public const ADMIN_ID = 'admin_id';
    public const FLUSHED_AT = 'flushed_at';
    public const LOG_ID = 'log_id';

    /**
     * @return int
     */
    public function getLogId(): int;

    /**
     * @param int|string $logId
     * @return self
     */
    public function setLogId(int|string $logId): self;

    /**
     * @return int
     */
    public function getAdminId(): int;

    /**
     * @param int|string $adminId
     * @return self
     */
    public function setAdminId(int|string $adminId): self;

    /**
     * @return string
     */
    public function getFlushedAt(): string;

    /**
     * @param string $flushedAt
     * @return self
     */
    public function setFlushedAt(string $flushedAt): self;
}
