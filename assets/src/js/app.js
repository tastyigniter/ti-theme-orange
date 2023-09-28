$.fn.tabs = function () {
    var selector = this

    this.each(function () {
        var obj = $(this)

        $(obj.attr('rel')).hide()

        $(obj).click(function () {
            $(selector).removeClass('active')

            $(selector).each(function (i, element) {
                $($(element).attr('rel')).hide()
            })

            $(this).addClass('active')

            $($(this).attr('rel')).show()

            return false
        })
    })

    $(this).show()

    $(this).first().click()
}

/*
 * Ensure the CSRF token is added to all AJAX requests.
 */
$.ajaxPrefilter(function (options) {
    var token = $('meta[name="csrf-token"]').attr('content')

    if (token) {
        if (!options.headers) options.headers = {}
        options.headers['X-CSRF-TOKEN'] = token
    }
})

$(function () {
    $(window).on('ajaxErrorMessage', function (event, message) {
        event.preventDefault()
        $.ti.flashMessage({class: 'danger', text: message})
    })
})

$(function () {
    var $el = $('[data-control="cookie-banner"]'),
        $btn = $el.find('#eu-cookie-action'),
        options = $.extend({}, $el.data()),
        cookieName = 'complianceCookie',
        cookieValue = 'on',
        cookieDuration = 30

    if ($el.length) {
        if (options.active === 1) {
            if (checkCookie(cookieName) !== cookieValue) {
                $el.fadeIn()
            }
        } else {
            eraseCookie('complianceCookie');
        }
    }

    $btn.on('click', function (event) {
        createCookie(cookieName, cookieValue, cookieDuration);
        $el.fadeOut()
    })

    function createCookie(name, value, days) {
        var expires = ''

        if (days) {
            var date = new Date()
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000))
            expires = '; expires=' + date.toGMTString()
        }

        document.cookie = name + "=" + value + expires + "; path=/"
    }

    function checkCookie(name) {
        var nameEQ = name + "=",
            ca = document.cookie.split(';')

        for (var i = 0; i < ca.length; i++) {
            var c = ca[i]
            while (c.charAt(0) === ' ') c = c.substring(1, c.length)
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length)
        }

        return null
    }

    function eraseCookie(name) {
        createCookie(name, "", -1);
    }
})

// CURRENCY HELPER FUNCTION DEFINITION
// ============================
$(function () {
    if (app) {
        app.currencyFormat = function (amount) {
            if (!app.currency)
                throw 'Currency values not defined in app scope';

            return currency(amount, {
                decimal: app.currency.decimal_sign,
                precision: app.currency.decimal_precision,
                separator: app.currency.thousand_sign,
                symbol: app.currency.symbol,
                pattern: app.currency.symbol_position ? '#!' : '!#',
            }).format();
        };
    }
})

// COUNTRY CODE PICKER
// ============================
$(function () {
    $(document).find('[data-control="country-code-picker"]').each(function () {
        var $this = $(this),
            options = $.extend({
                initialCountry: (app.country.iso_code_2 || '').toLowerCase(),
                separateDialCode: true,
                nationalMode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
            }, $this.data()),
            $telephoneInput = $('<input>').attr({
                type: 'hidden',
                id: 'hidden-input-' + $this.attr('id'),
                name: $this.attr('name'),
                value: $this.val(),
            });

        $this.removeAttr('name')
        $this.after($telephoneInput)

        var telephonePicker = $this.intlTelInput(options);

        $this.on('input countrychange', function () {
            $telephoneInput.val(telephonePicker.intlTelInput('getNumber'))
        })
    })
})

