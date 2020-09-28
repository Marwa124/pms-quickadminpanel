<?php

namespace App\Http\Requests;

use App\Models\Deparrtment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDeparrtmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('deparrtment_edit');
    }

    public function rules()
    {
        return [
            'department_name' => [
                'string',
                'required',
            ],
            'encryption'      => [
                'string',
                'nullable',
            ],
            'host'            => [
                'string',
                'nullable',
            ],
            'username'        => [
                'string',
                'nullable',
            ],
            'mailbox'         => [
                'string',
                'nullable',
            ],
        ];
    }
}
