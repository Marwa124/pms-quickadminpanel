@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.attendancess.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.attendancesses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.attendancess.fields.id') }}
                        </th>
                        <td>
                            {{ $attendancess->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendancess.fields.user') }}
                        </th>
                        <td>
                            {{ $attendancess->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendancess.fields.leave_application') }}
                        </th>
                        <td>
                            {{ $attendancess->leave_application->leave_type ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendancess.fields.date_in') }}
                        </th>
                        <td>
                            {{ $attendancess->date_in }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendancess.fields.date_out') }}
                        </th>
                        <td>
                            {{ $attendancess->date_out }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendancess.fields.attendance_status') }}
                        </th>
                        <td>
                            {{ App\Models\Attendancess::ATTENDANCE_STATUS_SELECT[$attendancess->attendance_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendancess.fields.clocking_status') }}
                        </th>
                        <td>
                            {{ $attendancess->clocking_status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.attendancesses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection