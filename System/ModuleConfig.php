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
}
