<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Model;

use Element119\AdminOpCacheReport\Api\Data\OpCacheFlushLogInterface;
use Element119\AdminOpCacheReport\Api\Data\OpCacheFlushLogInterfaceFactory;
use Element119\AdminOpCacheReport\Api\Data\OpCacheFlushLogSearchResultsInterfaceFactory;
use Element119\AdminOpCacheReport\Api\OpCacheFlushLogRepositoryInterface;
use Element119\AdminOpCacheReport\Model\ResourceModel\OpCacheFlushLog as OpCacheFlushLogResource;
use Element119\AdminOpCacheReport\Model\ResourceModel\OpCacheFlushLog\CollectionFactory as OpCacheFlushLogCollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class OpCacheFlushLogRepository implements OpCacheFlushLogRepositoryInterface
{
    public function __construct(
        private readonly OpCacheFlushLogCollectionFactory $opCacheFlushLogCollectionFactory,
        private readonly OpCacheFlushLogInterfaceFactory $opCacheFlushLogFactory,
        private readonly OpCacheFlushLogResource $resource,
        private readonly OpCacheFlushLogSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function save(OpCacheFlushLogInterface $opCacheFlushLog): OpCacheFlushLogInterface
    {
        try {
            $this->resource->save($opCacheFlushLog);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save the log: %1', $e->getMessage()));
        }

        return $opCacheFlushLog;
    }

    /**
     * @inheritDoc
     */
    public function getById($logId): OpCacheFlushLogInterface
    {
        $opCacheFlushLog = $this->opCacheFlushLogFactory->create();
        $this->resource->load($opCacheFlushLog, $logId);

        if (!$opCacheFlushLog->getId()) {
            throw new NoSuchEntityException(__('OpCache flush log with ID "%1" does not exist.', $logId));
        }

        return $opCacheFlushLog;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults
    {
        $collection = $this->opCacheFlushLogCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];

        foreach ($collection as $opCacheLog) {
            $items[] = $opCacheLog;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(OpCacheFlushLogInterface $opCacheFlushLog): bool
    {
        try {
            /** @var OpCacheFlushLogInterface $opCacheFlushLogModel */
            $opCacheFlushLogModel = $this->opCacheFlushLogFactory->create();

            $this->resource->load($opCacheFlushLogModel, $opCacheFlushLog->getEntityId());
            $this->resource->delete($opCacheFlushLogModel);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(
                __('Could not delete the OpCache flush log with ID: %1', $e->getMessage())
            );
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($logId): bool
    {
        return $this->delete($this->getById($logId));
    }
}
