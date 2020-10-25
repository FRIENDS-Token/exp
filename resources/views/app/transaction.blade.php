@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @push('metatags')
        <meta property="og:title" content="@lang('metatags.transaction.title')" />
        <meta property="og:description" content="@lang('metatags.transaction.description')">
    @endpush

    @push('scripts')
        <script src="{{ mix('js/clipboard.js')}}"></script>
    @endpush

    @section('breadcrumbs')
        <x-general.breadcrumbs :crumbs="[
            ['route' => 'home', 'label' => trans('menus.home')],
            ['label' => trans('menus.transaction')],
        ]" />
    @endsection

    @section('content')
        <x-transaction.header :transaction="$transaction" />

        <x-details.grid>
            <x-dynamic-component :component="$transaction->typeComponent()" :transaction="$transaction" />
        </x-details.grid>

        @if($transaction->hasExtraData())
            <x-dynamic-component :component="$transaction->extraComponent()" :transaction="$transaction" />
        @endif
    @endsection

@endcomponent