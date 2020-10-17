@extends('layouts.admin')
@section('content')
@can('leave_application_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('hr.admin.leave-applications.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.leaveApplication.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.leaveApplication.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-LeaveApplication">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.leaveApplication.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaveApplication.fields.user_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaveApplication.fields.leave_category') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaveApplication.fields.leave_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaveApplication.fields.hours') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaveApplication.fields.application_status') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaveApplication.fields.leave_start_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaveApplication.fields.leave_end_date') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('leave_application_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('hr.admin.leave-applications.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('hr.admin.leave-applications.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'user_name', name: 'user_name' },
{ data: 'leave_category_name', name: 'leave_category.name' },
{ data: 'leave_type', name: 'leave_type' },
{ data: 'hours', name: 'hours' },
{ data: 'application_status', name: 'application_status' },
{ data: 'leave_start_date', name: 'leave_start_date' },
{ data: 'leave_end_date', name: 'leave_end_date' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    createdRow: (row, data, dataIndex, cells) => {
        $(cells[6]).css('background-color', data.status_color)
    },
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-LeaveApplication').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
