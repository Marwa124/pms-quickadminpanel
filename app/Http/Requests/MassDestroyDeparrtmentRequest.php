<?php

namespace App\Http\Requests;

use App\Models\Deparrtment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDeparrtmentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('deparrtment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:deparrtments,id',
        ];
    }
}
