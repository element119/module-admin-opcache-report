<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class MemoryUnits implements OptionSourceInterface
{
    public const EXPONENT_GB = 3;
    public const EXPONENT_MB = 2;
    public const LABEL_GB = 'GB';
    public const LABEL_MB = 'MB';

    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::EXPONENT_MB,
                'label' => __(self::LABEL_MB),
            ],
            [
                'value' => self::EXPONENT_GB,
                'label' => __(self::LABEL_GB),
            ],
        ];
    }
}
