@can('department_show')
    <a class="btn btn-xs btn-primary" href="{{ route('hr.admin.departments.show', $department) }}">
        {{ trans('global.view') }}
    </a>
@endcan

@can('department_edit')
    <a class="btn btn-xs btn-info" href="{{ route('hr.admin.departments.edit', $department) }}">
        {{ trans('global.edit') }}
    </a>
@endcan

@can('department_delete')
    <form action="{{ route('hr.admin.departments.destroy', $department) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan





<div class="card">
    <div class="card-header">
        {{ trans('cruds.department.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="display responsive nowrap table table-bordered table-striped table-hover datatable datatable-Department"  style="width:100%">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        {{-- <th>
                            {{ trans('cruds.department.fields.id') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.department.fields.designation_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.department.fields.user_name') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.department.fields.unread_email') }}
                        </th> --}}
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="form_body_result">







@if ($department_head)
<?php $department_head_name = $result->department_head->accountDetail()->select('fullname')->first()->fullname; ?>
    <tr class="bg-info">
        <td align="left" colspan="1">Department Head</td>
        <td align="center" colspan="3">{{$department_head_name}}</td>
    </tr>
{{-- <div class="d-flex justify-content-center bg-warning department_head">{{$department_head_name}}</div> --}}
@else
<tr class="bg-link">
    <td align="left" colspan="1"></td>
    <td align="center" colspan="3" style="color:black;">No Data Found</td>
</tr>
@endif


@inject('accountDetails', 'App\Models\AccountDetail')
<?php

    $designationId = [];
    $designationName = [];
    // $departmentObject = Modules\HR\Entities\Department::where('id', $department)->first();
    if ($result) {
        foreach ($result->departmentDesignations()->get() as $key => $designation) {
        $designationId[] = $designation->id;
        // $designationName[] = $designation->departmentDesignations()->first()->designation_name;
        } // Designations array


        // dd($designationName);
        foreach ($accountDetails::all() as $key => $account) {
        $userDepart = $account->designation()->whereIn('id', $designationId)->get();
        //    if ($userDepart) {
        //         dd($account->fullname);
        //     }
        } // All Users

    }

?>

@foreach($accountDetails::all() as $key => $account)
    <?php $userDepart = $account->designation()->whereIn('id', $designationId)->first(); ?>
    <?php $acountUser = $account->user()->first(); ?>
    @if ($userDepart)

    <tr data-entry-id="{{ $acountUser->id }}">
        <td>

        </td>
        <td>
            {{ $userDepart->designation_name ?? '' }}
        </td>
        <td>
            {{ $account->fullname ?? '' }}
        </td>
        <td>
            @can('department_show')
<<<<<<< HEAD
                <a class="btn btn-xs btn-primary" href="{{ route('hr.admin.employees.show', $account->id) }}">
=======
                <a class="btn btn-xs btn-primary" href="{{ route('hr.admin.employees.show', $acountUser->id) }}">
>>>>>>> aaee768b5391726781f68147c58efa439678af21
                    {{ trans('global.view') }}
                </a>
            @endcan

            @can('department_edit')
<<<<<<< HEAD
                <a class="btn btn-xs btn-info" href="{{ route('hr.admin.employees.edit', $account->id) }}">
=======
                <a class="btn btn-xs btn-info" href="{{ route('hr.admin.employees.edit', $acountUser->id) }}">
>>>>>>> aaee768b5391726781f68147c58efa439678af21
                    {{ trans('global.edit') }}
                </a>
            @endcan

            @can('department_delete')
<<<<<<< HEAD
                <form action="{{ route('hr.admin.employees.destroy', $account->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
=======
                <form action="{{ route('hr.admin.employees.destroy', $acountUser->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
>>>>>>> aaee768b5391726781f68147c58efa439678af21
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                </form>
            @endcan

        </td>

    </tr>

    @endif

@endforeach









</tbody>

</table>
</div>
</div>
</div>
