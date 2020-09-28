<?php

namespace App\Http\Requests;

use App\Models\Overtime;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOvertimeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('overtime_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:overtimes,id',
        ];
    }
}
