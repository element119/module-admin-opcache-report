<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Ui\DataProvider;

use Element119\AdminOpCacheReport\Api\Data\OpCacheFlushLogInterface;
use Element119\AdminOpCacheReport\Api\OpCacheFlushLogRepositoryInterface;
use Hyva\Admin\Api\HyvaGridArrayProviderInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface;
use Zend_Db_Statement_Exception;

class OpCacheFlushLog implements HyvaGridArrayProviderInterface
{
    public function __construct(
        private readonly OpCacheFlushLogRepositoryInterface $opCacheFlushLogRepository,
        private readonly SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        private readonly ResourceConnection $resourceConnection,
        private readonly LoggerInterface $logger,
    ) { }

    public function getHyvaGridData(): array
    {
        $data = [];
        $connection = $this->resourceConnection->getConnection();
        $adminInfoSelect = $connection->select()
            ->from(
                $this->resourceConnection->getTableName('admin_user'),
                ['user_id', 'CONCAT(firstname, \' \', lastname) AS admin_name']
            )->where(
                'user_id IN (SELECT admin_id FROM ' . OpCacheFlushLogRepositoryInterface::MAIN_TABLE . ')'
            );

        try {
            $adminInfo = $connection->query($adminInfoSelect)->fetchAll();
        } catch (Zend_Db_Statement_Exception $e) {
            $this->logger->error(sprintf(
                'An error occurred trying to fetch admin info for the OpCache flush history report: %s',
                $e->getMessage()
            ));

            return $data;
        }

        $adminMap = array_combine(
            array_column($adminInfo, 'user_id'),
            array_column($adminInfo, 'admin_name')
        );

        $searchCriteria = $this->searchCriteriaBuilderFactory->create();
        $flushLogs = $this->opCacheFlushLogRepository->getList($searchCriteria->create());

        /** @var OpCacheFlushLogInterface $flushLog */
        foreach ($flushLogs->getItems() as $flushLog) {
            $data[] = [
                'log_id' => $flushLog->getLogId(),
                'admin_name' => $adminMap[$flushLog->getAdminId()],
                'flushed_at' => $flushLog->getFlushedAt(),
            ];
        }

        return $data;
    }
}
