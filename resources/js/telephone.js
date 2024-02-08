+function ($) {
    "use strict"

    $(document).render(function () {
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
        });
    });
}(window.jQuery)
