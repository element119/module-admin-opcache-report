<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Plugin;

use Hyva\Admin\Model\GridSourceType\ArrayProviderGridSourceType;

class HandleEmptyOpCacheFlushLogTable
{
    /**
     * Workaround to prevent the Hyva_Admin module throwing an exception while attempting to validate grid column keys
     * when the e119_opcache_admin_flush_history table is empty - which is the case immediately after this module is
     * first installed. A pull request has been opened upstream to avoid this validation when a table associated with a
     * Hyva_Admin grid is empty.
     *
     * @link https://github.com/hyva-themes/magento2-hyva-admin/pull/89
     */
    public function afterGetColumnKeys(ArrayProviderGridSourceType $subject, array $result): array
    {
        if (!$result && $subject->getGridName() === 'opcache-flush-log') {
            return [
                'log_id',
                'admin_name',
                'flushed_at',
            ];
        }

        return $result;
    }
}
