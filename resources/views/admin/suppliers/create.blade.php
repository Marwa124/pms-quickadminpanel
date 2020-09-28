@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.supplier.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.suppliers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.supplier.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.supplier.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mobile">{{ trans('cruds.supplier.fields.mobile') }}</label>
                <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', '') }}">
                @if($errors->has('mobile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mobile') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.supplier.fields.mobile_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.supplier.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.supplier.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.supplier.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', '') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.supplier.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.supplier.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.supplier.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="customer_group_id">{{ trans('cruds.supplier.fields.customer_group') }}</label>
                <select class="form-control select2 {{ $errors->has('customer_group') ? 'is-invalid' : '' }}" name="customer_group_id" id="customer_group_id" required>
                    @foreach($customer_groups as $id => $customer_group)
                        <option value="{{ $id }}" {{ old('customer_group_id') == $id ? 'selected' : '' }}>{{ $customer_group }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer_group'))
                    <div class="invalid-feedback">
                        {{ $errors->first('customer_group') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.supplier.fields.customer_group_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="premissions">{{ trans('cruds.supplier.fields.premissions') }}</label>
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
                <span class="help-block">{{ trans('cruds.supplier.fields.premissions_helper') }}</span>
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