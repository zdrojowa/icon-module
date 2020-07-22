@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header clearfix">
                        <h4 class="card-title float-left">Lista wszystkich ikonek</h4>
                        <a href="{{ route('IconModule::create') }}" class="btn btn-success float-right mr-2">
                            <i class="mdi mdi-plus-circle"></i> Dodaj
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascripts')
    @parent

    <script>
        $('.table').zdrojowaTable({
            ajax: {
                url: "{{route('IconModule::ajax')}}",
                method: "POST",
                data: {
                    "_token": "{{csrf_token()}}"
                },
            },
            headers: [
                {
                    name: 'Nazwa',
                    type: 'text',
                    ajax: 'name',
                    orderable: true,
                },
                {
                    name: 'Data utworzenia',
                    orderable: true,
                    ajax: 'created_at'
                },
                {
                    name: 'Akcje',
                    ajax: 'key',
                    type: 'actions',
                    buttons: [
                    @permission('IconModule.edit')
                        {
                            color: 'primary',
                            icon: 'mdi mdi-pencil',
                            class: 'remove',
                            url: "{{route('IconModule::edit', ['icon' => '%%id%%'])}}"
                        },
                    @endpermission
                    @permission('IconModule.delete')
                        {
                            color: 'danger',
                            icon: 'mdi mdi-delete',
                            class: 'ZdrojowaTable--remove-action',
                            url: "{{route('IconModule::destroy', ['icon' => '%%id%%'])}}"
                        },
                    @endpermission
                    ]
                }
            ]
        });
    </script>
@endsection
