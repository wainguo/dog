@extends ('backend.layouts.master')

@section ('title', trans('labels.backend.slider.management'))

@section('after-styles-end')
    {{ Html::style("css/backend/plugin/datatables/dataTables.bootstrap.min.css") }}
@stop

@section('page-header')
    <h1>{{ trans('labels.backend.slider.management') }}</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.slider.management') }}</h3>

            {{--<div class="box-tools pull-right">--}}
                {{--@include('backend.access.includes.partials.header-buttons')--}}
            {{--</div>--}}
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="sliders-table" class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.slider.table.title') }}</th>
                            <th>{{ trans('labels.backend.slider.table.url') }}</th>
                            <th>{{ trans('labels.backend.slider.table.cover') }}</th>
                            <th>{{ trans('labels.backend.slider.table.createtime') }}</th>
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
            $('#sliders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.slider.get") }}',
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'url', name: 'url'},
                    {data: 'cover', name: 'cover'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions'}
                ],
                "columnDefs": [ {
                    "targets": 2,
                    "data": 'cover',
                    "render": function ( data, type, full, meta ) {
                        return '<img src="'+data+'" style="width:120px;height:70px;"/>';
                    }
                } ],
                order: [[3, "asc"]],
                searchDelay: 500
            });
        });
    </script>
@stop