<div>
    @if ($version !== 'v2')
        <div class="g-recaptcha" data-sitekey="{{ $apiKey }}"></div>
        {!! form_error('g-recaptcha-response', '<span class="text-danger">', '</span>') !!}
        <button
                class="g-recaptcha btn btn-primary"
                data-sitekey="{{ $apiKey }}"
                data-callback="recaptchaCallback"
        >Submit</button>
        <script
                type="text/javascript"
                src="https://www.google.com/recaptcha/api.js?hl={{ $lang }}"
                async defer
        ></script>
        <script type="application/javascript">
            function recaptchaCallback() {
                $('button.g-recaptcha').closest('form').submit();
            }
        </script>
    @else
        <div class="g-recaptcha" data-sitekey="{{ $apiKey }}"></div>
        {!! form_error('g-recaptcha-response', '<span class="text-danger">', '</span>') !!}
        <script
                type="text/javascript"
                src="https://www.google.com/recaptcha/api.js?hl={{ $lang }}"
                async defer
        ></script>
    @endif
</div>
