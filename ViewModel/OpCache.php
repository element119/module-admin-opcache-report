<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\ViewModel;

use Element119\AdminOpCacheReport\System\ModuleConfig;
use Magento\Framework\Module\Dir\ReverseResolver as ModuleDirResolver;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class OpCache implements ArgumentInterface
{
    public const MODULE_DATA_HITS = 'hits';
    public const MODULE_DATA_KEY_UNKNOWN = 'Unknown';
    public const MODULE_DATA_MEMORY_USAGE = 'memory_consumption';
    public const MODULE_DATA_MODULE_NAME = 'module_name';
    public const MODULE_DATA_SCRIPT_COUNT = 'script_count';

    private array $opCacheConfig = [];
    private array $opCacheStatus = [];
    private array $opCacheModuleData = [];

    public function __construct (
        private readonly ModuleConfig $moduleConfig,
        private readonly ModuleDirResolver $moduleDirResolver,
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

    public function formatNumber($number): string
    {
        return number_format($number, $this->moduleConfig->getFloatPrecision());
    }

    /**
     * Get Magento module OpCache statistics.
     *
     * OpCache scripts that do not belong to a Magento module are categorised as "Unknown". You can use this as the
     * $module argument value.
     *
     * @param string|null $module
     * @return array
     */
    public function getOpCacheModuleData(?string $module = null): array
    {
        if (!$this->opCacheModuleData) {
            foreach ($this->getOpCacheStatusData('scripts') as $scriptPath => $data) {
                $moduleName = $this->moduleDirResolver->getModuleName($scriptPath) ?? self::MODULE_DATA_KEY_UNKNOWN;

                if (!array_key_exists($moduleName, $this->opCacheModuleData)) {
                    $this->opCacheModuleData[$moduleName] = [
                        self::MODULE_DATA_MODULE_NAME => $moduleName,
                        self::MODULE_DATA_SCRIPT_COUNT => 0,
                        self::MODULE_DATA_HITS => 0,
                        self::MODULE_DATA_MEMORY_USAGE => 0,
                    ];
                }

                $this->opCacheModuleData[$moduleName][self::MODULE_DATA_SCRIPT_COUNT]++;
                $this->opCacheModuleData[$moduleName][self::MODULE_DATA_HITS] += $data[self::MODULE_DATA_HITS];
                $this->opCacheModuleData[$moduleName][self::MODULE_DATA_MEMORY_USAGE] += $data[self::MODULE_DATA_MEMORY_USAGE];
            }

            ksort($this->opCacheModuleData);
        }

        if ($module && array_key_exists($module, $this->opCacheModuleData)) {
            return $this->opCacheModuleData[$module];
        }

        return $this->opCacheModuleData;
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
        $value = $this->formatNumber($memoryValue / (1024 ** $this->moduleConfig->getMemoryUnitExponent()));

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
