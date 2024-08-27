<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Cron;

use Element119\AdminOpCacheReport\Api\Data\OpCacheReportInterface;
use Element119\AdminOpCacheReport\Api\OpCacheReportRepositoryInterface;
use Element119\AdminOpCacheReport\System\ModuleConfig;
use Exception;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Intl\DateTimeFactory;
use Magento\Framework\Stdlib\DateTime;

class Clean
{
    public function __construct(
        private readonly OpCacheReportRepositoryInterface $opCacheReportRepository,
        private readonly ModuleConfig $moduleConfig,
        private readonly SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        private readonly DateTimeFactory $dateTimeFactory
    ) {
    }

    /**
     * Delete old OpCache report data.
     *
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(): void
    {
        if (!($days = $this->moduleConfig->getOpCacheLogTruncateDays())) {
            return;
        }

        $lastException = null;

        /** @var DateTime $cutoff */
        $cutoff = $this->dateTimeFactory->create(date(DateTime::DATETIME_PHP_FORMAT, strtotime("-$days day")));

        /** @var SearchCriteriaBuilder $searchCriteriaBuilder */
        $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
        $searchCriteria = $searchCriteriaBuilder->addFilter(
            OpCacheReportInterface::CREATED_AT,
            $cutoff,
            'lt'
        )->create();

        /** @var OpCacheReportInterface[] $opCacheReportsToDelete */
        $opCacheReportsToDelete = $this->opCacheReportRepository->getList($searchCriteria)->getItems();

        foreach ($opCacheReportsToDelete as $opCacheReport) {
            try {
                $this->opCacheReportRepository->delete($opCacheReport);
            } catch (CouldNotDeleteException $e) {
                $lastException = $e; // store exception as not to stop execution
            }
        }

        if ($lastException instanceof Exception) {
            throw $lastException; // re-throw exception to make noise
        }
    }
}
