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
    $(window).on('ajaxError', function (event, context, textStatus, jqXHR) {
        if (!jqXHR.responseJSON || !jqXHR.responseJSON.X_IGNITER_ERROR_FIELDS) return
        var fields = jqXHR.responseJSON.X_IGNITER_ERROR_FIELDS
        for (let field in fields) {
            var fieldName = dotToArrayString(field),
                $field = $('input[name="'+fieldName+'"], select[name="'+fieldName+'"]'),
                $floating = $field.closest('.form-floating')
            $field.attr('required', true)
            $field.addClass('is-invalid')
            $floating.addClass('is-invalid')
            $floating.find('.invalid-feedback').html(fields[field][0])
        }

        event.preventDefault()
    })

    $(window).on('ajaxErrorMessage', function (event, message) {
        event.preventDefault()
        $.ti.flashMessage({class: 'danger', text: message})
    })

    function dotToArrayString(str) {
        if (str.indexOf('.') !== -1) {
            let parts = str.split('.'), output = parts[0]
            for (var i = 1; i < parts.length; i++)
                output += '['+parts[i]+']'

            return output
        } else {
            return str
        }
    }
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
            date.setTime(date.getTime()+(days * 24 * 60 * 60 * 1000))
            expires = '; expires='+date.toGMTString()
        }

        document.cookie = name+"="+value+expires+"; path=/"
    }

    function checkCookie(name) {
        var nameEQ = name+"=",
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

/*
 * Custom event that unifies document.ready with window.ajaxUpdateComplete
 *
 * $(document).render(function() { })
 * $(document).on('render', function() { })
 */
+ function ($) {
    "use strict";

    $(document).ready(function () {
        $(document).trigger('render')
    })

    $(window).on('ajaxUpdateComplete', function () {
        $(document).trigger('render')
    })

    $(document).on('livewire:init', () => {
        Livewire.hook('request', ({respond, succeed}) => {
            respond(({status, response}) => {
                $(document).trigger('render')
            })
        })
    })

    $.fn.render = function (callback) {
        $(document).on('render', callback)
    }
}(window.jQuery);

