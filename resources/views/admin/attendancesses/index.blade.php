@extends('layouts.admin')
@section('content')
@can('attendancess_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.attendancesses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.attendancess.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.attendancess.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Attendancess">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.attendancess.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendancess.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendancess.fields.leave_application') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendancess.fields.date_in') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendancess.fields.date_out') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendancess.fields.attendance_status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendancesses as $key => $attendancess)
                        <tr data-entry-id="{{ $attendancess->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $attendancess->id ?? '' }}
                            </td>
                            <td>
                                {{ $attendancess->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $attendancess->leave_application->leave_type ?? '' }}
                            </td>
                            <td>
                                {{ $attendancess->date_in ?? '' }}
                            </td>
                            <td>
                                {{ $attendancess->date_out ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Attendancess::ATTENDANCE_STATUS_SELECT[$attendancess->attendance_status] ?? '' }}
                            </td>
                            <td>
                                @can('attendancess_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.attendancesses.show', $attendancess->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('attendancess_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.attendancesses.edit', $attendancess->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('attendancess_delete')
                                    <form action="{{ route('admin.attendancesses.destroy', $attendancess->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('attendancess_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.attendancesses.massDestroy') }}",
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
    pageLength: 25,
  });
  let table = $('.datatable-Attendancess:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection