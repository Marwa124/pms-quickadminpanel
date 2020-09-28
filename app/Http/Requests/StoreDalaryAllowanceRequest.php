<?php

namespace App\Http\Requests;

use App\Models\DalaryAllowance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDalaryAllowanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dalary_allowance_create');
    }

    public function rules()
    {
        return [
            'name'               => [
                'string',
                'required',
                'unique:dalary_allowances',
            ],
            'value'              => [
                'string',
                'required',
            ],
            'salary_template_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
