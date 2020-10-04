@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.dailyAttendance.title_singular') }} {{ trans('global.list') }}
    </div>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Manage Attendance') }} </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <!-- Notification Box -->
                <div class="col-md-12">
                    @if (!empty(Session::get('message')))
                    <div class="alert alert-success alert-dismissible" id="notification_box">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i> {{ Session::get('message') }}
                    </div>
                    @elseif (!empty(Session::get('exception')))
                    <div class="alert alert-warning alert-dismissible" id="notification_box">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-warning"></i> {{ Session::get('exception') }}
                    </div>
                    @endif
                </div>
                <!-- /.Notification Box -->
                <div class="col-md-12">
                    {{-- <form action="{{ route('hr.admin.daily-attendances.index') }}" method="get"> --}}
                        {{-- {{ csrf_field() }} --}}
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <div class="input-group margin">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input class="form-control date" type="text" name="date" id="datepicker" required>
                                    <span class="input-group-btn">
                                      <button id="submit-date" type="submit" class="btn btn-info btn-flat"
                                      data-token="{{csrf_token()}}"
                                      data-route="{{route('hr.admin.daily-attendances.index')}}"
                                      ><i class="icon fa fa-arrow-right"></i>{{ __('Go') }} </button>
                                  </span>
                              </div>
                            </div>
                        {{-- </div> --}}
                  {{-- </form> --}}
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

    <div class="card-body" id="table-daily-attendance">
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
            </table>
        </div>
    </div>
</div>



@endsection

@section('scripts')
@parent
<script>
    $(function () {

        // $("#table-daily-attendance").css('display', 'none');
        $("#submit-date").on('click', function(e){
            // $("#table-daily-attendance").css('display', 'block');

                let dtOverrideGlobals = {
                    processing: true,
                    serverSide: true,
                    retrieve: true,
                    aaSorting: [],
                    ajax: "{{ route('hr.admin.daily-attendances.index') }}",
                    columns: [
                        { data: 'placeholder', name: 'placeholder' },
                        { data: 'id', name: 'id' },
                        // { data: 'leave_category_name', name: 'leave_category.name' },
                        { data: 'date', name: 'date' },
                        { data: 'time', name: 'time' },
                        // { data: 'leave_start_date', name: 'leave_start_date' },
                        // { data: 'leave_end_date', name: 'leave_end_date' },
                        { data: 'actions', name: '{{ trans('global.actions') }}' }
                    ],
                    orderCellsTop: true,
                    order: [[ 1, 'desc' ]],
                    pageLength: 25,
                };
                let table = $('.datatable-DailyAttendance').DataTable(dtOverrideGlobals);
                $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                    $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust();
                });

        });


});

</script>
@endsection
