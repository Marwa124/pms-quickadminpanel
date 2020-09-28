<?php

namespace App\Http\Requests;

use App\Models\MonthlyAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMonthlyAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('monthly_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:monthly_attendances,id',
        ];
    }
}
