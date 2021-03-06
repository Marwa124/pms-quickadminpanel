<?php

namespace App\Http\Requests;

use App\Models\HourlyRate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHourlyRateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('hourly_rate_edit');
    }

    public function rules()
    {
        return [
            'hourly_grade' => [
                'string',
                'required',
            ],
            'hourly_rate'  => [
                'string',
                'required',
            ],
        ];
    }
}
