@extends ('backend.layouts.master')

@section ('title', trans('labels.backend.article.management'))

@section('after-styles-end')
    {{ Html::style("css/backend/plugin/datatables/dataTables.bootstrap.min.css") }}
@stop

@section('page-header')
    <h1>{{ trans('labels.backend.article.management') }}</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.article.management') }}</h3>
            <div class="box-tools pull-right">
                {{ link_to_route('admin.article.create', trans('labels.backend.article.create'), [], ['class' => 'btn btn-primary btn-xs']) }}
            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table id="articles-table" class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.article.table.title') }}</th>
                            <th>{{ trans('labels.backend.article.table.subtitle') }}</th>
                            <th>{{ trans('labels.backend.article.table.url') }}</th>
                            <th>{{ trans('labels.backend.article.table.cover') }}</th>
                            <th>{{ trans('labels.backend.article.table.status') }}</th>
                            <th>{{ trans('labels.backend.article.table.user_name') }}</th>
                            <th>{{ trans('labels.backend.article.table.createtime') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@stop

@section('after-scripts-end')
    {{ Html::script("js/backend/plugin/datatables/jquery.dataTables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables.bootstrap.min.js") }}

    <script>
        $(function() {
            $('#articles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.article.get") }}',
                columns: [
                    {data: 'title', name: 'title', width: '25%'},
                    {data: 'subtitle', name: 'subtitle', width: '15%'},
                    {data: 'url', name: 'url', width: '20%'},
                    {data: 'cover', name: 'cover'},
                    {data: 'status', name: 'status'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions'}
                ],
                "columnDefs": [ {
                    "targets": 3,
                    "data": 'cover',
                    "render": function ( data, type, full, meta ) {
                        return '<img src="'+data+'" style="width:50px;height:50px;"/>';
                    }
                } ],
                order: [[3, "asc"]],
                searchDelay: 500
            });
        });
    </script>
@stop