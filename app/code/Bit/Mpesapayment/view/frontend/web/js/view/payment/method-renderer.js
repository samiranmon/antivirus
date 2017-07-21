define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'mpesapayment',
                component: 'Bit_Mpesapayment/js/view/payment/method-renderer/mpesapayment'
            }
        );
        return Component.extend({});
    }
);