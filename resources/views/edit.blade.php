@extends('DashboardModule::dashboard.index', ['title' => (isset($icon) ? 'Edytowanie' : 'Dodawanie') . ' ikonki'])

@section('navbar-actions')
    <b-nav-form>
        <b-button size="sm" class="my-2 my-sm-0" type="button" to="{{ route('IconModule::index') }}">
            <b-icon-arrow-left></b-icon-arrow-left> Do listy
        </b-button>
    </b-nav-form>
@endsection

@section('content')
    <b-container fluid>
        <icon
                route="{{ isset($icon) ? route('IconModule::update', ['icon' => $icon]) : route('IconModule::store') }}"
                csrf="{{ csrf_token() }}"
                media-search-route="{{ route('MediaModule::api.files') }}"
                media-route='/media/'
                check-key-route="{{ route('IconModule::api.checkKey') }}"
                :icon="{{ isset($icon) ? json_encode($icon) : json_encode(null) }}"
                :langs="{{ json_encode($langs) }}"
        >
        </icon>
    </b-container>
@endsection

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ mix('vendor/css/MediaModule.css') }}">
@endsection

@section('javascripts')
    <script src="{{ mix("vendor/js/IconModule.js") }}"></script>
@endsection
