@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.acount.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.acounts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.acount.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.acount.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.acount.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}">
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.acount.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="balance">{{ trans('cruds.acount.fields.balance') }}</label>
                <input class="form-control {{ $errors->has('balance') ? 'is-invalid' : '' }}" type="text" name="balance" id="balance" value="{{ old('balance', '') }}">
                @if($errors->has('balance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('balance') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.acount.fields.balance_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="premissions">{{ trans('cruds.acount.fields.premissions') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('premissions') ? 'is-invalid' : '' }}" name="premissions[]" id="premissions" multiple>
                    @foreach($premissions as $id => $premissions)
                        <option value="{{ $id }}" {{ in_array($id, old('premissions', [])) ? 'selected' : '' }}>{{ $premissions }}</option>
                    @endforeach
                </select>
                @if($errors->has('premissions'))
                    <div class="invalid-feedback">
                        {{ $errors->first('premissions') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.acount.fields.premissions_helper') }}</span>
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