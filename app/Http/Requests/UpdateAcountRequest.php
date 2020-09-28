<?php

namespace App\Http\Requests;

use App\Models\Acount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAcountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('acount_edit');
    }

    public function rules()
    {
        return [
            'name'          => [
                'string',
                'required',
                'unique:acounts,name,' . request()->route('acount')->id,
            ],
            'description'   => [
                'string',
                'nullable',
            ],
            'balance'       => [
                'string',
                'nullable',
            ],
            'premissions.*' => [
                'integer',
            ],
            'premissions'   => [
                'array',
            ],
        ];
    }
}
