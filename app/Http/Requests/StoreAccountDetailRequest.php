<?php

namespace App\Http\Requests;

use App\Models\AccountDetail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAccountDetailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('account_detail_create');
    }

    public function rules()
    {
        return [
            'user_id'         => [
                'required',
                'integer',
            ],
            'fullname'        => [
                'string',
                'required',
            ],
            'company'         => [
                'string',
                'nullable',
            ],
            'city'            => [
                'string',
                'nullable',
            ],
            'country'         => [
                'string',
                'nullable',
            ],
            'locale'          => [
                'string',
                'nullable',
            ],
            'address'         => [
                'string',
                'nullable',
            ],
            'phone'           => [
                'string',
                'nullable',
            ],
            'mobile'          => [
                'string',
                'nullable',
            ],
            'skype'           => [
                'string',
                'nullable',
            ],
            'language'        => [
                'string',
                'nullable',
            ],
            'joining_date'    => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'present_address' => [
                'string',
                'nullable',
            ],
            'date_of_birth'   => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'gender'          => [
                'required',
            ],
            'marital_status'  => [
                'required',
            ],
            'father_name'     => [
                'string',
                'nullable',
            ],
            'mother_name'     => [
                'string',
                'nullable',
            ],
            'passport'        => [
                'string',
                'nullable',
            ],
        ];
    }
}
