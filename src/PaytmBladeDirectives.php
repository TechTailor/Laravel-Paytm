<?php

namespace TechTailor\Paytm;

class PaytmBladeDirectives
{
    public static function paytmScripts(string $expression): string
    {
        return <<<'HTML'
        <script type="application/javascript" crossorigin="anonymous" src="{{ config('paytm.url.testing') }}/merchantpgpui/checkoutjs/merchants/{{ config('paytm.merchant.id') }}.js"></script>
        <script src="{{ asset('vendor/paytm/js/paytm.js') }}" data-turbo-eval="false" data-turbolinks-eval="false"></script>
        HTML;
    }
}
