<?php

namespace App\Http\Requests;

use App\Models\Holiday;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreHolidayRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('holiday_create');
    }

    public function rules()
    {
        return [
            'name'       => [
                'string',
                'required',
            ],
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_date'   => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'user_id'    => [
                'required',
                'integer',
            ],
        ];
    }
}
