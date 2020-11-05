@extends('layouts.admin')
@section('content')
@inject('salaryTemplateModel', 'App\Models\SalaryTemplate')
@can('account_detail_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.account-details.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.accountDetail.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.accountDetail.title_singular') }} {{ trans('global.list') }}
    </div>
    {{-- <select data-column="0" class="form-control filter-select" name="filter-select" id="">
        <option value="active">Active Users</option>
        <option value="unactive">Unactive Users</option>
    </select> --}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="display responsive nowrap table table-bordered table-striped table-hover datatable datatable-AccountDetail" style="width:100%">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.accountDetail.fields.avatar') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.accountDetail.fields.id') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.accountDetail.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.accountDetail.fields.fullname') }}
                        </th>
                        <th>
                            {{ trans('cruds.accountDetail.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.accountDetail.fields.banned') }}
                        </th>
                        <th>
                            {{ trans('cruds.accountDetail.fields.joining_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.accountDetail.fields.designation') }}
                        </th>
                        <th>
                            {{ trans('cruds.accountDetail.fields.department') }}
                        </th>
                        <th>
                            {{ trans('cruds.accountDetail.fields.salary') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.accountDetail.fields.designation') }}
                        </th> --}}
                        {{-- <th>
                            {{ trans('cruds.accountDetail.fields.gender') }}
                        </th> --}}
                        <th>
                            &nbsp;
                        </th>
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
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            @inject('usersModel', 'App\Models\User')
                            <select class="search">
                                <option value="active">Active</option>
                                <option value="banned">Banned</option>
                            </select>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accountDetails as $key => $accountDetail)
                    @if ($accountDetail)

                        <tr data-entry-id="{{ $accountDetail->id }}">
                            <td>

                            </td>
                            <td>
                                @if($accountDetail->avatar)
                                    <a href="{{ $accountDetail->avatar->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $accountDetail->avatar->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            {{-- <td>
                                {{ $accountDetail->id ?? '' }}
                            </td> --}}
                            <td>
                                {{ $accountDetail->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $accountDetail->fullname ?? '' }}
                            </td>
                            <td>
                                {{ $accountDetail->user->email ?? '' }}
                            </td>
                            <td>
                                {{ ($accountDetail->user->banned == 0) ? 'Active' : 'Banned' }}
                            </td>
                            <td>
                                {{ $accountDetail->joining_date ?? '' }}
                            </td>
                            <td>
                                {{ $accountDetail->designation->designation_name ?? '' }}
                            </td>
                            <td>
                                {{-- {{dd($accountDetail->designation->department->department_name )}} --}}
                                {{ $accountDetail->designation->department->department_name ?? '' }}
                            </td>
                            <td>
                                <?php
                                    $designatonName = $accountDetail->designation;
                                    $salary = $designatonName ? $salaryTemplateModel::where('salary_grade', $designatonName->designation_name)->select('basic_salary')->first() : '';
                                ?>
                                {{-- {{dd($salaryTemplateModel::where('salary_grade', $designatonName)->select('basic_salary')->first()->basic_salary)}} --}}

                                {{  $salary ? 'EGY ' .number_format($salary->basic_salary, 0, ',', '.') : ''}}
                                {{-- {{ $salary ? $salary->basic_salary : '' }} --}}
                            </td>
                            {{-- <td>
                                {{ $accountDetail->designation->designation_name ?? '' }}
                            </td> --}}
                            {{-- <td>
                                {{ App\Models\AccountDetail::GENDER_RADIO[$accountDetail->gender] ?? '' }}
                            </td> --}}
                            <td>
                                @can('account_detail_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.account-details.show', $accountDetail->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('account_detail_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.account-details.edit', $accountDetail->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('account_detail_delete')
                                    <form action="{{ route('admin.account-details.destroy', $accountDetail->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endif

                    @endforeach
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <td>
                            <select data-column="0" class="form-control filter-select" name="" id="">
                                <option value="active">Active Users</option>
                                <option value="unactive">Unactive Users</option>
                            </select>
                        </td>
                    </tr>
                </tfoot> --}}
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
// @can('account_detail_delete')
//   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
//   let deleteButton = {
//     text: deleteButtonTrans,
//     url: "{{ route('admin.account-details.massDestroy') }}",
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
  let table = $('.datatable-AccountDetail:not(.ajaxTable)').DataTable({
        buttons: [dtButtons, 'colvis'],
    })

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

  $(".filter-select").change(function(){
console.log($(this).val());
    $.ajax({
        headers: {'x-csrf-token': _token},
        type: 'GET',
        url: "{{route('admin.account-details.index')}}",
        dataType: 'html',
        data: {
            selectFilter: $(this).val(),
        },
        success: function(data){
            // table.column( data )
            $('body').html(data)
            // console.log($('tbody').html(data));
        }
    })


    //   table.column( $(this).data('column') )
    //   .search($(this).val())
    //   .draw();
    //   console.log($(this).val());
    //   console.log($(this).data('column'));

  })

})

</script>
@endsection
