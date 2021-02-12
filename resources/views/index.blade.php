@extends('DashboardModule::dashboard.index', ['title' => 'Ikonki'])

@section('navbar-actions')
    <b-nav-form>
        <b-form-input size="sm" class="mr-sm-2" placeholder="Szukaj" v-model="search"></b-form-input>
        <b-button size="sm" class="my-2 my-sm-0" type="button" @click="find">Szukaj</b-button>
    </b-nav-form>
    <b-nav-form>
        <b-button size="sm" class="my-2 my-sm-0" type="button" variant="success" to="{{ route('IconModule::create') }}">
            <b-icon-plus></b-icon-plus> Dodaj
        </b-button>
    </b-nav-form>
@endsection

@section('content')
    <b-container fluid>
        <index
                add-route="{{ route('IconModule::create') }}"
                media-route="/media/"
                media-search-route="{{ route('MediaModule::api.files') }}"
                edit-route="{{ route('IconModule::edit', ['icon' => 'id']) }}"
                remove-route="{{ route('IconModule::api.remove', ['icon' => 'id']) }}"
                :items="items"
                csrf="{{ csrf_token() }}"
        >
        </index>
    </b-container>
@endsection

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ mix('vendor/css/MediaModule.css') }}">
@endsection

@section('javascripts')
    <script src="{{ mix("vendor/js/IconModule.js") }}"></script>
@endsection
