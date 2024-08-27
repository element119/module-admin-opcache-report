<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\System;

use Element119\AdminOpCacheReport\Model\Config\Source\MemoryUnits;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ModuleConfig implements ArgumentInterface
{
    private const XML_PATH_MEMORY_UNITS = 'system/opcache_report/memory_units';
    private const XML_PATH_FLOAT_PRECISION = 'system/opcache_report/float_precision';
    private const XML_PATH_DATE_FORMAT = 'system/opcache_report/date_format';
    private const XML_PATH_CRON_ENABLE = 'system/opcache_report/cron_enable';
    private const XML_PATH_CRON_SCHEDULE = 'system/opcache_report/cron_schedule';
    private const XML_PATH_LOG_TRUNCATE_DAYS = 'system/opcache_report/log_truncate_days';
    private const XML_PATH_INCLUDE_RAW_SCRIPTS = 'system/opcache_report/include_raw_script_data';
    private const XML_PATH_INCLUDE_MODULE_SCRIPTS = 'system/opcache_report/include_module_script_data';

    public function __construct(
        private readonly MemoryUnits $memoryUnits,
        private readonly ScopeConfigInterface $scopeConfig,
    ) {
    }

    public function getMemoryUnitExponent(): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_MEMORY_UNITS);
    }

    public function getMemoryUnitLabel(): ?Phrase
    {
        $exponent = $this->getMemoryUnitExponent();

        foreach ($this->memoryUnits->toOptionArray() as $memoryUnit) {
            if ($memoryUnit['value'] === $exponent) {
                return $memoryUnit['label'];
            }
        }

        return null;
    }

    public function getFloatPrecision(): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_FLOAT_PRECISION);
    }

    public function getDateFormat(): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_DATE_FORMAT);
    }

    public function isDataCollectionCronEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CRON_ENABLE);
    }

    public function getDataCollectionCronSchedule(): string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CRON_SCHEDULE) ?? '0 * * * *';
    }

    public function getOpCacheLogTruncateDays(): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_LOG_TRUNCATE_DAYS);
    }

    public function includeRawOpCacheScripts(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_INCLUDE_RAW_SCRIPTS);
    }

    public function includeModuleOpCacheScripts(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_INCLUDE_MODULE_SCRIPTS);
    }
}
