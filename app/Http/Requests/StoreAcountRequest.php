<?php

namespace App\Http\Requests;

use App\Models\Acount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAcountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('acount_create');
    }

    public function rules()
    {
        return [
            'name'          => [
                'string',
                'required',
                'unique:acounts',
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
