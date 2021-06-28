/**
 * Tooltip for the Field Formatter Test tooltip formatter.
 */
(function ($) {
    'use strict';
    Drupal.behaviors.field_formatter_test = {
        attach: function () {
            $('.tooltiphover').qtip();
        }
    };
})(jQuery);