@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.dailyAttendance.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-DailyAttendance">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.dailyAttendance.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.dailyAttendance.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.dailyAttendance.fields.clock_in') }}
                        </th>
                        <th>
                            {{ trans('cruds.dailyAttendance.fields.clock_out') }}
                        </th>
                        <th>
                            {{ trans('cruds.dailyAttendance.fields.absent') }}
                        </th>
                        <th>
                            {{ trans('cruds.dailyAttendance.fields.vacation') }}
                        </th>
                        <th>
                            {{ trans('cruds.dailyAttendance.fields.holiday') }}
                        </th>
                        <th>
                            {{ trans('cruds.dailyAttendance.fields.created_day') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailyAttendances as $key => $dailyAttendance)
                        <tr data-entry-id="{{ $dailyAttendance->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $dailyAttendance->id ?? '' }}
                            </td>
                            <td>
                                {{ $dailyAttendance->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $dailyAttendance->clock_in ?? '' }}
                            </td>
                            <td>
                                {{ $dailyAttendance->clock_out ?? '' }}
                            </td>
                            <td>
                                {{ $dailyAttendance->absent ?? '' }}
                            </td>
                            <td>
                                {{ $dailyAttendance->vacation ?? '' }}
                            </td>
                            <td>
                                {{ $dailyAttendance->holiday ?? '' }}
                            </td>
                            <td>
                                {{ $dailyAttendance->created_day ?? '' }}
                            </td>
                            <td>
                                @can('daily_attendance_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('hr.admin.daily-attendances.show', $dailyAttendance->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
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
// @can('daily_attendance_delete')
//   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
//   let deleteButton = {
//     text: deleteButtonTrans,
//     url: "{{ route('hr.admin.daily-attendances.massDestroy') }}",
//     className: 'btn-danger',
//     action: function (e, dt, node, config) {
//       var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
//           return $(entry).data('entry-id')
//       });

//       if (ids.length === 0) {
//         alert('{{ trans('global.datatables.zero_selected') }}')

//         return
//       }

//       if (confirm('{{ trans('global.areYouSure') }}')) {
//         $.ajax({
//           headers: {'x-csrf-token': _token},
//           method: 'POST',
//           url: config.url,
//           data: { ids: ids, _method: 'DELETE' }})
//           .done(function () { location.reload() })
//       }
//     }
//   }
//   dtButtons.push(deleteButton)
// @endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-DailyAttendance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection