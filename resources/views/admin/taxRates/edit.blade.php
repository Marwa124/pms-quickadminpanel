@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.taxRate.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.tax-rates.update", [$taxRate->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.taxRate.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $taxRate->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.taxRate.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="rate_percent">{{ trans('cruds.taxRate.fields.rate_percent') }}</label>
                <input class="form-control {{ $errors->has('rate_percent') ? 'is-invalid' : '' }}" type="number" name="rate_percent" id="rate_percent" value="{{ old('rate_percent', $taxRate->rate_percent) }}" step="0.01" required>
                @if($errors->has('rate_percent'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rate_percent') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.taxRate.fields.rate_percent_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="premissions">{{ trans('cruds.taxRate.fields.premissions') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('premissions') ? 'is-invalid' : '' }}" name="premissions[]" id="premissions" multiple>
                    @foreach($premissions as $id => $premissions)
                        <option value="{{ $id }}" {{ (in_array($id, old('premissions', [])) || $taxRate->premissions->contains($id)) ? 'selected' : '' }}>{{ $premissions }}</option>
                    @endforeach
                </select>
                @if($errors->has('premissions'))
                    <div class="invalid-feedback">
                        {{ $errors->first('premissions') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.taxRate.fields.premissions_helper') }}</span>
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