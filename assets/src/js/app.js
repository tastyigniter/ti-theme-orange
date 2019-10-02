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

$(function () {
    $(window).on('ajaxErrorMessage', function (event, message) {
        event.preventDefault()
        $.ti.flashMessage({class: 'danger', text: message})
    })
})

$(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'fa fa-check-square-o'
                },
                off: {
                    icon: 'fa fa-square-o'
                }
            }

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'))
            $checkbox.triggerHandler('change')
            updateDisplay()
        })
        $checkbox.on('change', function () {
            updateDisplay()
        })

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked')

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off")

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon)

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active')
            } else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default')
            }
        }

        // Initialization
        function init() {

            updateDisplay()

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i>')
            }
        }

        init()
    })
})

$(function () {
    $(window).bind("load resize", function () {
        $('.affix-module').each(function () {
            $(this).find('[data-spy="affix"]:first-child').css('width', $(this).width())
        })
        $('body').css({'padding-bottom': $('.footer').outerHeight() + 10 + 'px'});
    })
    $('body').css({'padding-bottom': $('.footer').outerHeight() + 10 + 'px'});
})

$(function () {
    var $el = $('[data-control="cookie-banner"]'),
        $btn = $el.find('#eu-cookie-action'),
        options = $.extend({}, $el.data()),
        cookieName = 'complianceCookie',
        cookieValue = 'on',
        cookieDuration = 30

    if (options.active === 1) {
        if (checkCookie(cookieName) !== cookieValue) {
            $el.fadeIn()
        }
    } else {
        eraseCookie('complianceCookie');
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