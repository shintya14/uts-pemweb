@extends('layouts.admin')
@section('content')
@can('fakultasdata_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.fakultasdatas.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.fakultasdata.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.fakultasdata.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Fakultasdata">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.fakultasdata.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.fakultasdata.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.fakultasdata.fields.dekan') }}
                        </th>
                        <th>
                            {{ trans('cruds.fakultasdata.fields.jumlahmahasiswa') }}
                        </th>
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fakultasdatas as $key => $fakultasdata)
                        <tr data-entry-id="{{ $fakultasdata->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $fakultasdata->id ?? '' }}
                            </td>
                            <td>
                                {{ $fakultasdata->name ?? '' }}
                            </td>
                            <td>
                                {{ $fakultasdata->dekan ?? '' }}
                            </td>
                            <td>
                                {{ $fakultasdata->jumlahmahasiswa ?? '' }}
                            </td>
                            <td>
                                @can('fakultasdata_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.fakultasdatas.show', $fakultasdata->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('fakultasdata_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.fakultasdatas.edit', $fakultasdata->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('fakultasdata_delete')
                                    <form action="{{ route('admin.fakultasdatas.destroy', $fakultasdata->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('fakultasdata_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.fakultasdatas.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Fakultasdata:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection