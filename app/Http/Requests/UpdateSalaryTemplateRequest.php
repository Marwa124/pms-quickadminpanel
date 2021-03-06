<?php

namespace App\Http\Requests;

use App\Models\SalaryTemplate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSalaryTemplateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('salary_template_edit');
    }

    public function rules()
    {
        return [
            'salary_grade'    => [
                'string',
                'required',
            ],
            'basic_salary'    => [
                'string',
                'required',
            ],
            'overtime_salary' => [
                'string',
                'required',
            ],
        ];
    }
}
