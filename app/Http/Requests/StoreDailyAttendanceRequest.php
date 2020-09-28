<?php

namespace App\Http\Requests;

use App\Models\DailyAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDailyAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('daily_attendance_create');
    }

    public function rules()
    {
        return [
            'user_id'     => [
                'required',
                'integer',
            ],
            'clock_in'    => [
                'string',
                'nullable',
            ],
            'clock_out'   => [
                'string',
                'nullable',
            ],
            'absent'      => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'vacation'    => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'holiday'     => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'created_day' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
