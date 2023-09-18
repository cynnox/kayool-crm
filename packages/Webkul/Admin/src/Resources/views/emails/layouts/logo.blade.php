@if ($logo = core()->getCurrentChannel()->logo_url)
    <img src="{{ $logo }}" alt="{{ config('app.name') }}" style="height: 40px; width: 110px;"/>
@else
    <!-- <img src="{{ asset('themes/default/assets/images/logo.svg') }}" alt="{{ config('app.name') }}"/> -->
    <img src="asset('vendor/webkul/admin/assets/images/kayool-logo.png')" alt="{{ config('app.name') }}" style="height: 50px;width: unset;"/>
@endif