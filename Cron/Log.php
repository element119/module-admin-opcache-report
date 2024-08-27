<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Cron;

use Element119\AdminOpCacheReport\Api\Data\OpCacheReportInterface;
use Element119\AdminOpCacheReport\Api\OpCacheReportRepositoryInterface;
use Element119\AdminOpCacheReport\Model\OpCacheReportFactory;
use Element119\AdminOpCacheReport\System\ModuleConfig;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\UrlInterface;
use Magento\Framework\Webapi\Response;

class Log
{
    public function __construct(
        private readonly OpCacheReportRepositoryInterface $opCacheReportRepository,
        private readonly OpCacheReportFactory $opCacheReportFactory,
        private readonly ModuleConfig $moduleConfig,
        private readonly Curl $curl,
        private readonly UrlInterface $url,
    ) {
    }

    /**
     * Store OpCache report data.
     *
     * @return void
     * @throws CouldNotSaveException
     * @throws LocalizedException
     */
    public function execute(): void
    {
        if (!$this->moduleConfig->isDataCollectionCronEnabled()) {
            return;
        }

        // make API call to fetch OpCache data for the correct execution context
        $this->curl->setHeaders(['Content-Type' => 'application/json']);
        $this->curl->get(rtrim($this->url->getBaseUrl(), '/') . '/rest/V1/e119/opcache-report');

        if ($this->curl->getStatus() !== Response::HTTP_OK) {
            throw new LocalizedException(__('Unable to read OpCache data.'));
        }

        /** @var OpCacheReportInterface $opCacheReportModel */
        $opCacheReportModel = $this->opCacheReportFactory->create();
        $opCacheReportModel->setReportData(json_decode($this->curl->getBody(), true));
        $this->opCacheReportRepository->save($opCacheReportModel);
    }
}
