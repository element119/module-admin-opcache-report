<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Api;

use Element119\AdminOpCacheReport\Api\Data\OpCacheFlushLogInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface OpCacheFlushLogRepositoryInterface
{
    public const MAIN_TABLE = 'e119_opcache_admin_flush_history';

    /**
     * @param OpCacheFlushLogInterface $opCacheFlushLog
     * @return OpCacheFlushLogInterface
     * @throws CouldNotSaveException
     */
    public function save(OpCacheFlushLogInterface $opCacheFlushLog): OpCacheFlushLogInterface;

    /**
     * @param int $logId
     * @return OpCacheFlushLogInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $logId): OpCacheFlushLogInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;

    /**
     * @param OpCacheFlushLogInterface $opCacheFlushLog
     * @return bool true on success
     * @throws CouldNotDeleteException
     */
    public function delete(OpCacheFlushLogInterface $opCacheFlushLog): bool;

    /**
     * @param int $logId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $logId): bool;
}
