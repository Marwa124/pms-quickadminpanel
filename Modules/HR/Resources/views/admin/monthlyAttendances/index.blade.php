@extends('layouts.admin')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.monthlyAttendance.title_singular') }} {{ trans('global.list') }}
    </div>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border d-flex justify-content-center">
                <h3 class="box-title">{{ __('Monthly Attendance') }} </h3>

            </div>
            <div class="box-body">
                <!-- /.Notification Box -->
                <div class="col-md-12">
                    <form action="{{ route('hr.admin.monthly-attendances.index') }}" method="get">
                        @csrf
                        <div class="form-group m-auto d-flex justify-content-center">
                            <div class="col-sm-offset-3 col-sm-6">
                                <div class="input-group margin">
                                    <div class="nav-link"><i class="fa fa-calendar"></i></div>
                                    {{-- <input class="form-control date" type="text" name="date" id="datepicker" value="{{$date}}" required> --}}
                                    
                                    <input type="text" class="form-control" name="date" id="datepicker" />

                                    <span class="input-group-btn">
                                      <button id="submit-date" type="submit" class="btn btn-info btn-flat"
                                      ><i class="icon fa fa-arrow-right"></i>{{ __('Go') }} </button>
                                  </span>
                              </div>
                            </div>
                        </div>
                  </form>
              </div>
              <!-- /. end col -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">

          </div>
          <!-- /.box-footer -->
      </div>
      <!-- /.box -->
  </section>
  <!-- /.content -->

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-MonthlyAttendance">
                <thead>
                    <tr>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyAttendances as $key => $monthlyAttendance)
                    <?php
        // echo "<pre>";
        //     var_dump($dailyAttendance);
        //     die();
        //     var_dump($dailyAttendance->user->userAccountDetail->fullname);
                    ?>
                        <tr data-entry-id="{{ $monthlyAttendance->id }}">
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
                        </tr>
                    @endforeach
                    <?php
            // die();

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $(function () {
        $("#datepicker").datepicker( {
            format: "yyyy-mm",
            startView: "months", 
            minViewMode: "months"
        });
        
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-MonthlyAttendance:not(.ajaxTable)').DataTable({ 
    "buttons": [
       { "extend": 'pdf', "text":'PDF',"className": 'btn btn-default' },
       { "extend": 'csv', "text":'CSV',"className": 'btn btn-default' },
       { "extend": 'copy', "text":'Copy',"className": 'btn btn-default' },
       { "extend": 'print', "text":'Print',"className": 'btn btn-default' },
       { "extend": 'excel', "text":'Excel',"className": 'btn btn-default' },
    ],
    'columnDefs': [
         {
            'targets': 0,
            'checkboxes': {
               'selectRow': false
            }
         }
      ],
   })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection