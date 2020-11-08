@extends('layouts.admin')
@section('content')
@can('job_application_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('hr.admin.job-applications.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.jobApplication.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.jobApplication.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-JobApplication">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.jobApplication.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobApplication.fields.job_circular') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobApplication.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobApplication.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobApplication.fields.mobile') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobApplication.fields.application_status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobApplications as $key => $jobApplication)
                        <tr data-entry-id="{{ $jobApplication->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $jobApplication->id ?? '' }}
                            </td>
                            <td>
                                {{ $jobApplication->job_circular->name ?? '' }}
                            </td>
                            <td>
                                {{ $jobApplication->name ?? '' }}
                            </td>
                            <td>
                                {{ $jobApplication->email ?? '' }}
                            </td>
                            <td>
                                {{ $jobApplication->mobile ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\JobApplication::APPLICATION_STATUS_SELECT[$jobApplication->application_status] ?? '' }}
                            </td>
                            <td>
                                @can('job_application_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('hr.admin.job-applications.show', $jobApplication->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('job_application_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('hr.admin.job-applications.edit', $jobApplication->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('job_application_delete')
                                    <form action="{{ route('hr.admin.job-applications.destroy', $jobApplication->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('job_application_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('hr.admin.job-applications.massDestroy') }}",
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
  let table = $('.datatable-JobApplication:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection