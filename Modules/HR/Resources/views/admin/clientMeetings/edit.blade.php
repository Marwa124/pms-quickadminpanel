@extends('layouts.admin')
@section('content')

@inject('clientMeetingModel', 'Modules\HR\Entities\clientMeeting');

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.clientMeeting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("hr.admin.client-meetings.update", [$clientMeeting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.clientMeeting.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $clientMeeting->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.clientMeeting.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.clientMeeting.fields.day_hour') }}</label>
                <select class="form-control {{ $errors->has('day_hour') ? 'is-invalid' : '' }}" name="day_hour" id="day_hour" required>
                    <option value disabled {{ old('day_hour',  $clientMeeting->day_hour) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($clientMeetingModel::MEETING_STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('day_hour', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('day_hour'))
                    <div class="invalid-feedback">
                        {{ $errors->first('day_hour') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.clientMeeting.fields.day_hour_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="from_time">{{ trans('cruds.clientMeeting.fields.from_time') }}</label>
                <input class="form-control {{ $errors->has('from_time') ? 'is-invalid' : '' }}" type="time" name="from_time" id="from_time" value="{{ old('from_time',  $clientMeeting->from_time   ) }}">
                @if($errors->has('from_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('from_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.clientMeeting.fields.from_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="to_time">{{ trans('cruds.clientMeeting.fields.to_time') }}</label>
                <input class="form-control {{ $errors->has('to_time') ? 'is-invalid' : '' }}" type="time" name="to_time" id="to_time" value="{{ old('to_time', $clientMeeting->to_time) }}">
                @if($errors->has('to_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('to_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.clientMeeting.fields.to_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.clientMeeting.fields.status') }}</label>
                @foreach($clientMeetingModel::APPROVE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', $clientMeeting->status) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.clientMeeting.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comments">{{ trans('cruds.clientMeeting.fields.comments') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{!! old('comments', $clientMeeting->comments) !!}</textarea>
                @if($errors->has('comments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.clientMeeting.fields.comments_helper') }}</span>
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