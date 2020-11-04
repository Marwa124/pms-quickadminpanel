@foreach($designations as $key => $department)
    <tr data-entry-id="{{ $department->id }}">
        <td>

        </td>
        <td>
            {{ $department->id ?? '' }}
        </td>
        <td>
            {{ $department->accountDetails ?? '' }}
        </td>

    </tr>
@endforeach