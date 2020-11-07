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
                            <label class="required" for="department_name">{{ trans('cruds.department.fields.department_name') }}</label>
                            <select class="form-control select2 {{ $errors->has('department_head') ? 'is-invalid' : '' }}" name="department" id="department">
                                <option selected disabled>Choose a department</option>
                                @foreach($departmentModel::pluck('department_name', 'id') as $id => $value)
                                {{-- {{dd($departments::pluck('department_name', 'id'))}} --}}
                                    <option value="{{ $id }}" {{ old('department') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
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

<div class="allResult"></div>





@endsection
@section('scripts')
@parent
<script>
    $(function () {
//   let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
// @can('department_delete')
//   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
//   let deleteButton = {
//     text: deleteButtonTrans,
//     url: "{{ route('hr.admin.departments.massDestroy') }}",
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

//   $.extend(true, $.fn.dataTable.defaults, {
//     orderCellsTop: true,
//     order: [[ 1, 'desc' ]],
//     pageLength: 25,
//   });
  let table = $('.datatable-Department:not(.ajaxTable)').DataTable({
    paging: false,
    "buttons": [],
  });
  table.buttons( '.csv').disable();
  table.buttons( '.excel').disable();
  table.buttons( '.pdf').disable();
  table.buttons( '.print').disable();
  table.buttons( '.copy').disable();

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
    $(".card").css('visibility', 'hidden');

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
                $(".card").css('visibility', 'visible');
                $('.allResult').html(e);
                console.log(e);
                // $('.form_body').append(e)
                // $('.form_body_result').html(e)

                // $(".department_head").html(e.department_head);
                // console.log(e.department_head);
            }
        });
    })
</script>
@endsection
