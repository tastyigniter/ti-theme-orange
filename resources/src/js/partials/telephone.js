+function ($) {
    "use strict"

    $(document).render(function () {
        $(document).find('[data-control="country-code-picker"]').each(function () {
            var $el = $(this),
                options = $.extend({
                    initialCountry: (app.country.iso_code_2 || '').toLowerCase(),
                    separateDialCode: true,
                    nationalMode: true,
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
                }, $el.data()),
                $telephoneInput = $('<input>').attr({
                    type: 'hidden',
                    id: 'hidden-input-' + $el.attr('id'),
                    name: $el.attr('name'),
                    value: $el.val(),
                });

            $el.removeAttr('name')
            $el.after($telephoneInput)

            var telephonePicker = intlTelInput($el.get(0), options);

            $el.on('input countrychange', function () {
                $telephoneInput.val(telephonePicker.getNumber())
            })
        });
    });
}(window.jQuery)
