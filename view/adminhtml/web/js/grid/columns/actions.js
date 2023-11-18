define([
    'uiComponent',
    'Magento_Ui/js/modal/confirm'
], function (Component, confirm) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'DigitalHub_DoubleCheck/grid/columns/actions',
        },

        /**
         * Handler of delete action click.
         *
         * @param {Object} record
         */
        onDelete: function (record) {
            var self = this;

            confirm({
                content: 'Tem certeza de que deseja excluir este item?',
                actions: {
                    confirm: function () {
                        self.getSource().delete(record);
                    }
                }
            });
        },
    });
});
