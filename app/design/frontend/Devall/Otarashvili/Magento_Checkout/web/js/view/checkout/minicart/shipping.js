define(
    [
        'uiComponent',
        'ko',
        'Magento_Customer/js/customer-data',
    ],
    function (
        Component,
        ko,
        customerData,
    ) {
        'use strict';

        // Get cart section data
        var cartObservable = customerData.get('cart');

        return Component.extend({
            initialize: function() {
                this._super();

                // Make message an observable property
                this.shipping = ko.observable(cartObservable().shipping);

                // Subscribe to changes from cart section data
                cartObservable.subscribe((function(newCart) {
                    // Update message when cart section data changes
                    this.shipping(newCart.shipping);
                }).bind(this));
            },
        });
    }
);
