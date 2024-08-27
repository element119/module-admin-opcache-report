<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Model;

use Element119\AdminOpCacheReport\Api\Data\OpCacheReportInterface;
use Element119\AdminOpCacheReport\Api\Data\OpCacheReportInterfaceFactory;
use Element119\AdminOpCacheReport\Api\Data\OpCacheReportSearchResultsInterfaceFactory;
use Element119\AdminOpCacheReport\Api\OpCacheReportRepositoryInterface;
use Element119\AdminOpCacheReport\Model\ResourceModel\OpCacheReport as OpCacheReportResource;
use Element119\AdminOpCacheReport\Model\ResourceModel\OpCacheReport\CollectionFactory as OpCacheReportCollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class OpCacheReportRepository implements OpCacheReportRepositoryInterface
{
    public function __construct(
        private readonly OpCacheReportCollectionFactory $opCacheReportCollectionFactory,
        private readonly OpCacheReportInterfaceFactory $opCacheReportFactory,
        private readonly OpCacheReportResource $resource,
        private readonly OpCacheReportSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function save(OpCacheReportInterface $opCacheReport): OpCacheReportInterface
    {
        try {
            $this->resource->save($opCacheReport);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save the report: %1', $e->getMessage()));
        }

        return $opCacheReport;
    }

    /**
     * @inheritDoc
     */
    public function getById($opCacheReportId): OpCacheReportInterface
    {
        $opCacheReport = $this->opCacheReportFactory->create();
        $this->resource->load($opCacheReport, $opCacheReportId);

        if (!$opCacheReport->getId()) {
            throw new NoSuchEntityException(
                __('OpCache report with entity ID "%1" does not exist.', $opCacheReportId)
            );
        }

        return $opCacheReport;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults
    {
        $collection = $this->opCacheReportCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];

        foreach ($collection as $opCacheReport) {
            $items[] = $opCacheReport;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(OpCacheReportInterface $opCacheReport): bool
    {
        try {
            /** @var OpCacheReportInterface $opCacheReportModel */
            $opCacheReportModel = $this->opCacheReportFactory->create();

            $this->resource->load($opCacheReportModel, $opCacheReport->getEntityId());
            $this->resource->delete($opCacheReportModel);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(
                __('Could not delete the OpCache report with ID: %1', $e->getMessage())
            );
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($opCacheReportId): bool
    {
        return $this->delete($this->getById($opCacheReportId));
    }
}
