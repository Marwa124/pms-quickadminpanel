@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.employee.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("hr.admin.employees.update", [$employee->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="username">{{ trans('cruds.employee.fields.username') }}</label>
                <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username" id="username" value="{{ old('username', $employee->username) }}" required>
                @if($errors->has('username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.username_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="password">{{ trans('cruds.employee.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.employee.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $employee->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="role_id">{{ trans('cruds.employee.fields.role') }}</label>
                <select class="form-control select2 {{ $errors->has('role') ? 'is-invalid' : '' }}" name="role_id" id="role_id" required>
                    @foreach($roles as $id => $role)
                        <option value="{{ $id }}" {{ (old('role_id') ? old('role_id') : $employee->role->id ?? '') == $id ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
                @if($errors->has('role'))
                    <div class="invalid-feedback">
                        {{ $errors->first('role') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.role_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.employee.fields.activated') }}</label>
                @foreach(App\Models\Employee::ACTIVATED_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('activated') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="activated_{{ $key }}" name="activated" value="{{ $key }}" {{ old('activated', $employee->activated) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="activated_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('activated'))
                    <div class="invalid-feedback">
                        {{ $errors->first('activated') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.activated_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.employee.fields.banned') }}</label>
                @foreach(App\Models\Employee::BANNED_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('banned') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="banned_{{ $key }}" name="banned" value="{{ $key }}" {{ old('banned', $employee->banned) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="banned_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('banned'))
                    <div class="invalid-feedback">
                        {{ $errors->first('banned') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.banned_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ban_reason">{{ trans('cruds.employee.fields.ban_reason') }}</label>
                <textarea class="form-control {{ $errors->has('ban_reason') ? 'is-invalid' : '' }}" name="ban_reason" id="ban_reason">{{ old('ban_reason', $employee->ban_reason) }}</textarea>
                @if($errors->has('ban_reason'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ban_reason') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.ban_reason_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="new_password_key">{{ trans('cruds.employee.fields.new_password_key') }}</label>
                <input class="form-control {{ $errors->has('new_password_key') ? 'is-invalid' : '' }}" type="text" name="new_password_key" id="new_password_key" value="{{ old('new_password_key', $employee->new_password_key) }}">
                @if($errors->has('new_password_key'))
                    <div class="invalid-feedback">
                        {{ $errors->first('new_password_key') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.new_password_key_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="new_password_requested">{{ trans('cruds.employee.fields.new_password_requested') }}</label>
                <input class="form-control {{ $errors->has('new_password_requested') ? 'is-invalid' : '' }}" type="text" name="new_password_requested" id="new_password_requested" value="{{ old('new_password_requested', $employee->new_password_requested) }}">
                @if($errors->has('new_password_requested'))
                    <div class="invalid-feedback">
                        {{ $errors->first('new_password_requested') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.new_password_requested_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="new_email">{{ trans('cruds.employee.fields.new_email') }}</label>
                <input class="form-control {{ $errors->has('new_email') ? 'is-invalid' : '' }}" type="text" name="new_email" id="new_email" value="{{ old('new_email', $employee->new_email) }}">
                @if($errors->has('new_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('new_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.new_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.employee.fields.online_time') }}</label>
                @foreach(App\Models\Employee::ONLINE_TIME_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('online_time') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="online_time_{{ $key }}" name="online_time" value="{{ $key }}" {{ old('online_time', $employee->online_time) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="online_time_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('online_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('online_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.online_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="permissions">{{ trans('cruds.employee.fields.permissions') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}" name="permissions[]" id="permissions" multiple>
                    @foreach($permissions as $id => $permissions)
                        <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || $employee->permissions->contains($id)) ? 'selected' : '' }}>{{ $permissions }}</option>
                    @endforeach
                </select>
                @if($errors->has('permissions'))
                    <div class="invalid-feedback">
                        {{ $errors->first('permissions') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.permissions_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="active_email">{{ trans('cruds.employee.fields.active_email') }}</label>
                <input class="form-control {{ $errors->has('active_email') ? 'is-invalid' : '' }}" type="email" name="active_email" id="active_email" value="{{ old('active_email', $employee->active_email) }}">
                @if($errors->has('active_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('active_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.active_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_email_type">{{ trans('cruds.employee.fields.smtp_email_type') }}</label>
                <input class="form-control {{ $errors->has('smtp_email_type') ? 'is-invalid' : '' }}" type="text" name="smtp_email_type" id="smtp_email_type" value="{{ old('smtp_email_type', $employee->smtp_email_type) }}">
                @if($errors->has('smtp_email_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_email_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.smtp_email_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_action">{{ trans('cruds.employee.fields.smtp_action') }}</label>
                <input class="form-control {{ $errors->has('smtp_action') ? 'is-invalid' : '' }}" type="text" name="smtp_action" id="smtp_action" value="{{ old('smtp_action', $employee->smtp_action) }}">
                @if($errors->has('smtp_action'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_action') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.smtp_action_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_host_name">{{ trans('cruds.employee.fields.smtp_host_name') }}</label>
                <input class="form-control {{ $errors->has('smtp_host_name') ? 'is-invalid' : '' }}" type="text" name="smtp_host_name" id="smtp_host_name" value="{{ old('smtp_host_name', $employee->smtp_host_name) }}">
                @if($errors->has('smtp_host_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_host_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.smtp_host_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_user_name">{{ trans('cruds.employee.fields.smtp_user_name') }}</label>
                <input class="form-control {{ $errors->has('smtp_user_name') ? 'is-invalid' : '' }}" type="text" name="smtp_user_name" id="smtp_user_name" value="{{ old('smtp_user_name', $employee->smtp_user_name) }}">
                @if($errors->has('smtp_user_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_user_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.smtp_user_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_password">{{ trans('cruds.employee.fields.smtp_password') }}</label>
                <input class="form-control {{ $errors->has('smtp_password') ? 'is-invalid' : '' }}" type="password" name="smtp_password" id="smtp_password">
                @if($errors->has('smtp_password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.smtp_password_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_port">{{ trans('cruds.employee.fields.smtp_port') }}</label>
                <input class="form-control {{ $errors->has('smtp_port') ? 'is-invalid' : '' }}" type="text" name="smtp_port" id="smtp_port" value="{{ old('smtp_port', $employee->smtp_port) }}">
                @if($errors->has('smtp_port'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_port') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.smtp_port_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_additional_flag">{{ trans('cruds.employee.fields.smtp_additional_flag') }}</label>
                <input class="form-control {{ $errors->has('smtp_additional_flag') ? 'is-invalid' : '' }}" type="text" name="smtp_additional_flag" id="smtp_additional_flag" value="{{ old('smtp_additional_flag', $employee->smtp_additional_flag) }}">
                @if($errors->has('smtp_additional_flag'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_additional_flag') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.smtp_additional_flag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="last_postmaster_run">{{ trans('cruds.employee.fields.last_postmaster_run') }}</label>
                <input class="form-control {{ $errors->has('last_postmaster_run') ? 'is-invalid' : '' }}" type="text" name="last_postmaster_run" id="last_postmaster_run" value="{{ old('last_postmaster_run', $employee->last_postmaster_run) }}">
                @if($errors->has('last_postmaster_run'))
                    <div class="invalid-feedback">
                        {{ $errors->first('last_postmaster_run') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.last_postmaster_run_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="media_path_slug">{{ trans('cruds.employee.fields.media_path_slug') }}</label>
                <input class="form-control {{ $errors->has('media_path_slug') ? 'is-invalid' : '' }}" type="text" name="media_path_slug" id="media_path_slug" value="{{ old('media_path_slug', $employee->media_path_slug) }}">
                @if($errors->has('media_path_slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('media_path_slug') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.media_path_slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="marketing_username">{{ trans('cruds.employee.fields.marketing_username') }}</label>
                <input class="form-control {{ $errors->has('marketing_username') ? 'is-invalid' : '' }}" type="text" name="marketing_username" id="marketing_username" value="{{ old('marketing_username', $employee->marketing_username) }}">
                @if($errors->has('marketing_username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('marketing_username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.marketing_username_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="marketing_password">{{ trans('cruds.employee.fields.marketing_password') }}</label>
                <input class="form-control {{ $errors->has('marketing_password') ? 'is-invalid' : '' }}" type="password" name="marketing_password" id="marketing_password">
                @if($errors->has('marketing_password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('marketing_password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.marketing_password_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="marketing_type">{{ trans('cruds.employee.fields.marketing_type') }}</label>
                <input class="form-control {{ $errors->has('marketing_type') ? 'is-invalid' : '' }}" type="text" name="marketing_type" id="marketing_type" value="{{ old('marketing_type', $employee->marketing_type) }}">
                @if($errors->has('marketing_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('marketing_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.marketing_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sp_username">{{ trans('cruds.employee.fields.sp_username') }}</label>
                <input class="form-control {{ $errors->has('sp_username') ? 'is-invalid' : '' }}" type="text" name="sp_username" id="sp_username" value="{{ old('sp_username', $employee->sp_username) }}">
                @if($errors->has('sp_username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sp_username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.sp_username_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sp_password">{{ trans('cruds.employee.fields.sp_password') }}</label>
                <input class="form-control {{ $errors->has('sp_password') ? 'is-invalid' : '' }}" type="password" name="sp_password" id="sp_password">
                @if($errors->has('sp_password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sp_password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.sp_password_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_of_join">{{ trans('cruds.employee.fields.date_of_join') }}</label>
                <input class="form-control date {{ $errors->has('date_of_join') ? 'is-invalid' : '' }}" type="text" name="date_of_join" id="date_of_join" value="{{ old('date_of_join', $employee->date_of_join) }}">
                @if($errors->has('date_of_join'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_of_join') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.date_of_join_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_of_insurance">{{ trans('cruds.employee.fields.date_of_insurance') }}</label>
                <input class="form-control date {{ $errors->has('date_of_insurance') ? 'is-invalid' : '' }}" type="text" name="date_of_insurance" id="date_of_insurance" value="{{ old('date_of_insurance', $employee->date_of_insurance) }}">
                @if($errors->has('date_of_insurance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_of_insurance') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.date_of_insurance_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection