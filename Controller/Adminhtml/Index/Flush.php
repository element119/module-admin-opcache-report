<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Controller\Adminhtml\Index;

use Element119\AdminOpCacheReport\Api\Data\OpCacheFlushLogInterfaceFactory;
use Element119\AdminOpCacheReport\Api\OpCacheFlushLogRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Auth\Session as AdminSession;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

class Flush extends Action
{
    public const ADMIN_RESOURCE = 'Element119_AdminOpCacheReport::flush';

    public function __construct(
        private readonly Context $context,
        private readonly OpCacheFlushLogInterfaceFactory $opCacheFlushLogInterfaceFactory,
        private readonly OpCacheFlushLogRepositoryInterface $opCacheFlushLogRepository,
        private readonly AdminSession $adminSession,
        private readonly LoggerInterface $logger,
    ) {
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        opcache_reset();

        try {
            $opCacheFlushLog = $this->opCacheFlushLogInterfaceFactory->create();
            $opCacheFlushLog->setAdminId($this->adminSession->getUser()->getId());
            $this->opCacheFlushLogRepository->save($opCacheFlushLog);
        } catch (CouldNotSaveException $e) {
            $this->logger->error(sprintf('Could not save OpCache flush log: %s', $e->getMessage()));
        }

        $this->messageManager->addSuccessMessage(__('PHP OpCache flushed successfully.'));

        return $this->resultRedirectFactory->create()->setPath('opcache_report/index/index');
    }
}
