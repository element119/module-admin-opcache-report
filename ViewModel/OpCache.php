<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\ViewModel;

use Element119\AdminOpCacheReport\System\ModuleConfig;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class OpCache implements ArgumentInterface
{
    private array $opCacheConfig = [];
    private array $opCacheStatus = [];

    public function __construct (
        private readonly ModuleConfig $moduleConfig,
    ) {
    }

    public function getOpCacheConfig(): array
    {
        if (!$this->opCacheConfig) {
            $this->opCacheConfig = opcache_get_configuration();
        }

        return $this->opCacheConfig;
    }

    public function getOpCacheStatus(): array
    {
        if (!$this->opCacheStatus) {
            $this->opCacheStatus = opcache_get_status();
        }

        return $this->opCacheStatus;
    }

    public function getOpCacheConfigData(string $path)
    {
        return $this->getData($this->getOpCacheConfig(), $path);
    }

    public function getOpCacheStatusData(string $path)
    {
        return $this->getData($this->getOpCacheStatus(), $path);
    }

    public function getOrdinalMemoryValue(int $memoryValue): string
    {
        $value = number_format(
            $memoryValue / (1024 ** $this->moduleConfig->getMemoryUnitExponent()),
            $this->moduleConfig->getFloatPrecision()
        );

        return $value . $this->moduleConfig->getMemoryUnitLabel();
    }

    private function getData(array $data, string $path)
    {
        $current = $data;
        $keys = explode('.', $path);

        foreach ($keys as $key) {
            $current = $current[$key];
        }

        return $current === $data ? null : $current;
    }
}
