@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.acount.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.acounts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.acount.fields.id') }}
                        </th>
                        <td>
                            {{ $acount->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.acount.fields.name') }}
                        </th>
                        <td>
                            {{ $acount->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.acount.fields.description') }}
                        </th>
                        <td>
                            {{ $acount->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.acount.fields.balance') }}
                        </th>
                        <td>
                            {{ $acount->balance }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.acount.fields.premissions') }}
                        </th>
                        <td>
                            @foreach($acount->premissions as $key => $premissions)
                                <span class="label label-info">{{ $premissions->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.acounts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection