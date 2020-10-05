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

            </div>
            <div class="box-body">
                <!-- /.Notification Box -->
                <div class="col-md-12">
                    <form action="{{ route('hr.admin.daily-attendances.index') }}" method="get">
                        @csrf
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <div class="input-group margin">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input class="form-control date" type="text" name="date" id="datepicker" value="{{ $date }}" required>
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

    <div class="card-body" id="table-daily-attendance">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-DailyAttendance">
                <thead>
                    <tr>
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
                    @foreach($fingerprintAttendances as $key => $dailyAttendance)
                    <?php
        // echo "<pre>";
        //     var_dump($dailyAttendance);
        //     die();
        //     var_dump($dailyAttendance->user->userAccountDetail->fullname);
                    ?>
                    @if ($dailyAttendance != null)
                    <tr data-entry-id="{{ $dailyAttendance['id'] }}">
                        <td>
                            {{ $dailyAttendance['id'] ?? '' }}
                        </td>
                        <td>
                            {{ $dailyAttendance['name'] ?? '' }}
                        </td>
                        <td>
                            {{-- {{ $dailyAttendance->clock_in ?? '' }} --}}
                            {{ $dailyAttendance['clock_in'] ?? '' }}
                        </td>
                        <td>
                            {{-- {{ $dailyAttendance->clock_out ?? '' }} --}}
                            {{ $dailyAttendance['clock_out'] ?? '' }}
                        </td>
                        <td>
                            {{-- {{ $dailyAttendance->clock_out ?? '' }} --}}
                            {{-- {{ $dailyAttendance->time ?? '' }} --}}
                        </td>
                    </tr>
                    @endif
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
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

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
