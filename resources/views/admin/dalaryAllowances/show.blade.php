@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.dalaryAllowance.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dalary-allowances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.dalaryAllowance.fields.id') }}
                        </th>
                        <td>
                            {{ $dalaryAllowance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dalaryAllowance.fields.name') }}
                        </th>
                        <td>
                            {{ $dalaryAllowance->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dalaryAllowance.fields.value') }}
                        </th>
                        <td>
                            {{ $dalaryAllowance->value }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dalaryAllowance.fields.salary_template') }}
                        </th>
                        <td>
                            {{ $dalaryAllowance->salary_template->salary_grade ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dalary-allowances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection