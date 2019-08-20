/*global define*/
define([
    'knockout',
    'jquery',
    'mage/url',
    'Magento_Ui/js/form/form',
    'Magento_Ui/js/form/element/select',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/url-builder',
    'Magento_Checkout/js/model/error-processor',
    'Magento_Checkout/js/model/cart/cache',
    'OuterEdge_LeadSources/js/model/checkout/custom-checkout-form'
], function(ko, $, urlFormatter, form, Component, customer, quote, urlBuilder, errorProcessor, cartCache, formData) {
    'use strict';

    return Component.extend({
        customFields: ko.observable(null),
        formData: formData.customFieldsData,

        /**
         * Data bing event on update
         * @param {*} value
         */
        onUpdate: function (value) {
            this.showOtherReasonInput();
            this.saveCustomFields();
        },

        /**
         * Initialize component
         *
         * @returns {exports}
         */
        initialize: function () {
            var self = this;
            this._super();
            formData = this.source.get('shippingAddress');
            var formDataCached = cartCache.get('custom-form');
            if (formDataCached) {
                formData = this.source.set('shippingAddress', formDataCached);
            }

            this.customFields.subscribe(function(change){
                self.formData(change);

            });

            return this;
        },

        /**
         * Show or hide other reason input
         */
        showOtherReasonInput: function() {

            var formData = this.source.get('shippingAddress');
            var requiredField = '<div class="field-error"><span>This is a required field.</span></div>';

            if (formData.checkout_lead == 'Other reason') {
                $('div[name="shippingAddress.checkout_lead_input"]').css("display", "block");
                $('div[name="shippingAddress.checkout_lead_input"]').closest('.field').addClass('_required');
                $('div[name="shippingAddress.checkout_lead_input"] .control').append(requiredField);

                $('button.button.action.continue.primary').attr('disabled', true);


                $('div[name="shippingAddress.checkout_lead_input"] input').keyup(function() {
                    if($(this).val() != '') {
                       $('button.button.action.continue.primary').attr('disabled', false);
                       $('div[name="shippingAddress.checkout_lead_input"] .control .field-error').remove();
                    }
                 });
            } else {
                $('div[name="shippingAddress.checkout_lead_input"]').css("display", "none");
                $('button.button.action.continue.primary').attr('disabled', false);
            }
        },

        /**
         * Form submit handler
         */
        saveCustomFields: function() {

            var formData = this.source.get('shippingAddress');
            var quoteId = quote.getQuoteId();
            var isCustomer = customer.isLoggedIn();
            var url;
            var data = formData.checkout_lead;

            if ($('div[name="shippingAddress.checkout_lead_input"]').css("display") == 'block') {
                data = formData.checkout_lead + ' : ' + formData.checkout_lead_input;
            }

            if (isCustomer) {
                url = urlBuilder.createUrl('/carts/mine/set-order-custom-fields', {});
            } else {
                url = urlBuilder.createUrl('/guest-carts/:cartId/set-order-custom-field', {cartId: quoteId});
            }

            var payload = {
                cartId: quoteId,
                customFields: {'checkout_lead': data}
            };

            var result = true;
            $.ajax({
                url: urlFormatter.build(url),
                data: JSON.stringify(payload),
                global: false,
                contentType: 'application/json',
                type: 'PUT',
                async: true
            }).done(
                function (response) {
                    cartCache.set('custom-form', formData);
                    result = true;
                }
            ).fail(
                function (response) {
                    result = false;
                    errorProcessor.process(response);
                }
            );

            this.source.trigger('shippingAddress.data.validate');
            return result;
        }
    });
});