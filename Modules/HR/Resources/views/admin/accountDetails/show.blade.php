@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.accountDetail.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.account-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.id') }}
                        </th>
                        <td>
                            {{ $accountDetail->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.user') }}
                        </th>
                        <td>
                            {{ $accountDetail->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.fullname') }}
                        </th>
                        <td>
                            {{ $accountDetail->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.company') }}
                        </th>
                        <td>
                            {{ $accountDetail->company }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.city') }}
                        </th>
                        <td>
                            {{ $accountDetail->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.country') }}
                        </th>
                        <td>
                            {{ $accountDetail->country }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.locale') }}
                        </th>
                        <td>
                            {{ $accountDetail->locale }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.address') }}
                        </th>
                        <td>
                            {{ $accountDetail->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.phone') }}
                        </th>
                        <td>
                            {{ $accountDetail->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.mobile') }}
                        </th>
                        <td>
                            {{ $accountDetail->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.skype') }}
                        </th>
                        <td>
                            {{ $accountDetail->skype }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.language') }}
                        </th>
                        <td>
                            {{ $accountDetail->language }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.designation') }}
                        </th>
                        <td>
                            {{ $accountDetail->designation->designation_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.avatar') }}
                        </th>
                        <td>
                            @if($accountDetail->avatar)
                                <a href="{{ $accountDetail->avatar->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $accountDetail->avatar->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.joining_date') }}
                        </th>
                        <td>
                            {{ $accountDetail->joining_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.present_address') }}
                        </th>
                        <td>
                            {{ $accountDetail->present_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.date_of_birth') }}
                        </th>
                        <td>
                            {{ $accountDetail->date_of_birth }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Models\AccountDetail::GENDER_RADIO[$accountDetail->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.marital_status') }}
                        </th>
                        <td>
                            {{ App\Models\AccountDetail::MARITAL_STATUS_SELECT[$accountDetail->marital_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.father_name') }}
                        </th>
                        <td>
                            {{ $accountDetail->father_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.mother_name') }}
                        </th>
                        <td>
                            {{ $accountDetail->mother_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.passport') }}
                        </th>
                        <td>
                            {{ $accountDetail->passport }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.accountDetail.fields.direction') }}
                        </th>
                        <td>
                            {{ App\Models\AccountDetail::DIRECTION_RADIO[$accountDetail->direction] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.account-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection