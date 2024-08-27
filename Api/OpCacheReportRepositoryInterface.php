<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Api;

use Element119\AdminOpCacheReport\Api\Data\OpCacheReportInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface OpCacheReportRepositoryInterface
{
    public const MAIN_TABLE = 'e119_opcache_report';

    /**
     * @param OpCacheReportInterface $opCacheReport
     * @return OpCacheReportInterface
     * @throws CouldNotSaveException
     */
    public function save(OpCacheReportInterface $opCacheReport): OpCacheReportInterface;

    /**
     * @param int $opCacheReportId
     * @return OpCacheReportInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $opCacheReportId): OpCacheReportInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;

    /**
     * @param OpCacheReportInterface $opCacheReport
     * @return bool true on success
     * @throws CouldNotDeleteException
     */
    public function delete(OpCacheReportInterface $opCacheReport): bool;

    /**
     * @param int $opCacheReportId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $opCacheReportId): bool;
}
