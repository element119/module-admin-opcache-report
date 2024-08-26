/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
define([
    'chartJs',
], function (Chart) {
    'use strict';

    return function (config, element) {
        new Chart(element, {
            type: config.type,
            data: config.data,
            options: config.options,
        });
    };
});
