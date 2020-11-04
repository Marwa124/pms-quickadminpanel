@extends('layouts.admin')
@section('content')
@inject('users', 'App\Models\User')
@inject('departmentModel', 'Modules\HR\Entities\Department')
<div class="box" bis_skin_checked="1">
    <div class="box-header with-border d-flex justify-content-center" bis_skin_checked="1">
        <h3 class="box-title">Departments</h3>

    </div>
    <div class="box-body" bis_skin_checked="1">
        <div class="col-md-12" bis_skin_checked="1">
            <form action="http://127.0.0.1:8000/admin/hr/daily-attendances" method="get">
                @csrf
                <div class="form-group m-auto d-flex justify-content-center" bis_skin_checked="1">
                    <div class="col-sm-offset-3 col-sm-6" bis_skin_checked="1">
                        <div class="input-group margin" bis_skin_checked="1">
                            {{-- <div class="nav-link" bis_skin_checked="1"><i class="fa fa-calendar"></i></div> --}}
                            <select class="form-control select2 {{ $errors->has('department_head') ? 'is-invalid' : '' }}" name="department" id="department">
                                <option selected disabled>Choose a department</option>
                                @foreach($departmentModel::pluck('department_name', 'id') as $id => $value)
                                {{-- {{dd($departments::pluck('department_name', 'id'))}} --}}
                                    <option value="{{ $id }}" {{ old('department') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            {{-- <input class="form-control" type="text" name="department" value="2020-11-04" required=""> --}}
                            <span class="input-group-btn">
                              <button id="submit-date" type="submit" class="btn btn-info btn-flat"><i class="icon fa fa-arrow-right"></i>Go </button>
                          </span>
                      </div>
                    </div>
                </div>
          </form>
      </div>
      <!-- /. end col -->
  </div>
  <!-- /.box-body -->
  <div class="box-footer clearfix" bis_skin_checked="1">

  </div>
  <!-- /.box-footer -->
</div>


@can('department_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('hr.admin.departments.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.department.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="d-flex justify-content-center bg-warning department_head"></div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.department.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Department">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.department.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.department.fields.department_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.department.fields.department_head') }}
                        </th>
                        <th>
                            {{ trans('cruds.department.fields.unread_email') }}
                        </th>
                        {{-- <th>
                            &nbsp;
                        </th> --}}
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($users::all() as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        {{-- <td>
                        </td> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $key => $department)
                        <tr data-entry-id="{{ $department->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $department->id ?? '' }}
                            </td>
                            <td>
                                {{ $department->department_name ?? '' }}
                            </td>
                            <td>
                                {{ $department->department_head->name ?? '' }}
                            </td>
                            <td>
                                {{ $department->unread_email ?? '' }}
                            </td>
                            {{-- <td>
                                @can('department_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('hr.admin.departments.show', $department->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('department_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('hr.admin.departments.edit', $department->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('department_delete')
                                    <form action="{{ route('hr.admin.departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td> --}}

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
@can('department_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('hr.admin.departments.massDestroy') }}",
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
  let table = $('.datatable-Department:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  $('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value
      table
        .column($(this).parent().index())
        .search(value, strict)
        .draw()
  });
})

</script>
<script>
    $("#department").change(function() {
        var departmentId = $('#department').val();
        // console.log($('#department').val());
        $.ajax({
            url: '{{route('hr.admin.departments.index')}}',
            type: 'get',
            dataType:'html',
            data: {
                department_id: departmentId,
            },
            success: function(e){
                console.log(e);
                $(".department_head").html(e);
            }
        });
    })
</script>
@endsection