<?php

namespace App\Http\Requests;

use App\Models\SalaryTemplate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySalaryTemplateRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('salary_template_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:salary_templates,id',
        ];
    }
}
