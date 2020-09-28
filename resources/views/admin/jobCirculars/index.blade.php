@extends('layouts.admin')
@section('content')
@can('job_circular_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.job-circulars.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.jobCircular.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.jobCircular.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-JobCircular">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.jobCircular.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobCircular.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobCircular.fields.designation') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobCircular.fields.posted_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobCircular.fields.employment_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobCircular.fields.experience') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobCircular.fields.last_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.jobCircular.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobCirculars as $key => $jobCircular)
                        <tr data-entry-id="{{ $jobCircular->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $jobCircular->id ?? '' }}
                            </td>
                            <td>
                                {{ $jobCircular->name ?? '' }}
                            </td>
                            <td>
                                {{ $jobCircular->designation->designation_name ?? '' }}
                            </td>
                            <td>
                                {{ $jobCircular->posted_date ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\JobCircular::EMPLOYMENT_TYPE_SELECT[$jobCircular->employment_type] ?? '' }}
                            </td>
                            <td>
                                {{ $jobCircular->experience ?? '' }}
                            </td>
                            <td>
                                {{ $jobCircular->last_date ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\JobCircular::STATUS_SELECT[$jobCircular->status] ?? '' }}
                            </td>
                            <td>
                                @can('job_circular_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.job-circulars.show', $jobCircular->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('job_circular_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.job-circulars.edit', $jobCircular->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('job_circular_delete')
                                    <form action="{{ route('admin.job-circulars.destroy', $jobCircular->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('job_circular_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.job-circulars.massDestroy') }}",
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
  let table = $('.datatable-JobCircular:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection