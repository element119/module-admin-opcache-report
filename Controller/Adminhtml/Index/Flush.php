<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\View\Result\PageFactory;

class Flush extends Action
{
    public const ADMIN_RESOURCE = 'Element119_AdminOpCacheReport::flush';

    public function __construct(
        private readonly Context $context,
        private readonly PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        opcache_reset();

        $this->messageManager->addSuccessMessage(__('PHP OpCache flushed successfully.'));

        return $this->resultRedirectFactory->create()->setPath('opcache_report/index/index');
    }
}
