+function ($) {
    "use strict"

    if ($.fn.checkout === undefined)
        $.fn.checkout = {}

    var Checkout = function (element, options) {
        this.$el = $(element)
        this.options = options || {}
        this.paymentInputSelector = 'input[name="' + this.options.paymentInputName + '"]'
        this.$form = $(this.options.formSelector)
        this.$checkoutBtn = $(this.options.buttonSelector)

        this.init()
    }

    Checkout.prototype.init = function () {
        var self = this
        $(document)
            .on('click', '[data-checkout-control]', $.proxy(this.onControlClick, this))
            .on('ajaxBeforeSend', this.options.buttonSelector, function () {
                $(this).prop('disabled', true)
            })
            .on('ajaxFail', this.options.buttonSelector, function () {
                $(this).prop('disabled', false)
            })
            .on('ajaxFail', this.options.buttonSelector, function () {
                this.$checkoutBtn.prop('disabled', false)
            })
            .on('submit', this.options.formSelector, $.proxy(this.onSubmitCheckoutForm, this))

        Livewire.on('checkout::validated', (message) => {
            self.completeCheckout();
        })

        Livewire.hook('morph.updating',  ({ el, component, toEl, skip, childrenOnly }) => {
            if (this.$checkoutBtn.data('skipValidation')) {

                if ($(el).data('toggle') === 'payments' || $(el).is(this.options.buttonSelector)) {
                    skip()
                }

            }
        })
    }

    Checkout.prototype.completeCheckout = function () {
        var _event = jQuery.Event('submitCheckoutForm')
        this.$form.trigger(_event)
        if (_event.isDefaultPrevented()) {
            return false;
        }

        Livewire.dispatch(this.options.confirmEvent);
    }

    Checkout.prototype.choosePayment = function ($el) {
        var $paymentToggle = $el.closest('[data-toggle="payments"]')

        if ($paymentToggle.hasClass('in-progress') || $el.find(this.paymentInputSelector).is(':checked'))
            return

        $(this.paymentInputSelector, document).prop('disabled', true)
        Livewire.dispatch(this.options.choosePaymentEvent, {code: $el.data('paymentCode')});
    }

    Checkout.prototype.deletePaymentProfile = function ($el) {
        Livewire.dispatch(this.options.deletePaymentProfileEvent, {code: $el.data('paymentCode')});
    }

    Checkout.prototype.triggerPaymentInputChange = function ($el) {
        var paymentInputSelector = this.paymentInputSelector + '[value=' + $el.data('paymentCode') + ']';
        setTimeout(function () {
            $(paymentInputSelector, document).prop('checked', true).trigger('change')
        }, 1)
    }

    // EVENT HANDLERS
    // ============================

    Checkout.prototype.onControlClick = function (event) {
        var $el = $(event.currentTarget),
            control = $el.data('checkoutControl')

        switch (control) {
            case 'choose-payment':
                this.choosePayment($el)
                return false
            case 'delete-payment-profile':
                this.deletePaymentProfile($el, event)
                return false
        }
    }

    Checkout.prototype.onSubmitCheckoutForm = function (event) {
        var $selectedPaymentMethod = $(this.paymentInputSelector + ':checked', document)

        event.preventDefault();

        if (!this.$checkoutBtn.data('skipValidation') && $selectedPaymentMethod && $selectedPaymentMethod.data('preValidateCheckout') === true) {
            this.$checkoutBtn.data('skipValidation', true)
            Livewire.dispatch(this.options.validateEvent);
            return false;
        }

        this.completeCheckout();
    }

    Checkout.DEFAULTS = {
        alias: 'checkout',
        wireId: undefined,
        formSelector: '#checkout-form',
        buttonSelector: '[data-checkout-control="submit"]',
        paymentInputName: 'payment',
        confirmEvent: undefined,
        validateEvent: undefined,
        choosePaymentEvent: undefined,
        deletePaymentProfileEvent: undefined,
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.checkout

    $.fn.checkout = function (option) {
        var args = arguments

        return this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.checkout')
            var options = $.extend({}, Checkout.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.checkout', (data = new Checkout(this, options)))
            if (typeof option == 'string') data[option].apply(data, args)
        })
    }

    $.fn.checkout.Constructor = Checkout

    $.fn.checkout.noConflict = function () {
        $.fn.checkout = old
        return this
    }

    $(document).render(function () {
        $('[data-control="checkout"]').checkout()
    })

    $(document)
        .on('ajaxPromise', '[data-payment-code]', function () {
            var $indicatorContainer = $(this).closest('.progress-indicator-container')
            $indicatorContainer.prepend('<div class="progress-indicator"></div>')
            $indicatorContainer.addClass('is-loading')
        })
        .on('ajaxFail ajaxDone', '[data-payment-code]', function () {
            var $indicatorContainer = $(this).closest('.progress-indicator-container')
            $('div.progress-indicator', $indicatorContainer).remove()
            $indicatorContainer.removeClass('is-loading')
        })
}(window.jQuery)
