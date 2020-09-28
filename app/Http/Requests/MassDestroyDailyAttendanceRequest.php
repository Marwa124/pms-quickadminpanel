<?php

namespace App\Http\Requests;

use App\Models\DailyAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDailyAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('daily_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:daily_attendances,id',
        ];
    }
}
