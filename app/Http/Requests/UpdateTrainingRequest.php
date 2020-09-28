<?php

namespace App\Http\Requests;

use App\Models\Training;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTrainingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('training_edit');
    }

    public function rules()
    {
        return [
            'training_name' => [
                'string',
                'nullable',
            ],
            'vendor_name'   => [
                'string',
                'nullable',
            ],
            'start_date'    => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'finish_date'   => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'remarks'       => [
                'string',
                'nullable',
            ],
            'permissions.*' => [
                'integer',
            ],
            'permissions'   => [
                'array',
            ],
        ];
    }
}
