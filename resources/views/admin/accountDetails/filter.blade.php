@inject('salaryTemplateModel', 'App\Models\SalaryTemplate')

@foreach($accountDetails as $key => $accountDetail)
<tr data-entry-id="{{ $accountDetail->id }}">
    <td>

    </td>
    <td>
        @if($accountDetail->avatar)
            <a href="{{ $accountDetail->avatar->getUrl() }}" target="_blank" style="display: inline-block">
                <img src="{{ $accountDetail->avatar->getUrl('thumb') }}">
            </a>
        @endif
    </td>
    {{-- <td>
        {{ $accountDetail->id ?? '' }}
    </td> --}}
    <td>
        {{ $accountDetail->user->name ?? '' }}
    </td>
    <td>
        {{ $accountDetail->fullname ?? '' }}
    </td>
    <td>
        {{ $accountDetail->user->email ?? '' }}
    </td>
    <td>
        {{ $accountDetail->joining_date ?? '' }}
    </td>
    <td>
        {{ $accountDetail->designation->designation_name ?? '' }}
    </td>
    <td>
        {{ $accountDetail->designation->department->department_name ?? '' }}
    </td>
    <td>
        <?php
            $designatonName = $accountDetail->designation;
            $salary = $designatonName ? $salaryTemplateModel::where('salary_grade', $designatonName->designation_name)->select('basic_salary')->first() : '';
        ?>
        {{ $salary ? $salary->basic_salary : '' }}
    </td>
    <td>
        @can('account_detail_show')
            <a class="btn btn-xs btn-primary" href="{{ route('admin.account-details.show', $accountDetail->id) }}">
                {{ trans('global.view') }}
            </a>
        @endcan

        @can('account_detail_edit')
            <a class="btn btn-xs btn-info" href="{{ route('admin.account-details.edit', $accountDetail->id) }}">
                {{ trans('global.edit') }}
            </a>
        @endcan

        @can('account_detail_delete')
            <form action="{{ route('admin.account-details.destroy', $accountDetail->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
            </form>
        @endcan

    </td>

</tr>
@endforeach
