<?php

namespace App\Http\Requests;

use App\Models\LeaveCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLeaveCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('leave_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:leave_categories,id',
        ];
    }
}
