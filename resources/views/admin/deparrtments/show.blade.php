@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.deparrtment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.deparrtments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.deparrtment.fields.id') }}
                        </th>
                        <td>
                            {{ $deparrtment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deparrtment.fields.department_name') }}
                        </th>
                        <td>
                            {{ $deparrtment->department_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deparrtment.fields.department_head') }}
                        </th>
                        <td>
                            {{ $deparrtment->department_head->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deparrtment.fields.email') }}
                        </th>
                        <td>
                            {{ $deparrtment->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deparrtment.fields.encryption') }}
                        </th>
                        <td>
                            {{ $deparrtment->encryption }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deparrtment.fields.host') }}
                        </th>
                        <td>
                            {{ $deparrtment->host }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deparrtment.fields.username') }}
                        </th>
                        <td>
                            {{ $deparrtment->username }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deparrtment.fields.mailbox') }}
                        </th>
                        <td>
                            {{ $deparrtment->mailbox }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deparrtment.fields.unread_email') }}
                        </th>
                        <td>
                            {{ $deparrtment->unread_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deparrtment.fields.delete_email_after_import') }}
                        </th>
                        <td>
                            {{ $deparrtment->delete_email_after_import }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deparrtment.fields.last_postmaster_run') }}
                        </th>
                        <td>
                            {{ $deparrtment->last_postmaster_run }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.deparrtments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#department_designations" role="tab" data-toggle="tab">
                {{ trans('cruds.designation.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="department_designations">
            @includeIf('admin.deparrtments.relationships.departmentDesignations', ['designations' => $deparrtment->departmentDesignations])
        </div>
    </div>
</div>

@endsection