@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.monthlyAttendance.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-MonthlyAttendance">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.total_attendance_days') }}
                        </th>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.total_hours') }}
                        </th>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.total_absence') }}
                        </th>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.total_vacation') }}
                        </th>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.holidays') }}
                        </th>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.created_month') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyAttendances as $key => $monthlyAttendance)
                        <tr data-entry-id="{{ $monthlyAttendance->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $monthlyAttendance->id ?? '' }}
                            </td>
                            <td>
                                {{ $monthlyAttendance->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $monthlyAttendance->total_attendance_days ?? '' }}
                            </td>
                            <td>
                                {{ $monthlyAttendance->total_hours ?? '' }}
                            </td>
                            <td>
                                {{ $monthlyAttendance->total_absence ?? '' }}
                            </td>
                            <td>
                                {{ $monthlyAttendance->total_vacation ?? '' }}
                            </td>
                            <td>
                                {{ $monthlyAttendance->holidays ?? '' }}
                            </td>
                            <td>
                                {{ $monthlyAttendance->created_month ?? '' }}
                            </td>
                            <td>
                                @can('monthly_attendance_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('hr.admin.monthly-attendances.show', $monthlyAttendance->id) }}">
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
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-MonthlyAttendance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection