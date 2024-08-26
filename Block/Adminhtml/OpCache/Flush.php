<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminOpCacheReport\Block\Adminhtml\OpCache;

use Magento\Backend\Block\Widget\Container;

class Flush extends Container
{
    protected function _construct()
    {
        parent::_construct();

        if ($this->_authorization->isAllowed('Element119_AdminOpCacheReport::flush')) {
            $message = __('Caution: Flushing the PHP OpCache will lead to temporary performance degradation. See the <a href="https://www.php.net/manual/en/intro.opcache.php" target="_blank">PHP OpCache documentation</a> for more information.');
            $this->buttonList->add(
                'flush_opcache',
                [
                    'label' => __('Flush PHP OpCache'),
                    'onclick' => 'confirmSetLocation(\'' . $message . '\', \'' . $this->getFlushOpCacheUrl() . '\')',
                    'class' => 'primary',
                ]
            );
        }
    }

    public function getFlushOpCacheUrl(): string
    {
        return $this->getUrl('opcache_report/index/flush');
    }
}
