@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.vacation.title_singular') }} {{ trans('global.list') }}
    </div>
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
    <div class="card-body">
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
        //     var_dump($dailyAttendance->user->userAccountDetail);

                    ?>
                        <tr data-entry-id="{{ $dailyAttendance->id }}">
                            <td>
                                {{ $dailyAttendance->id ?? '' }}
                            </td>
                            <td>
                                {{-- {{ $dailyAttendance->user()->userAccountDetail->fullname ?? '' }} --}}
                                {{ $dailyAttendance->user->name ?? '' }}
                            </td>
                            <td>
                                {{-- {{ $dailyAttendance->clock_in ?? '' }} --}}
                                {{ $dailyAttendance->date ?? '' }}
                            </td>
                            <td>
                                {{-- {{ $dailyAttendance->clock_out ?? '' }} --}}
                                {{ $dailyAttendance->time ?? '' }}
                            </td>
                            <td>
                                @can('daily_attendance_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('hr.admin.daily-attendances.show', $dailyAttendance->id) }}">
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
            paging:true,
        });
        let table = $('.datatable-DailyAttendance:not(.ajaxTable)').DataTable({ buttons: dtButtons, })
        
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    })

</script>
@endsection
